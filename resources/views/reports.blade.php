@extends('layouts.app')

@section('title', 'Compliance Reports Dashboard | LexiGuard AI')

@section('content')
<style>
    body {
        font-family: 'Cairo', 'Amiri', sans-serif;
        direction: rtl;
        text-align: right;
    }
</style>

@php
    $riskMeta = function (?int $score) {
        if ($score === null) return ['label' => 'Not Analyzed', 'main' => '#64748B', 'soft' => '#F1F5F9'];
        if ($score > 70) return ['label' => 'High Risk', 'main' => '#DC2626', 'soft' => '#FEE2E2'];
        if ($score > 40) return ['label' => 'Medium Risk', 'main' => '#D97706', 'soft' => '#FEF3C7'];
        return ['label' => 'Low Risk', 'main' => '#16A34A', 'soft' => '#DCFCE7'];
    };

    $highRiskCount = 0;
    $reportsById = [];

    foreach ($documents as $doc) {
        $analysis = $doc->analyses->first();
        $score = $analysis->risk_score ?? null;

        if ($doc->status === 'done' && $score !== null && $score > 70) {
            $highRiskCount++;
        }

        $reportsById[$doc->id] = [
            'id'                => $doc->id,
            'title'             => $doc->original_name ?? $doc->title,
            'score'             => $score,
            'critical_issues'   => $analysis->critical_issues ?? 0,
            'summary'           => $analysis->summary ?? 'No summary available for this document.',
            'risk_reason'       => $analysis->risk_reason ?? null,
            'clauses_analysis'  => $analysis->clauses_analysis ?? [],
            'date'              => $doc->created_at->format('M d, Y'),
            'status'            => $doc->status, // pending / processing / done / failed
            'progress'          => $doc->progress,
            'pdf_url'           => route('documents.export-pdf', $doc->id),
            'word_url'          => route('documents.export-word', $doc->id),
        ];
    }
@endphp

<main class="h-screen flex flex-col relative">

    <div class="flex-1 overflow-y-auto p-margin-page bg-background custom-scrollbar">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter mb-10">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Intelligence Reports</h2>
                <p class="font-body-md text-on-surface-variant max-w-xl">Actionable legal insights derived from your entire contract ecosystem. Manage summaries, audit logs, and risk matrices.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 bg-surface border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined">calendar_today</span> Last 30 Days
                </button>
                <div class="h-8 w-[1px] bg-outline-variant mx-1"></div>
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-on-surface border border-outline-variant rounded-lg font-label-md hover:bg-surface-container-low transition-colors paper-shadow">
                    <span class="material-symbols-outlined">csv</span> Export CSV
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <button class="flex flex-col text-left p-6 bg-white border-2 border-primary rounded-xl paper-shadow transition-all group">
                <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">security</span>
                </div>
                <h3 class="font-title-lg text-title-lg mb-1">Portfolio Risk</h3>
                <p class="font-body-md text-on-surface-variant mb-4">Analyze liability caps, indemnification clauses, and high-risk triggers.</p>
                <div class="mt-auto flex items-center gap-2 text-primary font-label-md font-bold">
                    <span>Active Monitor</span> <span class="material-symbols-outlined text-sm">check_circle</span>
                </div>
            </button>

            <div class="flex flex-col p-6 bg-white border border-outline-variant rounded-xl paper-shadow justify-between">
                <div>
                    <span class="font-label-md uppercase text-on-surface-variant block mb-1">Total Audited</span>
                    <span class="text-3xl font-bold tracking-tight text-primary">{{ $documents->total() }}</span>
                </div>
                <p class="text-xs text-on-surface-variant mt-2">Contracts processed via Guard AI Engine</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-outline-variant rounded-xl paper-shadow justify-between">
                <div>
                    <span class="block text-on-surface-variant text-[10px] uppercase font-label-md">High Risk Exposure</span>
                    <span class="text-3xl font-bold tracking-tight text-error">{{ $highRiskCount }}</span>
                </div>
                <p class="text-xs text-error/80 mt-2">Requires immediate litigation review</p>
            </div>
        </div>

        <div class="bg-white border border-outline-variant rounded-xl paper-shadow overflow-hidden mb-12">
            <div class="p-6 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
                <h4 class="font-title-lg text-title-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">folder_managed</span> Compiled Document Ledgers
                </h4>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant bg-surface-container-low/40">
                            <th class="p-4 font-label-md font-bold text-on-surface-variant w-2/5">Contract Name</th>
                            <th class="p-4 font-label-md font-bold text-on-surface-variant">Uploaded Date</th>
                            <th class="p-4 font-label-md font-bold text-on-surface-variant text-center">Risk Level</th>
                            <th class="p-4 font-label-md font-bold text-on-surface-variant text-center">Critical Issues</th>
                            <th class="p-4 font-label-md font-bold text-on-surface-variant text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                            @php
                                $r = $reportsById[$doc->id];
                                $meta = $riskMeta($r['score']);
                                $isDone = $r['status'] === 'done';
                            @endphp
                            <tr class="border-b border-outline-variant hover:bg-surface-container-low/60 transition-colors group" id="row-{{ $doc->id }}">
                                <td class="p-4 font-body-md font-bold text-on-surface">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary">description</span>
                                        <span>{{ $r['title'] }}</span>
                                    </div>
                                </td>
                                <td class="p-4 font-body-md text-on-surface-variant">{{ $r['date'] }}</td>
                                <td class="p-4 text-center" id="status-cell-{{ $doc->id }}">
                                    @if(!$isDone)
                                        <span class="px-3 py-1 bg-primary/10 text-primary text-label-sm rounded-full font-bold inline-flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                            <span>{{ $r['status'] === 'failed' ? 'FAILED' : ($r['progress'] . '%') }}</span>
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-label-sm rounded-full font-bold" style="background:{{ $meta['soft'] }}; color:{{ $meta['main'] }}">{{ $meta['label'] }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-body-md text-on-surface font-medium">{{ $r['critical_issues'] }}</td>
                                <td class="p-4 text-right space-x-2 whitespace-nowrap">
                                    <button
                                        onclick="openPreview({{ $doc->id }})"
                                        {{ !$isDone ? 'disabled' : '' }}
                                        class="px-3 py-1.5 border border-outline-variant text-body-md rounded-lg transition-colors inline-flex items-center gap-1 {{ !$isDone ? 'opacity-40 cursor-not-allowed' : 'hover:bg-surface-container-low' }}">
                                        <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                    </button>
                                    <a href="{{ $r['pdf_url'] }}"
                                       class="px-3 py-1.5 bg-primary text-on-primary text-body-md rounded-lg transition-opacity inline-flex items-center gap-1 {{ !$isDone ? 'opacity-40 pointer-events-none' : 'hover:opacity-90' }}">
                                        <span class="material-symbols-outlined text-sm">download</span> PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-on-surface-variant">
                                    ما في مستندات مرفوعة لهلق. ارفع أول عقد عشان يبدأ التحليل.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-surface-bright border-t border-outline-variant">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    {{-- ================= PREVIEW MODAL — نفس بنية وتصميم summary-pdf.blade.php ================= --}}
    <div id="previewModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closePreview()"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-3xl border border-outline-variant">

                {{-- Header: نفس أسلوب هيدر الـ PDF (خط سفلي بلون indigo) --}}
                <div class="relative px-8 py-6 border-b-4 border-[#4f46e5] flex items-start justify-between">
                    <div class="pr-10">
                        <h3 class="text-lg font-bold text-[#4f46e5]">LexiGuard AI — Contract Summary Report</h3>
                        <p id="modalFileName" class="text-sm text-on-surface-variant mt-1"></p>
                    </div>
                    <button onclick="closePreview()" class="text-on-surface-variant hover:text-on-surface shrink-0">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-8 space-y-6 max-h-[65vh] overflow-y-auto custom-scrollbar">

                    {{-- Meta grid — نفس جدول الـ meta تبع الـ PDF بالضبط --}}
                    <table class="w-full border-collapse">
                        <tr>
                            <td class="p-3 border border-outline-variant w-1/4">
                                <span class="block text-[10px] uppercase text-on-surface-variant mb-1">Uploaded Date</span>
                                <span id="modalDate" class="font-bold text-sm"></span>
                            </td>
                            <td class="p-3 border border-outline-variant w-1/4">
                                <span class="block text-[10px] uppercase text-on-surface-variant mb-1">Risk Score</span>
                                <span id="modalRiskScore" class="font-bold text-sm"></span>
                            </td>
                            <td class="p-3 border border-outline-variant w-1/4">
                                <span class="block text-[10px] uppercase text-on-surface-variant mb-1">Critical Issues</span>
                                <span id="modalCriticalIssues" class="font-bold text-sm"></span>
                            </td>
                            <td class="p-3 border border-outline-variant w-1/4">
                                <span class="block text-[10px] uppercase text-on-surface-variant mb-1">Status</span>
                                <span id="modalStatus" class="font-bold text-sm"></span>
                            </td>
                        </tr>
                    </table>

                    {{-- Executive Summary --}}
                    <div>
                        <h4 class="text-[15px] font-bold text-on-surface mb-2 pb-1.5 border-b border-outline-variant">Executive Summary</h4>
                        <div id="modalSummary" class="bg-surface-container rounded-lg border border-outline-variant p-4 text-body-md text-on-surface whitespace-pre-line"></div>
                    </div>

                    {{-- Risk Reasoning --}}
                    <div id="modalRiskReasonWrap" class="hidden">
                        <h4 class="text-[15px] font-bold text-on-surface mb-2 pb-1.5 border-b border-outline-variant">Risk Reasoning</h4>
                        <div id="modalRiskReason" class="bg-surface-container rounded-lg border border-outline-variant p-4 text-body-md text-on-surface whitespace-pre-line"></div>
                    </div>

                    {{-- Key Clauses --}}
                    <div id="modalClausesWrap" class="hidden">
                        <h4 class="text-[15px] font-bold text-on-surface mb-2 pb-1.5 border-b border-outline-variant">Key Clauses</h4>
                        <div id="modalClauses" class="space-y-2"></div>
                    </div>
                </div>

                <div class="bg-surface-container px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-outline-variant">
                    <span class="text-label-sm text-on-surface-variant italic">This report is AI-generated and should not replace professional legal advice.</span>
                    <div class="flex items-center gap-2 shrink-0">
                        <a id="modalPdfLink" href="#" class="px-4 py-2 bg-[#4f46e5] text-white rounded-lg text-body-md font-bold hover:opacity-90 transition-opacity inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF
                        </a>
                        <a id="modalWordLink" href="#" class="px-4 py-2 bg-white border border-outline-variant text-on-surface rounded-lg text-body-md font-bold hover:bg-surface-container-low transition-colors inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">description</span> Word
                        </a>
                        <button onclick="closePreview()" class="px-4 py-2 bg-white border border-outline-variant rounded-lg text-body-md font-bold hover:bg-surface-container-low transition-colors">
                            Dismiss
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // بيانات كل التقارير مبنية عالسيرفر — نفس حقول summary-pdf.blade.php بالضبط
    const REPORTS = @json($reportsById);
    const STATUS_URL_TEMPLATE = "{{ route('documents.status', ['document' => '__ID__']) }}";

    function riskMeta(score) {
        if (score === null || score === undefined) return { label: 'Not Analyzed', main: '#64748B' };
        if (score > 70) return { label: 'High Risk', main: '#DC2626' };
        if (score > 40) return { label: 'Medium Risk', main: '#D97706' };
        return { label: 'Low Risk', main: '#16A34A' };
    }

    function openPreview(id) {
        const doc = REPORTS[id];
        if (!doc || doc.status !== 'done') return;

        const meta = riskMeta(doc.score);

        document.getElementById('modalFileName').textContent = doc.title;
        document.getElementById('modalDate').textContent = doc.date;

        const scoreEl = document.getElementById('modalRiskScore');
        scoreEl.textContent = (doc.score ?? 'N/A') + '/100 (' + meta.label + ')';
        scoreEl.style.color = meta.main;

        document.getElementById('modalCriticalIssues').textContent = doc.critical_issues + ' Issues';
        document.getElementById('modalStatus').textContent = (doc.status || '').toUpperCase();

        document.getElementById('modalSummary').textContent = doc.summary;

        const reasonWrap = document.getElementById('modalRiskReasonWrap');
        if (doc.risk_reason) {
            document.getElementById('modalRiskReason').textContent = doc.risk_reason;
            reasonWrap.classList.remove('hidden');
        } else {
            reasonWrap.classList.add('hidden');
        }

        const clausesWrap = document.getElementById('modalClausesWrap');
        const clausesBox = document.getElementById('modalClauses');
        clausesBox.innerHTML = '';
        if (doc.clauses_analysis && doc.clauses_analysis.length) {
            doc.clauses_analysis.forEach(item => {
                const div = document.createElement('div');
                div.className = 'border border-outline-variant rounded-lg p-3';
                const title = document.createElement('div');
                title.className = 'font-bold text-[#4f46e5] text-sm';
                title.textContent = item.clause || 'Clause';
                const body = document.createElement('div');
                body.className = 'text-on-surface-variant text-sm mt-1';
                body.textContent = item.analysis || '';
                div.appendChild(title);
                div.appendChild(body);
                clausesBox.appendChild(div);
            });
            clausesWrap.classList.remove('hidden');
        } else {
            clausesWrap.classList.add('hidden');
        }

        document.getElementById('modalPdfLink').href = doc.pdf_url;
        document.getElementById('modalWordLink').href = doc.word_url;

        document.getElementById('previewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePreview();
    });

    // Live polling لأي مستند لسا pending/processing
    async function pollPendingStatuses() {
        const pendingIds = Object.keys(REPORTS).filter(id =>
            REPORTS[id].status === 'pending' || REPORTS[id].status === 'processing'
        );
        if (!pendingIds.length) return;

        let anyJustFinished = false;

        await Promise.all(pendingIds.map(async (id) => {
            try {
                const url = STATUS_URL_TEMPLATE.replace('__ID__', id);
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();

                if (data.status !== REPORTS[id].status || data.progress !== REPORTS[id].progress) {
                    REPORTS[id].status = data.status;
                    REPORTS[id].progress = data.progress;

                    const cell = document.getElementById('status-cell-' + id);
                    if (cell) {
                        if (data.status === 'failed') {
                            cell.innerHTML = '<span class="px-3 py-1 bg-error-container text-on-error-container text-label-sm rounded-full font-bold">FAILED</span>';
                        } else if (data.status === 'done') {
                            anyJustFinished = true;
                        } else {
                            cell.innerHTML = '<span class="px-3 py-1 bg-primary/10 text-primary text-label-sm rounded-full font-bold inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span><span>' + data.progress + '%</span></span>';
                        }
                    }
                }
            } catch (e) {
                console.error('Status poll failed for document', id, e);
            }
        }));

        if (anyJustFinished) {
            window.location.reload();
        }
    }

    setInterval(pollPendingStatuses, 4000);
</script>
@endsection