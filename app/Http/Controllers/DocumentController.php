<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeDocumentJob;
use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class DocumentController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
    ]);

    // 1. جلب اسم الملف الأصلي قبل رفعه
    $originalName = $request->file('document')->getClientOriginalName();

    // 2. التحقق مما إذا كان المستخدم الحالي قد رفع ملفاً بنفس الاسم سابقاً
    $existingDocument = Document::where('user_id', auth()->user->id())
                                ->where('original_name', $originalName)
                                ->first();

    if ($existingDocument) {
        // إذا كان الملف موجوداً، نقوم بإرجاع المستخدم للخلف مع رسالة خطأ واضحة
        return redirect()->back()->withErrors([
'document' => 'This document has already been uploaded! You can find it in your history.'
        ]);
    }

    // 3. إذا لم يكن موجوداً، يكمل الكود طبيعي ويقوم بالرفع
    $path = $request->file('document')->store('documents');

    $document = Document::create([
        'user_id' => auth()->user->id(),
        'original_name' => $originalName,
        'title' => pathinfo($originalName, PATHINFO_FILENAME),
        'file_path' => $path,
        'file_type' => $request->file('document')->getClientOriginalExtension(),
        'status' => 'pending',
        'progress' => 0,
    ]);

    // إرسال الملف للتحليل بالخلفية
    AnalyzeDocumentJob::dispatch($document);

    return redirect()->route('documents.analyzing', ['document' => $document->id]);
}
    public function history()
    {
        // جلب مستندات المستخدم الحالي فقط وترتيبها من الأحدث للأقدم مع الترقيم (Pagination)
        $documents = auth()->user()->documents()->latest()->paginate(10);

        return view('documents.history', compact('documents'));
    }

    public function show(Document $document)
    {
        $document->load('analyses');
        $analysis = $document->analyses->first();

        if ($document->status !== 'done' || ! $analysis) {
            // التعديل: نمرر البرامتر كمصفوفة مفتاح وقيمة واضحة تماشيًا مع الروت [document => id]
            return redirect()->route('documents.analyzing', ['document' => $document->id]);
        }

        return view('documents.show', compact('document', 'analysis'));
    }

    public function destroy(Document $document)
    {
        $document->delete();

        // if($document->cover_image) {
        //     Storage::disk('public')->delete($document->cover_image);
        // }

        return redirect()->to('/documents/history')->with('success', 'Document deleted successfully!');
    }

    public function analyzing(Document $document)
    {
        abort_unless($document->user_id === auth()->user->id(), 403);

        return view('documents.analyzing', compact('document'));
    }

    public function status(Document $document)
    {
        abort_unless($document->user_id === auth()->user->id(), 403);

        return response()->json([
            'status' => $document->status,
            'progress' => $document->progress,
        ]);
    }

    public function getStatus(Document $document)
    {
        return response()->json([
            'status' => $document->status,   // سيعود بـ processing أو done
            'progress' => $document->progress,  // سيعود بـ 20، 50، 90، أو 100
        ]);
    }

    public function exportPdf(Document $document)
{
    $analysis = $document->analyses()->latest()->first();
 
    $pdf = Pdf::loadView('documents.summary-pdf', compact('document', 'analysis'))
        ->setPaper('a4', 'portrait');
 
    $fileName = \Illuminate\Support\Str::slug($document->original_name ?? 'document-summary') . '-summary.pdf';
 
    return $pdf->download($fileName);
}
 
}
