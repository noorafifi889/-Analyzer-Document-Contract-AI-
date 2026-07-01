<?php

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



Route::middleware(['auth'])->group(function () {
    // رابط لعرض صفحة الرفع
    Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
    
    // رابط معالجة رفع الملف وحفظه
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.store');
});