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
Route::get('/history', [DocumentController::class, 'history'])->name('documents.history');

Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
Route::middleware('auth')->group(function () {
    
    // الرواتس الإضافية الخاصة بك (ضعها قبل الـ show لتجنب أي تضارب في قراءة الـ URL)
    Route::get('/documents/{document}/analyzing', [DocumentController::class, 'analyzing'])->name('documents.analyzing');
    Route::get('/documents/{document}/status', [DocumentController::class, 'status'])->name('documents.status');

    // الـ Resource الكامل أصبح الآن محمياً بالـ auth ومسؤول عن (index, create, store, show, edit, update, destroy)
    Route::resource('documents', DocumentController::class);
    
});