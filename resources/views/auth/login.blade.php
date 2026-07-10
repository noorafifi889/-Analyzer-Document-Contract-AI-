<x-layouts.app>
<x-slot:title>
        Sign in | LexiGuard AI
    </x-slot:title>

    <x-slot:hideNav>true</x-slot:hideNav>

<div class="fixed inset-0 top-0 h-screen w-screen flex flex-col md:flex-row bg-background z-50">        
<section class="w-full md:w-[45%] lg:w-[40%] flex flex-col items-center justify-center p-gutter lg:p-xxl pt-xl bg-surface-container-lowest z-10 overflow-y-auto min-h-screen">            <div class="w-full max-w-md my-auto pb-xxl md:pb-0">
                <div class="mb-xl">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-headline-md" style="font-variation-settings: 'FILL' 1;">gavel</span>
                        <span class="font-headline-sm text-headline-sm font-bold text-primary">LexiGuard AI</span>
                    </div>
                </div>
                
                <div class="space-y-sm mb-xl">
                    <h1 class="font-headline-md text-headline-md text-on-surface">Sign in to your account</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant">Access your legal document intelligence.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-lg">
                    @csrf

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="email">Email Address</label>
                        <input class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-outline" 
                            id="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" type="email" required autofocus autocomplete="username" />
                        @if ($errors->has('email'))
                            <p class="text-error text-body-sm mt-xs flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[16px]">error</span>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <div class="relative">
                        <div class="flex justify-between items-center mb-xs">
                            <label class="block font-label-md text-label-md text-on-surface-variant" for="password">Password</label>
                            @if (Route::has('password.request'))
                                <a class="font-label-md text-label-md text-primary hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <input class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-outline" 
                                id="password" name="password" placeholder="••••••••" type="password" required autocomplete="current-password" />
                            <button class="absolute right-md top-1/2 -translate-y-1/2 text-outline hover:text-on-surface-variant transition-colors" onclick="togglePassword()" type="button">
                                <span class="material-symbols-outlined" id="eye-icon">visibility</span>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <p class="text-error text-body-sm mt-xs flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[16px]">error</span>
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center">
                        <input class="w-4 h-4 text-primary bg-surface border-outline-variant rounded focus:ring-primary" id="remember" name="remember" type="checkbox"/>
                        <label class="ml-sm font-body-sm text-body-sm text-on-surface-variant select-none" for="remember">Remember me</label>
                    </div>

                    <button class="w-full py-md px-lg bg-primary text-on-primary font-headline-sm text-headline-sm rounded-lg hover:opacity-90 active:opacity-80 transition-all shadow-sm flex items-center justify-center gap-sm" type="submit">
                        <span class="material-symbols-outlined text-[20px]">login</span>
                        Sign in
                    </button>

               
                </form>

                <p class="mt-xl text-center font-body-sm text-body-sm text-on-surface-variant">
                    Don't have an account? <a class="text-primary font-semibold hover:underline" href="{{ route('register') }}">Register</a>
                </p>
            </div>
        </section>

<section class="hidden md:flex flex-1 bg-gradient-to-br from-[#003ea8] via-[#00297a] to-[#0b1c30] relative items-center justify-center overflow-hidden min-h-full">    <div class="relative z-10 w-full max-w-2xl px-xl  bg-blue/500">
        <div class="grid grid-cols-12 gap-md items-end">
            <div class="col-span-8 glass-panel p-lg rounded-xl shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                <div class="flex justify-between items-start mb-md">
                    <div>
                        <h3 class="text-white font-headline-sm text-headline-sm mb-xs">Master Service Agreement</h3>
                        <p class="text-white/70 font-body-sm text-body-sm">v2.4 • Updated yesterday</p>
                    </div>
                    <div class="bg-error-container text-on-error-container px-sm py-xs rounded-full font-label-md text-label-md flex items-center gap-xs">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">warning</span>
                        High Risk
                    </div>
                </div>
                <div class="space-y-sm">
                    <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-error w-3/4"></div>
                    </div>
                    <div class="flex gap-sm">
                        <div class="flex-1 h-20 bg-white/5 rounded-lg border border-white/10 p-sm">
                            <div class="w-1/2 h-2 bg-white/20 rounded mb-xs"></div>
                            <div class="w-full h-2 bg-white/10 rounded"></div>
                        </div>
                        <div class="flex-1 h-20 bg-white/5 rounded-lg border border-white/10 p-sm">
                            <div class="w-2/3 h-2 bg-white/20 rounded mb-xs"></div>
                            <div class="w-1/3 h-2 bg-white/10 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-span-4 glass-panel p-md rounded-lg shadow-xl translate-y-8">
                <div class="flex items-center gap-sm mb-xs">
                    <span class="material-symbols-outlined text-tertiary-fixed">auto_awesome</span>
                    <span class="text-white font-label-md text-label-md">AI Insight</span>
                </div>
                <p class="text-white/80 font-body-sm text-body-sm leading-tight">Indemnity clause exceeds standard liability caps by 40%.</p>
            </div>
            
            <div class="col-span-12 mt-md glass-panel p-md rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-md">
                    <div class="w-10 h-10 bg-primary-container rounded flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">description</span>
                    </div>
                    <div>
                        <p class="text-white font-label-md text-label-md">Employment_Contract_Final.pdf</p>
                        <p class="text-white/60 text-[12px]">Ready for Review</p>
                    </div>
                </div>
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full border-2 border-primary bg-secondary-fixed flex items-center justify-center text-[10px] font-bold">JD</div>
                    <div class="w-8 h-8 rounded-full border-2 border-primary bg-tertiary-fixed flex items-center justify-center text-[10px] font-bold">AS</div>
                </div>
            </div>
        </div>
        
        <div class="mt-xl text-center">
            <h2 class="text-white font-headline-lg text-headline-lg mb-sm">Unmatched Legal Precision</h2>
            <p class="text-white/70 font-body-lg text-body-lg max-w-lg mx-auto">LexiGuard AI scans thousands of clauses in seconds, identifying hidden liabilities and ensuring compliance with your corporate standards.</p>
        </div>
    </div>
    
    <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-primary/30 rounded-full blur-3xl"></div>
    <div class="absolute -top-16 -left-16 w-64 h-64 bg-secondary/30 rounded-full blur-3xl"></div>
</section>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.glass-panel');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
                    el.style.opacity = '1';
                    el.style.transform = index === 0 ? 'rotate(-2deg) translateY(0)' : 'translateY(0)';
                }, 100 * (index + 1));
            });
        });
    </script>
</x-layouts.app>