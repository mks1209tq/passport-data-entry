<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\TIPLController::class, 'create'])->name('welcome');

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

// Public TIPL routes (create only - no login required)
Route::get('/tipl/register', [App\Http\Controllers\TIPLController::class, 'create'])->name('tipl.create');
Route::post('/tipl/register', [App\Http\Controllers\TIPLController::class, 'store'])->name('tipl.store');

// Admin TIPL routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/tipl', [App\Http\Controllers\TIPLController::class, 'index'])->name('tipl.index');
    Route::get('/tipl/{tipl}', [App\Http\Controllers\TIPLController::class, 'show'])->name('tipl.show');
    Route::get('/tipl/{tipl}/edit', [App\Http\Controllers\TIPLController::class, 'edit'])->name('tipl.edit');
    Route::put('/tipl/{tipl}', [App\Http\Controllers\TIPLController::class, 'update'])->name('tipl.update');
    Route::delete('/tipl/{tipl}', [App\Http\Controllers\TIPLController::class, 'destroy'])->name('tipl.destroy');
});

require __DIR__.'/auth.php';
