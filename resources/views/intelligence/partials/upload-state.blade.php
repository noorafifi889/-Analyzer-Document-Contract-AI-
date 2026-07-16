<div class="w-full max-w-3xl mx-auto text-center mt-10">

    <div class="flex items-center justify-center gap-4 mb-4">
        <div
            class="w-14 h-14 shrink-0 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center border border-indigo-100 shadow-sm">
            <span class="material-symbols-outlined text-3xl">gavel</span>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-[#0F172A]">LexiGuard AI</h1>
    </div>

    <p class="text-slate-600 mb-8 max-w-md mx-auto text-base">
        Upload a new contract or select from recently analyzed documents to launch the compliance audit
        execution layer.
    </p>

    @error('document')
        <p class="text-red-600 text-sm mb-4 font-bold text-center">{{ $message }}</p>
    @enderror
    <div
        class="border-2 border-dashed border-slate-200 rounded-2xl p-12 bg-white hover:border-indigo-500 hover:shadow-lg transition-all duration-300 mb-12 group">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
            id="intelligence-upload-form">
            @csrf
            <input type="hidden" name="redirect_to" value="intelligence">
            <label class="cursor-pointer flex flex-col items-center justify-center w-full">
                <span
                    class="material-symbols-outlined text-6xl text-indigo-500 group-hover:text-indigo-600 transition-colors mb-4">upload_file</span>
                <span class="text-lg font-bold text-[#0F172A]">Click to upload new document</span>
                <span class="text-sm text-slate-400 mt-2 font-mono">PDF · DOCX · TXT — Up to 10MB</span>
                <input type="file" name="document" class="hidden" onchange="submitUploadForm(this)">
            </label>
        </form>
    </div>

    {{-- Recent Documents Section (آخر 5 ملفات) --}}
    <div class="text-left max-w-2xl mx-auto">
        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-100">
            <span class="material-symbols-outlined text-indigo-500 text-xl">history</span>
            <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-slate-500">Recent Analyzed
                Contracts</h3>
        </div>

        @include('intelligence.partials.recent-documents-list', ['recentDocuments' => $recentDocuments])
    </div>
</div>