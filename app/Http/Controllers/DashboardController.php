<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Analysis;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم مع الإحصائيات الحقيقية لـ LexiGuard AI
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. إجمالي المستندات
        $totalContracts = Document::where('user_id', $userId)->count();

        // 2. المخاطر النشطة (High Risks) -> سكور >= 70
        $activeRisks = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('risk_score', '>=', 70)
            ->count();

        // 3. المستندات المعالجة حالياً أو المعلقة
        $pendingRenewals = Document::where('user_id', $userId)
            ->whereIn('status', ['processing', 'pending'])
            ->count();

        // --- حساب توزيع المخاطر الحقيقي للشارت ---
        // العقود ذات المخاطر العالية (High Risk): سكور من 70 إلى 100
        $highRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('risk_score', '>=', 70)->count();

        // العقود ذات المخاطر المتوسطة (Medium Risk): سكور من 40 إلى 69
        $medRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereBetween('risk_score', [40, 69])->count();

        // العقود ذات المخاطر المنخفضة (Low Risk): سكور أقل من 40
        $lowRiskCount = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('risk_score', '<', 40)->count();

        // حساب النِسب المئوية لتمريرها للـ Blade (لتجنب القسمة على صفر إذا كانت العقود 0)
        $highRiskPercent = $totalContracts > 0 ? round(($highRiskCount / $totalContracts) * 100) : 0;
        $medRiskPercent = $totalContracts > 0 ? round(($medRiskCount / $totalContracts) * 100) : 0;
        $lowRiskPercent = $totalContracts > 0 ? round(($lowRiskCount / $totalContracts) * 100) : 0;

        // 4. آخر التقارير للـ Insights
        $latestAnalyses = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('document')
            ->latest()
            ->take(3)
            ->get();

        // 🔥 السطر المفقود الذي كان يسبب المشكلة (جلب المستندات الأخيرة لعرضها بالجدول) 🔥
        $recentDocuments = Document::where('user_id', $userId)
            ->with('analysis')
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
            'recentDocuments' // الآن المتغير موجود ومعرّف ولن يظهر الخطأ مجدداً!
        ));
    }
}