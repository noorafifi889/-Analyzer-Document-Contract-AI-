<!-- 
  تعديلات الـ header:
  - إضافة lg:pl-[280px] لمنع تغطية المحتوى بواسطة الـ Sidebar الثابت في الشاشات الكبيرة.
  - تحسين توزيع الأزرار لتوفير أكبر مساحة ممكنة لمربع البحث على الهواتف.
-->
<header class="sticky top-0 z-30 w-full bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-4 lg:pl-[296px] lg:pr-margin-page gap-2">

    <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">

        <!-- زر فتح القائمة - يظهر فقط على الشاشات الصغيرة (أصغر من lg) -->
        <button
            type="button"
            @click="$store.sidebar.open = true"
            class="lg:hidden shrink-0 w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors"
            aria-label="Open menu">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <div class="relative w-full max-w-md min-w-0" x-data="headerSearch()" @click.outside="open = false">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg" data-icon="search">search</span>

            <input
                class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-10 py-2 text-body-md focus:ring-1 focus:ring-primary truncate"
                placeholder="Search..."
                type="text"
                x-model="query"
                @input.debounce.350ms="search()"
                @focus="if (results) open = true"
                @keydown.enter.prevent
            />

            <!-- Loading spinner -->
            <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2" x-cloak>
                <span class="material-symbols-outlined animate-spin text-on-surface-variant text-lg">progress_activity</span>
            </div>

            <!-- Dropdown النتائج -->
            <div
                x-show="open"
                x-transition
                x-cloak
                class="absolute mt-2 w-full bg-surface-container rounded-2xl shadow-lg border border-outline-variant overflow-hidden z-50"
                style="display: none;"
            >
                <template x-if="results && results.documents.length === 0">
                    <p class="px-4 py-3 text-body-sm text-on-surface-variant">No result found.</p>
                </template>

                <template x-if="results && results.documents.length > 0">
                    <div>
                        <p class="px-4 pt-3 pb-1 text-label-sm font-bold text-on-surface-variant">Documents</p>
                        <template x-for="doc in results.documents" :key="doc.id">
                            <a :href="`//${doc.id}`" class="flex items-center gap-2 px-4 py-2 hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-lg text-on-surface-variant">description</span>
                                <span class="text-body-md truncate" x-text="doc.title"></span>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-1 sm:gap-3 shrink-0">
        <!-- زر الإشعارات -->
        <button type="button" class="hidden sm:flex items-center gap-2 p-2 text-on-surface-variant hover:text-primary transition-colors relative">
            <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
        </button>
        
        <!-- زر المساعدة -->
        <a href="{{ route('help.index') }}" class="hidden sm:flex items-center gap-2 p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined" data-icon="help">help</span>
        </a>
        
        <!-- فورم الرفع -->
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="header-upload-form" class="inline-block">
            @csrf
            <input type="hidden" name="redirect_to" value="intelligence">
            <label class="bg-primary text-on-primary w-10 h-10 sm:w-auto sm:px-6 sm:py-2.5 rounded-full font-label-md text-label-md font-bold flex items-center justify-center sm:justify-start gap-2 shadow-sm hover:opacity-90 active:scale-95 transition-all cursor-pointer">
                <span class="material-symbols-outlined" data-icon="upload">upload</span>
                <span class="hidden sm:inline">Upload Contract</span>
                <input type="file" name="document" class="hidden" onchange="submitHeaderUploadForm(this)">
            </label>
        </form>
    </div>
</header>