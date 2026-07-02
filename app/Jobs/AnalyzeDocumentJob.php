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
        // 1. بدء المعالجة
        $this->document->update(['status' => 'processing', 'progress' => 20]);
        sleep(3); // ننتظر 3 ثوانٍ لمحاكاة استخراج النص مؤقتاً

        $this->document->update(['progress' => 50]);
        sleep(3); 
        $this->document->update(['progress' => 90]);
        sleep(2); 

$this->document->update(['status' => 'done', 'progress' => 100]);
    }
}