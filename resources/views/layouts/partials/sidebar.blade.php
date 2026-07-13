<aside class="fixed left-0 top-0 h-screen w-[280px] bg-surface-container-lowest border-r border-outline-variant flex flex-col py-stack-lg px-gutter z-50">
    <div class="mb-10 px-2 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary text-2xl" style="font-variation-settings: 'FILL' 1;">gavel</span>
        </div>
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-on-surface">LexiGuard AI</h1>
            <p class="font-label-md text-label-md text-on-surface-variant">Enterprise Legal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors duration-150
                  {{ request()->routeIs('dashboard') ? 'text-primary font-bold bg-surface-container-low' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('dashboard') ? 1 : 0 }};">dashboard</span>
            <span class="font-label-md text-label-md">Dashboard</span>
        </a>

        <a href="{{ route('documents.history') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors duration-150
                  {{ request()->routeIs('documents.*') ? 'text-primary font-bold bg-surface-container-low' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('documents.*') ? 1 : 0 }};">description</span>
            <span class="font-label-md text-label-md">Contracts</span>
        </a>

        <a href="{{ route('intelligence.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors duration-150
                  {{ request()->routeIs('intelligence.*') ? 'text-primary font-bold bg-surface-container-low' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ request()->routeIs('intelligence.*') ? 1 : 0 }};">psychology</span>
            <span class="font-label-md text-label-md">Contract Intelligence</span>
        </a>
                           <a href="{{ route('reports.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors duration-150
                  {{ request()->routeIs('reports.*') ? 'text-primary font-bold bg-surface-container-low' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined">bar_chart</span>
                        <span class="font-label-md text-label-md">Reports</span>
        </a>
               <a href="{{ route('settings.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors duration-150
                  {{ request()->routeIs('settings.*') ? 'text-primary font-bold bg-surface-container-low' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined">settings</span>
                        <span class="font-label-md text-label-md">Settings</span>
        </a>

  
    
    </nav>

   <div class="mt-auto border-t border-outline-variant pt-6 flex items-center gap-3">
    @if(auth()->user()->avatar)
        <img class="w-10 h-10 rounded-full border border-outline-variant object-cover"
             src="{{ Storage::url(auth()->user()->avatar) }}"
             alt="{{ auth()->user()->name }}">
    @else
        <div class="w-10 h-10 rounded-full border border-outline-variant bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    @endif

    <div class="flex-1 overflow-hidden">
        <p class="font-label-md text-label-md font-bold text-on-surface truncate">{{ auth()->user()->name }}</p>
        <p class="font-label-sm text-label-sm text-on-surface-variant truncate">Principal Counsel</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-on-surface-variant hover:text-primary transition-colors" title="Sign out">
            <span class="material-symbols-outlined">logout</span>
        </button>
    </form>
</div>
</aside>