<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'ContractGuard AI - Enterprise Legal Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Geist:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- تسجيل الـ store قبل ما Alpine يبلش، عشان $store.sidebar تكون متاحة بأول render بكل الأماكن (هيدر + sidebar) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false
            });
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid #E5E7EB;
        }
        body {
            background-color: #F8FAFC;
        }
        [x-cloak] {
            display: none !important;
        }
        /* تحكم يدوي بإخفاء الـ sidebar على الموبايل، بدل الاعتماد على class ديناميكية من Tailwind CDN */
        #lexiguard-sidebar {
            transition: transform 300ms ease-in-out;
        }
        @media (max-width: 1023px) {
            #lexiguard-sidebar.sidebar-closed {
                transform: translateX(-100%);
            }
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 10px;
        }
    </style>

    @include('layouts.partials.tailwind-config')
</head>
<body x-data class="font-body-md text-on-surface bg-background">
    @include('layouts.partials.sidebar')

    <!-- lg:ml-[280px] يبعد المحتوى عن الـ sidebar بس على الشاشات الكبيرة (فوق 1024px) -->
    <main class="lg:ml-[280px] min-h-screen">

        @include('layouts.partials.header')

        <div class="mx-4 md:mx-10 mt-5 max-w-[1440px] space-y-10">
            @yield('content')
        </div>

        {{-- @include('layouts.partials.footer') --}}

    </main>

    <button class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center z-50">
        <span class="material-symbols-outlined text-2xl" data-icon="chat" style="font-variation-settings: 'FILL' 1;">chat</span>
    </button>

    <script>
        // منع تحديث الصفحة عند الضغط على الروابط الفارغة
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('click', (e) => {
                if (el.tagName === 'A' && el.getAttribute('href') === '#') e.preventDefault();
            });
        });

        // تأثيرات حقل البحث
        const searchInput = document.querySelector('input[type="text"]');
        if(searchInput) {
            searchInput.addEventListener('focus', () => {
                searchInput.parentElement.classList.add('ring-1', 'ring-primary');
            });
            searchInput.addEventListener('blur', () => {
                searchInput.parentElement.classList.remove('ring-1', 'ring-primary');
            });
        }

        // --- حل مشكلة الأخطاء الحمراء في الكونسول ---
        // تعريف دالة البحث الخاصة بالهيدر ليتعرف عليها Alpine.js
        function headerSearch() {
            return {
                query: '',
                results: null,
                loading: false,
                open: false,

                async search() {
                    if (this.query.trim().length < 2) {
                        this.results = null;
                        this.open = false;
                        return;
                    }

                    this.loading = true;
                    try {
                        // تأكد من تغيير الرابط أدناه إذا كان مختلفاً في مشروعك
                        const res = await fetch(`/search/live?q=${encodeURIComponent(this.query)}`, {
                            headers: { 'Accept': 'application/json' }
                        });
                        this.results = await res.json();
                        this.open = true;
                    } catch (e) {
                        console.error('Search error:', e);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>
