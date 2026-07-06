<x-layouts.app>
<div class="w-full">
    
    <section class="relative flex flex-col items-center text-center py-12 md:py-20 max-w-4xl mx-auto">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <span class="inline-flex items-center gap-sm px-md py-xs rounded-full font-label-md text-label-md bg-primary-container text-primary mb-md relative z-10">
            <span class="material-symbols-outlined text-[16px] animate-pulse">policy</span>
            AI-Powered Document Intelligence & Security
        </span>
        
        <h1 class="font-headline-xl text-[44px] md:text-[60px] leading-tight tracking-tight text-on-surface font-extrabold mb-md relative z-10">
            Drop Massive Contracts. <br class="hidden sm:inline">
            <span class="text-primary">Extract Insights instantly.</span>
        </h1>
        
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-xl relative z-10">
            Upload PDFs or Word docs. LexiGuard AI instantly sanitizes formatting, generates crystal-clear summaries, alerts you to critical risks, and lets you chat directly with your document. 
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-md w-full sm:w-auto relative z-10">
            <a href="{{ route('register') }}" class="w-full sm:w-auto flex items-center justify-center gap-sm px-xl py-md font-body-md text-body-md bg-primary text-on-primary rounded-xl hover:opacity-95 transition-all shadow-md shadow-primary/20 font-semibold group">
                Analyze Your First File Free
                <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">upload_file</span>
            </a>
            <a href="#" class="w-full sm:w-auto flex items-center justify-center gap-sm px-xl py-md font-body-md text-body-md bg-surface-container border border-outline-variant text-on-surface hover:bg-surface-container-high transition-all rounded-xl">
                <span class="material-symbols-outlined text-[20px]">play_circle</span>
                See How It Works
            </a>
        </div>
    </section>

    <div class="w-full border-t border-outline-variant/60 my-md"></div>

    <section class="py-12">
        <div class="text-center max-w-2xl mx-auto mb-xl">
            <span class="font-label-md text-label-md text-tertiary uppercase tracking-wider font-bold">Built For Professionals</span>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mt-xs">Tailored for High-Stakes Document Review</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-lg">
            <div class="bento-card p-xl rounded-xl bg-surface-container-low border border-outline-variant">
                <div class="flex items-center gap-sm text-primary mb-sm">
                    <span class="material-symbols-outlined text-[32px]">gavel</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Legal Teams & Attorneys</h3>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Scan massive multi-page contracts, NDAs, and agreements in seconds. Spot hidden liabilities, non-compete traps, and critical compliance issues without missing a single clause.
                </p>
            </div>
            
            <div class="bento-card p-xl rounded-xl bg-surface-container-low border border-outline-variant">
                <div class="flex items-center gap-sm text-tertiary mb-sm">
                    <span class="material-symbols-outlined text-[32px]">groups</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">HR & People Operations</h3>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Streamline employment agreements, corporate policies, and onboarding paperwork. Ensure absolute alignment with company standards and flag high-risk terms instantly.
                </p>
            </div>
        </div>
    </section>

    <div class="w-full border-t border-outline-variant/60 my-md"></div>

    <section class="py-16">
        <div class="text-center max-w-2xl mx-auto mb-xl">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-sm">Turn Messy Files Into Actionable Intel</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">LexiGuard AI processes, dissects, and guards your business data effortlessly.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-lg">
            <div class="bento-card p-xl rounded-xl bg-surface-container-lowest border border-outline-variant group">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-md group-hover:bg-primary group-hover:text-on-primary transition-all duration-300">
                    <span class="material-symbols-outlined text-[28px]">summarize</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-xs text-on-surface">Instant Executive Summaries</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Get a bulletproof, high-level overview of 50+ page documents in under 5 seconds. Understand the core intent without reading the fluff.</p>
            </div>

            <div class="bento-card p-xl rounded-xl bg-surface-container-lowest border border-outline-variant group">
                <div class="w-12 h-12 rounded-lg bg-error-container flex items-center justify-center text-error mb-md group-hover:bg-error group-hover:text-on-error-container transition-all duration-300">
                    <span class="material-symbols-outlined text-[28px]">report</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-xs text-on-surface">Critical Risk Red-Flagging</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Our AI automatically highlights high-risk clauses, predatory terms, or financial anomalies, giving you complete tactical awareness.</p>
            </div>

            <div class="bento-card p-xl rounded-xl bg-surface-container-lowest border border-outline-variant group">
                <div class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300">
                    {{-- <span class="material-symbols-outlined text-[28px]">chat_bounce</span> --}}
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-xs text-on-surface">Interactive Document Chatbot</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Ask questions directly to your file. Type queries like *"What is the termination policy?"* or *"Is there an expiration date?"* and get precise citations.</p>
            </div>

            <div class="bento-card p-xl rounded-xl bg-surface-container-lowest border border-outline-variant group">
                <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-on-primary-fixed-variant mb-md group-hover:bg-primary-container group-hover:text-on-primary-container transition-all duration-300">
                    <span class="material-symbols-outlined text-[28px]">description</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-xs text-on-surface">Sanitized Plain-Text Conversion</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Converts PDFs and Word docs into clean, raw, unstructured text while stripping out tracking elements and unsecure hidden code.</p>
            </div>
        </div>
    </section>

    <div class="w-full border-t border-outline-variant/60 my-md"></div>

    <section class="py-16 w-full max-w-5xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-xl">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-sm">How LexiGuard Protects Your Workflow</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Upload to audit in three seamless steps.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-xl relative">
            <div class="space-y-sm relative">
                <div class="font-label-md text-label-md font-bold tracking-widest text-primary uppercase">Step 1</div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">cloud_upload</span> Secure Upload
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Drag and drop your PDF or Word document. Your data is encrypted and remains strictly confidential.</p>
            </div>
            <div class="space-y-sm relative">
                <div class="font-label-md text-label-md font-bold tracking-widest text-tertiary uppercase">Step 2</div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-tertiary">troubleshoot</span> Deep AI Audit
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">LexiGuard scans for hidden risks, generates an interactive summary, and maps out critical data points.</p>
            </div>
            <div class="space-y-sm relative">
                <div class="font-label-md text-label-md font-bold tracking-widest text-primary uppercase">Step 3</div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">forum</span> Chat & Extract
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Review the flagged risks and use the inline AI Chatbot to ask any follow-up questions about the text.</p>
            </div>
        </div>
    </section>

    <section class="py-16 text-center max-w-4xl mx-auto w-full">
        <div class="bg-surface-container-high p-xl md:p-xxl rounded-xl border border-outline-variant space-y-md">
            <h2 class="font-headline-lg text-[32px] md:text-[40px] font-bold tracking-tight text-on-surface">Stop Reviewing Contracts Manually.</h2>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mx-auto">
                Join modern HR managers and legal counsels who save over 15 hours a week using LexiGuard AI.
            </p>chat_bounce

            <div class="pt-sm">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-sm px-xl py-md font-body-md text-body-md bg-primary text-on-primary font-semibold rounded-xl hover:opacity-95 transition-all shadow-md shadow-primary/20">
                    <span class="material-symbols-outlined text-[20px]">security</span>
                    Get Started Now (Free Dashboard Access)
                </a>
            </div>
        </div>
    </section>

</div>
</x-layouts.app>