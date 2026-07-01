<x-layouts.app>
    <x-slot:title>Analyzing Document - LexiGuard AI</x-slot:title>

    <div class="w-full max-w-[480px] text-center">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-xl shadow-sm relative overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-1 bg-surface-container-high">
                <div class="h-full bg-primary transition-all duration-700 ease-in-out" id="progress-line" style="width: 0%;"></div>
            </div>

            <div class="mb-lg relative flex justify-center">
                <div class="w-24 h-24 bg-surface-container-low rounded-lg border border-outline-variant flex items-center justify-center document-pulse">
                    <span class="material-symbols-outlined text-primary text-[48px]" style="font-variation-settings: 'FILL' 1;">description</span>
                </div>
            </div>

            <div class="space-y-sm mb-xl">
                <h1 class="font-headline-md text-headline-md text-on-surface">Analyzing document...</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">{{ $document->original_name }}</p>
            </div>

            <div class="space-y-md">
                <div class="flex justify-between items-end mb-base">
                    <span class="font-label-md text-label-md text-primary uppercase tracking-wider">Processing</span>
                    <span class="font-label-md text-label-md text-on-surface" id="percent-text">0%</span>
                </div>
                <div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
                    <div class="h-full animate-shimmer rounded-full transition-all duration-700 ease-in-out" id="main-progress" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const documentId = {{ $document->id }};
        const statusUrl = "{{ route('documents.status', $document) }}";
        const resultUrl = id => `/documents/${id}`; 

        const progressBar = document.getElementById('main-progress');
        const progressLine = document.getElementById('progress-line');
        const percentText = document.getElementById('percent-text');

        const poll = setInterval(async () => {
            try {
                const res = await fetch(statusUrl);
                const data = await res.json();

                progressBar.style.width = `${data.progress}%`;
                progressLine.style.width = `${data.progress}%`;
                percentText.textContent = `${data.progress}%`;

                if (data.status === 'done') {
                    clearInterval(poll);
                    window.location.href = resultUrl(documentId);
                }
            } catch (error) {
                console.error("Error fetching document status:", error);
            }
        }, 1500);
    </script>
</x-layouts.app>