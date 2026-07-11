<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * عرض صفحة الإعدادات الرئيسية للمستخدم.
     */
    public function index()
    {
        // جلب بيانات المستخدم الحالي المسجل دخوله
        $user = Auth::user();

        // استدعاء ملف settings.blade.php مباشرة من مجلد views
        return view('settings', compact('user'));
    }

    /**
     * حفظ وتحديث إعدادات وتفضيلات المستخدم.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // التحقق من صحة البيانات القادمة من الـ Form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // يمكنك إضافة شروط التحقق لباقي المدخلات هنا (مثل السلايدر أو الـ Checkboxes)
        ]);

        // تحديث البيانات الأساسية
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // اختياري: إذا أردت حفظ تفضيلات الـ AI أو الـ Checkboxes في أعمدة مخصصة بجدول المستخدمين
        // $user->update([
        //     'ai_sensitivity' => $request->input('ai_sensitivity'),
        //     'auto_extraction' => $request->has('auto_extraction'),
        // ]);

        // إعادة التوجيه إلى صفحة الإعدادات مع رسالة نجاح خفيفة
        return redirect()->route('settings.index')->with('success', 'Preferences updated successfully.');
    }
}