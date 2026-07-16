<div class="relative border-l-2 border-indigo-100 ml-4 my-3 pl-8 space-y-6">
    @foreach ($obligations as $ob)
        <div class="relative" dir="auto">
            <span
                class="absolute -left-[39px] top-1 w-5 h-5 rounded-full bg-white border-2 border-indigo-600 flex items-center justify-center shadow-sm">
                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
            </span>
            <div class="bg-white border border-slate-200 p-4 rounded-xl shadow-sm max-w-2xl">
                <div class="flex items-center justify-between gap-4 mb-2">
                    <span
                        class="text-xs font-bold font-mono bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg">{{ $ob['due_date'] }}</span>
                    <span
                        class="text-xs uppercase font-mono text-slate-400 font-bold">{{ $ob['type'] }}
                        Type</span>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed">{{ $ob['desc'] }}</p>
            </div>
        </div>
    @endforeach
</div>