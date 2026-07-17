<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // 🌟 خطوة 1: استيراد الـ Gate Facade

class ContractIntelligenceController extends Controller
{
    public function index()
    {
$recentDocuments = Auth::user()->documents()->latest()->take(5)->get();
        
        return view('intelligence.show', [
            'document' => null,
            'recentDocuments' => $recentDocuments
        ]);
    }

    // عند اختيار ملف أو بعد رفعه والتحويل إليه
    public function show(Document $document)
    {
        // 🌟 خطوة 2: استبدال الـ abort_if اليدوي بالـ Policy الأنيق
        Gate::authorize('view', $document);

        $analysis = $document->analyses()->first(); // أو العلاقات الخاصة بك
        
$recentDocuments = Auth::user()->documents()->latest()->take(5)->get();
        return view('intelligence.show', [
            'document' => $document,
            'analysis' => $analysis,
            'recentDocuments' => $recentDocuments // أضفناها هنا لضمان عمل القائمة الجانبية
        ]);
    }
}