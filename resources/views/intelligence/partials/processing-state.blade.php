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