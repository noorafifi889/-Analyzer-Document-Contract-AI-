@php
    $clauses = $analysis->clauses_analysis ?? [];

    // Separate "Critical issues" from regular clauses once
    $criticalEntry = collect($clauses)->first(fn($c) => ($c['clause'] ?? '') === 'Critical issues');
    $regularClauses = collect($clauses)->reject(fn($c) => ($c['clause'] ?? '') === 'Critical issues')->values();
    $criticalIssuesList = $criticalEntry
        ? array_values(array_filter(array_map('trim', explode('|', $criticalEntry['analysis'] ?? ''))))
        : [];

    $riskScoreValue = $analysis->risk_score ?? 0;
    if ($riskScoreValue > 70) {
        $verdictColor = '#DC2626';
        $verdictSoft = '#FEE2E2';
        $statusText = 'High Risk';
    } elseif ($riskScoreValue > 40) {
        $verdictColor = '#D97706';
        $verdictSoft = '#FEF3C7';
        $statusText = 'Medium Risk';
    } else {
        $verdictColor = '#059669';
        $verdictSoft = '#D1FAE5';
        $statusText = 'Low Risk';
    }

    // Fallback data
    $missingClauses = $analysis->missing_clauses ?? [
        [
            'clause' => 'Governing Law & Jurisdiction',
            'risk' => 'High',
            'reason' => 'Missing explicit jurisdiction leaves company vulnerable to cross-border litigation costs.',
        ],
        [
            'clause' => 'Data Protection Addendum (DPA)',
            'risk' => 'Medium',
            'reason' => 'Required for GDPR/CCPA compliance since the contract involves user data transfer.',
        ],
    ];

    $obligations = $analysis->obligations ?? [
        [
            'due_date' => 'Within 14 days',
            'type' => 'Financial',
            'desc' => 'Initial setup fee payment activation deadline.',
        ],
        [
            'due_date' => 'End of Q3 2026',
            'type' => 'Compliance',
            'desc' => 'Submit compliance report regarding data encryption frameworks.',
        ],
    ];

    // Dummy dynamic list for last 5 contracts if not passed from controller
    $recentDocuments = $recentDocuments ?? collect([]);

    $riskDistribution = $analysis->risk_distribution ?? [
        'Legal' => 0,
        'Financial' => 0,
        'Privacy' => 0,
        'Compliance' => 0,
    ];

    $riskColorPalette = ['#F87171', '#FBBF24', '#34D399', '#818CF8', '#38BDF8', '#F472B6'];
@endphp

@extends('layouts.app')

@section('title', isset($document) && $document ? $document->original_name . ' | Contract Intelligence Hub' : 'Contract
    Intelligence Hub')

@section('content')
    <div class="w-full antialiased text-[#0F172A] -mt-4 font-sans selection:bg-indigo-100" x-data="{ currentTab: 'ledger' }">

        @if (!$document)
    
            <div class="w-full max-w-3xl mx-auto text-center mt-10">

                <div class="flex items-center justify-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 shrink-0 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center border border-indigo-100 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">gavel</span>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-[#0F172A]">LexiGuard AI</h1>
                </div>

                <p class="text-slate-600 mb-8 max-w-md mx-auto text-base">
                    Upload a new contract or select from recently analyzed documents to launch the compliance audit
                    execution layer.
                </p>

                @error('document')
                    <p class="text-red-600 text-sm mb-4 font-bold text-center">{{ $message }}</p>
                @enderror
                <div
                    class="border-2 border-dashed border-slate-200 rounded-2xl p-12 bg-white hover:border-indigo-500 hover:shadow-lg transition-all duration-300 mb-12 group">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
                        id="intelligence-upload-form">
                        @csrf
                        <input type="hidden" name="redirect_to" value="intelligence">
                        <label class="cursor-pointer flex flex-col items-center justify-center w-full">
                            <span
                                class="material-symbols-outlined text-6xl text-indigo-500 group-hover:text-indigo-600 transition-colors mb-4">upload_file</span>
                            <span class="text-lg font-bold text-[#0F172A]">Click to upload new document</span>
                            <span class="text-sm text-slate-400 mt-2 font-mono">PDF · DOCX · TXT — Up to 10MB</span>
                            <input type="file" name="document" class="hidden" onchange="submitUploadForm(this)">
                        </label>
                    </form>
                </div>

                {{-- Recent Documents Section (آخر 5 ملفات) --}}
                <div class="text-left max-w-2xl mx-auto">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100">
                        <span class="material-symbols-outlined text-indigo-500 text-xl">history</span>
                        <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-slate-500">Recent Analyzed
                            Contracts</h3>
                    </div>

                    @if ($recentDocuments->isNotEmpty())
                        <div
                            class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm divide-y divide-slate-100">
                            @foreach ($recentDocuments->take(5) as $recent)
                                <a href="{{ route('intelligence.show', $recent->id) }}"
                                    class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span
                                            class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 transition-colors">description</span>
                                        <div class="truncate">
                                            <p class="text-sm font-bold text-slate-800 truncate">
                                                {{ $recent->title ?? $recent->original_name }}</p>
                                            <p class="text-xs text-slate-400 font-mono mt-0.5">
                                                {{ $recent->created_at ? $recent->created_at->diffForHumans() : 'Recently' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        @if ($recent->status === 'done')
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-green-50 text-green-700 border border-green-200">Ready</span>
                                        @elseif($recent->status === 'failed')
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-red-50 text-red-700 border border-red-200">Failed</span>
                                        @else
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-amber-50 text-amber-600 border border-amber-200 animate-pulse">Processing</span>
                                        @endif
                                        <span
                                            class="material-symbols-outlined text-sm text-slate-300 group-hover:text-slate-500 transition-colors">arrow_forward_ios</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="bg-slate-50 border border-slate-200 rounded-xl p-6 text-center text-sm text-slate-400 italic">
                            No recently processed documents found in this session workspace.
                        </div>
                    @endif
                </div>
            </div>
        @elseif($document->status === 'failed')
            {{-- ============================== --}}
            {{-- STATE 2b: Analysis failed      --}}
            {{-- ============================== --}}
            <div class="w-full max-w-xl mx-auto py-24 px-4">
                <div class="bg-white border border-red-200 rounded-2xl p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-red-600"></div>

                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-20 h-20 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 border border-red-100">
                            <span class="material-symbols-outlined text-4xl">error</span>
                        </div>

                        <h1 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Analysis Failed</h1>
                        <p class="text-sm text-slate-500 max-w-xs mb-8">
                            حصل خطأ أثناء معالجة هالعقد. ممكن يكون الملف تالف أو صيغته غير مدعومة.
                        </p>

                        <div
                            class="w-full bg-slate-50 rounded-xl p-4 border border-slate-100 text-left mb-6 flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                <span class="material-symbols-outlined text-xl">description</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-mono text-slate-400 uppercase font-bold tracking-wider">Target
                                    Resource</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $document->original_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full">
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm">
                                    حذف الملف
                                </button>
                            </form>
                            <a href="{{ route('documents.index') }}"
                                class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors text-sm text-center">
                                ارفع ملف جديد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($document->status !== 'done')
            {{-- ============================== --}}
            {{-- STATE 2: Analysis in progress  --}}
            {{-- ============================== --}}
            <div class="w-full max-w-xl mx-auto py-24 px-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-xl relative overflow-hidden">
                    {{-- Decorative Top Glow Banner --}}
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                    </div>

                    <div class="flex flex-col items-center text-center">
                        {{-- Animated Progress Ring/Spinner Wrapper --}}
                        <div class="relative w-20 h-20 flex items-center justify-center mb-6">
                            <div class="absolute inset-0 rounded-full border-4 border-indigo-50 opacity-100"></div>
                            <div
                                class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin">
                            </div>
                            <span class="material-symbols-outlined text-3xl text-indigo-600 animate-pulse">cognition</span>
                        </div>

                        <h1 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Processing Ingestion Pipeline
                        </h1>
                        <p class="text-sm text-slate-500 max-w-xs mb-8">AI is parsing the contract corpus, structure
                            mapping, and verifying global compliance parameters...</p>

                        {{-- Current File Status Block --}}
                        <div class="w-full bg-slate-50 rounded-xl p-4 border border-slate-100 text-left mb-6 flex items-center gap-3"
                            id="statusBlock">
                            <span
                                class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                <span class="material-symbols-outlined text-xl">quick_reference_all</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-mono text-slate-400 uppercase font-bold tracking-wider">Target
                                    Resource</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $document->original_name }}</p>
                            </div>
                            <span
                                class="font-mono text-sm font-black text-indigo-600 bg-white px-2.5 py-1 rounded-md border border-slate-200 shadow-sm"
                                id="progressPercentText">{{ $document->progress ?? 0 }}%</span>
                        </div>

                        {{-- Main Progress Bar Track --}}
                        <div class="w-full">
                            <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-600 transition-all duration-500 rounded-full shadow-sm"
                                    id="progressBarFill" style="width: {{ $document->progress ?? 0 }}%;"></div>
                            </div>
                            <div
                                class="flex justify-between items-center mt-3 text-xs font-mono font-bold text-slate-400 uppercase tracking-wide">
                                <span>Ingestion Engine</span>
                                <span class="text-indigo-500 animate-pulse">Running Neural Analytics...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- ============================== --}}
            {{-- STATE 3: Full Enterprise SaaS Dossier View --}}
            {{-- ============================== --}}
            <div class="flex flex-col gap-6">

                {{-- Document Meta & Multi-format Export Bar --}}
                <div
                    class="flex flex-wrap items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-4 min-w-0">
                        <span
                            class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-indigo-50 text-indigo-600 border border-indigo-100">
                            <span class="material-symbols-outlined text-2xl">description</span>
                        </span>
                        <div class="min-w-0">
                            <h2 class="text-base font-extrabold text-slate-900 truncate">
                                {{ $document->title ?? $document->original_name }}</h2>
                            <p class="text-xs font-mono text-slate-500 mt-0.5">Classification: <span
                                    class="text-indigo-600 font-bold">Commercial Agreement</span> · Ingested Today</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-mono font-extrabold tracking-wider uppercase shadow-sm"
                            style="background: {{ $verdictSoft }}; color: {{ $verdictColor }};">
                            {{ $statusText }}
                        </span>
                    </div>

                    {{-- Actions Bar --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('documents.chat', $document->id) }}"
                            class="px-4 py-2.5 border border-slate-200 rounded-xl font-bold bg-indigo-50 hover:bg-indigo-100 transition-all flex items-center gap-2 text-sm text-indigo-600 shadow-sm">
                            <span class="material-symbols-outlined text-lg fill-1">chat</span>
                            Persistent AI Chat
                        </a>

                        <a href="{{ route('documents.export-pdf', $document) }}"
                            class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors flex items-center gap-2 text-sm shadow-sm">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Export PDF Dossier
                        </a>
                    </div>
                </div>

                {{-- Grid Structure: Balanced Layout --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                    {{-- A) Interactive Document Canvas (5 Columns) --}}
                    <div
                        class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden min-h-[650px] max-h-[750px]">
                        <div
                            class="p-4 border-b border-slate-100 bg-slate-50/70 flex justify-between items-center shrink-0">
                            <span
                                class="font-mono text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-indigo-500">auto_stories</span>
                                Interactive PDF Corpus
                            </span>
                            <span
                                class="text-[11px] text-slate-500 bg-white px-2 py-0.5 border border-slate-200 rounded font-mono">Highlighting
                                Active</span>
                        </div>
                        <div class="p-6 overflow-y-auto flex-1 text-base text-slate-800 leading-relaxed font-normal select-text whitespace-pre-line bg-white"
                            dir="auto">
                            @if (filled($document->extracted_text))
                                {{ $document->extracted_text }}
                            @else
                                <div
                                    class="text-slate-400 italic text-center py-32 flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-5xl text-slate-300">find_in_page</span>
                                    No extractable text corpus isolated.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- B) Advanced AI Verdict & Insights Rail (7 Columns) --}}
                    <div class="lg:col-span-7 space-y-6 min-h-[650px] max-h-[750px] overflow-y-auto pr-2">

                        {{-- AI Verdict Dashboard Card --}}
                        <div class="rounded-2xl p-6 bg-[#0F172A] shadow-md text-white relative overflow-hidden">
                            <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                                style="background-image: radial-gradient(#4f46e5 1px, transparent 1px); background-size: 16px 16px;">
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <p class="font-mono text-xs text-indigo-400 uppercase tracking-widest font-bold">AI Verdict
                                    Layer</p>
                                <span class="text-xs font-mono text-slate-400">Confidence Model v2.4</span>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="relative w-24 h-24 shrink-0">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" fill="transparent" r="41"
                                            stroke="rgba(255,255,255,0.08)" stroke-width="7"></circle>
                                        <circle cx="50" cy="50" fill="transparent" r="41"
                                            stroke="{{ $verdictColor }}" stroke-dasharray="257.6"
                                            stroke-dashoffset="{{ 257.6 - (257.6 * $riskScoreValue) / 100 }}"
                                            stroke-linecap="round" stroke-width="7"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                                        <span
                                            class="text-2xl font-black text-white tabular-nums">{{ $riskScoreValue }}</span>
                                        <span class="font-mono text-[9px] text-slate-400 uppercase">/ 100</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold mb-2"
                                        style="background: {{ $verdictSoft }}; color: {{ $verdictColor }};">
                                        {{ $statusText }}
                                    </span>
                                    @if (isset($analysis->ai_confidence))
                                        <p class="font-mono text-xs text-indigo-400 mb-1 font-bold">
                                            {{ $analysis->ai_confidence }}% Neural Certainty</p>
                                    @endif
                                    <p class="text-sm text-slate-300 leading-relaxed">
                                        {{ $riskScoreValue > 70 ? 'Critical vulnerabilities identified. Comprehensive legal review highly mandated.' : ($riskScoreValue > 40 ? 'Moderate exposure issues mapped. Standard caution flags active.' : 'Low risk profile verified. Terms conform with safe harbor paradigms.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Risk Distribution Matrix --}}
    <div class="mt-5 pt-4 border-t border-slate-800 space-y-3">
    <p class="font-mono text-xs text-slate-400 uppercase tracking-wider font-semibold">Risk Weight Distribution</p>

    @php
        // 1. التأكد أولاً إذا كانت القيمة مخزنة كـ string وعمل decode لها
        $finalDistribution = is_string($riskDistribution) ? json_decode($riskDistribution, true) : $riskDistribution;

        // 2. إذا كانت فارغة تماماً بعد الـ decode، نضع القيم الافتراضية كـ fallback
        if (empty($finalDistribution)) {
            $finalDistribution = [
                'Legal' => 0,
                'Financial' => 0,
                'Privacy' => 0,
                'Compliance' => 0,
            ];
        }
    @endphp

    {{-- الفحص بناءً على المصفوفة الموحدة والآمنة --}}
    @if(!empty($finalDistribution) && count($finalDistribution))
        <div class="grid gap-3 text-center text-xs font-mono"
             style="grid-template-columns: repeat({{ min(count($finalDistribution), 4) }}, minmax(0, 1fr));">
            @foreach($finalDistribution as $label => $percent)
                @php $color = $riskColorPalette[$loop->index % count($riskColorPalette)] ?? '#fff'; @endphp
                <div class="bg-slate-800/60 p-2.5 rounded-xl border border-slate-800/80">
                    <span class="block text-sm font-bold mb-0.5" style="color: {{ $color }};">
                        {{ (int) $percent }}%
                    </span>
                    {{ $label }}
                </div>
            @endforeach
        </div>
    @else
        <p class="text-xs text-slate-500 italic">No distribution data available.</p>
    @endif
</div>
                        </div>

                        {{-- AI Insights Cards --}}
                        @if (filled($analysis->summary ?? null))
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 border-l-4 border-l-indigo-500 shadow-sm"
                                dir="auto">
                                <h4
                                    class="font-mono text-xs text-indigo-600 uppercase tracking-widest mb-2 flex items-center gap-2 font-bold">
                                    <span class="material-symbols-outlined text-base">auto_awesome</span> Executive AI
                                    Insights Brief
                                </h4>
                                <p class="text-base text-slate-700 leading-relaxed font-normal">{{ $analysis->summary }}
                                </p>
                            </div>
                        @endif

                        {{-- Critical Structural Breaches --}}
                        @if (count($criticalIssuesList))
                            <div class="rounded-2xl overflow-hidden border border-red-200 shadow-sm">
                                <div class="px-4 py-2.5 flex items-center gap-2 bg-red-600 text-white">
                                    <span class="material-symbols-outlined text-base">report</span>
                                    <span class="text-xs font-bold uppercase tracking-wider">Critical Structural
                                        Breaches</span>
                                </div>
                                <div class="bg-white divide-y divide-red-100">
                                    @foreach ($criticalIssuesList as $issue)
                                        <div class="px-4 py-3 flex items-start gap-3 bg-red-50/30" dir="auto">
                                            <span class="w-2 h-2 rounded-full bg-red-600 mt-2 shrink-0"></span>
                                            <p class="text-base text-red-950 leading-relaxed font-medium">
                                                {{ $issue }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- C) The SaaS Multi-Tab Intelligence Console --}}
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mt-4">

                    {{-- Dynamic Tab Switchers --}}
                    <div
                        class="flex border-b border-slate-200 bg-slate-50 text-xs font-bold text-slate-500 tracking-wider uppercase font-mono">
                        <button @click="currentTab = 'ledger'"
                            :class="currentTab === 'ledger' ? 'border-b-indigo-600 text-[#0F172A] bg-white text-sm' : ''"
                            class="px-6 py-4 border-b-2 border-transparent transition-all font-extrabold">
                            Clause Ledger Findings ({{ $regularClauses->count() }})
                        </button>
                        <button @click="currentTab = 'missing'"
                            :class="currentTab === 'missing' ? 'border-b-indigo-600 text-[#0F172A] bg-white text-sm' : ''"
                            class="px-6 py-4 border-b-2 border-transparent transition-all font-extrabold flex items-center gap-2">
                            Missing Clauses Detector <span
                                class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ count($missingClauses) }}</span>
                        </button>
                        <button @click="currentTab = 'timeline'"
                            :class="currentTab === 'timeline' ? 'border-b-indigo-600 text-[#0F172A] bg-white text-sm' : ''"
                            class="px-6 py-4 border-b-2 border-transparent transition-all font-extrabold flex items-center gap-2">
                            Obligations Timeline <span
                                class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">{{ count($obligations) }}</span>
                        </button>
                    </div>

                    <div class="p-5 min-h-[250px]">

                        {{-- TAB 1: Clause Ledger --}}
                        <div x-show="currentTab === 'ledger'">
                            @if ($regularClauses->isNotEmpty())
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr
                                                class="text-xs font-mono font-bold text-slate-400 tracking-widest border-b border-slate-200 uppercase">
                                                <th class="pb-3 w-16">Index</th>
                                                <th class="pb-3 w-1/4">Clause Category</th>
                                                <th class="pb-3 w-2/4">Granular AI Analysis Mapping</th>
                                                <th class="pb-3 w-1/4 text-right">AI Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-slate-800 text-base">
                                            @foreach ($regularClauses as $item)
                                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                                    <td class="py-4 font-mono text-indigo-600 font-bold align-top">
                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                                    <td class="py-4 font-bold align-top text-[#0F172A]" dir="auto">
                                                        {{ $item['clause'] ?? 'Unclassified Clause' }}</td>
                                                    <td class="py-4 text-slate-700 leading-relaxed align-top font-normal pr-4"
                                                        dir="auto">
                                                        {{ $item['analysis'] ?? 'No evaluation parameters populated.' }}
                                                    </td>
                                                    <td class="py-4 align-top text-right space-x-2 whitespace-nowrap">
                                                        <button title="Explain Clause"
                                                            class="px-3 py-1.5 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 hover:text-indigo-600 transition-all inline-flex items-center gap-1">
                                                            <span
                                                                class="material-symbols-outlined text-sm">translate</span>
                                                            Explain
                                                        </button>
                                                        <button title="Rewrite & Improve Clause"
                                                            class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all inline-flex items-center gap-1">
                                                            <span
                                                                class="material-symbols-outlined text-sm">edit_note</span>
                                                            Rewrite
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-slate-400 py-12 text-base">No structured data findings
                                    populated yet.</div>
                            @endif
                        </div>

                        {{-- TAB 2: Missing Clauses Detector --}}
                        <div x-show="currentTab === 'missing'" style="display: none;">
                            <div class="space-y-4">
                                @foreach ($missingClauses as $mClause)
                                    <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl flex flex-wrap items-start justify-between gap-4"
                                        dir="auto">
                                        <div class="space-y-2 max-w-3xl">
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <h5 class="font-extrabold text-base text-[#0F172A]">
                                                    {{ $mClause['clause'] }}</h5>
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-mono font-bold rounded bg-red-100 text-red-700 uppercase shadow-sm">{{ $mClause['risk'] }}
                                                    Risk</span>
                                            </div>
                                            <p class="text-sm text-slate-700 leading-relaxed"><span
                                                    class="font-mono text-xs text-indigo-600 font-bold block uppercase mb-0.5">Recommendation
                                                    Matrix:</span>{{ $mClause['reason'] }}</p>
                                        </div>
                                        <button
                                            class="shrink-0 text-xs font-bold text-indigo-600 border border-indigo-200 bg-white px-4 py-2 rounded-xl hover:bg-indigo-50 transition-all shadow-sm">
                                            + Draft Clause
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- TAB 3: Obligations & Deadlines Timeline --}}
                        <div x-show="currentTab === 'timeline'" style="display: none;">
                            <div class="relative border-l-2 border-indigo-100 ml-4 my-3 pl-8 space-y-6">
                                @foreach ($obligations as $ob)
                                    <div class="relative" dir="auto">
                                        <span
                                            class="absolute -left-[39px] top-1 w-5 h-5 rounded-full bg-white border-2 border-indigo-600 flex items-center justify-center shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                        </span>
                                        <div class="bg-white border border-slate-200 p-4 rounded-xl shadow-sm max-w-2xl">
                                            <div class="flex items-center justify-between gap-4 mb-2">
                                                <span
                                                    class="text-xs font-bold font-mono bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg">{{ $ob['due_date'] }}</span>
                                                <span
                                                    class="text-xs uppercase font-mono text-slate-400 font-bold">{{ $ob['type'] }}
                                                    Type</span>
                                            </div>
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $ob['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        @endif
    </div>

    <script>
        function submitUploadForm(input) {
            if (input.files && input.files.length > 0) {
                document.getElementById('intelligence-upload-form').submit();
            }
        }
    </script>

    @if ($document && !in_array($document->status, ['done', 'failed']))
        <script>
            (function() {
                const statusUrl = "{{ route('documents.status', $document->id) }}";
                const progressBarFill = document.getElementById('progressBarFill');
                const progressPercentText = document.getElementById('progressPercentText');

                const pollInterval = setInterval(async () => {
                    try {
                        const res = await fetch(statusUrl, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();

                        // تحديث شريط التقدم مباشرة بدون Refresh
                        if (progressBarFill) {
                            progressBarFill.style.width = data.progress + '%';
                        }
                        if (progressPercentText) {
                            progressPercentText.textContent = data.progress + '%';
                        }

                        // لما يخلص التحليل أو يفشل، حوّله تلقائياً
                        if (data.status === 'done' || data.status === 'failed') {
                            clearInterval(pollInterval);
                            window.location.reload();
                        }
                    } catch (e) {
                        console.error('Status polling error:', e);
                    }
                }, 3000); 
            })();
        </script>
    @endif
@endsection
