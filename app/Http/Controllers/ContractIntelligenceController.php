<?php
namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class ContractIntelligenceController extends Controller
{
    public function index()
    {
        $recentDocuments = auth()->user()->documents()->latest()->take(5)->get();
        
        return view('intelligence.show', [
            'document' => null,
            'recentDocuments' => $recentDocuments
        ]);
    }

    // عند اختيار ملف أو بعد رفعه والتحويل إليه
    public function show(Document $document)
    {
        abort_if($document->user_id !== auth()->id(), 403);

        $analysis = $document->analyses()->first(); // أو العلاقات الخاصة بك
        
        $recentDocuments = auth()->user()->documents()->latest()->take(5)->get();

        return view('intelligence.show', [
            'document' => $document,
            'analysis' => $analysis,
            'recentDocuments' => $recentDocuments // أضفناها هنا لضمان عمل القائمة الجانبية
        ]);
    }
}