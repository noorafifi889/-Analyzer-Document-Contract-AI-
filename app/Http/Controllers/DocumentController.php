<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeDocumentJob;
use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;
use I18N\Arabic;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        // تم الإبقاء عليها كما هي، لكن الفلترة الأساسية والصفحة المطلوبة تعمل على دالة history بالأسفل
        $departments = Document::whereNotNull('department')->distinct()->pluck('department');
        $query = Document::with(['analyses'])->latest();

        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        $documents = $query->paginate(10)->withQueryString();

        return view('documents.history', compact('documents', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        $originalName = $request->file('document')->getClientOriginalName();

        $existingDocument = Document::where('user_id', auth()->id())
            ->where('original_name', $originalName)
            ->first();

        if ($existingDocument) {
            return redirect()->back()->withErrors([
                'document' => 'This document has already been uploaded! You can find it in your history.',
            ]);
        }

        $path = $request->file('document')->store('documents');

        $document = Document::create([
            'user_id' => auth()->id(),
            'original_name' => $originalName,
            'title' => pathinfo($originalName, PATHINFO_FILENAME),
            'file_path' => $path,
            'file_type' => $request->file('document')->getClientOriginalExtension(),
            'status' => 'pending',
            'progress' => 0,
        ]);

        AnalyzeDocumentJob::dispatch($document);

        return redirect()->route('intelligence.show', $document);
    }

    public function history(Request $request)
    {
        // 1. بناء الاستعلام الخاص بمستندات المستخدم الحالي فقط لضمان الأمان
        $query = auth()->user()->documents()
            ->with(['analyses' => fn ($q) => $q->latest()]);

        // 2. تطبيق فلترة مستوى الخطورة (Risk Level) بناءً على الـ Request
        if ($request->filled('risk')) {
            $risk = $request->risk;
            
            $query->whereHas('analyses', function($q) use ($risk) {
                if ($risk === 'low') {
                    $q->where('risk_score', '<=', 35);
                } elseif ($risk === 'med') {
                    $q->where('risk_score', '>', 35)->where('risk_score', '<=', 65);
                } elseif ($risk === 'high') {
                    $q->where('risk_score', '>', 65);
                }
            });
        }

        // 3. جلب المستندات مرتبة من الأحدث إلى الأقدم مع الحفاظ على قيم الفلترة في الترقيم الصفحي
        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('documents.history', compact('documents'));
    }

    public function show(Document $document)
    {
        $document->load('analyses');
        $analysis = $document->analyses->first();

        if ($document->status !== 'done' || ! $analysis) {
            return redirect()->route('intelligence.show', $document);
        }

        return view('documents.show', compact('document', 'analysis'));
    }

    public function destroy(Document $document)
    {
        abort_unless($document->user_id === auth()->id(), 403);

        $document->delete();

        return redirect()->to('/documents/history')->with('success', 'Document deleted successfully!');
    }

    public function getStatus(Document $document)
    {
        abort_unless($document->user_id === auth()->id(), 403);

        return response()->json([
            'status' => $document->status,     // pending / processing / done / failed
            'progress' => $document->progress, // 0, 20, 50, 90, 100
        ]);
    }

    public function exportPdf($id)
    {
        $document = Document::findOrFail($id);
        $analysis = $document->analyses()->latest()->first();

        abort_if(! $analysis, 404, 'Analysis report is not ready yet.');

        $dynamicTitle = $document->title;
        $dynamicSummary = $analysis->summary;
        $dynamicCounterparty = $analysis->counterparty ?? 'N/A';

        $pdf = Pdf::loadView('pdf.report', compact('document', 'analysis', 'dynamicTitle', 'dynamicSummary', 'dynamicCounterparty'));

        return $pdf->download('Report-'.$document->id.'.pdf');
    }

    public function exportWord(Document $document)
    {
        abort_unless($document->user_id === auth()->id(), 403);

        $analysis = $document->analyses()->latest()->first();
        abort_if(! $analysis, 404, 'Analysis report is not ready yet.');

        $phpWord = new PhpWord();

        $titleStyle = ['bold' => true, 'size' => 20, 'color' => '1F2937'];
        $headingStyle = ['bold' => true, 'size' => 13, 'color' => '2563EB'];
        $labelStyle = ['bold' => true, 'size' => 10, 'color' => '6B7280'];

        $section = $phpWord->addSection([
            'marginTop' => 900, 'marginBottom' => 900, 'marginLeft' => 1100, 'marginRight' => 1100,
        ]);

        $section->addText($document->title, $titleStyle);
        $section->addText('Counterparty: ' . ($document->counterparty ?? 'N/A'), ['size' => 10, 'color' => '6B7280']);
        $section->addTextBreak(1);

        // Snapshot table
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => 'E5E7EB', 'cellMargin' => 100]);

        $riskLabel = $analysis->risk_score >= 70 ? 'HIGH' : ($analysis->risk_score >= 40 ? 'MEDIUM' : 'LOW');

        $rows = [
            ['Safety Score', (100 - $analysis->risk_score) . '%'],
            ['Risk Level', $riskLabel],
            ['Financial Exposure', '$' . number_format($analysis->exposure ?? 0)],
            ['Clauses Reviewed', (string) ($analysis->clauses_count ?? 0)],
            ['Analysis Date', $document->created_at->format('M d, Y')],
        ];

        foreach ($rows as [$label, $value]) {
            $table->addRow();
            $table->addCell(3000)->addText($label, $labelStyle);
            $table->addCell(4000)->addText($value);
        }

        $section->addTextBreak(1);
        $section->addText('Executive AI Summary', $headingStyle);
        $section->addText($analysis->summary, ['size' => 11]);

        if (! empty($analysis->key_risks)) {
            $section->addTextBreak(1);
            $section->addText('Key Risks', $headingStyle);
            foreach ((array) $analysis->key_risks as $risk) {
                $section->addListItem($risk, 0, ['size' => 11], ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
            }
        }

        if (! empty($analysis->recommendations)) {
            $section->addTextBreak(1);
            $section->addText('Recommendations', $headingStyle);
            foreach ((array) $analysis->recommendations as $rec) {
                $section->addListItem($rec, 0, ['size' => 11], ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
            }
        }

        $fileName = Str::slug($document->original_name ?? 'document-summary') . '-summary.docx';

        $tmpDir = storage_path('app/tmp');
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }
        $tempPath = $tmpDir . '/' . $fileName;

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}