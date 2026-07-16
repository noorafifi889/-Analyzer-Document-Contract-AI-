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