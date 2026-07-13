@extends('layouts.app')

@section('content')
<div class="max-w-7xl py-8 px-4 md:px-8 mx-auto">

    {{-- Hero --}}
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-label-md font-bold mb-4">
            <span class="material-symbols-outlined text-lg">help</span>
            Help Center
        </div>
        <h1 class="text-display-sm font-bold text-on-surface mb-2">How can we help you?</h1>
        <p class="text-body-lg text-on-surface-variant">Everything you need to know about contract uploading, analysis, and search.</p>
    </div>

    {{-- Quick Start Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
        <div class="bg-surface-container rounded-3xl p-6 border border-outline-variant hover:border-primary transition-colors">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
            </div>
            <h3 class="text-title-md font-bold text-on-surface mb-1.5">Upload Your First Contract</h3>
            <p class="text-body-sm text-on-surface-variant leading-relaxed">Click the "Upload Contract" button in the header, select a PDF or Word file, and it will upload automatically.</p>
        </div>

        <div class="bg-surface-container rounded-3xl p-6 border border-outline-variant hover:border-primary transition-colors">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-2xl">psychology</span>
            </div>
            <h3 class="text-title-md font-bold text-on-surface mb-1.5">AI Analysis</h3>
            <p class="text-body-sm text-on-surface-variant leading-relaxed">After uploading, the system starts analyzing the contract automatically. Track the progress from the contract page.</p>
        </div>

        <div class="bg-surface-container rounded-3xl p-6 border border-outline-variant hover:border-primary transition-colors">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-2xl">search</span>
            </div>
            <h3 class="text-title-md font-bold text-on-surface mb-1.5">Smart Search</h3>
            <p class="text-body-sm text-on-surface-variant leading-relaxed">Use the search bar in the header to find contracts by title or even within their text content.</p>
        </div>
    </div>

    {{-- FAQ --}}
    <div class="mb-12" x-data="{ activeFaq: null }">
        <h2 class="text-title-lg font-bold text-on-surface mb-4">Frequently Asked Questions</h2>

        <div class="bg-surface-container rounded-3xl border border-outline-variant overflow-hidden divide-y divide-outline-variant">

            <div>
                <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full flex items-center justify-between px-6 py-4 text-start hover:bg-surface-container-high transition-colors">
                    <span class="text-body-lg font-medium text-on-surface">What file types are supported for upload?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200" :class="activeFaq === 1 && 'rotate-180'">expand_more</span>
                </button>
                <div x-show="activeFaq === 1" x-collapse>
                    <p class="px-6 pb-4 text-body-md text-on-surface-variant leading-relaxed">Currently, PDF and Word files (.doc / .docx  / .txt) are supported.</p>
                </div>
            </div>

            <div>
                <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full flex items-center justify-between px-6 py-4 text-start hover:bg-surface-container-high transition-colors">
                    <span class="text-body-lg font-medium text-on-surface">How long does the contract analysis take?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200" :class="activeFaq === 2 && 'rotate-180'">expand_more</span>
                </button>
                <div x-show="activeFaq === 2" x-collapse>
                    <p class="px-6 pb-4 text-body-md text-on-surface-variant leading-relaxed">It depends on the size and number of pages in the contract, but it usually takes from one to a few minutes.</p>
                </div>
            </div>

            <div>
                <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full flex items-center justify-between px-6 py-4 text-start hover:bg-surface-container-high transition-colors">
                    <span class="text-body-lg font-medium text-on-surface">Does the search look inside the contract content or just the title?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200" :class="activeFaq === 3 && 'rotate-180'">expand_more</span>
                </button>
                <div x-show="activeFaq === 3" x-collapse>
                    <p class="px-6 pb-4 text-body-md text-on-surface-variant leading-relaxed">The search looks through the title, the original file name, and also within the extracted text of the contract itself.</p>
                </div>
            </div>

            <div>
                <button @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full flex items-center justify-between px-6 py-4 text-start hover:bg-surface-container-high transition-colors">
                    <span class="text-body-lg font-medium text-on-surface">Can I see other users' contracts?</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200" :class="activeFaq === 4 && 'rotate-180'">expand_more</span>
                </button>
                <div x-show="activeFaq === 4" x-collapse>
                    <p class="px-6 pb-4 text-body-md text-on-surface-variant leading-relaxed">No, each user can only see the contracts they have uploaded. They are securely protected within your personal account.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Contact Support --}}
    <div class="bg-primary/5 border border-primary/20 rounded-3xl p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-primary text-on-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">support_agent</span>
            </div>
            <div>
                <h3 class="text-title-md font-bold text-on-surface mb-1">Still need help?</h3>
                <p class="text-body-md text-on-surface-variant">Our support team is ready to assist you at any time.</p>
            </div>
        </div>
        <a href="mailto:support@example.com" class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-bold text-label-md shadow-sm hover:opacity-90 active:scale-95 transition-all whitespace-nowrap">
            Contact Us
        </a>
    </div>

</div>
@endsection