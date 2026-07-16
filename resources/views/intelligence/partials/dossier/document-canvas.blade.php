<div class="p-4 border-b border-slate-100 bg-slate-50/70 flex justify-between items-center shrink-0">
    <span
        class="font-mono text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
        <span class="material-symbols-outlined text-base text-indigo-500">auto_stories</span>
        Interactive PDF Corpus
    </span>
    <span
        class="text-[11px] text-slate-500 bg-white px-2 py-0.5 border border-slate-200 rounded font-mono">Highlighting
        Active</span>
</div>
<div class="p-6 overflow-y-auto flex-1 text-base text-slate-800 leading-relaxed font-normal select-text whitespace-pre-line bg-white"
    dir="auto">
    @if (filled($document->extracted_text))
        {{ $document->extracted_text }}
    @else
        <div
            class="text-slate-400 italic text-center py-32 flex flex-col items-center justify-center gap-2">
            <span class="material-symbols-outlined text-5xl text-slate-300">find_in_page</span>
            No extractable text corpus isolated.
        </div>
    @endif
</div>