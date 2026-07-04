<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/documents/{document}/analyzing', [DocumentController::class, 'analyzing'])->name('documents.analyzing');
    Route::get('/documents/{document}/status', [DocumentController::class, 'getStatus'])->name('documents.status');

    // 3. الـ Resource الكامل (يتكفل  index, create, store, show, edit, update, destroy) تلقائياً بصيغة {document}
    Route::resource('documents', DocumentController::class);
    
});


Route::get('/documents/{document}/chat', [AiChatController::class, 'show'])->name('documents.chat');
Route::post('/documents/{document}/chat/send', [AiChatController::class, 'sendMessage'])->name('documents.chat.send');