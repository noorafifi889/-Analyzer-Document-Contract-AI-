@extends('layouts.app')

@section('title', 'Dashboard - History')

@section('content')
    <div class="w-full max-w-container-max px-4 py-6 mx-auto">

        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-on-surface mb-2">Document History</h1>
                <p class="text-sm text-on-surface-variant max-w-2xl opacity-80">
                    Track and review all processed legal instruments. Automated risk scoring and departmental categorization
                    are applied instantly.
                </p>
            </div>
         <div class="flex items-center gap-2">
    <div class="relative min-w-[200px]">
        <select id="risk-filter" 
                class="w-full bg-surface-container-high rounded-xl pl-4 pr-10 py-2.5 appearance-none border border-outline-variant hover:bg-surface-container-low transition-colors text-sm font-medium text-on-surface-variant focus:outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer">
            
            <option value="">All Risk Levels </option>
            <option value="low" {{ request('risk') == 'low' ? 'selected' : '' }}>Low Risk </option>
            <option value="med" {{ request('risk') == 'med' ? 'selected' : '' }}>Medium Risk </option>
            <option value="high" {{ request('risk') == 'high' ? 'selected' : '' }}>High Risk </option>
            
        </select>
        <span class="material-symbols-outlined text-lg absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">
            expand_more
        </span>
    </div>
</div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant overflow-hidden shadow-sm">

            @if ($documents->isEmpty())
                <div class="text-center py-16 px-6">
                    <div
                        class="w-16 h-16 bg-surface-container-low rounded-full border border-outline-variant flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-on-surface-variant text-[32px]">history</span>
                    </div>
                    <h3 class="text-xl font-semibold text-on-surface mb-1">No history found</h3>
                    <p class="text-sm text-on-surface-variant mb-6">You haven't uploaded any documents for analysis yet.</p>
                    <a href="{{ route('documents.create') }}"
                        class="inline-flex items-center justify-center h-11 px-6 bg-primary text-on-primary rounded-xl font-medium hover:opacity-90 active:scale-[0.98] transition-all shadow-sm">
                        Analyze New Document
                    </a>
                </div>
            @else
                <div
                    class="hidden md:grid grid-cols-12 gap-4 px-6 py-3.5 bg-surface-container-low border-b border-outline-variant">
                    <div class="col-span-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">File Name
                    </div>
                    <div class="col-span-2 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Date
                    </div>
                    <div class="col-span-2 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Status
                    </div>
                    <div
                        class="col-span-2 text-xs font-semibold text-on-surface-variant uppercase tracking-wider text-center">
                        Progress / Risk</div>
                    <div
                        class="col-span-2 text-xs font-semibold text-on-surface-variant uppercase tracking-wider text-right">
                        Action</div>
                </div>

                <div class="divide-y divide-outline-variant/60">
                    @foreach ($documents as $doc)
                        @php
                            $currentAnalysis = $doc->analyses->first();
                            $riskScore = $currentAnalysis ? $currentAnalysis->risk_score : null;
                        @endphp

                        <div onclick="window.location.href='{{ $doc->status === 'done' ? route('intelligence.show', $doc) : route('intelligence.show', $doc) }}'"
                            class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 px-6 py-4 items-center hover:bg-surface-container-low/50 transition-all cursor-pointer group">

                            <div class="col-span-1 md:col-span-4 flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-xl">description</span>
                                </div>
                                <span
                                    class="text-sm font-medium text-on-surface group-hover:text-primary transition-colors truncate max-w-xs md:max-w-md">
                                    {{ $doc->original_name }}
                                </span>
                            </div>

                            <div class="col-span-1 md:col-span-2 flex items-center md:block">
                                <span class="md:hidden text-xs font-semibold text-on-surface-variant mr-2 w-16">Date:</span>
                                <span class="text-sm text-on-surface-variant">
                                    {{ $doc->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            <div class="col-span-1 md:col-span-2 flex items-center">
                                <span
                                    class="md:hidden text-xs font-semibold text-on-surface-variant mr-2 w-16">Status:</span>
                                @if ($doc->status === 'done')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 capitalize">
                                        Active
                                    </span>
                                @elseif($doc->status === 'expired')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200 capitalize">
                                        Expired
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 capitalize animate-pulse">
                                        {{ $doc->status }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-span-1 md:col-span-2 flex items-center md:justify-center">
                                <span
                                    class="md:hidden text-xs font-semibold text-on-surface-variant mr-2 w-16">Risk/Prog:</span>
                                <div class="flex items-center gap-2">

                                    @if ($riskScore !== null)
                                        @if ($riskScore <= 35)
                                            <span
                                                class="px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800"
                                                title="Risk Score: {{ $riskScore }}%">LOW RISK</span>
                                        @elseif($riskScore <= 65)
                                            <span
                                                class="px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800"
                                                title="Risk Score: {{ $riskScore }}%">MED RISK</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-rose-100 text-rose-800"
                                                title="Risk Score: {{ $riskScore }}%">HIGH RISK</span>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <span
                                                class="text-xs text-on-surface-variant font-medium">{{ $doc->progress }}%</span>
                                            <div
                                                class="w-2.5 h-2.5 rounded-full {{ $doc->progress == 100 ? 'bg-emerald-500' : 'bg-amber-500 animate-ping' }}">
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2 flex items-center justify-end"
                                onclick="event.stopPropagation();">
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف نهائياً؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors"
                                        title="Delete Document">
                                        <span class="material-symbols-outlined text-lg block">delete</span>
                                    </button>

                                </form>
                                <a href="{{ route('intelligence.show', $doc->id) }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-outline  hover:bg-primary-container/30 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div
                    class="px-6 py-4 bg-surface-container-low border-t border-outline-variant flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-sm text-on-surface-variant">
                        Showing <span class="font-medium text-on-surface">{{ $documents->firstItem() }}</span> to <span
                            class="font-medium text-on-surface">{{ $documents->lastItem() }}</span> of <span
                            class="font-medium text-on-surface">{{ $documents->total() }}</span> documents
                    </span>
                    <div class="flex items-center gap-2">
                        {{ $documents->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div
                class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant flex flex-col justify-between shadow-sm">
                <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider block mb-2">Scan
                    Accuracy</span>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-bold tracking-tight text-on-surface">99.8%</span>
                    <span class="text-xs font-medium text-emerald-600 mb-1 flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-sm font-bold">arrow_upward</span>+0.2% vs last month
                    </span>
                </div>
            </div>

            <div
                class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant flex flex-col justify-between shadow-sm">
                <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider block mb-2">Total
                    Scanned</span>
                <div class="flex items-end gap-2">
                    <span class="text-3xl font-bold tracking-tight text-on-surface">{{ $documents->total() }} Files</span>
                    <span class="text-xs text-on-surface-variant mb-1">all time</span>
                </div>
            </div>

            <div
                class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant flex flex-col justify-between shadow-sm">
                <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider block mb-3">Quick
                    Action</span>

                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data"
                    id="dashboard-upload-form" class="w-full">
                    @csrf
                    <label for="document" id="upload-label"
                        class="w-full bg-primary text-on-primary h-11 rounded-xl font-medium flex items-center justify-center gap-2 hover:opacity-95 active:scale-[0.98] transition-all shadow-sm cursor-pointer">
                        <span class="material-symbols-outlined text-xl">upload_file</span>
                        <span>Upload Document</span>
                    </label>

                    <input type="file" id="document" name="document" accept=".pdf,.docx,.txt" class="hidden">
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('risk-filter').addEventListener('change', function() {
    const selectedRisk = this.value;
    const currentUrl = new URL(window.location.href);
    
    if (selectedRisk) {
        currentUrl.searchParams.set('risk', selectedRisk);
    } else {
        currentUrl.searchParams.delete('risk');
    }
    
    currentUrl.searchParams.delete('page'); // إعادة تعيين الصفحة للأولى عند الفلترة
    window.location.href = currentUrl.toString();
});
    </script>
@endsection
