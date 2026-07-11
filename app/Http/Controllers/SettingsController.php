<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $files = $user->documents()->latest()->get(); 

    // تمرير الملفات إلى صفحة الـ Blade
    return view('settings', compact('files'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        // 1. التحقق من صحة البيانات المرسلة (Validation)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'max:2048'], // ماكس 2 ميجا بايت
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // 2. معالجة وتحديث الصورة الشخصية (Avatar)
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // حفظ الصورة الجديدة
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. معالجة تحديث كلمة المرور (في حال قام بتعبئتها)
        if ($request->filled('new_password')) {
            // التحقق من صحة كلمة السر الحالية
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        // 4. تحديث البيانات العامة الأساسية
        $user->name = $request->name;
        $user->email = $request->email;
        
        // هنا يمكنك حفظ متغيرات الـ AI داخل الـ Database إذا كان لديك حقول لها
        // $user->ai_severity = $request->ai_severity;
        
        $user->save();

        return back()->with('success', 'تم تحديث كافة الإعدادات والملف الشخصي بنجاح!');
    }

    /**
     * حذف الحساب نهائياً
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        // حذف صورة الحساب من السيرفر قبل الحذف النهائي
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // تسجيل خروج المستخدم وحذف السجل
        auth()->logout();
        $user->delete();

        // إلغاء الجلسة الحالية
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'تم حذف حسابك وكافة البيانات المرتبطة به بنجاح.');
    }
}