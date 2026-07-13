<header class="sticky top-0 z-40 w-full bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-margin-page">
    <div class="flex items-center gap-4 flex-1">
        <div class="relative w-full max-w-md" x-data="headerSearch()" @click.outside="open = false">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg" data-icon="search">search</span>

            <input
                class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-body-md focus:ring-1 focus:ring-primary"
                placeholder="Search contracts, clauses, or vendors..."
                type="text"
                x-model="query"
                @input.debounce.350ms="search()"
                @focus="if (results) open = true"
            />

            <!-- Loading spinner صغير -->
            <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
                <span class="material-symbols-outlined animate-spin text-on-surface-variant text-lg">progress_activity</span>
            </div>

            <!-- Dropdown النتائج -->
            <div
                x-show="open"
                x-transition
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
                                <span class="text-body-md" x-text="doc.title"></span>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button class="flex items-center gap-2 p-2 text-on-surface-variant hover:text-primary transition-colors relative">
            <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface"></span>
        </button>
        <button class="flex items-center gap-2 p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined" data-icon="help">help</span>
        </button>
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="header-upload-form" class="inline-block">
            @csrf
            <input type="hidden" name="redirect_to" value="intelligence">
            <label class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-md text-label-md font-bold flex items-center gap-2 shadow-sm hover:opacity-90 active:scale-95 transition-all cursor-pointer">
                <span class="material-symbols-outlined" data-icon="upload">upload</span>
                Upload Contract
                <input type="file" name="document" class="hidden" onchange="submitHeaderUploadForm(this)">
            </label>
        </form>
    </div>
</header>

<script>
    function submitHeaderUploadForm(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById('header-upload-form').submit();
        }
    }

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
                    const res = await fetch(`{{ route('search.live') }}?q=${encodeURIComponent(this.query)}`, {
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