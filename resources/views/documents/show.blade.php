
@php
    // تحديد الألوان والنصوص بناءً على درجة الخطورة ديناميكياً
    if ($analysis->risk_score > 70) {
        $badgeClass = 'bg-error-container text-error border border-error/20';
        $statusText = 'High Risk';
        $riskColor = 'red';
    } elseif ($analysis->risk_score > 40) {
        $badgeClass = 'bg-warning-container text-warning border border-warning/20';
        $statusText = 'Medium Risk';
        $riskColor = 'amber';
    } else {
        $badgeClass = 'bg-success-container text-success border border-success/20';
        $statusText = 'Low Risk';
        $riskColor = 'green';
    }
@endphp
<x-layouts.app>
    <x-slot:title>LexiGuard AI | {{ $document->title }} Summary</x-slot:title>
 
    <div class="w-full max-w-container-max mx-auto px-gutter py-xl">
 
        <!-- ===================== قسم العنوان والإجراءات ===================== -->
        <section class="mb-xxl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-primary"
                        style="font-variation-settings: 'FILL' 1;">description</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                        Document Analysis
                    </span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface">Contract Summary</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">
                    Reviewing
                    <span class="font-semibold text-on-surface">{{ $document->original_name }}</span>
                    for compliance.
                </p>
            </div>
            <div class="flex gap-sm">
                <a href="{{ route('documents.chat', $document->id) }}"
                    class="px-md py-sm border border-outline-variant rounded-lg font-semibold bg-surface-container-low hover:bg-white transition-all flex items-center gap-xs text-body-md">
                    <span class="material-symbols-outlined text-[18px]">smart_toy</span>
                    Chat with AI
                </a>
                <a href="{{ route('documents.export-pdf', $document) }}"
                    class="px-md py-sm bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-opacity flex items-center gap-xs shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export PDF
                </a>
            </div>
        </section>
 
        <div class="grid grid-cols-1 md:grid-cols-12 gap-lg">
 
            <!-- ===================== الجزء الأيسر: نوع المستند والملخص التنفيذي ===================== -->
            <div class="md:col-span-8 space-y-lg">
 
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-lg">
                    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">Document Type</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">work</span>
                            </div>
                            <span class="font-headline-sm text-headline-sm uppercase">
                                {{ $document->file_type }} Document
                            </span>
                        </div>
                    </div>
 
                    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">AI Confidence Level</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-secondary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-secondary">psychology</span>
                            </div>
                            <span class="font-headline-sm text-headline-sm">
                                {{ $analysis->ai_confidence ?? 'N/A' }}%
                            </span>
                        </div>
                    </div>
                </div>
 
                @error('document')
                    <p class="text-red-500 text-xs mt-sm font-semibold text-center animate-pulse">
                        {{ $message }}
                    </p>
                @enderror
 
                <!-- بطاقة الملخص التنفيذي -->
                <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <div class="h-1 bg-primary w-full"></div>
                    <div class="p-lg">
                        <div class="flex justify-between items-start mb-md">
                            <div class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                                <h3 class="font-headline-sm text-headline-sm">Executive Summary</h3>
                            </div>
                            <span class="bg-surface-container text-on-surface-variant px-sm py-xs rounded font-label-md text-label-md">
                                AI Generated
                            </span>
                        </div>
 
                        <div class="space-y-md font-body-md text-body-md text-on-surface-variant leading-relaxed" dir="auto">
                            <p class="text-body-md text-on-surface-variant mt-md leading-relaxed whitespace-pre-line">
                                {{ $analysis->summary }}
                            </p>
                        </div>
 
                        <div class="mt-xl pt-lg border-t border-outline-variant grid grid-cols-3 gap-md">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Uploaded Date</p>
                                <p class="font-body-md text-body-md font-semibold text-on-surface">
                                    {{ $document->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Critical Issues Count</p>
                                <p class="font-body-md text-body-md font-semibold text-red-600">
                                    {{ $analysis->critical_issues }} Issues
                                </p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Status</p>
                                <p class="font-body-md text-body-md font-semibold text-green-600 uppercase">
                                    {{ $document->status }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- ===================== الجزء الأيمن: حساب المخاطر والبنود المستخرجة ===================== -->
            <div class="md:col-span-4 space-y-lg">
 
                <!-- تقييم المخاطر -->
                <div class="bg-white border border-outline-variant p-lg rounded-xl shadow-sm flex flex-col items-center text-center hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <span class="font-label-md text-label-md text-on-surface-variant mb-md">AI Risk Assessment</span>
 
                    <div class="relative w-32 h-32 flex items-center justify-center mb-md">
                        <svg class="absolute inset-0 w-full h-full" viewbox="0 0 100 100">
                            <circle class="text-surface-container" cx="50" cy="50" fill="transparent"
                                r="42" stroke="currentColor" stroke-width="8"></circle>
                            <circle class="{{ $analysis->risk_score > 50 ? 'text-red-500' : 'text-green-500' }}"
                                cx="50" cy="50" fill="transparent" r="42" stroke="currentColor"
                                stroke-dasharray="264"
                                stroke-dashoffset="{{ 264 - (264 * ($analysis->risk_score ?? 0)) / 100 }}"
                                stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-headline-xl text-headline-xl {{ $analysis->risk_score > 50 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $analysis->risk_score ?? 0 }}
                            </span>
                            <span class="font-label-md text-label-md text-on-surface-variant -mt-1">/100</span>
                        </div>
                    </div>
 
                    <div class="flex flex-col w-full p-md rounded-xl">
                        <div class="flex flex-wrap items-center justify-center gap-sm">
                            <div class="px-md py-sm bg-surface-container-high text-on-surface font-semibold rounded-full text-body-sm border border-outline-variant">
                                Status: <span class="font-bold">{{ $statusText }}</span>
                            </div>
                        </div>
 
                        @if(!empty($analysis->risk_reason))
                            <div class="mt-sm pt-xs border-t border-outline-variant/50 flex items-start gap-xs text-body-sm text-on-surface-variant text-right" dir="auto">
                                <span class="material-symbols-outlined text-sm text-primary shrink-0 mt-0.5">info</span>
                                <p>
                                    <strong class="text-on-surface">Reason:</strong>
                                    {{ $analysis->risk_reason }}
                                </p>
                            </div>
                        @endif
                    </div>
 
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">
                        This score models potential contract liabilities identified by AI reasoning.
                    </p>
                </div>
 
            </div>
        </div>
 
        <!-- ===================== البنود الرئيسية (Key Clauses) — قسم كامل العرض ===================== -->
        <div class="mt-lg bg-surface-container-low border border-outline-variant rounded-xl overflow-hidden shadow-sm">
 
            <!-- رأس القسم -->
            <div class="px-lg py-lg bg-gradient-to-r from-primary-fixed to-surface-container-low flex items-center justify-between border-b border-outline-variant">
                <div class="flex items-center gap-md">
                    <div class="w-11 h-11 rounded-lg bg-primary flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-on-primary text-[24px]">gavel</span>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <h4 class="font-headline-md text-headline-md text-on-surface">Key Clauses</h4>
                        <span class="font-label-md text-label-md text-on-surface-variant">
                            Extracted &amp; analyzed by AI
                        </span>
                    </div>
                </div>
 
                <span class="bg-primary/10 text-primary font-bold text-body-md px-md py-xs rounded-full border border-primary/20">
                    {{ is_countable($analysis->clauses_analysis ?? null) ? count($analysis->clauses_analysis) : 0 }} Clauses
                </span>
            </div>
 
            <!-- شبكة البنود: تاخد مساحة أكبر بعرض الصفحة -->
            <div class="p-lg grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-md max-h-[36rem] overflow-y-auto scrollbar-none">
                @forelse($analysis->clauses_analysis as $index => $item)
                    <div class="group bg-white p-lg rounded-xl flex flex-col gap-sm border border-outline-variant/40 hover:border-primary/50 hover:shadow-md transition-all duration-200 relative overflow-hidden"
                        dir="rtl">
 
                        <!-- شريط جانبي ملوّن -->
                        <div class="absolute top-0 bottom-0 right-0 w-1 bg-primary/70 group-hover:bg-primary transition-colors"></div>
 
                        <div class="flex justify-between items-start w-full gap-sm">
                            <div class="flex items-center gap-xs">
                                <span class="w-7 h-7 shrink-0 rounded-full bg-primary/10 text-primary font-bold text-[12px] flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-body-lg text-body-lg text-on-surface font-bold">
                                    {{ $item['clause'] ?? 'بند فرعي' }}
                                </span>
                            </div>
                            <span class="material-symbols-outlined text-green-600 text-[20px] shrink-0" title="Reviewed">
                                verified
                            </span>
                        </div>
 
                        @if(!empty($item['analysis']))
                            <p class="text-sm text-on-surface-variant leading-relaxed pr-9">
                                {{ $item['analysis'] }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center text-center py-xxl gap-xs">
                        <span class="material-symbols-outlined text-on-surface-variant text-[36px] opacity-50">
                            fact_check
                        </span>
                        <p class="text-sm text-on-surface-variant">No specific clauses identified.</p>
                    </div>
                @endforelse
            </div>
        </div>
 
    </div>
</x-layouts.app>