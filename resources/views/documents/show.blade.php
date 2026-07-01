<x-layouts.app>
    <x-slot:title>LexiGuard AI | {{ $document->name }} Summary</x-slot:title>

    <div class="w-full max-w-container-max mx-auto px-gutter py-xl">
        <section class="mb-xxl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">description</span>
                    <span class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Document Analysis</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface">Contract Summary</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">Reviewing <span class="font-semibold text-on-surface">{{ $document->name }}</span> for compliance.</p>
            </div>
            <div class="flex gap-sm">
                <button class="px-md py-sm border border-outline-variant rounded-lg font-semibold hover:bg-white transition-all flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export PDF
                </button>
                <button class="px-md py-sm bg-primary text-on-primary rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    Share Report
                </button>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-lg">
            <div class="md:col-span-8 space-y-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-lg">
                    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">Document Type</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">work</span>
                            </div>
                            <span class="font-headline-sm text-headline-sm">Employment Contract</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl flex flex-col gap-sm">
                        <span class="font-label-md text-label-md text-on-surface-variant">Key Parties</span>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-lg bg-secondary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-secondary">groups</span>
                            </div>
                            <span class="font-headline-sm text-headline-sm">TechCorp & User</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <div class="h-1 bg-primary w-full"></div>
                    <div class="p-lg">
                        <div class="flex justify-between items-start mb-md">
                            <div class="flex items-center gap-sm">
                                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                                <h3 class="font-headline-sm text-headline-sm">Executive Summary</h3>
                            </div>
                            <span class="bg-surface-container text-on-surface-variant px-sm py-xs rounded font-label-md text-label-md">AI Generated</span>
                        </div>
                        <div class="space-y-md font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            {{-- هنا يمكنك عرض الحقول الديناميكية مستقبلاً من جدول قاعدة البيانات --}}
                            <p>This document outlines the standard employment terms analyzed for <span class="font-semibold text-on-surface">{{ $document->name }}</span>. The agreement includes comprehensive intellectual property protections and standard non-disclosure requirements.</p>
                            <p>Key highlights include compliance metrics based on corporate guidelines. No significant deviations from industry standards were detected during analysis.</p>
                        </div>
                        <div class="mt-xl pt-lg border-t border-outline-variant grid grid-cols-3 gap-md">
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Uploaded Date</p>
                                <p class="font-body-md text-body-md font-semibold text-on-surface">{{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Jurisdiction</p>
                                <p class="font-body-md text-body-md font-semibold text-on-surface">California, US</p>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Currency</p>
                                <p class="font-body-md text-body-md font-semibold text-on-surface">USD ($)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-4 space-y-lg">
                <div class="bg-white border border-outline-variant p-lg rounded-xl shadow-sm flex flex-col items-center text-center hover:translate-y-[-2px] transition-transform duration-200 ease-out">
                    <span class="font-label-md text-label-md text-on-surface-variant mb-md">AI Risk Assessment</span>
                    <div class="relative w-32 h-32 flex items-center justify-center mb-md">
                        <svg class="absolute inset-0 w-full h-full" viewbox="0 0 100 100">
                            <circle class="text-surface-container" cx="50" cy="50" fill="transparent" r="42" stroke="currentColor" stroke-width="8"></circle>
                            <circle class="text-green-500" cx="50" cy="50" fill="transparent" r="42" stroke="currentColor" stroke-dasharray="264" stroke-dashoffset="{{ 264 - (264 * $document->progress) / 100 }}" stroke-linecap="round" stroke-width="8"></circle>
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-headline-xl text-headline-xl text-green-600">{{ $document->progress }}</span>
                            <span class="font-label-md text-label-md text-on-surface-variant -mt-1">/100</span>
                        </div>
                    </div>
                    <div class="bg-green-100 text-green-800 px-md py-sm rounded-full font-bold flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        Analysis Progress: {{ $document->progress }}%
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-md">This document is currently reflecting its processing state dynamically.</p>
                </div>

                <div class="bg-surface-container-low border border-outline-variant p-lg rounded-xl">
                    <h4 class="font-headline-sm text-headline-sm mb-md flex items-center gap-sm">
                        <span class="material-symbols-outlined text-on-surface-variant">list_alt</span>
                        Key Clauses
                    </h4>
                    <div class="space-y-sm">
                        <div class="bg-white p-sm rounded-lg flex justify-between items-center border border-outline-variant/30">
                            <span class="font-body-md text-body-md text-on-surface">Non-Compete</span>
                            <span class="bg-tertiary-container text-on-tertiary-container px-xs py-0.5 rounded text-[11px] font-bold">12 MO</span>
                        </div>
                        <div class="bg-white p-sm rounded-lg flex justify-between items-center border border-outline-variant/30">
                            <span class="font-body-md text-body-md text-on-surface">Termination</span>
                            <span class="bg-surface-container text-on-surface-variant px-xs py-0.5 rounded text-[11px] font-bold">30 DAYS</span>
                        </div>
                        <div class="bg-white p-sm rounded-lg flex justify-between items-center border border-outline-variant/30">
                            <span class="font-body-md text-body-md text-on-surface">Intellectual Property</span>
                            <span class="material-symbols-outlined text-green-600 text-[18px]">verified</span>
                        </div>
                        <div class="bg-white p-sm rounded-lg flex justify-between items-center border border-outline-variant/30">
                            <span class="font-body-md text-body-md text-on-surface">Governing Law</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">CA, USA</span>
                        </div>
                    </div>
                    <button class="w-full mt-md py-sm text-primary font-semibold text-body-sm hover:underline">View Detailed Breakdown</button>
                </div>
            </div>
        </div>

        <section class="mt-xxl">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-lg">Contract Preview</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                <div class="lg:col-span-2 bg-white border border-outline-variant rounded-xl p-xl h-96 overflow-y-auto relative scrollbar-none">
                    <div class="space-y-md font-serif text-[#334155] leading-relaxed">
                        <h4 class="font-bold text-center mb-xl uppercase">{{ $document->name }}</h4>
                        <p>This digital record stands for the analyzed file entry tracking details under database key index: {{ $document->id }}.</p>
                        <p><strong class="text-on-surface">1. Meta Reference.</strong> The file name parsed is securely logged under corporate encryption. Reviewing logs confirm integrity matches verification protocol.</p>
                        <p><strong class="text-on-surface">2. Status Integrity.</strong> Current operational state of the document pipeline evaluates directly to: <span class="font-semibold text-primary uppercase">{{ $document->status }}</span>.</p>
                    </div>
                </div>
                
                <div class="flex flex-col gap-lg">
                    <div class="bg-surface-container-highest/50 rounded-xl p-lg border border-outline-variant/20 flex-grow relative overflow-hidden flex flex-col justify-between">
                        <div>
                            <h4 class="font-headline-sm text-headline-sm mb-sm">Visualizing the Terms</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">AI-generated conceptualization of the contract's scope and legal architecture.</p>
                        </div>
                        <div class="mt-md w-full h-40 rounded-lg overflow-hidden border border-outline-variant">
                            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCl7HzgqET7LDz-JhSaYOmIVzv0KtoP-hL9uheH89T0gcbiShrx8e-6HhvAptEZwgYQm5Nu29-GG3GWwXCRBeetgbTkPc7ApC5qzsLJ6CQevSTR_s6KACikCknHUf3M4dqgGKX02KiIdNWG9z985oLdYSqVD5wjsdUSaW68JTNITUkzOjp0byLa9Nd5_uCK-C02nBFR_IpPefMInsPOMuQSOBV6Td5Ptd_R6H6GEGj7alI0lQJt-obJyebUTaYy-kUjYZ90Ajb2hQI" alt="Legal tech dashboard visual style graph"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>