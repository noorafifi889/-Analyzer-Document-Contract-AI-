<div class="rounded-2xl overflow-hidden border border-red-200 shadow-sm">
    <div class="px-4 py-2.5 flex items-center gap-2 bg-red-600 text-white">
        <span class="material-symbols-outlined text-base">report</span>
        <span class="text-xs font-bold uppercase tracking-wider">Critical Structural
            Breaches</span>
    </div>
    <div class="bg-white divide-y divide-red-100">
        @foreach ($criticalIssuesList as $issue)
            <div class="px-4 py-3 flex items-start gap-3 bg-red-50/30" dir="auto">
                <span class="w-2 h-2 rounded-full bg-red-600 mt-2 shrink-0"></span>
                <p class="text-base text-red-950 leading-relaxed font-medium">
                    {{ $issue }}</p>
            </div>
        @endforeach
    </div>
</div>