<x-layouts.app>
<div class="w-full relative overflow-hidden bg-background antialiased selection:bg-primary/20 selection:text-primary">
    
    <!-- خلفية شبكية جمالية خفيفة جداً لمنح التصميم عمقاً هندسياً -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

    <!-- البطل (Hero Section) -->
    <section class="relative flex flex-col items-center text-center pt-20 pb-16 md:pt-28 md:pb-24 max-w-5xl mx-auto px-4 z-10">
        <!-- إضاءة نيون خلفية عملاقة وخافتة -->
        <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-primary/10 to-tertiary/5 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- شارة علوية أنيقة -->
        <span class="inline-flex items-center gap-xs px-4 py-1.5 rounded-full font-label-md text-label-md bg-primary/10 text-primary border border-primary/20 mb-xl animate-fade-in backdrop-blur-md">
            <span class="material-symbols-outlined text-[18px] animate-pulse">policy</span>
            AI-Powered Document Intelligence & Security
        </span>
        
        <!-- عنوان رئيسي ضخم وقوي -->
        <h1 class="font-headline-xl text-[44px] md:text-[68px] leading-[1.1] tracking-tight text-on-surface font-black mb-lg max-w-4xl">
            Drop Massive Contracts. <br class="hidden sm:inline">
            <span class="bg-gradient-to-r from-primary via-primary-fixed-dim to-tertiary bg-clip-text text-transparent">Extract Insights Instantly.</span>
        </h1>
        
        <!-- الوصف الفرعي مريح للعين -->
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl mx-auto mb-2xl leading-relaxed text-opacity-90">
            Upload PDFs or Word docs. LexiGuard AI instantly sanitizes formatting, generates crystal-clear summaries, alerts you to critical risks, and lets you chat directly with your document. 
        </p>
        
        <!-- أزرار الدعوة للإجراء (CTA) تفاعلية وممتازة -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-md w-full sm:w-auto">
            <a href="{{ route('register') }}" class="w-full sm:w-auto flex items-center justify-center gap-sm px-xl py-md font-body-md text-body-md bg-primary text-on-primary rounded-xl hover:bg-primary/95 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-primary/25 font-bold group">
                Analyze Your First File Free
                <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">upload_file</span>
            </a>
            <a href="#" class="w-full sm:w-auto flex items-center justify-center gap-sm px-xl py-md font-body-md text-body-md bg-surface-container-high border border-outline-variant text-on-surface hover:bg-surface-container-highest hover:border-outline transition-all rounded-xl font-medium">
                <span class="material-symbols-outlined text-[20px] text-on-surface-variant">play_circle</span>
                See How It Works
            </a>
        </div>
    </section>

    <!-- فاصل ناعم متلاشي -->
    <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-outline-variant/60 to-transparent my-md"></div>

    <!-- قسم الفئات المستهدفة (Target Audience) -->
    <section class="py-16 px-4 max-w-6xl mx-auto relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-2xl">
            <span class="font-label-md text-label-md text-tertiary uppercase tracking-widest font-extrabold bg-tertiary/10 px-3 py-1 rounded-md">Built For Professionals</span>
            <h2 class="font-headline-lg text-[32px] md:text-headline-lg font-bold text-on-surface mt-sm">Tailored for High-Stakes Document Review</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-xl">
            <!-- كرت المحامين -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-low border border-outline-variant/70 hover:border-primary/40 transition-all duration-300 hover:shadow-xl hover:shadow-primary/5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center gap-sm text-primary mb-md">
                        <div class="p-2 rounded-xl bg-primary/10 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px] block">gavel</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Legal Teams & Attorneys</h3>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Scan massive multi-page contracts, NDAs, and agreements in seconds. Spot hidden liabilities, non-compete traps, and critical compliance issues without missing a single clause.
                    </p>
                </div>
            </div>
            
            <!-- كرت الموارد البشرية -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-low border border-outline-variant/70 hover:border-tertiary/40 transition-all duration-300 hover:shadow-xl hover:shadow-tertiary/5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center gap-sm text-tertiary mb-md">
                        <div class="p-2 rounded-xl bg-tertiary/10 group-hover:bg-tertiary group-hover:text-on-tertiary transition-colors">
                            <span class="material-symbols-outlined text-[32px] block">groups</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">HR & People Operations</h3>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Streamline employment agreements, corporate policies, and onboarding paperwork. Ensure absolute alignment with company standards and flag high-risk terms instantly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-outline-variant/60 to-transparent my-md"></div>

    <!-- قسم المميزات الخارقة (Features Bento Grid) -->
    <section class="py-20 px-4 max-w-6xl mx-auto relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-2xl">
            <h2 class="font-headline-lg text-[32px] md:text-headline-lg text-on-surface font-bold mb-sm tracking-tight">Turn Messy Files Into Actionable Intel</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">LexiGuard AI processes, dissects, and guards your business data effortlessly.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-lg">
            <!-- ميزة 1 -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-outline hover:scale-[1.01] hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-md group-hover:bg-primary group-hover:text-on-primary transition-all duration-300 shadow-sm">
                    <span class="material-symbols-outlined text-[26px]">summarize</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm font-bold mb-xs text-on-surface">Instant Executive Summaries</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Get a bulletproof, high-level overview of 50+ page documents in under 5 seconds. Understand the core intent without reading the fluff.</p>
            </div>

            <!-- ميزة 2 -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-error/40 hover:scale-[1.01] hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-error-container/60 flex items-center justify-center text-error mb-md group-hover:bg-error group-hover:text-on-error transition-all duration-300 shadow-sm">
                    <span class="material-symbols-outlined text-[26px]">report</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm font-bold mb-xs text-on-surface">Critical Risk Red-Flagging</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Our AI automatically highlights high-risk clauses, predatory terms, or financial anomalies, giving you complete tactical awareness.</p>
            </div>

            <!-- ميزة 3 (تم إصلاح الأيقونة والتاغ التالف هنا) -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-secondary/40 hover:scale-[1.01] hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-secondary-container/60 flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300 shadow-sm">
                    <span class="material-symbols-outlined text-[26px]">chat</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm font-bold mb-xs text-on-surface">Interactive Document Chatbot</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Ask questions directly to your file. Type queries like *"What is the termination policy?"* or *"Is there an expiration date?"* and get precise citations.</p>
            </div>

            <!-- ميزة 4 -->
            <div class="bento-card p-xl rounded-2xl bg-surface-container-lowest border border-outline-variant hover:border-primary/40 hover:scale-[1.01] hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-on-primary-fixed-variant mb-md group-hover:bg-primary-container group-hover:text-on-primary-container transition-all duration-300 shadow-sm">
                    <span class="material-symbols-outlined text-[26px]">description</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm font-bold mb-xs text-on-surface">Sanitized Plain-Text Conversion</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Converts PDFs and Word docs into clean, raw, unstructured text while stripping out tracking elements and unsecure hidden code.</p>
            </div>
        </div>
    </section>

    <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-outline-variant/60 to-transparent my-md"></div>

    <!-- قسم خطوات العمل الخطيّة (Steps Review) -->
    <section class="py-20 px-4 w-full max-w-6xl mx-auto relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-2xl">
            <h2 class="font-headline-lg text-[32px] md:text-headline-lg text-on-surface font-bold mb-sm">How LexiGuard Protects Your Workflow</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Upload to audit in three seamless steps.</p>
        </div>

        <!-- الخطوات مع روابط بصرية منقطة دقيقة جدًا بين المراحل -->
        <div class="grid md:grid-cols-3 gap-xl relative">
            
            <!-- الخطوة 1 -->
            <div class="space-y-sm relative p-md rounded-xl hover:bg-surface-container-low transition-all">
                <div class="font-label-md text-label-md font-black tracking-widest text-primary uppercase bg-primary/10 w-fit px-2 py-0.5 rounded">Step 1</div>
                <h3 class="font-headline-sm text-[20px] font-bold text-on-surface flex items-center gap-xs mt-sm">
                    <span class="material-symbols-outlined text-primary">cloud_upload</span> Secure Upload
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Drag and drop your PDF or Word document. Your data is encrypted and remains strictly confidential.</p>
            </div>

            <!-- الخطوة 2 -->
            <div class="space-y-sm relative p-md rounded-xl hover:bg-surface-container-low transition-all">
                <div class="font-label-md text-label-md font-black tracking-widest text-tertiary uppercase bg-tertiary/10 w-fit px-2 py-0.5 rounded">Step 2</div>
                <h3 class="font-headline-sm text-[20px] font-bold text-on-surface flex items-center gap-xs mt-sm">
                    <span class="material-symbols-outlined text-tertiary">troubleshoot</span> Deep AI Audit
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">LexiGuard scans for hidden risks, generates an interactive summary, and maps out critical data points.</p>
            </div>

            <!-- الخطوة 3 -->
            <div class="space-y-sm relative p-md rounded-xl hover:bg-surface-container-low transition-all">
                <div class="font-label-md text-label-md font-black tracking-widest text-primary uppercase bg-primary/10 w-fit px-2 py-0.5 rounded">Step 3</div>
                <h3 class="font-headline-sm text-[20px] font-bold text-on-surface flex items-center gap-xs mt-sm">
                    <span class="material-symbols-outlined text-primary">forum</span> Chat & Extract
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">Review the flagged risks and use the inline AI Chatbot to ask any follow-up questions about the text.</p>
            </div>
        </div>
    </section>

    <!-- الإغلاق الساحر وعقد الصفقة (CTA Box) -->
    <section class="py-20 px-4 text-center max-w-5xl mx-auto w-full relative z-10">
        <div class="relative bg-gradient-to-b from-surface-container-high to-surface-container rounded-3xl p-xl md:p-xxl border border-outline-variant/80 shadow-2xl overflow-hidden group">
            <!-- إضاءة بؤرية دائرية مدمجة داخل الكرت -->
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-tertiary/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-lg">
                <h2 class="font-headline-lg text-[32px] md:text-[46px] font-black tracking-tight text-on-surface leading-tight">
                    Stop Reviewing Contracts Manually.
                </h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mx-auto text-opacity-90">
                    Join modern HR managers and legal counsels who save over 15 hours a week using LexiGuard AI.
                </p>

                <div class="pt-md flex justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-sm px-xl py-md font-body-md text-body-md bg-primary text-on-primary font-bold rounded-xl hover:scale-[1.03] active:scale-[0.98] transition-all shadow-xl shadow-primary/25 group">
                        <span class="material-symbols-outlined text-[22px] group-hover:rotate-12 transition-transform">security</span>
                        Get Started Now (Free Dashboard Access)
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
</x-layouts.app>