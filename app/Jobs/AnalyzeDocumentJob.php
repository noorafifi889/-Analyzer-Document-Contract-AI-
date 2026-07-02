<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage; 

class AnalyzeDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Document $document) {}

    public function handle(): void
    {
        // 1. تحديث الحالة إلى جاري المعالجة والتقدم 20%
        $this->document->update(['status' => 'processing', 'progress' => 20]);

        // الطريقة الأكثر أماناً في لارافيل لجلب مسار الملف الحقيقي كاملاً دون أخطاء
        $filePath = Storage::path($this->document->file_path); 
        $text = '';

        try {
            if (!file_exists($filePath)) {
                throw new \Exception("الملف غير موجود في المسار: " . $filePath);
            }

            // 2. فحص نوع الملف واستخراج النص بناءً عليه (اليوم السابع)
            if ($this->document->file_type === 'pdf') {
                // استخراج النص من PDF باستخدام حزمة Spatie
                $text = \Spatie\PdfToText\Pdf::getText($filePath);
                //  dd($text);
            } 
            elseif (in_array($this->document->file_type, ['docx', 'doc'])) {
                // استخراج النص من ملف الوورد باستخدام PHPWord
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        
                        // أ) قراءة النصوص والفقرات العادية المباشرة
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                        
                        // ب) قراءة النصوص العربية المركبة والمجزأة (TextRun)
                        elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                            foreach ($element->getElements() as $textElement) {
                                if (method_exists($textElement, 'getText')) {
                                    $text .= $textElement->getText();
                                }
                            }
                            $text .= "\n";
                     
 
                            }
                        
                        // ج) تفكيك الجداول والخلايا وقراءة نصوصها (مهم جداً لملف الواجب)
                        elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                            foreach ($element->getRows() as $row) {
                                foreach ($row->getCells() as $cell) {
                                    foreach ($cell->getElements() as $cellElement) {
                                        if (method_exists($cellElement, 'getText')) {
                                            $text .= $cellElement->getText() . " ";
                                        }
                                    }
                                }
                                $text .= "\n"; // سطر جديد بعد كل صف في الجدول


                            }
                        }
                        
                    }
                }
            }

            // فحص نهائي: إذا كان النص فارغاً تماماً نرمي استثناءً لنكشف المشكلة فوراً
            if (empty(trim($text))) {
                throw new \Exception("المكتبة لم تعثر على أي نصوص رقمية داخل الملف.");
            }
dump($text);
            // 3. حفظ النص المستخرج وتحديث التقدم لـ 50%
            $this->document->update([
                'extracted_text' => $text,
                'progress' => 50
            ]);

            // تأخير بسيط للمحاكاة قبل الانتقال للذكاء الاصطناعي
            sleep(2);
            $this->document->update(['progress' => 90]);
            sleep(2);

            // 4. إنهاء العملية بنجاح مئة بالمئة
            $this->document->update(['status' => 'done', 'progress' => 100]);

        } catch (\Exception $e) {
            // في حال حدوث أي خطأ، نقلب الحالة إلى Failed
            $this->document->update([
                'status' => 'failed',
                'progress' => 0
            ]);
            
            // طباعة رسالة الخطأ في الـ Terminal لرؤيتها مباشرة عند تشغيل الـ Worker
            dump("🚨 خطأ أثناء استخراج النص: " . $e->getMessage());
            dump("نوع الملف: " . $this->document->file_type);
dump("المسار: " . $filePath);
dump("هل الملف موجود: " . (file_exists($filePath) ? 'YES' : 'NO'));
            Log::error("Error extracting text from document ID {$this->document->id}: " . $e->getMessage());
        }
    }
}