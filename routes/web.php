<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/issues', function () {
    return view('issues');
})->middleware(['auth', 'verified'])->name('issues');

Route::get('/to_verify', function () {
    return view('to_verify');
})->middleware(['auth', 'verified'])->name('to_verify');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('passports', App\Http\Controllers\PassportController::class);
Route::get('/passports/{passport}/verify', [App\Http\Controllers\PassportController::class, 'verify'])->name('verify');
Route::post('/passports/{passport}/verify-update', [App\Http\Controllers\PassportController::class, 'verify_update'])->name('verify-update');