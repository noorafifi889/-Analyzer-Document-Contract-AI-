<x-layouts.app>
    <x-slot:title>Analyzing Document - LexiGuard AI</x-slot:title>

    <div class="w-full max-w-[480px] text-center">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-xl shadow-sm relative overflow-hidden">

            <!-- الشريط العلوي النحيف -->
            <div class="absolute top-0 left-0 w-full h-1 bg-surface-container-high">
                <div class="h-full bg-primary transition-all duration-1000 ease-in-out" id="progress-line" style="width: 0%;"></div>
            </div>

            <div class="mb-lg relative flex justify-center">
                <!-- إضافة أنيميشن نبض خفيف للملف ليظهر أنه يتحرك -->
                <div class="w-24 h-24 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-center animate-pulse">
                    <span class="material-symbols-outlined text-primary text-[48px]" style="font-variation-settings: 'FILL' 1;">description</span>
                </div>
            </div>

            <div class="space-y-sm mb-xl">
                <h1 class="font-headline-md text-headline-md text-on-surface">Analyzing document...</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">{{ $document->original_name }}</p>
            </div>

            <div class="space-y-md">
                <div class="flex justify-between items-end mb-base">
                    <span class="font-label-md text-label-md text-primary uppercase tracking-wider animate-pulse">Processing...</span>
                    <span class="font-label-md text-label-md text-on-surface font-bold transition-all duration-500" id="percent-text">0%</span>
                </div>
                <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden relative">
                    <!-- الشريط الرئيسي مع إضافة لون bg-primary وحركة لمعان مستمرة -->
                    <div class="h-full bg-primary rounded-full transition-all duration-1000 ease-in-out relative" id="main-progress" style="width: 0%;">
                        <!-- تأثير اللمعان المتحرك الخلفي -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-[shimmer_1.5s_infinite] w-full h-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة الـ keyframes الخاصة باللمعان بما أننا نستخدم الـ CDN -->
    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>

    <script>
        const documentId = {{ $document->id }};
        const statusUrl = "{{ route('documents.status', $document) }}";
        const resultUrl = id => `/documents/${id}`; 

        const progressBar = document.getElementById('main-progress');
        const progressLine = document.getElementById('progress-line');
        const percentText = document.getElementById('percent-text');

        // متغير للاحتفاظ بآخر قيمة مسجلة لمنع التراجع
        let currentProgress = 0;

        const poll = setInterval(async () => {
            try {
                const res = await fetch(statusUrl);
                const data = await res.json();

                console.log("Current Status from DB:", data);

                // نتأكد أن النسبة القادمة أكبر أو تساوي الحالية لضمان سلاسة الصعود
                if (data.progress >= currentProgress) {
                    currentProgress = data.progress;
                    
                    // تحديث العناصر مع الـ Transition الخاص بـ Tailwind (سيتغير بنعومة خلال ثانية كاملة)
                    progressBar.style.width = `${currentProgress}%`;
                    progressLine.style.width = `${currentProgress}%`;
                    percentText.textContent = `${currentProgress}%`;
                }

                if (data.status === 'done' || data.status === 'Completed' || currentProgress >= 100) {
                    clearInterval(poll);
                    console.log("Analysis done! Redirecting...");
                    
                    // ننتظر ثانية واحدة بعد الـ 100% ليشاهد المستخدم اكتمال الأنيميشن بالكامل
                    setTimeout(() => {
                        window.location.href = resultUrl(documentId);
                    }, 1200); 
                }
            } catch (error) {
                console.error("Error fetching document status:", error);
            }
        }, 1500);
    </script>
</x-layouts.app>