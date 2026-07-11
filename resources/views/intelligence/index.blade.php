@extends('layouts.app')

@section('title', isset($document) && $document ? $document->original_name . ' | Contract Intelligence' : 'Contract Intelligence')

@section('content')
<div class="w-full min-h-screen font-body-md text-on-surface antialiased flex">

    @if(!$document)
        {{-- ============================== --}}
        {{-- STATE 1: No document selected (upload view) --}}
        {{-- ============================== --}}
        <div class="w-full max-w-xl mx-auto text-center ">
            <div class="w-20 h-20 bg-primary-container/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-primary/10">
                <span class="material-symbols-outlined text-4xl">analytics</span>
            </div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-2">LexiGuard AI</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-md mx-auto">
                Please upload a new contract or select from recently analyzed files to initialize the intelligent processing suite.
            </p>

            @error('document')
                <p class="text-red-500 text-xs mb-4 font-semibold text-center animate-pulse">
                    {{ $message }}
                </p>
            @enderror

            <div class="border-2 border-dashed border-outline-variant rounded-2xl p-10 bg-surface-container-lowest hover:border-primary hover:shadow-md transition-all duration-300 mb-8 shadow-sm group">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="intelligence-upload-form">
                    @csrf
                    {{-- Tell the store() endpoint to bounce back here instead of Document History --}}
                    <input type="hidden" name="redirect_to" value="intelligence">
                    <label class="cursor-pointer flex flex-col items-center justify-center w-full">
                        <span class="material-symbols-outlined text-5xl text-outline group-hover:text-primary transition-colors mb-3">upload_file</span>
                        <span class="font-label-lg text-lg font-bold text-primary">Click to upload a new document</span>
                        <span class="font-body-sm text-body-sm text-outline mt-1.5">Supported formats: PDF, DOCX, TXT up to 10MB</span>
                        <input type="file" name="document" class="hidden" onchange="submitUploadForm(this)">
                    </label>
                </form>
            </div>

            @if(isset($recentDocuments) && $recentDocuments->isNotEmpty())
                <div class="text-left bg-surface-container-lowest rounded-xl p-6 border border-outline-variant shadow-sm">
                    <h3 class="font-label-sm text-label-sm text-outline uppercase tracking-widest mb-4">Recently Processed Instruments</h3>
                    <div class="divide-y divide-outline-variant">
                        @foreach($recentDocuments as $recent)
                            <a href="{{ route('intelligence.show', $recent) }}" class="flex items-center justify-between py-3.5 hover:text-primary transition-colors group">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-outline group-hover:text-primary text-[18px]">description</span>
                                    <span class="font-body-md text-body-md font-semibold text-on-surface group-hover:text-primary truncate max-w-md">{{ $recent->original_name }}</span>
                                </div>
                                <span class="material-symbols-outlined text-[16px] opacity-0 group-hover:opacity-100 -translate-x-1 group-hover:translate-x-0 transition-all">arrow_forward</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    @elseif($document->status !== 'done')
        {{-- ============================== --}}
        {{-- STATE 2: Document uploaded, analysis not ready yet --}}
        {{-- ============================== --}}
        <div class="w-full max-w-[480px] mx-auto text-center py-28 px-6">
            @if($document->status === 'failed')
                <div class="w-20 h-20 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-100">
                    <span class="material-symbols-outlined text-4xl">error</span>
                </div>
                <h1 class="font-headline-md text-headline-md text-on-surface mb-2">Analysis failed</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mb-8">
                    We couldn't process <span class="font-semibold text-on-surface">{{ $document->original_name }}</span>.
                    The file may be corrupted, password-protected, or contain no extractable text.
                </p>
                <a href="{{ route('intelligence.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-lg font-label-md text-label-md font-bold hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    Upload a different document
                </a>
            @else
                {{-- Animated "Analyzing" card, mirrors the Document Analyzing screen --}}
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm relative overflow-hidden text-left">

                    {{-- Thin top progress line --}}
                    <div class="absolute top-0 left-0 w-full h-1 bg-surface-container-high">
                        <div class="h-full bg-primary transition-all duration-1000 ease-in-out" id="progress-line" style="width: {{ $document->progress }}%;"></div>
                    </div>

                    <div class="mb-6 relative flex justify-center">
                        <div class="w-24 h-24 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-center animate-pulse">
                            <span class="material-symbols-outlined text-primary text-[48px]" style="font-variation-settings: 'FILL' 1;">description</span>
                        </div>
                    </div>

                    <div class="space-y-1 mb-8 text-center">
                        <h1 class="font-headline-md text-headline-md text-on-surface">Analyzing document&hellip;</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant truncate">{{ $document->original_name }}</p>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-end mb-1">
                            <span class="font-label-md text-label-md text-primary uppercase tracking-wider animate-pulse">Processing&hellip;</span>
                            <span class="font-label-md text-label-md text-on-surface font-bold transition-all duration-500 tabular-nums" id="percent-text">{{ $document->progress }}%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden relative">
                            <div class="h-full bg-primary rounded-full transition-all duration-1000 ease-in-out relative" id="main-progress" style="width: {{ $document->progress }}%;">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-[shimmer_1.5s_infinite] w-full h-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes shimmer {
                        0% { transform: translateX(-100%); }
                        100% { transform: translateX(100%); }
                    }
                </style>

                <script>
                    (function () {
                        const statusUrl = "{{ route('documents.status', $document) }}";
                        const progressBar = document.getElementById('main-progress');
                        const progressLine = document.getElementById('progress-line');
                        const percentText = document.getElementById('percent-text');

                        let currentProgress = {{ $document->progress }};

                        const poll = setInterval(async () => {
                            try {
                                const res = await fetch(statusUrl);
                                const data = await res.json();

                                if (data.progress >= currentProgress) {
                                    currentProgress = data.progress;
                                    progressBar.style.width = `${currentProgress}%`;
                                    progressLine.style.width = `${currentProgress}%`;
                                    percentText.textContent = `${currentProgress}%`;
                                }

                                if (data.status === 'done' || data.status === 'failed' || currentProgress >= 100) {
                                    clearInterval(poll);
                                    // Reload in place — this same URL renders the full
                                    // analytics view (or the failed state) once status flips.
                                    setTimeout(() => window.location.reload(), 1200);
                                }
                            } catch (error) {
                                console.error('Error fetching document status:', error);
                            }
                        }, 1500);
                    })();
                </script>
            @endif
        </div>

    @else
        {{-- ============================== --}}
        {{-- STATE 3: Full analytics suite (status = done) --}}
        {{-- ============================== --}}
        @php
            // clauses_analysis holds both real per-clause findings AND a synthesized
            // "Critical issues" entry (see AnalyzeDocumentJob) — flag it so we can badge it.
            $clauses = $analysis->clauses_analysis ?? [];
            $highlightClauses = collect($clauses)->take(2);

            // Same risk banding used on the Contract Summary page, so the two views
            // always agree on what "High/Medium/Low" means for a given score.
            $riskScoreValue = $analysis->risk_score ?? 0;
            if ($riskScoreValue > 70) {
                $badgeClass = 'bg-error-container text-error border border-error/20';
                $statusText = 'High Risk';
                $riskColor = 'red';
            } elseif ($riskScoreValue > 40) {
                $badgeClass = 'bg-warning-container text-warning border border-warning/20';
                $statusText = 'Medium Risk';
                $riskColor = 'amber';
            } else {
                $badgeClass = 'bg-success-container text-success border border-success/20';
                $statusText = 'Low Risk';
                $riskColor = 'green';
            }
            $riskStrokeClass = ['red' => 'text-red-500', 'amber' => 'text-amber-500', 'green' => 'text-emerald-500'][$riskColor];
        @endphp
        <main class="flex flex-col overflow-hidden w-full relative">

            {{-- Page header: document name + primary actions (mirrors the Contract Summary page) --}}
            <div class="h-16 px-8 border-b border-outline-variant flex items-center justify-between gap-4 shrink-0 bg-surface-container-lowest">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined text-primary shrink-0">description</span>
                    <span class="font-body-md text-body-md font-semibold text-on-surface truncate">
                        {{ $document->title ?? $document->original_name }}
                    </span>
                    <span class="{{ $badgeClass }} px-2.5 py-1 rounded-full text-[11px] font-bold shrink-0">
                        {{ $statusText }}
                    </span>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('documents.chat', $document->id) }}"
                       class="px-4 py-2 border border-outline-variant rounded-lg font-semibold bg-surface-container-low hover:bg-surface-container transition-all flex items-center gap-1.5 text-body-sm text-on-surface">
                        <span class="material-symbols-outlined text-[18px]">smart_toy</span>
                        Chat with AI
                    </a>
                    <a href="{{ route('documents.export-pdf', $document) }}"
                       class="px-4 py-2 bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-opacity flex items-center gap-1.5 text-body-sm shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Export PDF
                    </a>
                </div>
            </div>

            <div class="flex-1 flex overflow-hidden">

                {{-- A) Document canvas: real extracted text --}}
<section class="w-full max-w-xl flex flex-col h-[calc(100vh-140px)] overflow-y-auto border border-outline-variant rounded-xl bg-surface-container-lowest shadow-sm scrollbar-thin mr-5 my-8">
    <div class="p-10 font-serif text-[13px] relative leading-relaxed">

        <div class="text-center font-sans font-bold text-sm tracking-widest uppercase mb-6 border-b border-outline-variant pb-4 text-on-surface sticky top-0 bg-surface-container-lowest z-10">
            {{ $document->original_name }}
        </div>

        <p class="mb-6 text-[11px] font-sans text-outline uppercase tracking-wide">
            Uploaded {{ $document->created_at->format('F d, Y') }}
        </p>

        @if(filled($document->extracted_text))
            <div class="whitespace-pre-line text-on-surface-variant leading-relaxed select-text">
                {{ $document->extracted_text }}
            </div>
        @else
            <p class="text-outline italic text-center py-12">No extracted text is available for this document.</p>
        @endif
    </div>
</section>>

                {{-- B) Analytics intelligence panel --}}
                <section class="w-[390px] flex-1 border-l border-outline-variant bg-surface-container-lowest flex flex-col overflow-y-auto shrink-0 p-6 space-y-6 scrollbar-none shadow-sm relative z-10">

                    {{-- Risk gauge --}}
                    <div>
                        <h3 class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-3">Risk Assessment</h3>
                        <div class="flex flex-col items-center border border-outline-variant rounded-2xl p-5 bg-surface-container-low/50">
                            <div class="relative w-28 h-28 flex items-center justify-center mb-3">
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                    <circle class="text-outline-variant" cx="50" cy="50" fill="transparent" r="41" stroke="currentColor" stroke-width="7.5"></circle>
                                    <circle class="{{ $riskStrokeClass }}"
                                            cx="50" cy="50" fill="transparent" r="41" stroke="currentColor"
                                            stroke-dasharray="257.6"
                                            stroke-dashoffset="{{ 257.6 - (257.6 * $riskScoreValue) / 100 }}"
                                            stroke-linecap="round" stroke-width="7.5"></circle>
                                </svg>
                                <div class="text-center">
                                    <span class="text-3xl font-black text-on-surface leading-none tracking-tight tabular-nums">{{ $riskScoreValue }}</span>
                                    <p class="text-[10px] font-bold text-outline uppercase mt-0.5 tracking-wider">Out of 100</p>
                                </div>
                            </div>

                            <span class="{{ $badgeClass }} px-3 py-1 rounded-full text-[11px] font-bold mb-2">
                                Status: {{ $statusText }}
                            </span>

                            @if(isset($analysis->ai_confidence))
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-3 py-1 rounded-full border border-emerald-200 mb-2.5 shadow-sm">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> {{ $analysis->ai_confidence }}% Confidence Score
                                </span>
                            @endif

                            @if(!empty($analysis->risk_reason))
                                <div class="w-full mt-1 pt-2.5 border-t border-outline-variant/50 flex items-start gap-1.5 text-[12px] text-on-surface-variant text-left">
                                    <span class="material-symbols-outlined text-sm text-primary shrink-0 mt-0.5">info</span>
                                    <p><strong class="text-on-surface">Reason:</strong> {{ $analysis->risk_reason }}</p>
                                </div>
                            @else
                                <p class="font-body-sm text-body-sm text-on-surface-variant text-center leading-relaxed font-medium px-1">
                                    {{ $riskScoreValue > 70 ? 'High risk profile detected. Review flagged clauses before signing.' : ($riskScoreValue > 40 ? 'Moderate risk profile detected.' : 'Low risk profile. No major red flags detected.') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Meta metrics --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="border border-outline-variant rounded-xl p-3 bg-surface-container-low/40 shadow-sm">
                            <span class="font-label-sm text-[10px] font-bold text-outline uppercase tracking-wider">File Type</span>
                            <p class="font-body-md text-sm font-bold text-on-surface mt-1 truncate uppercase">{{ $document->file_type }}</p>
                        </div>
                        <div class="border border-outline-variant rounded-xl p-3 bg-surface-container-low/40 shadow-sm">
                            <span class="font-label-sm text-[10px] font-bold text-outline uppercase tracking-wider">Analyzed On</span>
                            <p class="font-body-md text-sm font-bold text-on-surface mt-1">{{ $document->updated_at->format('M d, Y') }}</p>
                        </div>
                        @if(isset($analysis->critical_issues))
                            <div class="col-span-2 border border-outline-variant rounded-xl p-3 bg-surface-container-low/40 shadow-sm flex items-center justify-between">
                                <span class="font-label-sm text-[10px] font-bold text-outline uppercase tracking-wider">Critical Issues Count</span>
                                <span class="font-body-md text-sm font-bold text-red-600">{{ $analysis->critical_issues }} Issues</span>
                            </div>
                        @endif
                    </div>

                    {{-- Executive summary --}}
                    @if(filled($analysis->summary ?? null))
                        <div>
                            <h4 class="font-body-md text-sm font-bold text-on-surface flex items-center gap-2 mb-2.5">
                                <span class="material-symbols-outlined text-primary text-lg">auto_awesome</span> Executive Summary
                            </h4>
                            <p class="text-[13px] text-on-surface-variant leading-relaxed bg-surface-container-low p-4 rounded-xl border border-outline-variant">
                                {{ $analysis->summary }}
                            </p>
                        </div>
                    @endif

                    {{-- Highlights (top findings — full list is in the table below) --}}
                    @if($highlightClauses->isNotEmpty())
                        <div>
                            <h3 class="font-label-sm text-label-sm text-outline tracking-widest uppercase mb-2.5">Key Findings</h3>
                            <div class="space-y-2.5">
                                @foreach($highlightClauses as $item)
                                    @php($isCritical = ($item['clause'] ?? '') === 'Critical issues')
                                    <div class="{{ $isCritical ? 'bg-red-50/50 border-red-100' : 'bg-primary-container/5 border-primary/15' }} border rounded-xl p-3.5 flex gap-3">
                                        <span class="material-symbols-outlined {{ $isCritical ? 'text-red-500' : 'text-primary' }} text-lg mt-0.5">
                                            {{ $isCritical ? 'warning' : 'gavel' }}
                                        </span>
                                        <div class="text-[13px] min-w-0">
                                            <p class="font-bold {{ $isCritical ? 'text-red-950' : 'text-on-surface' }} mb-0.5 truncate">{{ $item['clause'] ?? 'Clause' }}</p>
                                            <p class="{{ $isCritical ? 'text-red-900/80' : 'text-on-surface-variant' }} leading-relaxed line-clamp-3">{{ $item['analysis'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>
            </div>

            {{-- C) Full clause-by-clause table --}}
            <footer class="h-72 border-t border-outline-variant bg-surface-container-lowest flex flex-col shrink-0 overflow-hidden shadow-md relative z-20">

                <div class="flex border-b border-outline-variant px-6 bg-surface-container-low text-xs font-extrabold text-outline shrink-0 tracking-wider uppercase">
                    <button class="px-5 py-3.5 border-b-2 border-primary text-primary font-black bg-surface-container-lowest">
                        Clause Analysis ({{ count($clauses) }})
                    </button>
                    <button class="px-5 py-3.5 text-outline-variant cursor-not-allowed" title="Not available yet">Missing Clauses</button>
                    <button class="px-5 py-3.5 text-outline-variant cursor-not-allowed" title="Not available yet">Obligations</button>
                    <button class="px-5 py-3.5 text-outline-variant cursor-not-allowed" title="Not available yet">Version History</button>
                </div>

                <div class="flex-1 overflow-y-auto px-6 py-3 scrollbar-thin">
                    @if(count($clauses))
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="text-xs font-bold text-outline tracking-widest border-b border-outline-variant uppercase bg-surface-container-lowest sticky top-0 z-10 py-2">
                                    <th class="pb-3 pt-1 w-1/4">Clause</th>
                                    <th class="pb-3 pt-1 w-2/4">Analysis</th>
                                    <th class="pb-3 pt-1 w-1/4 text-right">Type</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant text-on-surface-variant font-medium text-[13px]">
                                @foreach($clauses as $item)
                                    @php($isCritical = ($item['clause'] ?? '') === 'Critical issues')
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3.5 font-bold text-on-surface align-top">{{ $item['clause'] ?? 'Clause' }}</td>
                                        <td class="py-3.5 text-on-surface-variant leading-relaxed align-top">{{ $item['analysis'] ?? '' }}</td>
                                        <td class="py-3.5 text-right align-top">
                                            @if($isCritical)
                                                <span class="bg-red-100 text-red-700 text-[10px] font-black px-2 py-0.5 rounded tracking-wide">CRITICAL</span>
                                            @else
                                                <span class="bg-surface-container text-on-surface-variant text-[10px] font-black px-2 py-0.5 rounded tracking-wide border border-outline-variant">CLAUSE</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="h-full flex items-center justify-center text-outline font-label-md text-label-md">
                            No clause-level findings were returned for this document.
                        </div>
                    @endif
                </div>
            </footer>
        </main>
    @endif
</div>

<script>
    function submitUploadForm(input) {   

        if (input.files && input.files.length > 0) {
            document.getElementById('intelligence-upload-form').submit();
        }
    }
</script>
@endsection