<div class="w-full max-w-xl mx-auto py-24 px-4">
    <div class="bg-white border border-red-200 rounded-2xl p-8 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-1.5 bg-red-600"></div>

        <div class="flex flex-col items-center text-center">
            <div
                class="w-20 h-20 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6 border border-red-100">
                <span class="material-symbols-outlined text-4xl">error</span>
            </div>

            <h1 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Analysis Failed</h1>
            <p class="text-sm text-slate-500 max-w-xs mb-8">
                An error occurred while processing this contract. The file might be corrupted or in an unsupported format.
            </p>

            <div
                class="w-full bg-slate-50 rounded-xl p-4 border border-slate-100 text-left mb-6 flex items-center gap-3">
                <span
                    class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                    <span class="material-symbols-outlined text-xl">description</span>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-mono text-slate-400 uppercase font-bold tracking-wider">Target Resource</p>
                    <p class="text-sm font-bold text-slate-800 truncate">{{ $document->original_name }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full">
                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition-all text-sm">
                        Delete Document
                    </button>
                </form>
                <a href="{{ route('intelligence.index') }}"
                    class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors text-sm text-center">
                    Upload New File
                </a>
            </div>
        </div>
    </div>
</div>