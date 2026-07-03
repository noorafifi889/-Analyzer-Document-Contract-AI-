<?php

namespace App\Jobs;

use App\Models\Analysis;
use App\Models\Document;
use App\Services\GroqAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory;
use Spatie\PdfToText\Pdf;

class AnalyzeDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Document $document) {}

    public function handle(GroqAnalysisService $groqService): void
    {
        Log::info('JOB STARTED', [
            'document_id' => $this->document->id,
            'file_path' => $this->document->file_path,
            'file_type' => $this->document->file_type,
        ]);
        // 1. تحديث الحالة إلى جاري المعالجة والتقدم 20%
        $this->document->update(['status' => 'processing', 'progress' => 20]);

        $filePath = Storage::path($this->document->file_path);
        $text = '';

        try {
            if (! file_exists($filePath)) {
                throw new \Exception('الملف غير موجود في المسار: '.$filePath);
            }

            // 2. فحص نوع الملف واستخراج النص بناءً عليه (نفس الكود الأصلي بدون تغيير)
            if ($this->document->file_type === 'pdf') {
                $text = Pdf::getText($filePath);
            } elseif (in_array($this->document->file_type, ['docx', 'doc'])) {
                try {
                    // محاولة القراءة بالطريقة القياسية أولاً
                    $phpWord = IOFactory::load($filePath);

                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if (method_exists($element, 'getText')) {
                                $text .= $element->getText()."\n";
                            } elseif ($element instanceof TextRun) {
                                foreach ($element->getElements() as $textElement) {
                                    if (method_exists($textElement, 'getText')) {
                                        $text .= $textElement->getText();
                                    }
                                }
                                $text .= "\n";
                            } elseif ($element instanceof Table) {
                                foreach ($element->getRows() as $row) {
                                    foreach ($row->getCells() as $cell) {
                                        foreach ($cell->getElements() as $cellElement) {
                                            if (method_exists($cellElement, 'getText')) {
                                                $text .= $cellElement->getText().' ';
                                            }
                                        }
                                    }
                                    $text .= "\n";
                                }
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('فشلت قراءة PhpWord القياسية، يتم الانتقال لطريقة الاستخراج السريع للملف: '.$this->document->id);

                    // خطة البديل الأقوى (Fallback): استخراج النص مباشرة من ملف الـ docx المضغوط
                    $text = $this->extractTextFromDocxDirectly($filePath);
                }
            }
            if (empty(trim($text))) {
                throw new \Exception('المكتبة لم تعثر على أي نصوص رقمية داخل الملف.');
            }

            // 3. حفظ النص المستخرج وتحديث التقدم لـ 50%
            $this->document->update([
                'extracted_text' => $text,
                'progress' => 50,
            ]);

            // === 4. الجزء الجديد: إرسال النص لـ Groq AI وحفظ نتيجة التحليل ===
            $analysisResult = $groqService->analyzeContract($text);

            $criticalIssuesList = $analysisResult['critical_issues'] ?? [];
            $clausesAnalysis = $analysisResult['clauses_analysis'] ?? [];

            if (! empty($criticalIssuesList)) {
                $clausesAnalysis[] = [
                    'clause' => 'المشاكل الحرجة',
                    'analysis' => implode(' | ', $criticalIssuesList),
                ];
            }

            Analysis::create([
                'document_id' => $this->document->id,
                'summary' => $analysisResult['summary'] ?? null,
                'risk_score' => $analysisResult['risk_score'] ?? null,
                'critical_issues' => count($criticalIssuesList), // عدد بس، مش array
                'clauses_analysis' => $clausesAnalysis,
                'ai_confidence' => isset($analysisResult['ai_confidence'])
                                        ? (int) round($analysisResult['ai_confidence'] * 100)
                                        : null, // نحوله لنسبة مئوية صحيحة
            ]);

            $this->document->update(['progress' => 90]);

            // 5. إنهاء العملية بنجاح مئة بالمئة
            $this->document->update(['status' => 'done', 'progress' => 100]);

        } catch (\Exception $e) {
            $this->document->update([
                'status' => 'failed',
                'progress' => 0,
            ]);

            dump('🚨 خطأ: '.$e->getMessage());
            Log::error("Error analyzing document ID {$this->document->id}: ".$e->getMessage());
        }
    }

    private function extractTextFromDocxDirectly(string $filePath): string
    {
        $stripedText = '';
        $zip = new \ZipArchive;

        if ($zip->open($filePath) === true) {
            if (($index = $zip->locateName('word/document.xml')) !== false) {
                $data = $zip->getFromIndex($index);

                $stripedText = strip_tags(
                    str_replace(['</w:p>', '</w:r>', '<w:tab/>'], ["\n", ' ', "\t"], $data)
                );
            }
            $zip->close();
        }

        return trim($stripedText);
    }
}
