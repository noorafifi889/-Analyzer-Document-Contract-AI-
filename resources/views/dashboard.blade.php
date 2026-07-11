@extends('layouts.app')
 
@section('title', 'Dashboard - ContractGuard AI')
 
@section('content')
<div class="space-y-10">
 
    {{-- ============================== --}}
    {{-- Page Header --}}
    {{-- ============================== --}}
    <section class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 pb-1 border-b border-outline-variant/60">
        <div>
            <p class="font-label-md text-label-md text-primary font-bold uppercase tracking-[0.12em] mb-1">Legal Workspace</p>
            <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Welcome back, {{ auth()->user()->name }}
            </h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">
                Here's what's happening with your contracts today.
            </p>
        </div>
 
        <div class="flex items-center gap-3 text-on-surface-variant bg-surface-container-low px-4 py-2.5 rounded-xl border border-outline-variant w-fit shadow-sm">
            <span class="material-symbols-outlined text-primary text-[20px]">calendar_today</span>
            <span class="font-label-md text-label-md font-bold text-on-surface">
                {{ now()->subDays(7)->format('M d, Y') }} &nbsp;&ndash;&nbsp; {{ now()->format('M d, Y') }}
            </span>
            <span class="material-symbols-outlined text-outline">expand_more</span>
        </div>
    </section>
 
    {{-- ============================== --}}
    {{-- Stats Cards --}}
    {{-- ============================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
 
        {{-- Total Contracts --}}
        <div class="relative overflow-hidden bg-surface-container-lowest border border-outline-variant rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <span class="absolute inset-y-0 left-0 w-1 bg-primary"></span>
            <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-xl">description</span>
            </div>
            <div class="min-w-0">
                <p class="font-label-md text-label-md text-on-surface-variant font-semibold">Total Contracts</p>
                <p class="text-[26px] leading-tight font-extrabold text-on-surface mt-0.5 tabular-nums">{{ $totalContracts }}</p>
            </div>
        </div>
 
        {{-- Active Risks --}}
        <div class="relative overflow-hidden bg-surface-container-lowest border border-outline-variant rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <span class="absolute inset-y-0 left-0 w-1 bg-red-500"></span>
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-xl">warning</span>
            </div>
            <div class="min-w-0">
                <p class="font-label-md text-label-md text-on-surface-variant font-semibold">Active Risks</p>
                <p class="text-[26px] leading-tight font-extrabold text-red-600 mt-0.5 tabular-nums">{{ $activeRisks }}</p>
            </div>
        </div>
 
        {{-- Pending Processing --}}
        <div class="relative overflow-hidden bg-surface-container-lowest border border-outline-variant rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <span class="absolute inset-y-0 left-0 w-1 bg-amber-500"></span>
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-xl">pending_actions</span>
            </div>
            <div class="min-w-0">
                <p class="font-label-md text-label-md text-on-surface-variant font-semibold">Pending Processing</p>
                <p class="text-[26px] leading-tight font-extrabold text-on-surface mt-0.5 tabular-nums">{{ $pendingRenewals }}</p>
            </div>
        </div>
 
        {{-- Analysis Confidence --}}
        <div class="relative overflow-hidden bg-surface-container-lowest border border-outline-variant rounded-2xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <span class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></span>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-xl">payments</span>
            </div>
            <div class="min-w-0">
                <p class="font-label-md text-label-md text-on-surface-variant font-semibold">Analysis Confidence</p>
                <p class="text-[26px] leading-tight font-extrabold text-on-surface mt-0.5 tabular-nums">94.2%</p>
            </div>
        </div>
 
    </div>
 
    {{-- ============================== --}}
    {{-- Latest AI Insights + Risk Distribution --}}
    {{-- ============================== --}}
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
 
        {{-- Latest AI Insights --}}
        <div class="lg:col-span-2 flex flex-col">
            <div class="flex justify-between items-center mb-4 px-1">
                <h3 class="font-headline-sm text-headline-sm text-on-surface">Latest AI Insights</h3>
                <a class="text-primary font-label-md text-label-md hover:underline font-semibold inline-flex items-center gap-1" href="#">
                    View all insights
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
 
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">
                @forelse($latestAnalyses as $index => $analysis)
                    @php
                        // Card color encodes the actual risk level, not a decorative rotation,
                        // so the eye catches the highest-risk insight first.
                        $riskScore = $analysis->risk_score ?? null;
 
                        if ($riskScore >= 70) {
                            $currentStyle = ['bg' => 'bg-red-50/60', 'border' => 'border-red-100', 'icon_bg' => 'bg-red-600', 'text' => 'text-red-900', 'icon' => 'warning'];
                        } elseif ($riskScore >= 40) {
                            $currentStyle = ['bg' => 'bg-amber-50/60', 'border' => 'border-amber-100', 'icon_bg' => 'bg-amber-600', 'text' => 'text-amber-900', 'icon' => 'schedule'];
                        } elseif ($riskScore !== null) {
                            $currentStyle = ['bg' => 'bg-emerald-50/60', 'border' => 'border-emerald-100', 'icon_bg' => 'bg-emerald-600', 'text' => 'text-emerald-900', 'icon' => 'verified'];
                        } else {
                            // No score yet (analysis still processing) — neutral style
                            $currentStyle = ['bg' => 'bg-surface-container-low', 'border' => 'border-outline-variant', 'icon_bg' => 'bg-on-surface-variant', 'text' => 'text-on-surface-variant', 'icon' => 'auto_awesome'];
                        }
                    @endphp
 
                    <div class="{{ $currentStyle['bg'] }} {{ $currentStyle['border'] }} border rounded-2xl p-5 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                        <div>
                            <div class="w-9 h-9 rounded-lg {{ $currentStyle['icon_bg'] }} text-white flex items-center justify-center mb-4 shadow-sm">
                                <span class="material-symbols-outlined text-base">{{ $currentStyle['icon'] }}</span>
                            </div>
                            <p class="font-body-md text-body-md {{ $currentStyle['text'] }} leading-relaxed">
                                <span class="font-bold block mb-1 text-on-surface truncate">
                                    {{ $analysis->document->title ?? $analysis->document->original_name }}
                                </span>
                                {{ Str::limit($analysis->summary, 120) }}
                            </p>
                        </div>
 
                        {{-- Footer: risk badge + link to the full analysis --}}
                        <div class="flex items-center justify-between mt-5 pt-4 border-t {{ $currentStyle['border'] }}">
                            @if(isset($analysis->risk_score))
                                @if($analysis->risk_score >= 70)
                                    <span class="px-2.5 py-1 bg-white/70 text-red-700 rounded-full text-label-sm font-medium flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> High ({{ $analysis->risk_score }}%)
                                    </span>
                                @elseif($analysis->risk_score >= 40)
                                    <span class="px-2.5 py-1 bg-white/70 text-amber-700 rounded-full text-label-sm font-medium flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Med Risk ({{ $analysis->risk_score }}%)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-white/70 text-green-700 rounded-full text-label-sm font-medium flex items-center gap-1.5 w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Low Risk
                                    </span>
                                @endif
                            @else
                                <span></span>
                            @endif
 
                            <a href="{{ route('documents.show', $analysis->document->id ?? $analysis->document_id) }}"
                               class="text-on-surface font-label-sm text-label-sm font-semibold inline-flex items-center gap-1 hover:underline">
                                View analysis
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-surface-container-lowest border border-dashed border-outline-variant rounded-2xl flex flex-col items-center justify-center gap-2 p-10 text-outline shadow-sm">
                        <span class="material-symbols-outlined text-3xl text-outline-variant">auto_awesome</span>
                        <p class="font-label-md text-label-md font-medium">No AI insights generated yet.</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Upload a contract to get your first analysis.</p>
                    </div>
                @endforelse
            </div>
        </div>
 
        {{-- Risk Distribution --}}
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 flex flex-col justify-between shadow-sm">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-headline-sm text-[16px] font-bold text-on-surface">Risk Distribution</h3>
                <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors">more_horiz</span>
            </div>
 
            <div class="relative w-44 h-44 mx-auto my-3 flex items-center justify-center">
                <canvas id="riskDonutChart"></canvas>
                <div class="absolute flex flex-col items-center justify-center text-center pointer-events-none" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <span class="font-headline-lg text-[28px] font-extrabold text-on-surface leading-none tabular-nums">{{ $totalContracts }}</span>
                    <span class="font-label-sm text-[10px] text-outline uppercase tracking-wider mt-1">Total</span>
                </div>
            </div>
 
            <div class="w-full grid grid-cols-3 gap-2 border-t border-outline-variant/60 pt-4 mt-2">
                <div class="text-center">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444]"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">High</span>
                    </div>
                    <p class="font-bold text-on-surface text-body-lg tabular-nums">{{ $highRiskPercent }}%</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Medium</span>
                    </div>
                    <p class="font-bold text-on-surface text-body-lg tabular-nums">{{ $medRiskPercent }}%</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center gap-1.5 mb-0.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Low</span>
                    </div>
                    <p class="font-bold text-on-surface text-body-lg tabular-nums">{{ $lowRiskPercent }}%</p>
                </div>
            </div>
        </div>
    </section>
 
    {{-- ============================== --}}
    {{-- Recent Documents --}}
    {{-- ============================== --}}
    <section class="space-y-4">
        <div class="flex justify-between items-center px-1">
            <h3 class="font-headline-sm text-headline-sm text-on-surface">Recent Documents</h3>
            <a class="text-primary font-label-md text-label-md hover:underline font-semibold inline-flex items-center gap-1" href="#">
                View all documents
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
 
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low border-b border-outline-variant">
                    <tr>
                        <th class="px-6 py-3.5 font-label-md text-label-md text-on-surface-variant uppercase tracking-wide text-xs">Document</th>
                        <th class="px-6 py-3.5 font-label-md text-label-md text-on-surface-variant uppercase tracking-wide text-xs">Risk Level</th>
                        <th class="px-6 py-3.5 font-label-md text-label-md text-on-surface-variant uppercase tracking-wide text-xs">Status</th>
                        <th class="px-6 py-3.5 font-label-md text-label-md text-on-surface-variant uppercase tracking-wide text-xs">Date</th>
                        <th class="px-6 py-3.5 font-label-md text-label-md text-on-surface-variant uppercase tracking-wide text-xs text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($recentDocuments as $doc)
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-container to-surface-container-highest flex items-center justify-center font-bold text-primary shrink-0 shadow-sm">
                                        {{ strtoupper(substr($doc->original_name, 0, 1)) }}
                                    </div>
                                    <span class="font-body-md text-body-md font-semibold truncate max-w-xs text-on-surface">
                                        {{ $doc->title ?? $doc->original_name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($doc->analysis)
                                    @if($doc->analysis->risk_score >= 70)
                                        <span class="px-2.5 py-1 bg-red-50 text-red-700 rounded-full text-label-sm font-medium border border-red-100 flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> High ({{ $doc->analysis->risk_score }}%)
                                        </span>
                                    @elseif($doc->analysis->risk_score >= 40)
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full text-label-sm font-medium border border-amber-100 flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Med Risk ({{ $doc->analysis->risk_score }}%)
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-label-sm font-medium border border-green-100 flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Low Risk
                                        </span>
                                    @endif
                                @else
                                    <span class="text-outline text-label-sm italic">No analysis</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-label-md text-label-md capitalize text-on-surface-variant">{{ $doc->status }}</span>
                            </td>
                            <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant tabular-nums">
                                {{ $doc->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('intelligence.show', $doc->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-outline hover:text-primary hover:bg-primary-container/30 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-outline">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-3xl text-outline-variant">folder_open</span>
                                    <p class="font-label-md text-label-md font-medium">No documents uploaded yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
 
</div>
 
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('riskDonutChart').getContext('2d');
 
            // Real counts injected from the server
            const highRiskData = {{ $highRiskCount }};
            const medRiskData  = {{ $medRiskCount }};
            const lowRiskData  = {{ $lowRiskCount }};
 
            // Fall back to a neutral, fully-formed ring when there is no data yet,
            // instead of rendering a broken/empty chart
            const hasData    = (highRiskData + medRiskData + lowRiskData) > 0;
            const chartData  = hasData ? [highRiskData, medRiskData, lowRiskData] : [0, 0, 1];
            const chartColors = hasData ? ['#EF4444', '#F59E0B', '#10B981'] : ['#E5E7EB'];
 
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['High Risk', 'Medium Risk', 'Low Risk'],
                    datasets: [{
                        data: chartData,
                        backgroundColor: chartColors,
                        borderWidth: 0,
                        hoverOffset: hasData ? 4 : 0,
                    }],
                },
                options: {
                    cutout: '78%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: hasData,
                            callbacks: {
                                label: (context) => ` ${context.label}: ${context.raw}`,
                            },
                        },
                    },
                },
            });
        });
    </script>
@endpush
@endsection