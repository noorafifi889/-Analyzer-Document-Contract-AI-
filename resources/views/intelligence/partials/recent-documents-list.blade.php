@if ($recentDocuments->isNotEmpty())
    <div
        class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm divide-y divide-slate-100">
        @foreach ($recentDocuments as $recent)
            @include('intelligence.partials.recent-document-item', ['recent' => $recent])
        @endforeach
    </div>
@else
    <div
        class="bg-slate-50 border border-slate-200 rounded-xl p-6 text-center text-sm text-slate-400 italic">
        No recently processed documents found in this session workspace.
    </div>
@endif