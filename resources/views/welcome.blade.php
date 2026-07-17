<x-layouts.app>
<section class="relative max-w-[1280px] mx-auto px-6 md:px-10 pt-16 md:pt-20 pb-24 grid md:grid-cols-2 gap-16 items-center">
    <div class="absolute top-[-140px] left-[-160px] w-[520px] h-[520px] bg-primary/10 rounded-full blur-[130px] pointer-events-none"></div>
 
    <div class="relative z-10 fade-up">
      <div class="inline-flex items-center gap-2 font-mono text-[11px] tracking-[0.14em] uppercase text-primary bg-primary/8 border border-primary/20 px-3 py-1.5 rounded-full mb-7">
        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
        AI Contract Intelligence
      </div>
 
      <h1 class="font-display text-[46px] md:text-[64px] leading-[1.05] font-semibold tracking-tight text-on-surface mb-7">
        The fine print<br>
        <span class="italic text-primary">doesn't stand</span> a chance.
      </h1>
 
      <p class="text-[17px] leading-[1.7] text-on-surface-variant max-w-md mb-9">
        Drop in any contract, policy, or agreement. LexiGuard reads every clause in seconds, flags what's dangerous, and answers your questions — in plain English, with citations.
      </p>
 
      <div class="flex flex-wrap items-center gap-4 mb-8">
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-md bg-primary text-on-primary font-semibold text-[15px] shadow-[0_10px_30px_-8px_rgba(0,74,198,0.55)] hover:scale-[1.02] active:scale-[0.98] transition-all">
          Analyze your first file free
          <span class="material-symbols-outlined text-[19px]">arrow_forward</span>
        </a>
        <a href="#process" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-md border border-outline text-on-surface font-medium text-[15px] hover:bg-surface-container-low transition-colors">
          <span class="material-symbols-outlined text-[19px]">play_circle</span>
          See a live scan
        </a>
      </div>
 
      <p class="font-mono text-[11px] tracking-wide text-on-surface-variant/80 uppercase">
        Encrypted uploads · Files never used to train models · Delete anytime
      </p>
    </div>
 
    <!-- signature element: scanning contract mock -->
    <div class="relative z-10 flex justify-center md:justify-end fade-up" style="animation-delay:.15s">
      <div class="relative w-full max-w-[380px]">
        <div class="relative bg-surface-container-lowest border border-outline-variant rounded-sm shadow-[0_30px_60px_-20px_rgba(25,27,35,0.25)] rotate-[1.5deg] overflow-hidden paper-lines" style="aspect-ratio: 8.5/11;">
          <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-primary/25 via-primary/10 to-transparent animate-scan"></div>
          </div>
 
          <div class="relative px-7 pt-8 pb-3 border-b border-outline-variant/60">
            <div class="font-mono text-[9px] tracking-[0.15em] text-on-surface-variant/70 uppercase">Master Services Agreement</div>
            <div class="font-mono text-[9px] tracking-[0.1em] text-on-surface-variant/50 uppercase mt-0.5">Ref. 2291-B — Reviewed by LexiGuard</div>
          </div>
 
          <div class="relative px-7 pt-6 space-y-3">
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-full"></div>
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-11/12"></div>
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-4/5"></div>
 
            <div class="relative border-l-[3px] border-tertiary bg-tertiary/10 pl-3.5 py-3 my-4 rounded-r-sm">
              <div class="h-[7px] bg-tertiary/40 rounded-full w-10/12 mb-2"></div>
              <div class="h-[7px] bg-tertiary/40 rounded-full w-7/12"></div>
            </div>
 
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-full"></div>
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-3/4"></div>
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-5/6"></div>
            <div class="h-[7px] bg-on-surface/[0.08] rounded-full w-2/3"></div>
          </div>
        </div>
 
        <div class="absolute -right-9 top-[30%] bg-surface-container-lowest border border-tertiary/30 shadow-xl rounded-lg px-3.5 py-2.5 flex items-center gap-2 text-[12.5px] font-semibold text-on-tertiary-fixed-variant animate-float max-w-[190px]">
          <span class="material-symbols-outlined text-[17px] text-tertiary shrink-0">warning</span>
          Auto-renewal clause detected
        </div>
 
        <div class="absolute -left-10 bottom-8 bg-secondary text-white shadow-xl rounded-xl rounded-bl-sm px-4 py-3 max-w-[210px] text-[12.5px] leading-snug animate-float-delay">
          "What's the termination window?"
          <span class="block mt-1.5 text-white/75 font-mono text-[10.5px]">→ 30 days written notice, §4.2</span>
        </div>
      </div>
    </div>
  </section>
 
  <!-- ================= TRUST STRIP ================= -->
  <section class="border-y border-outline-variant/70 bg-surface-container-low">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-8 flex flex-col sm:flex-row items-center justify-center divide-y sm:divide-y-0 sm:divide-x divide-outline-variant/70 gap-6 sm:gap-0 text-center">
      <div class="sm:px-12 pt-4 sm:pt-0">
        <div class="font-display text-[30px] font-semibold text-on-surface">5 sec<span class="text-on-surface-variant/60 text-[18px] font-sans"> / 50-page scan</span></div>
        <div class="font-mono text-[11px] tracking-wide uppercase text-on-surface-variant mt-1">Full-document read</div>
      </div>
      <div class="sm:px-12 pt-4 sm:pt-0">
        <div class="font-display text-[30px] font-semibold text-on-surface">15 hrs<span class="text-on-surface-variant/60 text-[18px] font-sans"> / week saved</span></div>
        <div class="font-mono text-[11px] tracking-wide uppercase text-on-surface-variant mt-1">Reported by legal &amp; HR teams</div>
      </div>
      <div class="sm:px-12 pt-4 sm:pt-0">
        <div class="font-display text-[30px] font-semibold text-on-surface">0<span class="text-on-surface-variant/60 text-[18px] font-sans"> clauses missed</span></div>
        <div class="font-mono text-[11px] tracking-wide uppercase text-on-surface-variant mt-1">Every line, cited</div>
      </div>
    </div>
  </section>
 
  <!-- ================= AUDIENCE ================= -->
  <section id="audience" class="max-w-[1280px] mx-auto px-6 md:px-10 py-24 md:py-28">
    <div class="max-w-xl mb-16">
      <span class="font-mono text-[11px] tracking-[0.14em] uppercase text-on-surface-variant">Built for high-stakes review</span>
      <h2 class="font-display text-[34px] md:text-[42px] font-semibold tracking-tight mt-3 leading-[1.15]">
        Two teams. One document.<br>Zero patience for surprises.
      </h2>
    </div>
 
    <div class="grid md:grid-cols-2 border-t border-outline-variant">
      <div class="border-b md:border-b-0 md:border-r border-outline-variant py-10 md:pr-14">
        <div class="flex items-center gap-3 text-primary mb-5">
          <span class="material-symbols-outlined text-[26px]">gavel</span>
          <span class="font-mono text-[12px] tracking-[0.1em] uppercase text-on-surface-variant">For counsel</span>
        </div>
        <h3 class="font-display text-[26px] font-semibold mb-4">Legal teams &amp; attorneys</h3>
        <p class="text-on-surface-variant leading-[1.75] mb-6">
          Scan multi-page contracts, NDAs, and vendor agreements before your first coffee is cold. Catch non-compete traps, indemnity gaps, and compliance exposure without reading line by line.
        </p>
        <div class="flex flex-wrap gap-2">
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-primary/8 text-primary border border-primary/15">NDAs</span>
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-primary/8 text-primary border border-primary/15">Vendor agreements</span>
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-primary/8 text-primary border border-primary/15">Compliance review</span>
        </div>
      </div>
 
      <div class="pt-10 md:pt-10 md:pl-14">
        <div class="flex items-center gap-3 text-secondary mb-5">
          <span class="material-symbols-outlined text-[26px]">groups</span>
          <span class="font-mono text-[12px] tracking-[0.1em] uppercase text-on-surface-variant">For people ops</span>
        </div>
        <h3 class="font-display text-[26px] font-semibold mb-4">HR &amp; people operations</h3>
        <p class="text-on-surface-variant leading-[1.75] mb-6">
          Run employment agreements and onboarding paperwork through LexiGuard before they hit a signature line. Stay aligned with company policy and catch high-risk terms instantly.
        </p>
        <div class="flex flex-wrap gap-2">
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-secondary/8 text-secondary border border-secondary/15">Offer letters</span>
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-secondary/8 text-secondary border border-secondary/15">Policy docs</span>
          <span class="text-[12.5px] font-medium px-3 py-1.5 rounded-full bg-secondary/8 text-secondary border border-secondary/15">Onboarding packs</span>
        </div>
      </div>
    </div>
  </section>
 
  <!-- ================= FEATURES AS CLAUSE LIST ================= -->
<section id="clauses" class="bg-surface-container-low border-y border-outline-variant/70">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-16 md:py-20">
      <div class="max-w-xl mb-10">
        <span class="font-mono text-[11px] tracking-[0.14em] uppercase text-on-surface-variant">Article II</span>
        <h2 class="font-display text-[28px] md:text-[34px] font-semibold tracking-tight mt-2 leading-[1.15]">
          What happens the moment you hit upload
        </h2>
      </div>

      <div class="grid md:grid-cols-2 border-t border-l border-outline-variant">
        <div class="group flex gap-4 items-start p-6 md:p-7 border-b border-r border-outline-variant">
          <div class="w-10 h-10 rounded-md bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[20px]">summarize</span>
          </div>
          <div>
            <div class="font-mono text-[11px] text-on-surface-variant/50 mb-1">§ 1</div>
            <h3 class="font-display text-[18px] font-semibold mb-1.5">Instant executive summaries</h3>
            <p class="text-on-surface-variant text-[14.5px] leading-[1.65]">A bulletproof overview of a 50-page document in under five seconds — the intent, without the fluff.</p>
          </div>
        </div>

        <div class="group flex gap-4 items-start p-6 md:p-7 border-b border-r border-outline-variant">
          <div class="w-10 h-10 rounded-md bg-tertiary/10 flex items-center justify-center text-tertiary shrink-0">
            <span class="material-symbols-outlined text-[20px]">report</span>
          </div>
          <div>
            <div class="font-mono text-[11px] text-on-surface-variant/50 mb-1">§ 2</div>
            <h3 class="font-display text-[18px] font-semibold mb-1.5">Critical risk red-flagging</h3>
            <p class="text-on-surface-variant text-[14.5px] leading-[1.65]">High-risk clauses and financial anomalies get flagged automatically, before you sign anything.</p>
          </div>
        </div>

        <div class="group flex gap-4 items-start p-6 md:p-7 border-r border-outline-variant">
          <div class="w-10 h-10 rounded-md bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
            <span class="material-symbols-outlined text-[20px]">chat</span>
          </div>
          <div>
            <div class="font-mono text-[11px] text-on-surface-variant/50 mb-1">§ 3</div>
            <h3 class="font-display text-[18px] font-semibold mb-1.5">Interactive document chat</h3>
            <p class="text-on-surface-variant text-[14.5px] leading-[1.65]">Ask your file directly — "what's the termination policy?" — and get precise, cited answers.</p>
          </div>
        </div>

        <div class="group flex gap-4 items-start p-6 md:p-7">
          <div class="w-10 h-10 rounded-md bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[20px]">description</span>
          </div>
          <div>
            <div class="font-mono text-[11px] text-on-surface-variant/50 mb-1">§ 4</div>
            <h3 class="font-display text-[18px] font-semibold mb-1.5">Sanitized plain-text extraction</h3>
            <p class="text-on-surface-variant text-[14.5px] leading-[1.65]">PDFs and Word docs converted into clean text — tracking elements and hidden code stripped out.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ================= PROCESS ================= -->
  <section id="process" class="max-w-[1280px] mx-auto px-6 md:px-10 py-24 md:py-28">
    <div class="max-w-xl mb-16">
      <span class="font-mono text-[11px] tracking-[0.14em] uppercase text-on-surface-variant">The workflow</span>
      <h2 class="font-display text-[34px] md:text-[42px] font-semibold tracking-tight mt-3 leading-[1.15]">
        Upload to audit in three moves
      </h2>
    </div>
 
    <div class="relative grid md:grid-cols-3 gap-12 md:gap-8">
      <div class="hidden md:block absolute top-[27px] left-[16.5%] right-[16.5%] h-px bg-[repeating-linear-gradient(to_right,#737686_0,#737686_6px,transparent_6px,transparent_12px)]"></div>
 
      <div class="relative">
        <div class="w-[54px] h-[54px] rounded-full border-2 border-primary bg-surface flex items-center justify-center text-primary relative z-10 mb-6">
          <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
        </div>
        <h3 class="font-display text-[20px] font-semibold mb-2">Secure upload</h3>
        <p class="text-on-surface-variant leading-[1.75] text-[15px]">Drag in a PDF or Word file. Encrypted in transit and at rest, and never used to train any model.</p>
      </div>
 
      <div class="relative">
        <div class="w-[54px] h-[54px] rounded-full border-2 border-tertiary bg-surface flex items-center justify-center text-tertiary relative z-10 mb-6">
          <span class="material-symbols-outlined text-[24px]">troubleshoot</span>
        </div>
        <h3 class="font-display text-[20px] font-semibold mb-2">Deep AI audit</h3>
        <p class="text-on-surface-variant leading-[1.75] text-[15px]">LexiGuard scans for hidden risk, builds an interactive summary, and maps every critical data point.</p>
      </div>
 
      <div class="relative">
        <div class="w-[54px] h-[54px] rounded-full border-2 border-secondary bg-surface flex items-center justify-center text-secondary relative z-10 mb-6">
          <span class="material-symbols-outlined text-[24px]">forum</span>
        </div>
        <h3 class="font-display text-[20px] font-semibold mb-2">Chat &amp; extract</h3>
        <p class="text-on-surface-variant leading-[1.75] text-[15px]">Review flagged risks, then ask the inline chatbot follow-up questions about anything in the text.</p>
      </div>
    </div>
  </section>
 
  <!-- ================= FINAL CTA ================= -->
  <section class="w-full  ">
    <div class="relative w-full bg-[#101426] text-white overflow-hidden rounded-md">
      <div class="absolute -top-24 -right-24 w-72 h-72 bg-primary/25 rounded-full blur-[100px] pointer-events-none"></div>
      <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-tertiary/20 rounded-full blur-[100px] pointer-events-none"></div>

      <div class="relative z-10 px-3 md:px-6 py-10 text-center max-w-2xl mx-auto ">
        <h2 class="font-display text-[34px] md:text-[46px] font-semibold tracking-tight leading-[1.15] mb-6">
          Stop reviewing contracts the slow way.
        </h2>
        <p class="text-white/65 text-[16px] leading-[1.7] mb-10 max-w-lg mx-auto">
          Join the legal and HR teams who read every clause and still get their evenings back.
        </p>

        <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 px-7 py-4 rounded-md bg-white text-[#101426] font-semibold text-[15.5px] hover:scale-[1.03] active:scale-[0.98] transition-all shadow-xl">
          <span class="material-symbols-outlined text-[20px]">security</span>
          Get free dashboard access
        </a>

        <svg class="mx-auto mt-12 opacity-40" width="150" height="34" viewBox="0 0 150 34" fill="none">
          <path d="M2 24C10 8 16 8 22 20C28 32 34 6 42 16C50 26 56 10 64 14C72 18 78 30 86 20C94 10 100 6 108 18C114 27 120 12 128 16C134 19 140 27 148 14" stroke="white" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
  </section>
 
</x-layouts.app>