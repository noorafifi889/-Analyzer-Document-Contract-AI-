<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ContractIntelligenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Models\Document;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// === جميع رواتس المستندات محمية وهيكلها مرتب وبدون أي تكرار ===
Route::middleware('auth')->group(function () {
    
    // 1. روت التاريخ (History)
    Route::get('/documents/history', [DocumentController::class, 'history'])->name('documents.history');

    // 2. رواتس الانتظار والحالة الفنية (يجب أن تكون قبل الـ Resource حتى لا يعتبرها الـ Resource جزءاً من الـ ID)
    // Route::get('/documents/{document}/analyzing', [DocumentController::class, 'analyzing'])->name('documents.analyzing');
    Route::get('/documents/{document}/status', [DocumentController::class, 'getStatus'])->name('documents.status');

    // 3. الـ Resource الكامل (يتكفل  index, create, store, show, edit, update, destroy) تلقائياً بصيغة {document}
    Route::resource('documents', DocumentController::class);
    
});


Route::get('/intelligence/{document}/chat', [AiChatController::class, 'show'])->name('documents.chat');
Route::post('/intelligence/{document}/chat/send', [AiChatController::class, 'sendMessage'])->name('documents.chat.send');


Route::get('/documents/{document}/export-pdf', [DocumentController::class, 'exportPdf'])->name('documents.export-pdf');


Route::get('/intelligence', [ContractIntelligenceController::class, 'index'])
    ->name('intelligence.index');

// مسار عرض تحليل ملف معين بعد الرفع أو الاختيار
Route::get('/intelligence/{document}', [ContractIntelligenceController::class, 'show'])
    ->name('intelligence.show');



    Route::prefix('settings')->name('settings.')->middleware(['auth'])->group(function () {
    
    // الصفحة الرئيسية للإعدادات (عرض الملف الشخصي)
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    
    // مسارات إضافية إذا قررت مستقبلاً فصل التبويبات إلى صفحات منفصلة أو طلبات Ajax
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::get('/ai-preferences', [SettingsController::class, 'aiPreferences'])->name('ai');
    Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
    
    // مسار حفظ التعديلات (طلب POST عند الضغط على Save Preferences)
    Route::post('/update', [SettingsController::class, 'update'])->name('update');
});
Route::middleware(['auth'])->group(function () {
    Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/delete', [SettingsController::class, 'destroy'])->name('settings.destroy');
});