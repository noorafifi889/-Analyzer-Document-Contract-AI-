@extends('layouts.app')

@section('title', 'Compliance Reports Dashboard | LexiGuard AI')

@section('content')

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

<main class="min-h-screen bg-background pb-12 w-full">

    <div class="px-8 w-full">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pt-6 w-full">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-1">Intelligence Reports</h2>
                <p class="font-body-md text-on-surface-variant max-w-2xl">Actionable legal insights derived from your entire contract ecosystem. Manage summaries and risk matrices.</p>
            </div>
            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                <button class="flex items-center gap-2 px-3.5 py-1.5 bg-surface border border-outline-variant rounded-lg font-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                    <span class="material-symbols-outlined text-sm">calendar_today</span> Last 30 Days
                </button>
                <div class="h-6 w-[1px] bg-outline-variant"></div>
                <button class="flex items-center gap-2 px-3.5 py-1.5 bg-white text-on-surface border border-outline-variant rounded-lg font-label-md hover:bg-surface-container-low transition-colors paper-shadow">
                    <span class="material-symbols-outlined text-sm">csv</span> Export CSV
                </button>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6 w-full">
            <button class="flex items-center gap-4 p-5 bg-white border border-outline-variant rounded-xl paper-shadow transition-all group text-left w-full">
                <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center group-hover:scale-105 transition-transform shrink-0">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">security</span>
                </div>
                <div>
                    <h3 class="font-title-md text-title-md mb-0.5">Portfolio Risk</h3>
                    <p class="text-xs text-on-surface-variant line-clamp-2">Analyze liability caps, indemnification, and risk triggers.</p>
                </div>
            </button>

            <div class="flex items-center justify-between p-5 bg-white border border-outline-variant rounded-xl paper-shadow w-full">
                <div>
                    <span class="font-label-md uppercase text-on-surface-variant text-xs block mb-1">Total Audited</span>
                    <p class="text-xs text-on-surface-variant">Processed via Guard AI</p>
                </div>
                <span class="text-3xl font-bold tracking-tight text-primary">{{ $documents->total() }}</span>
            </div>

            <div class="flex items-center justify-between p-5 bg-white border border-outline-variant rounded-xl paper-shadow w-full">
                <div>
                    <span class="block text-on-surface-variant text-xs uppercase font-label-md mb-1">High Risk Exposure</span>
                    <p class="text-xs text-error/80">Requires litigation review</p>
                </div>
                <span class="text-3xl font-bold tracking-tight text-error">{{ $highRiskCount }}</span>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white border border-outline-variant rounded-xl paper-shadow overflow-hidden w-full">
            <div class="p-5 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
                <h4 class="font-title-md text-title-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">folder_managed</span> Compiled Document Ledgers
                </h4>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant bg-surface-container-low/40">
                            <th class="p-3.5 font-label-md font-bold text-on-surface-variant w-2/5 text-sm">Contract Name</th>
                            <th class="p-3.5 font-label-md font-bold text-on-surface-variant text-sm">Uploaded Date</th>
                            <th class="p-3.5 font-label-md font-bold text-on-surface-variant text-center text-sm">Risk Level</th>
                            <th class="p-3.5 font-label-md font-bold text-on-surface-variant text-center text-sm">Critical Issues</th>
                            <th class="p-3.5 font-label-md font-bold text-on-surface-variant text-right text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @forelse($documents as $doc)
                            @php
                                $r = $reportsById[$doc->id];
                                $meta = $riskMeta($r['score']);
                                $isDone = $r['status'] === 'done';
                            @endphp
                            <tr class="hover:bg-surface-container-low/60 transition-colors group" id="row-{{ $doc->id }}">
                                <td class="p-3.5 font-body-md font-semibold text-on-surface">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-primary text-xl shrink-0">description</span>
                                        <span class="truncate max-w-md lg:max-w-xl">{{ $r['title'] }}</span>
                                    </div>
                                </td>
                                <td class="p-3.5 font-body-md text-on-surface-variant text-sm whitespace-nowrap">{{ $r['date'] }}</td>
                                <td class="p-3.5 text-center whitespace-nowrap" id="status-cell-{{ $doc->id }}">
                                    @if(!$isDone)
                                        <span class="px-2.5 py-1 bg-primary/10 text-primary text-[11px] rounded-full font-bold inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                            <span>{{ $r['status'] === 'failed' ? 'FAILED' : ($r['progress'] . '%') }}</span>
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[11px] rounded-full font-bold inline-block" style="background:{{ $meta['soft'] }}; color:{{ $meta['main'] }}">{{ $meta['label'] }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center font-body-md text-on-surface font-medium text-sm">{{ $r['critical_issues'] }}</td>
                                <td class="p-3.5 text-right space-x-1.5 whitespace-nowrap">
                                    <button
                                        onclick="openPreview({{ $doc->id }})"
                                        {{ !$isDone ? 'disabled' : '' }}
                                        class="px-2.5 py-1 border border-outline-variant text-sm rounded-lg transition-colors inline-flex items-center gap-1 {{ !$isDone ? 'opacity-40 cursor-not-allowed' : 'hover:bg-surface-container-low' }}">
                                        <span class="material-symbols-outlined text-sm">visibility</span> Preview
                                    </button>
                                    <a href="{{ $r['pdf_url'] }}"
                                       class="px-2.5 py-1 bg-primary text-on-primary text-sm rounded-lg transition-opacity inline-flex items-center gap-1 {{ !$isDone ? 'opacity-40 pointer-events-none' : 'hover:opacity-90' }}">
                                        <span class="material-symbols-outlined text-sm">download</span> PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-on-surface-variant font-body-md">
                                    لا يوجد مستندات مرفوعة حالياً. ابدأ برفع أول عقد لبدء التحليل.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3.5 bg-surface-bright border-t border-outline-variant">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    {{-- ================= PREVIEW MODAL ================= --}}
    <div id="previewModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closePreview()"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all w-full max-w-2xl border border-outline-variant my-8">

                {{-- Header --}}
                <div class="relative px-6 py-4 border-b-2 border-[#4f46e5] flex items-center justify-between bg-surface-bright">
                    <div>
                        <h3 class="text-base font-bold text-[#4f46e5]">LexiGuard AI — Summary Report</h3>
                        <p id="modalFileName" class="text-xs text-on-surface-variant mt-0.5 truncate max-w-lg"></p>
                    </div>
                    <button onclick="closePreview()" class="text-on-surface-variant hover:text-on-surface shrink-0 p-1 rounded-lg hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>

                <div class="p-6 space-y-5 max-h-[60vh] overflow-y-auto custom-scrollbar">

                    {{-- Meta Grid --}}
                    <table class="w-full border-collapse text-xs">
                        <tr>
                            <td class="p-2.5 border border-outline-variant w-1/4">
                                <span class="block text-[9px] uppercase text-on-surface-variant mb-0.5">Uploaded Date</span>
                                <span id="modalDate" class="font-bold"></span>
                            </td>
                            <td class="p-2.5 border border-outline-variant w-1/4">
                                <span class="block text-[9px] uppercase text-on-surface-variant mb-0.5">Risk Score</span>
                                <span id="modalRiskScore" class="font-bold"></span>
                            </td>
                            <td class="p-2.5 border border-outline-variant w-1/4">
                                <span class="block text-[9px] uppercase text-on-surface-variant mb-0.5">Critical Issues</span>
                                <span id="modalCriticalIssues" class="font-bold"></span>
                            </td>
                            <td class="p-2.5 border border-outline-variant w-1/4">
                                <span class="block text-[9px] uppercase text-on-surface-variant mb-0.5">Status</span>
                                <span id="modalStatus" class="font-bold"></span>
                            </td>
                        </tr>
                    </table>

                    {{-- Executive Summary --}}
                    <div>
                        <h4 class="text-sm font-bold text-on-surface mb-1.5 pb-1 border-b border-outline-variant">Executive Summary</h4>
                        <div id="modalSummary" class="bg-surface-container rounded-lg border border-outline-variant p-3 text-xs text-on-surface whitespace-pre-line leading-relaxed"></div>
                    </div>

                    {{-- Risk Reasoning --}}
                    <div id="modalRiskReasonWrap" class="hidden">
                        <h4 class="text-sm font-bold text-on-surface mb-1.5 pb-1 border-b border-outline-variant">Risk Reasoning</h4>
                        <div id="modalRiskReason" class="bg-surface-container rounded-lg border border-outline-variant p-3 text-xs text-on-surface whitespace-pre-line leading-relaxed"></div>
                    </div>

                    {{-- Key Clauses --}}
                    <div id="modalClausesWrap" class="hidden">
                        <h4 class="text-sm font-bold text-on-surface mb-1.5 pb-1 border-b border-outline-variant">Key Clauses</h4>
                        <div id="modalClauses" class="space-y-2"></div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-surface-container px-6 py-3.5 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-outline-variant">
                    <span class="text-[10px] text-on-surface-variant italic">AI-generated. This is not a replacement for professional legal advice.</span>
                    <div class="flex items-center gap-2 shrink-0">
                        <a id="modalPdfLink" href="#" class="px-3 py-1.5 bg-[#4f46e5] text-white rounded-lg text-xs font-bold hover:opacity-90 transition-opacity inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF
                        </a>
                        <a id="modalWordLink" href="#" class="px-3 py-1.5 bg-white border border-outline-variant text-on-surface rounded-lg text-xs font-bold hover:bg-surface-container-low transition-colors inline-flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">description</span> Word
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
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
                div.className = 'border border-outline-variant rounded-lg p-2.5 bg-surface-bright';
                const title = document.createElement('div');
                title.className = 'font-bold text-[#4f46e5] text-xs';
                title.textContent = item.clause || 'Clause';
                const body = document.createElement('div');
                body.className = 'text-on-surface-variant text-[11px] mt-0.5 leading-relaxed';
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
                            cell.innerHTML = '<span class="px-2.5 py-1 bg-error-container text-on-error-container text-[11px] rounded-full font-bold">FAILED</span>';
                        } else if (data.status === 'done') {
                            anyJustFinished = true;
                        } else {
                            cell.innerHTML = '<span class="px-2.5 py-1 bg-primary/10 text-primary text-[11px] rounded-full font-bold inline-flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span><span>' + data.progress + '%</span></span>';
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