<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/adminpanel', [AdminPanelController::class, 'index'])->name('adminpanel.index');
    Route::POST('/assign-passports', [AdminPanelController::class, 'assignPassports'])->name('assign-passports');
    Route::POST('/assign-users', [AdminPanelController::class, 'assignUsers'])->name('assign-users');
    Route::POST('/assign-verifiers', [AdminPanelController::class, 'assignVerifiers'])->name('assign-verifiers');
    Route::POST('/set-admin', [AdminPanelController::class, 'setAdmin'])->name('set-admin');
    Route::POST('/set-verifier', [AdminPanelController::class, 'setVerifier'])->name('set-verifier');
    Route::POST('/remove-verifier-assignments', [AdminPanelController::class, 'removeVerifierAssignments'])->name('remove-verifier-assignments');
    Route::POST('/remove-passport-assignments', [AdminPanelController::class, 'removePassportAssignments'])->name('remove-passport-assignments');
});


Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
require __DIR__.'/leaveRequest.php';
require __DIR__.'/passport.php';


