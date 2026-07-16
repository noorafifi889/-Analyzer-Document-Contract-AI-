<div class="flex flex-col gap-6">

    @include('intelligence.partials.dossier.header-bar', [
        'document' => $document,
        'verdictSoft' => $verdictSoft,
        'verdictColor' => $verdictColor,
        'statusText' => $statusText,
    ])

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Document Canvas --}}
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col overflow-hidden min-h-[650px] max-h-[750px]">
            @include('intelligence.partials.dossier.document-canvas', [
                'document' => $document,
            ])
        </div>

        {{-- AI Verdict & Insights Rail --}}
        <div class="lg:col-span-7 space-y-6 min-h-[650px] max-h-[750px] overflow-y-auto pr-2">
            @include('intelligence.partials.dossier.verdict-card', [
                'riskScoreValue' => $riskScoreValue,
                'verdictColor' => $verdictColor,
                'verdictSoft' => $verdictSoft,
                'statusText' => $statusText,
                'analysis' => $analysis,
                'finalDistribution' => $finalDistribution,
                'riskColorPalette' => $riskColorPalette,
            ])

            @includeWhen(filled($analysis->summary ?? null), 'intelligence.partials.dossier.insights-brief', [
                'analysis' => $analysis,
            ])

            @includeWhen(count($criticalIssuesList), 'intelligence.partials.dossier.critical-breaches', [
                'criticalIssuesList' => $criticalIssuesList,
            ])
        </div>
    </div>

    {{-- Console Tabs --}}
    @include('intelligence.partials.dossier.console', [
        'regularClauses' => $regularClauses,
        'missingClauses' => $missingClauses,
        'obligations' => $obligations,
    ])

</div>