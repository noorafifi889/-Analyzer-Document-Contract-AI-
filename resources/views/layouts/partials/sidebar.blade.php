<aside class="fixed left-0 top-0 h-screen w-[280px] bg-surface-container-lowest border-r border-outline-variant flex flex-col py-stack-lg px-gutter z-50">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary text-2xl" data-icon="gavel" style="font-variation-settings: 'FILL' 1;">gavel</span>
        </div>
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-on-surface">LexiGuard AI</h1>
            <p class="font-label-md text-label-md text-on-surface-variant">Enterprise Legal</p>
        </div>
    </div>
    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-primary font-bold bg-surface-container-low transition-colors duration-150" href=""{{ route('dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>
        <a  class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors duration-150"       href="{{ route('documents.history') }}">
            <span class="material-symbols-outlined" data-icon="description">description</span>
            <span class="font-label-md text-label-md">Contracts</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors duration-150" href="#">
            <span class="material-symbols-outlined" data-icon="psychology">psychology</span>
            <span class="font-label-md text-label-md">Contract Intelligence</span>
        </a>
     

        <div class="pt-8 pb-4">
            <p class="px-3 font-label-sm text-label-sm text-outline uppercase tracking-widest">Admin</p>
        </div>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors duration-150" href="#">
            <span class="material-symbols-outlined" data-icon="bar_chart">bar_chart</span>
            <span class="font-label-md text-label-md">Reports</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition-colors duration-150" href="#">
            <span class="material-symbols-outlined" data-icon="settings">settings</span>
            <span class="font-label-md text-label-md">Settings</span>
        </a>
    </nav>
    <div class="mt-auto border-t border-outline-variant pt-6 flex items-center gap-3">
        <img class="w-10 h-10 rounded-full border border-outline-variant object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZ3esGvmB655eRc8pryGKB6q4kPUjbys8kvDNTRGsPPZjby7rUPzTUaSi7lb4_WFvRC87tUAdqn1qst_CsDp3DkHATLS5TzphG_EewvOZJZBbNm4ShyXWC_rLaTjG_qjKvHGs61YwMu1rSQI-OAwZCjaJCJhImIqxxiiS6q1-xhkGDTwQPw-CYICjZuGBB7smfJWdlFJt7eRca6ZroQbAQPZeUHCdj5bxYms0CB10-g9z1djGIawd29sF6AbsvoVlEapUYB5JSbg"/>
        <div class="flex-1 overflow-hidden">
            <p class="font-label-md text-label-md font-bold text-on-surface truncate">     {{ auth()->user()->name }} </p>
            <p class="font-label-sm text-label-sm text-on-surface-variant truncate">Principal Counsel</p>
        </div>
        <button class="text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined" data-icon="logout">logout</span>
        </button>
    </div>
</aside>