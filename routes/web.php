<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\GuestController::class, 'search'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/guests/autocomplete', [App\Http\Controllers\GuestController::class, 'autocomplete'])->name('guests.autocomplete');
    Route::post('/guests/{guest}/mark-present', [App\Http\Controllers\GuestController::class, 'markPresent'])->name('guests.mark-present');
    Route::get('/guests/export', [App\Http\Controllers\GuestController::class, 'export'])->name('guests.export');
    Route::get('/guests/report', [App\Http\Controllers\GuestController::class, 'report'])->name('guests.report');
});

Route::resource('guests', App\Http\Controllers\GuestController::class);

require __DIR__.'/auth.php';
