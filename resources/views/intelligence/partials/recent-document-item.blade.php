<a href="{{ route('intelligence.show', $recent->id) }}"
    class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors group">
    <div class="flex items-center gap-3 min-w-0">
        <span
            class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 transition-colors">description</span>
        <div class="truncate">
            <p class="text-sm font-bold text-slate-800 truncate">
                {{ $recent->title ?? $recent->original_name }}</p>
            <p class="text-xs text-slate-400 font-mono mt-0.5">
                {{ $recent->created_at ? $recent->created_at->diffForHumans() : 'Recently' }}
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        @if ($recent->status === 'done')
            <span
                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-green-50 text-green-700 border border-green-200">Ready</span>
        @elseif($recent->status === 'failed')
            <span
                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-red-50 text-red-700 border border-red-200">Failed</span>
        @else
            <span
                class="px-2.5 py-0.5 rounded-full text-[11px] font-mono font-bold bg-amber-50 text-amber-600 border border-amber-200 animate-pulse">Processing</span>
        @endif
        <span
            class="material-symbols-outlined text-sm text-slate-300 group-hover:text-slate-500 transition-colors">arrow_forward_ios</span>
    </div>
</a>