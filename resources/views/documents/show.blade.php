@php
    // تحديد الألوان والنصوص بناءً على درجة الخطورة ديناميكياً
    if ($analysis->risk_score > 70) {
        $badgeClass = 'bg-error-container text-error border border-error/20';
        $statusText = 'High Risk';
    } elseif ($analysis->risk_score > 40) {
        $badgeClass = 'bg-warning-container text-warning border border-warning/20';
        $statusText = 'Medium Risk';
    } else {
        $badgeClass = 'bg-success-container text-success border border-success/20';
        $statusText = 'Low Risk';
    }
@endphp
<x-layouts.app>
    <x-slot:title>LexiGuard AI | {{ $document->title }} Summary</x-slot:title>

    <div class="w-full max-w-container-max mx-auto px-gutter py-xl">
        <!-- قسم العنوان والإجراءات -->
        <section class="mb-xxl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-primary"
                        style="font-variation-settings: 'FILL' 1;">description</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Document
                        Analysis</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface">Contract Summary</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">Reviewing <span
                        class="font-semibold text-on-surface">{{ $document->original_name }}</span> for compliance.</p>
            </div>
            <div class="flex gap-sm">
         <a href="{{ route('documents.chat', $document->id) }}" class="px-md py-sm border border-outline-variant rounded-lg font-semibold bg-surface-container-low hover:bg-white transition-all flex items-center gap-xs text-body-md">
    <span class="material-symbols-outlined text-[18px]">smart_toy</span>
    Chat with AI
</a>
                <button
                    class="px-md py-sm bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    Share Report
                </button>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-lg">
            <!-- الجزء الأيسر: نوع المستند والملخص التنفيذي -->
            <div class="md:col-span-8 space-y-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-lg">
                    <div
                        class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">Document Type</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">work</span>
                            </div>
                            <!-- نوع الملف ديناميكي بحسب الامتداد -->
                            <span class="font-headline-sm text-headline-sm uppercase">{{ $document->file_type }}
                                Document</span>
                        </div>
                    </div>
                    <div
                        class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">AI Confidence Level</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-secondary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-secondary">psychology</span>
                            </div>
                            <!-- نسبة ثقة الموديل القادمة من الـ AI مئوية -->
                            <span
                                class="font-headline-sm text-headline-sm">{{ $analysis->ai_confidence ?? 'N/A' }}%</span>
                        </div>
                    </div>
                </div>

                <!-- بطاقة الملخص التنفيذي (Executive Summary) -->
                @error('document')
                    <p class="text-red-500 text-xs mt-sm font-semibold text-center animate-pulse">
                        {{ $message }}
                    </p>
                @enderror
                <div
                    class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <div class="h-1 bg-primary w-full"></div>
                    <div class="p-lg">
                        <div class="flex justify-between items-start mb-md">
                            <div class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                                <h3 class="font-headline-sm text-headline-sm">Executive Summary</h3>
                            </div>
                            <span
                                class="bg-surface-container text-on-surface-variant px-sm py-xs rounded font-label-md text-label-md">AI
                                Generated</span>
                        </div>
                        <div class="space-y-md font-body-md text-body-md text-on-surface-variant leading-relaxed"
                            dir="auto">
                            <p class="text-body-md text-on-surface-variant mt-md leading-relaxed whitespace-pre-line">
                                {{ $analysis->summary }}
                            </p>
                        </div>
                        <div class="mt-xl pt-lg border-t border-outline-variant grid grid-cols-3 gap-md">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Uploaded Date</p>
                                <p class="font-body-md text-body-md font-semibold text-on-surface">
                                    {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Critical Issues
                                    Count</p>
                                <p class="font-body-md text-body-md font-semibold text-danger text-red-600">
                                    {{ $analysis->critical_issues }} Issues</p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Status</p>
                                <p class="font-body-md text-body-md font-semibold text-green-600 uppercase">
                                    {{ $document->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الجزء الأيمن: حساب المخاطر والبنود المستخرجة -->
            <div class="md:col-span-4 space-y-lg">
                <!-- تقييم المخاطر بشكل دائري متفاعل مع الـ Score -->
                <div
                    class="bg-white border border-outline-variant p-lg rounded-xl shadow-sm flex flex-col items-center text-center hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <span class="font-label-md text-label-md text-on-surface-variant mb-md">AI Risk Assessment</span>
                    <div class="relative w-32 h-32 flex items-center justify-center mb-md">
                        <svg class="absolute inset-0 w-full h-full" viewbox="0 0 100 100">
                            <circle class="text-surface-container" cx="50" cy="50" fill="transparent"
                                r="42" stroke="currentColor" stroke-width="8"></circle>
                            <!-- الدائرة الآن تعبر لوناً وحجماً عن الـ Risk Score الفعلي للتقرير -->
                            <circle class="{{ $analysis->risk_score > 50 ? 'text-red-500' : 'text-green-500' }}"
                                cx="50" cy="50" fill="transparent" r="42" stroke="currentColor"
                                stroke-dasharray="264"
                                stroke-dashoffset="{{ 264 - (264 * ($analysis->risk_score ?? 0)) / 100 }}"
                                stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="flex flex-col">
                            <span
                                class="font-headline-xl text-headline-xl {{ $analysis->risk_score > 50 ? 'text-red-600' : 'text-green-600' }}">{{ $analysis->risk_score ?? 0 }}</span>
                            <span class="font-label-md text-label-md text-on-surface-variant -mt-1">/100</span>
                        </div>
                    </div>
              <div class="flex flex-col  -low p-md rounded-xl ">
    <!-- السطر الأول: نسبة الخطورة والتصنيف -->
    <div class="flex flex-wrap items-center gap-sm">
      

        <!-- شارة حالة الخطورة المكتوبة -->
        <div class="px-md py-sm bg-surface-container-high text-on-surface font-semibold rounded-full text-body-sm border border-outline-variant">
            Status: <span class="font-bold">{{ $statusText }}</span>
        </div>
    </div>

    <!-- السطر الثاني: سبب الخطورة (Reason) -->
    @if(!empty($analysis->risk_reason))
        <div class="mt-sm pt-xs border-t border-outline-variant/50 flex items-start gap-xs text-body-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-sm text-primary shrink-0 mt-0.5">info</span>
            <p>
                <strong class="text-on-surface">Reason:</strong> 
                {{ $analysis->risk_reason }}
            </p>
        </div>
    @endif
</div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">This score models potential
                        contract liabilities identified by AI reasoning.</p>
                </div>

                <!-- البنود الرئيسية (Key Clauses) أصبحت ديناميكية بالكامل -->
                <div class="bg-surface-container-low border border-outline-variant p-lg rounded-xl">
                    <h4 class="font-headline-sm text-headline-sm mb-md flex items-center gap-sm">
                        <span class="material-symbols-outlined text-on-surface-variant">list_alt</span>
                        Key Clauses
                    </h4>
                    <div class="space-y-sm max-h-80 overflow-y-auto scrollbar-none text-right" dir="rtl">
                        @forelse($analysis->clauses_analysis as $item)
                            <div
                                class="bg-white p-sm rounded-lg flex flex-col gap-xs border border-outline-variant/30 hover:border-primary/40 transition-colors">
                                <div class="flex justify-between items-center w-full">
                                    <span
                                        class="font-body-md text-body-md text-primary font-semibold">{{ $item['clause'] ?? 'بند فرعي' }}</span>
                                    <span class="material-symbols-outlined text-green-600 text-[18px]">verified</span>
                                </div>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    {{ $item['analysis'] ?? '' }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-on-surface-variant text-center py-md">No specific clauses identified.
                            </p>
                        @endforelse
                    </div>
                  
                </div>
            </div>
        </div>

        <section class="mt-xxl">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-lg">Extracted Document Text</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                <div class="lg:col-span-2 bg-white border border-outline-variant rounded-xl p-xl h-96 overflow-y-auto relative text-right"
                    dir="rtl">
                    <div class="space-y-md font-serif text-[#334155] leading-relaxed whitespace-pre-line">
                        <h4 class="font-bold text-center mb-xl uppercase text-on-surface">{{ $document->title }}</h4>
                        <!-- طباعة النص المستخرج من الـ pdf أو الـ word فعلياً -->
                        {{ $document->extracted_text }}
                    </div>
                </div>

                <div class="flex flex-col gap-lg">
                    <div
                        class="bg-surface-container-highest/50 rounded-xl p-lg border border-outline-variant/20 flex-grow relative overflow-hidden flex flex-col justify-between">
                        <div>
                            <h4 class="font-headline-sm text-headline-sm mb-sm">Visualizing the Terms</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">AI-generated conceptualization
                                of the contract's scope and legal architecture.</p>
                        </div>
                        <div class="mt-md w-full h-40 rounded-lg overflow-hidden border border-outline-variant">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCl7HzgqET7LDz-JhSaYOmIVzv0KtoP-hL9uheH89T0gcbiShrx8e-6HhvAptEZwgYQm5Nu29-GG3GWwXCRBeetgbTkPc7ApC5qzsLJ6CQevSTR_s6KACikCknHUf3M4dqgGKX02KiIdNWG9z985oLdYSqVD5wjsdUSaW68JTNITUkzOjp0byLa9Nd5_uCK-C02nBFR_IpPefMInsPOMuQSOBV6Td5Ptd_R6H6GEGj7alI0lQJt-obJyebUTaYy-kUjYZ90Ajb2hQI"
                                alt="Legal tech dashboard visual style graph" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
