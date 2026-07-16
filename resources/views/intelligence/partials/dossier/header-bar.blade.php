<div
    class="flex flex-wrap items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
    <div class="flex items-center gap-4 min-w-0">
        <span
            class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-indigo-50 text-indigo-600 border border-indigo-100">
            <span class="material-symbols-outlined text-2xl">description</span>
        </span>
        <div class="min-w-0">
            <h2 class="text-base font-extrabold text-slate-900 truncate">
                {{ $document->title ?? $document->original_name }}</h2>
            <p class="text-xs font-mono text-slate-500 mt-0.5">Classification: <span
                    class="text-indigo-600 font-bold">Commercial Agreement</span> · Ingested Today</p>
        </div>
        <span
            class="px-3 py-1 rounded-full text-xs font-mono font-extrabold tracking-wider uppercase shadow-sm"
            style="background: {{ $verdictSoft }}; color: {{ $verdictColor }};">
            {{ $statusText }}
        </span>
    </div>

    {{-- Actions Bar --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('documents.chat', $document->id) }}"
            class="px-4 py-2.5 border border-slate-200 rounded-xl font-bold bg-indigo-50 hover:bg-indigo-100 transition-all flex items-center gap-2 text-sm text-indigo-600 shadow-sm">
            <span class="material-symbols-outlined text-lg fill-1">chat</span>
            Persistent AI Chat
        </a>

        <a href="{{ route('documents.export-pdf', $document) }}"
            class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors flex items-center gap-2 text-sm shadow-sm">
            <span class="material-symbols-outlined text-lg">download</span>
            Export PDF Dossier
        </a>
    </div>
</div>