<?php
namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class ContractIntelligenceController extends Controller
{
    // عند الضغط على السايدبار لأول مرة
    public function index()
    {
        // جلب آخر الملفات المرفوعة ليختار منها المستخدم إذا لم يرد رفع ملف جديد
        $recentDocuments = Document::latest()->take(5)->get();
        
        // نمرر المتغير كـ null لنعلم الـ Blade أننا في وضع "الانتظار/الرفع"
        return view('intelligence.index', [
            'document' => null,
            'recentDocuments' => $recentDocuments
        ]);
    }

    // عند اختيار ملف أو بعد رفعه والتحويل إليه
    public function show(Document $document)
    {
        // جلب التحليلات المرتبطة بهذا الملف تحديداً
        $analysis = $document->analyses()->first(); // أو العلاقات الخاصة بك
        
        return view('intelligence.index', [
            'document' => $document,
            'analysis' => $analysis
        ]);
    }
}