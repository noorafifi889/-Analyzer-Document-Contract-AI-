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
            @include('intelligence.partials.dossier.tabs.clause-ledger', ['regularClauses' => $regularClauses])
        </div>

        {{-- TAB 2: Missing Clauses Detector --}}
        <div x-show="currentTab === 'missing'" style="display: none;">
            @include('intelligence.partials.dossier.tabs.missing-clauses', ['missingClauses' => $missingClauses])
        </div>

        {{-- TAB 3: Obligations & Deadlines Timeline --}}
        <div x-show="currentTab === 'timeline'" style="display: none;">
            @include('intelligence.partials.dossier.tabs.obligations-timeline', ['obligations' => $obligations])
        </div>

    </div>
</div>