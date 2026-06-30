<x-layouts.app>
    <x-slot:title>
        LexiGuard AI - الصفحة الرئيسية
    </x-slot:title>

    <div class="max-w-2xl w-full text-center space-y-xl animate-in fade-in duration-700 slide-in-from-bottom-4">
        <!-- أيقونة المستند المستديرة -->
        <div class="flex justify-center mb-xl">
            <div class="w-24 h-24 bg-surface-container-lowest rounded-xl border border-outline-variant flex items-center justify-center text-primary shadow-sm">
                <span class="material-symbols-outlined text-[48px]" style="font-variation-settings: 'wght' 300;">description</span>
            </div>
        </div>
        
        <!-- النصوص الترحيبية -->
        <div class="space-y-md">
            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">LexiGuard AI</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg mx-auto">
                Smart analysis for HR, Legal, and Business. Uncover risks and insights in seconds with our legal-grade security engine.
            </p>
        </div>

        <!-- زر الرفع وصيغ الملفات -->
     <form action="/upload" method="POST" enctype="multipart/form-data" class="pt-lg flex flex-col items-center gap-md">
    @csrf

    <label for="document"
        class="upload-gradient text-on-primary px-xl py-md rounded-lg font-headline-sm flex items-center gap-sm hover:opacity-90 active:scale-95 transition-all shadow-md group cursor-pointer">

        <span class="material-symbols-outlined"
            style="font-variation-settings: 'FILL' 1;">
            upload_file
        </span>

        Upload Document
    </label>

    <input
        type="file"
        id="document"
        name="document"
        accept=".pdf,.doc,.docx,.txt"
        class="hidden">

    <p class="font-body-sm text-body-sm text-outline">
        Supported formats: PDF, DOCX, TXT. Max size 25MB.
    </p>
</form>

        <!-- شبكة المميزات الثلاثية (Bento Grid) متطابقة مع image_4a658d.png -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mt-xxl text-left">
            <!-- الكرت الأول -->
            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">verified_user</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Risk Assessment</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Automated identification of high-risk clauses and liabilities.</p>
            </div>

            <!-- الكرت الثاني (المضاف للتطابق) -->
            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">bolt</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Instant Summary</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Get the core terms and obligations in plain English.</p>
            </div>

            <!-- الكرت الثالث (المضاف للتطابق) -->
            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">translate</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Smart Translation</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Translate legal terminology across 20+ jurisdictions.</p>
            </div>
        </div>
    </div>
</x-layouts.app>