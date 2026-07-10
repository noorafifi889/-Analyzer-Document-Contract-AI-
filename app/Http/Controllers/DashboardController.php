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
        // جلب معرف المستخدم الحالي (إذا كنتِ تطبقين نظام المستخدمين، أو يمكنكِ جلب الجميع مؤقتاً)
        $userId = Auth::id();

        // 1. إجمالي المستندات المرفوعة الخاصة بالمستخدم الحالي
        $totalContracts = Document::where('user_id', $userId)->count();

        $activeRisks = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('risk_score', '>=', 70) 
            ->count();

        // 3. المستندات المعالجة حالياً أو المعلقة (Pending / Processing) بناءً على حقل status في الـ Document
        $pendingRenewals = Document::where('user_id', $userId)
            ->whereIn('status', ['processing', 'pending'])
            ->count();

        // 4. جلب مصفوفة من آخر التحليلات و الـ Insights الذكية لعرضها ديناميكياً
        // سنأخذ آخر 3 تحليلات تحتوي على ملخص (summary) لـ "AI Intelligence Report"
        $latestAnalyses = Analysis::whereHas('document', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('document')
            ->latest()
            ->take(3)
            ->get();

        // 5. جلب جدول العقود الأخيرة وعرضها بالـ Table أسفل الداشبورد
        $recentDocuments = Document::where('user_id', $userId)
            ->with('analysis') // التحميل المسبق للعلاقة لتحسين الأداء
            ->latest()
            ->take(5)
            ->get();

        // تمرير المتغيرات كاملة ومتوافقة مع الـ Blade
        return view('dashboard', compact(
            'totalContracts',
            'activeRisks',
            'pendingRenewals',
            'latestAnalyses',
            'recentDocuments'
        ));
    }
}