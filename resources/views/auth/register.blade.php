<x-layouts.app>
    <x-slot:title>
        Register | LexiGuard AI
    </x-slot:title>

    <x-slot:hideNav>true</x-slot:hideNav>

    <div class="fixed inset-0 top-0 h-screen w-screen flex flex-col md:flex-row bg-[#F8FAFC] z-30 overflow-hidden">

        {{-- ===== LEFT: Form Section ===== --}}
        <section class="w-full md:w-[45%] lg:w-[40%] bg-surface-container-lowest flex flex-col justify-center px-gutter py-xl relative z-10 overflow-y-auto custom-scrollbar">
            <div class="max-w-md mx-auto w-full">

                <div class="mb-xxl">
                    <span class="font-headline-sm text-headline-sm font-bold text-primary">LexiGuard AI</span>
                </div>

                <div class="mb-xl">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface mb-xs">Create your LexiGuard account</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant">Professional-grade document analysis.</p>
                </div>

                <form class="space-y-md" method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- ===== Validation Errors ===== --}}
                    @if ($errors->any())
                        <div class="p-md bg-error-container/20 border-l-4 border-error rounded-r-lg text-error font-body-sm text-body-sm">
                            <ul class="list-disc pl-md space-y-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- ← @endif هون، برا عن الحقول --}}

                    {{-- ===== Name ===== --}}
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="name">
                            Name
                        </label>
                        <input
                            class="w-full h-12 px-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary transition-all @error('name') border-error @enderror"
                            id="name"
                            name="name"
                            placeholder="Jane Doe"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autofocus
                        />
                        @error('name')
                            <p class="text-error font-body-sm text-body-sm mt-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ===== Email ===== --}}
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="email">
                            Email
                        </label>
                        <input
                            class="w-full h-12 px-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary transition-all @error('email') border-error @enderror"
                            id="email"
                            name="email"
                            placeholder="jane.doe@gmail.com"
                            type="email"
                            value="{{ old('email') }}"
                            required
                        />
                        @error('email')
                            <p class="text-error font-body-sm text-body-sm mt-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ===== Password ===== --}}
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="password-field">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                class="w-full h-12 pl-md pr-xl bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary transition-all @error('password') border-error @enderror"
                                id="password-field"
                                name="password"
                                placeholder="••••••••"
                                type="password"
                                required
                            />
                            <button
                                class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors"
                                onclick="togglePassword('password-field', 'password-toggle-icon')"
                                type="button"
                            >
                                <span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-error font-body-sm text-body-sm mt-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ===== Confirm Password ===== --}}
                    {{-- ⚠️ name لازم يكون password_confirmation عشان Breeze يتعرف عليه --}}
                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="confirm-password-field">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input
                                class="w-full h-12 pl-md pr-xl bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary transition-all"
                                id="confirm-password-field"
                                name="password_confirmation"
                                placeholder="••••••••"
                                type="password"
                                required
                            />
                            <button
                                class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors"
                                onclick="togglePassword('confirm-password-field', 'confirm-password-toggle-icon')"
                                type="button"
                            >
                                <span class="material-symbols-outlined text-[20px]" id="confirm-password-toggle-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    {{-- ===== Terms ===== --}}
                    <div class="flex items-start gap-md pt-sm">
                        <div class="flex items-center h-5">
                            <input
                                class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary"
                                id="terms"
                                type="checkbox"
                                required
                            />
                        </div>
                        <label class="font-body-sm text-body-sm text-on-surface-variant" for="terms">
                            I agree to the
                            <a class="text-primary hover:underline font-medium" href="#">Terms of Service</a>
                            and
                            <a class="text-primary hover:underline font-medium" href="#">Privacy Policy</a>.
                        </label>
                    </div>

                    {{-- ===== Submit ===== --}}
                    <div class="pt-md">
                        <button
                            class="w-full h-12 bg-primary text-on-primary font-headline-sm text-[16px] rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all duration-150"
                            type="submit"
                        >
                            Create account
                        </button>
                    </div>

                    {{-- ===== Login Link ===== --}}
                    <div class="text-center pt-md">
                        <p class="font-body-md text-body-md text-on-surface-variant">
                            Already have an account?
                            <a class="text-primary font-semibold hover:underline" href="{{ route('login') }}">Sign in</a>
                        </p>
                    </div>

                </form>
            </div>
        </section>

        {{-- ===== RIGHT: Preview Section ===== --}}
        <section class="hidden md:flex flex-1 bg-surface-dim relative items-center justify-center p-xl overflow-hidden">
            <div class="relative z-20 w-full max-w-2xl transform rotate-1 perspective-1000">
                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-xl overflow-hidden max-h-[716px] flex flex-col">

                    {{-- Header --}}
                    <div class="p-lg border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                        <div class="flex items-center gap-md">
                            <div class="w-8 h-8 rounded bg-primary-container flex items-center justify-center text-on-primary-container">
                                <span class="material-symbols-outlined text-[20px]">description</span>
                            </div>
                            <div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface">Master_Service_Agreement_v2.pdf</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Analyzing risks and clauses...</p>
                            </div>
                        </div>
                        <div class="px-md py-xs bg-tertiary-container text-on-tertiary-container rounded-full font-label-md text-label-md">
                            High Risk Detected
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-lg overflow-y-auto custom-scrollbar space-y-lg">
                        <div class="space-y-sm">
                            <div class="h-4 w-3/4 bg-surface-variant rounded-full opacity-60"></div>
                            <div class="h-4 w-full bg-surface-variant rounded-full opacity-60"></div>
                            <div class="h-4 w-5/6 bg-surface-variant rounded-full opacity-60"></div>
                        </div>

                        <div class="p-md border-l-4 border-error bg-error-container/20 rounded-r-lg">
                            <div class="flex items-center gap-xs mb-xs">
                                <span class="material-symbols-outlined text-error text-[18px]">warning</span>
                                <span class="font-label-md text-label-md text-error uppercase">Indemnification Clause 12.4</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface mb-md italic">
                                "The Contractor shall be solely responsible for any and all intellectual property infringement claims without limitation..."
                            </p>
                            <div class="p-sm bg-white border border-outline-variant rounded shadow-sm">
                                <p class="font-body-sm text-body-sm font-semibold text-primary">LexiGuard Analysis:</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">The lack of a liability cap poses a significant financial risk. Recommendation: Negotiate a cap equal to 12 months' fees.</p>
                            </div>
                        </div>

                        <div class="space-y-sm">
                            <div class="h-4 w-full bg-surface-variant rounded-full opacity-60"></div>
                            <div class="h-4 w-2/3 bg-surface-variant rounded-full opacity-60"></div>
                        </div>

                        <div class="p-md border-l-4 border-primary bg-secondary-container/20 rounded-r-lg">
                            <div class="flex items-center gap-xs mb-xs">
                                <span class="material-symbols-outlined text-primary text-[18px]">check_circle</span>
                                <span class="font-label-md text-label-md text-primary uppercase">Termination Rights</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Clause 14.1 correctly specifies a 30-day notice period for termination for convenience.</p>
                        </div>
                    </div>

                    {{-- Footer Stats --}}
                    <div class="p-md bg-surface-container-high border-t border-outline-variant flex items-center justify-around gap-lg">
                        <div class="text-center">
                            <p class="font-label-md text-[11px] text-on-surface-variant uppercase">Risk Score</p>
                            <p class="font-headline-sm text-headline-sm text-error">78/100</p>
                        </div>
                        <div class="w-px h-8 bg-outline-variant"></div>
                        <div class="text-center">
                            <p class="font-label-md text-[11px] text-on-surface-variant uppercase">Critical Issues</p>
                            <p class="font-headline-sm text-headline-sm text-on-surface">4</p>
                        </div>
                        <div class="w-px h-8 bg-outline-variant"></div>
                        <div class="text-center">
                            <p class="font-label-md text-[11px] text-on-surface-variant uppercase">AI Confidence</p>
                            <p class="font-headline-sm text-headline-sm text-on-surface">94%</p>
                        </div>
                    </div>

                </div>

                {{-- Floating image --}}
                <div class="absolute -bottom-12 -right-12 w-48 h-48 rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform -rotate-12 hidden lg:block">
                    <img class="w-full h-full object-cover" alt="Modern Workspace"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCnoVvOsJlHv0x1NuQpHWFHC6nUfHSCQe67JpyOUZTPRJbQA-AIwqQZGHbVbAG3XGI0BhK2E2m5tpvIeKs-ObB0LDrM5XFq2-EX89ljM_4vxccU3GgCiCy-0ahxNqOCRhsQDMBNsTmyQtJjO-ws47ESwxHV9OaQFsWv_dyrJfRSKmVb68h0brI9LtBDQ9DebEXP-kFfThvuOiQMuseleO3MzuN-HTCc0Y4d_N0BF34QexW1L9jwomCbT3CF8f-fXWcbN5XVsc3sF7A"/>
                </div>
            </div>
        </section>

    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                field.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        document.addEventListener('mousemove', (e) => {
            const panel = document.querySelector('.perspective-1000');
            if (!panel) return;
            const xAxis = (window.innerWidth / 2 - e.pageX) / 100;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 100;
            panel.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg) rotate(1deg)`;
        });
    </script>
</x-layouts.app>