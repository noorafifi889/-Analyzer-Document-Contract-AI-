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

        @include('intelligence.partials.dossier.risk-distribution', [
            'finalDistribution' => $finalDistribution,
            'riskColorPalette' => $riskColorPalette,
        ])
    </div>
</div>