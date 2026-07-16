@php
    $clauses = $analysis->clauses_analysis ?? [];

    // Separate "Critical issues" from regular clauses once
    $criticalEntry = collect($clauses)->first(fn($c) => ($c['clause'] ?? '') === 'Critical issues');
    $regularClauses = collect($clauses)->reject(fn($c) => ($c['clause'] ?? '') === 'Critical issues')->values();
    $criticalIssuesList = $criticalEntry
        ? array_values(array_filter(array_map('trim', explode('|', $criticalEntry['analysis'] ?? ''))))
        : [];

    $riskScoreValue = $analysis->risk_score ?? 0;
    if ($riskScoreValue > 70) {
        $verdictColor = '#DC2626';
        $verdictSoft = '#FEE2E2';
        $statusText = 'High Risk';
    } elseif ($riskScoreValue > 40) {
        $verdictColor = '#D97706';
        $verdictSoft = '#FEF3C7';
        $statusText = 'Medium Risk';
    } else {
        $verdictColor = '#059669';
        $verdictSoft = '#D1FAE5';
        $statusText = 'Low Risk';
    }

    // Fallback data
    $missingClauses = $analysis->missing_clauses ?? [
        [
            'clause' => 'Governing Law & Jurisdiction',
            'risk' => 'High',
            'reason' => 'Missing explicit jurisdiction leaves company vulnerable to cross-border litigation costs.',
        ],
        [
            'clause' => 'Data Protection Addendum (DPA)',
            'risk' => 'Medium',
            'reason' => 'Required for GDPR/CCPA compliance since the contract involves user data transfer.',
        ],
    ];

    $obligations = $analysis->obligations ?? [
        [
            'due_date' => 'Within 14 days',
            'type' => 'Financial',
            'desc' => 'Initial setup fee payment activation deadline.',
        ],
        [
            'due_date' => 'End of Q3 2026',
            'type' => 'Compliance',
            'desc' => 'Submit compliance report regarding data encryption frameworks.',
        ],
    ];

    // Dummy dynamic list for last 5 contracts if not passed from controller
    $recentDocuments = $recentDocuments ?? collect([]);

    $riskDistribution = $analysis->risk_distribution ?? [
        'Legal' => 0,
        'Financial' => 0,
        'Privacy' => 0,
        'Compliance' => 0,
    ];

    $riskColorPalette = ['#F87171', '#FBBF24', '#34D399', '#818CF8', '#38BDF8', '#F472B6'];

    // Normalize/Decode distribution into a safe array for the view
    $finalDistribution = is_string($riskDistribution) ? json_decode($riskDistribution, true) : $riskDistribution;
    if (empty($finalDistribution)) {
        $finalDistribution = [
            'Legal' => 0,
            'Financial' => 0,
            'Privacy' => 0,
            'Compliance' => 0,
        ];
    }
@endphp

@extends('layouts.app')

@section('title', isset($document) && $document ? $document->original_name . ' | Contract Intelligence Hub' : 'Contract
    Intelligence Hub')

@section('content')
    <div class="w-full antialiased text-[#0F172A] -mt-4 font-sans selection:bg-indigo-100" x-data="{ currentTab: 'ledger' }">

        @if (!$document)
            @include('intelligence.partials.upload-state', [
                'recentDocuments' => $recentDocuments,
            ])
        @elseif($document->status === 'failed')
            @include('intelligence.partials.failed-state', [
                'document' => $document,
            ])
        @elseif($document->status !== 'done')
            @include('intelligence.partials.processing-state', [
                'document' => $document,
            ])
            @include('intelligence.partials.status-poller', [
                'document' => $document,
            ])
        @else
            @include('intelligence.partials.dossier', [
                'document' => $document,
                'analysis' => $analysis,
                'riskScoreValue' => $riskScoreValue,
                'verdictColor' => $verdictColor,
                'verdictSoft' => $verdictSoft,
                'statusText' => $statusText,
                'finalDistribution' => $finalDistribution,
                'riskColorPalette' => $riskColorPalette,
                'regularClauses' => $regularClauses,
                'criticalIssuesList' => $criticalIssuesList,
                'missingClauses' => $missingClauses,
                'obligations' => $obligations,
            ])
        @endif
    </div>

    <script>
        function submitUploadForm(input) {
            if (input.files && input.files.length > 0) {
                document.getElementById('intelligence-upload-form').submit();
            }
        }
    </script>

@endsection
