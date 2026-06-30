<x-layouts.app>
    <x-slot:title>
        Forgot Password | LexiGuard AI
    </x-slot:title>

    <x-slot:hideNav>true</x-slot:hideNav>

    <div class="fixed inset-0 h-screen w-screen flex flex-col md:flex-row bg-[#F8FAFC] overflow-hidden">

        {{-- ===== LEFT: Branding Section ===== --}}
        <section class="hidden md:flex md:w-[45%] lg:w-[40%] bg-surface-container-low relative overflow-hidden items-center justify-center p-xl">
            <div class="relative z-10 max-w-md w-full">

                <div class="mb-xl">
                    <span class="font-headline-sm text-headline-sm font-bold text-primary">LexiGuard AI</span>
                </div>

                <h1 class="font-headline-xl text-headline-xl text-on-surface mb-lg">
                    Secure Document Intelligence.
                </h1>

                <p class="font-body-lg text-body-lg text-on-surface-variant mb-xl">
                    Experience legal-grade analysis with enterprise security at every step. Your data is encrypted, analyzed, and protected.
                </p>

                <div class="grid grid-cols-2 gap-md">
                    <div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant">
                        <span class="material-symbols-outlined text-primary mb-sm block" style="font-variation-settings: 'FILL' 1;">security</span>
                        <h3 class="font-headline-sm text-[16px] mb-xs">AES-256 Encryption</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Banking-level data security protocols.</p>
                    </div>
                    <div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant">
                        <span class="material-symbols-outlined text-primary mb-sm block" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        <h3 class="font-headline-sm text-[16px] mb-xs">Compliance Ready</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">SOC2 and GDPR fully compliant.</p>
                    </div>
                </div>
            </div>

            {{-- Decorative blur --}}
            <div class="absolute bottom-[-100px] right-[-100px] w-80 h-80 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
        </section>

        {{-- ===== RIGHT: Form Section ===== --}}
        <section class="flex-1 flex items-center justify-center p-gutter bg-surface-container-lowest overflow-y-auto custom-scrollbar">
            <div class="w-full max-w-[440px]">

                {{-- Mobile Logo --}}
                <div class="md:hidden mb-xl flex items-center gap-sm">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary" style="font-variation-settings: 'FILL' 1;">shield</span>
                    </div>
                    <span class="font-headline-sm text-headline-sm font-bold text-primary">LexiGuard AI</span>
                </div>

                {{-- Title --}}
                <div class="mb-xl">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-sm">Forgot password?</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Enter your email and we'll send you a link to reset your password.
                    </p>
                </div>

                {{-- Success Message --}}
                @if (session('status'))
                    <div class="mb-md p-md bg-green-50 border border-green-200 rounded-lg text-green-700 font-body-sm text-body-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-md p-md bg-error-container/20 border-l-4 border-error rounded-r-lg text-error font-body-sm text-body-sm">
                        <ul class="list-disc pl-md space-y-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form class="space-y-lg" id="forgot-password-form" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email Field --}}
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="email">
                            Email address
                        </label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline transition-colors duration-200"
                                id="email-icon"
                            >mail</span>
                            <input
                                class="w-full h-12 pl-12 pr-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary transition-all @error('email') border-error @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="name@company.com"
                                type="email"
                                required
                                autofocus
                            />
                        </div>
                        @error('email')
                            <p class="text-error font-body-sm text-body-sm mt-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button
                        class="w-full h-12 bg-primary text-on-primary font-headline-sm text-[16px] rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-sm"
                        type="submit"
                        id="submit-btn"
                    >
                        <span>Send reset link</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

                {{-- Back to Login --}}
                <div class="mt-xl pt-lg border-t border-outline-variant flex justify-center">
                    <a
                        class="flex items-center gap-xs font-body-md text-primary hover:underline transition-all"
                        href="{{ route('login') }}"
                    >
                        <span class="material-symbols-outlined text-[18px]">keyboard_backspace</span>
                        <span>Back to Sign in</span>
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="mt-xxl flex items-center justify-center gap-xl opacity-40">
                    <div class="h-8 w-28 border border-dashed border-outline rounded flex items-center justify-center text-[10px] text-on-surface-variant">
                        LAW FIRM PARTNER
                    </div>
                    <div class="h-8 w-28 border border-dashed border-outline rounded flex items-center justify-center text-[10px] text-on-surface-variant">
                        GLOBAL ENTERPRISE
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        // Icon focus effect
        const emailInput = document.getElementById('email');
        const emailIcon  = document.getElementById('email-icon');

        if (emailInput && emailIcon) {
            emailInput.addEventListener('focus', () => {
                emailIcon.classList.replace('text-outline', 'text-primary');
            });
            emailInput.addEventListener('blur', () => {
                emailIcon.classList.replace('text-primary', 'text-outline');
            });
        }

        // Loading state on submit
        document.getElementById('forgot-password-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `
                    <span class="material-symbols-outlined animate-spin">progress_activity</span>
                    <span>Sending...</span>
                `;
            }
        });
    </script>
</x-layouts.app>