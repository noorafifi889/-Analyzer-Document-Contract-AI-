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