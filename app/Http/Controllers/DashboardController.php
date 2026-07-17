<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Analysis;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   
    public function index()
    {
        $userId = Auth::id();

        $totalContracts = Document::where('user_id', $userId)->count();

       
        $highRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('risk_score', '>=', 70)->count();

        $activeRisks = $highRiskCount;

        $medRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereBetween('risk_score', [40, 69])->count();

        $lowRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('risk_score', '<', 40)->count();

        $pendingRenewals = Document::where('user_id', $userId)
            ->whereIn('status', ['processing', 'pending'])
            ->count();

        $highRiskPercent = $totalContracts > 0 ? round(($highRiskCount / $totalContracts) * 100) : 0;
        $medRiskPercent = $totalContracts > 0 ? round(($medRiskCount / $totalContracts) * 100) : 0;
        $lowRiskPercent = $totalContracts > 0 ? round(($lowRiskCount / $totalContracts) * 100) : 0;

        $latestAnalyses = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('document')
            ->latest()
            ->take(3)
            ->get();

        $recentDocuments = Document::where('user_id', $userId)
            ->with('analyses') 
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalContracts',
            'activeRisks',
            'pendingRenewals',
            'highRiskCount',
            'medRiskCount',
            'lowRiskCount',
            'highRiskPercent',
            'medRiskPercent',
            'lowRiskPercent',
            'latestAnalyses',
            'recentDocuments'
        ));
    }
}