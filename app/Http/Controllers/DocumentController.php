<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeDocumentJob;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('document')->store('documents');

        $document = Document::create([
            'user_id'       => auth()->id(),
            'original_name' => $request->file('document')->getClientOriginalName(),
            'title'         => pathinfo($request->file('document')->getClientOriginalName(), PATHINFO_FILENAME),
            'file_path'     => $path,
            'status'        => 'pending',
            'progress'      => 0,
        ]);

        // إرسال الملف للتحليل بالخلفية
        AnalyzeDocumentJob::dispatch($document);

        return redirect()->route('documents.analyzing', $document);
    }

    public function history()
{
    // جلب مستندات المستخدم الحالي فقط وترتيبها من الأحدث للأقدم مع الترقيم (Pagination)
    $documents = auth()->user()->documents()->latest()->paginate(10);

    return view('documents.history', compact('documents'));
}
    public function show(Document $document)
{

    // return response()->json($document);
    
    // أو إذا كنت ترجع صفحة Blade:
    // return view('documents.show', compact('document'));
}
    public function analyzing(Document $document)
    {
        abort_unless($document->user_id === auth()->id(), 403);

        return view('documents.analyzing', compact('document'));
    }

    public function status(Document $document)
    {
        abort_unless($document->user_id === auth()->id(), 403);

        return response()->json([
            'status'   => $document->status,
            'progress' => $document->progress,
        ]);
    }
}