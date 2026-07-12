<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\ContractIntelligenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ================= Documents =================
// كل روتس المستندات محمية بـ auth، وبدون أي تكرار.
// ملاحظة: الروتس الثابتة (history / status / export-*) لازم تكون قبل
// Route::resource حتى ما يفسّرها Laravel كـ {document} تبع show().
Route::middleware('auth')->group(function () {
    Route::get('/documents/history', [DocumentController::class, 'history'])->name('documents.history');
    Route::get('/documents/{document}/status', [DocumentController::class, 'getStatus'])->name('documents.status');
    Route::get('/documents/{document}/export-pdf', [DocumentController::class, 'exportPdf'])->name('documents.export-pdf');
    Route::get('/documents/{document}/export-word', [DocumentController::class, 'exportWord'])->name('documents.export-word');

    // بيوفر تلقائياً: documents.index / create / store / show / edit / update / destroy
    Route::resource('documents', DocumentController::class);
});

// ================= Contract Intelligence / AI Chat =================
Route::middleware('auth')->group(function () {
    Route::get('/intelligence', [ContractIntelligenceController::class, 'index'])->name('intelligence.index');
    Route::get('/intelligence/{document}', [ContractIntelligenceController::class, 'show'])->name('intelligence.show');

    Route::get('/intelligence/{document}/chat', [AiChatController::class, 'show'])->name('documents.chat');
    Route::post('/intelligence/{document}/chat/send', [AiChatController::class, 'sendMessage'])->name('documents.chat.send');
});

// ================= Settings =================
Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::get('/ai-preferences', [SettingsController::class, 'aiPreferences'])->name('ai');
    Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');

    // كان معرّف مرتين بميثودين مختلفين (POST هون وPUT برا الجروب) بنفس الاسم settings.update
    // → هيك كان سبب خطأ route:cache. خليتها PUT (أكثر توافق مع REST)،
    //   بس تأكد إن الفورم عندك فيه @method('PUT') إذا هو HTML form عادي.
    Route::put('/update', [SettingsController::class, 'update'])->name('update');
    Route::delete('/delete', [SettingsController::class, 'destroy'])->name('destroy');
});

// ================= Reports =================
Route::middleware('auth')->get('/reports', [ReportController::class, 'index'])->name('reports.index');