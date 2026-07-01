<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Document $document) {}

    public function handle(): void
    {
        $this->document->update(['status' => 'processing', 'progress' => 20]);

        // TODO: استخراج النص من PDF/DOCX
        $this->document->update(['progress' => 50]);

        // TODO: إرسال النص لـ AI وحفظ النتيجة بجدول analyses
        $this->document->update(['progress' => 90]);

        $this->document->update(['status' => 'done', 'progress' => 100]);
    }
}