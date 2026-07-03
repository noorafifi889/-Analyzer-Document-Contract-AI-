<x-layouts.app>
    <x-slot:title>Document History - LexiGuard AI</x-slot:title>

    <div class="w-full max-w-container-max ">
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface mb-xs">Document History</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                    Track and review all processed legal instruments. Automated risk scoring and departmental categorization are applied instantly.
                </p>
            </div>
            <div class="flex items-center gap-sm">
                <div class="bg-surface-container-high rounded-lg px-md py-sm flex items-center gap-sm border border-outline-variant">
                    <span class="font-label-md text-label-md text-on-surface-variant">Filter by Department</span>
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </div>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
            
            @if($documents->isEmpty())
                <div class="text-center py-2xl px-xl">
                    <div class="w-16 h-16 bg-surface-container-low rounded-full border border-outline-variant flex items-center justify-center mx-auto mb-md">
                        <span class="material-symbols-outlined text-on-surface-variant text-[32px]">history</span>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-xs">No history found</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-lg">You haven't uploaded any documents for analysis yet.</p>
                    <a href="{{ route('documents.create') }}" class="inline-flex items-center justify-center h-10 px-lg bg-primary text-on-primary rounded-full font-semibold hover:opacity-90 transition-opacity">
                        Analyze New Document
                    </a>
                </div>
    @else
        <!-- الهيدر المضبوط بـ 12 عموداً تماماً -->
        <div class="hidden md:grid grid-cols-12 gap-lg px-lg py-md bg-surface-container-low border-b border-outline-variant">
            <div class="col-span-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">File Name</div>
            <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Date</div>
            <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Status</div>
            <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">Progress / Risk</div>
            <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">Action</div>
        </div>

        <div class="divide-y divide-outline-variant">
            @foreach($documents as $doc)
                <!-- تم ضبط الـ col-span هنا أيضاً ليناسب الهيدر -->
                <div onclick="window.location.href='{{ $doc->status === 'done' ? route('documents.show', $doc) : route('documents.analyzing', $doc) }}'" 
                     class="grid grid-cols-1 md:grid-cols-12 gap-md md:gap-lg px-lg py-md items-center hover:bg-surface-container-low transition-all cursor-pointer group">
                    
                    <!-- اسم الملف (4 أعمدة) -->
                    <div class="col-span-1 md:col-span-4 flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary group-hover:scale-105 transition-transform">description</span>
                        <span class="font-body-md text-body-md text-red font-semibold group-hover:underline truncate max-w-xs md:max-w-md">
                            {{ $doc->original_name }}
                        </span>
                    </div>

                    <!-- التاريخ (عمودين) -->
                    <div class="col-span-1 md:col-span-2 flex items-center md:block">
                        <span class="md:hidden font-label-md text-label-md text-on-surface-variant mr-2">Date:</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant">
                            {{ $doc->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <!-- الحالة (عمودين) -->
                    <div class="col-span-1 md:col-span-2 flex items-center md:block">
                        <span class="md:hidden font-label-md text-label-md text-on-surface-variant mr-2">Status:</span>
                        @if($doc->status === 'done')
                            <span class="font-label-md text-label-md px-2 py-0.5 bg-success-container/30 text-success rounded border border-success/20">Completed</span>
                        @elseif($doc->status === 'failed')
                            <span class="font-label-md text-label-md px-2 py-0.5 bg-error-container/30 text-error rounded border border-error/20">Failed</span>
                        @else
                            <span class="font-label-md text-label-md px-2 py-0.5 bg-warning-container/30 text-warning rounded border border-warning/20 animate-pulse">Processing</span>
                        @endif
                    </div>

                    <!-- التقدم (عمودين) -->
                    <div class="col-span-1 md:col-span-2 flex items-center md:justify-end">
                        <span class="font-body-sm text-body-sm text-on-surface-variant mr-3 md:hidden">Progress</span>
                        <div class="flex items-center gap-sm">
                            <span class="font-label-md text-label-md text-on-surface-variant text-xs">{{ $doc->progress }}%</span>
                            <div class="w-3 h-3 rounded-full {{ $doc->progress == 100 ? 'bg-[#10b981]' : 'bg-[#f59e0b]' }}" title="Progress: {{ $doc->progress }}%"></div>
                        </div>
                    </div>

                    <!-- عمود الأكشن الجديد (عمودين) -->
                    <div class="col-span-1 md:col-span-2 flex items-center justify-end" onclick="event.stopPropagation();">
                        <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف نهائياً؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-xs text-error hover:bg-error-container/20 px-2 py-1 rounded transition-colors text-sm font-medium">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

                <div class="px-lg py-md bg-surface-container-low border-t border-outline-variant flex items-center justify-between">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">
                        Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of {{ $documents->total() }} documents
                    </span>
                    <div class="flex items-center gap-sm">
                        {{-- استخدام روابط لارافيل الافتراضية المخصصة للتنقل --}}
                        {{ $documents->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-lg">
            <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
                <span class="font-label-md text-label-md text-on-surface-variant uppercase block mb-sm">Scan Accuracy</span>
                <div class="flex items-end gap-sm">
                    <span class="font-headline-md text-headline-md text-on-surface">99.8%</span>
                    <span class="font-body-sm text-body-sm text-[#10b981] mb-1">+0.2% vs last month</span>
                </div>
            </div>
            <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant">
                <span class="font-label-md text-label-md text-on-surface-variant uppercase block mb-sm">Total Scanned</span>
                <div class="flex items-end gap-sm">
                    <span class="font-headline-md text-headline-md text-on-surface">{{ $documents->total() }} Files</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant mb-1">all time</span>
                </div>
            </div>
<div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant flex flex-col justify-between">
    <span class="font-label-md text-label-md text-on-surface-variant uppercase block">Quick Action</span>
    
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="dashboard-upload-form" class="pt-lg flex flex-col items-center gap-md">
        @csrf

        <label for="document" id="upload-label"
            class="upload-gradient text-on-primary px-xl py-md rounded-lg font-headline-sm flex items-center gap-sm hover:opacity-90 active:scale-95 transition-all shadow-md group cursor-pointer">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                upload_file
            </span>
            <span>Upload Document</span>
        </label>

        <input
            type="file"
            id="document"
            name="document"
            accept=".pdf,.docx,.txt"
            onchange="document.getElementById('dashboard-upload-form').submit();"
            class="hidden">
    </form>
</div>
        </div>
    </div>
</x-layouts.app>