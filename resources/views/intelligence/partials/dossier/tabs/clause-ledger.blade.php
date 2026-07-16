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
                        <td class="py-4 text-slate-700 leading-relaxed align-top font-normal pr-4" dir="auto">
                            {{ $item['analysis'] ?? 'No evaluation parameters populated.' }}
                        </td>
                        <td class="py-4 align-top text-right space-x-2 whitespace-nowrap">
                            <button title="Explain Clause"
                                class="px-3 py-1.5 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 hover:text-indigo-600 transition-all inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">translate</span>
                                Explain
                            </button>
                            <button title="Rewrite & Improve Clause"
                                class="px-3 py-1.5 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">edit_note</span>
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