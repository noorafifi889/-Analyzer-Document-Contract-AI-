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

        $this->document->update(['status' => 'processing', 'progress' => 20]);

        $filePath = Storage::path($this->document->file_path);
        $text = '';

        try {
            if (! file_exists($filePath)) {
                throw new \Exception('الملف غير موجود في المسار: '.$filePath);
            }

            if ($this->document->file_type === 'pdf') {
                $text = Pdf::getText($filePath);
            } elseif (in_array($this->document->file_type, ['docx', 'doc'])) {
                try {
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
                    $text = $this->extractTextFromDocxDirectly($filePath);
                }
            }

            // === 🌟 خطوة التنظيف الجديدة 🌟 ===
            $text = $this->cleanExtractedText($text);

            if (empty(trim($text))) {
                throw new \Exception('المكتبة لم تعثر على أي نصوص رقمية داخل الملف بعد التنظيف.');
            }

            // حفظ النص النظيف في قاعدة البيانات
            $this->document->update([
                'extracted_text' => $text,
                'progress' => 50,
            ]);

            $analysisResult = $groqService->analyzeContract($text);

            $criticalIssuesList = $analysisResult['critical_issues'] ?? [];
            $clausesAnalysis = $analysisResult['clauses_analysis'] ?? [];

            if (! empty($criticalIssuesList)) {
                $clausesAnalysis[] = [
                    'clause' => 'Critical issues',
                    'analysis' => implode(' | ', $criticalIssuesList),
                ];
            }

            Analysis::create([
                'document_id' => $this->document->id,
                'summary' => $analysisResult['summary'] ?? null,
                'risk_score' => $analysisResult['risk_score'] ?? null,
                'critical_issues' => count($criticalIssuesList), 
                'clauses_analysis' => $clausesAnalysis,
                'ai_confidence' => isset($analysisResult['ai_confidence'])
                                        ? (int) round($analysisResult['ai_confidence'] * 100)
                                        : null, 
            ]);

            $this->document->update(['progress' => 90]);
            $this->document->update(['status' => 'done', 'progress' => 100]);

        } catch (\Exception $e) {
            $this->document->update([
                'status' => 'failed',
                'progress' => 0,
            ]);
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

    /**
     * 🌟 دالة تنظيف وتنسيق النص المستخرج لإزالة العشوائية والسطور الفارغة
     */
    private function cleanExtractedText(string $text): string
    {
        if (empty($text)) return '';

        // 1. تقسيم النص إلى أسطر منفصلة بناءً على النزول لسطر جديد
        $lines = explode("\n", $text);
        $cleanedLines = [];

        foreach ($lines as $line) {
            // 2. تنظيف الفراغات من بداية ونهاية كل سطر
            $trimmedLine = trim($line);

            // 3. تجاهل الأسطر الفارغة تماماً، أو الأسطر التي تحتوي فقط على رموز طايرة (مثل نقطة وحيدة أو شرطة وحيدة ناتجة عن التنسيق السيء)
            if ($trimmedLine === '' || $trimmedLine === '•' || $trimmedLine === '-' || $trimmedLine === '*') {
                continue;
            }

            // 4. تنظيف الفراغات المتكررة داخل السطر الواحد (تحويل الفراغات الكثيرة إلى فراغ واحد)
            $trimmedLine = preg_replace('/\s+/', ' ', $trimmedLine);

            $cleanedLines[] = $trimmedLine;
        }

        // 5. إعادة تجميع الأسطر النظيفة بنزول سطر واحد فقط بين كل فقرة والثانية
        return implode("\n", $cleanedLines);
    }
}