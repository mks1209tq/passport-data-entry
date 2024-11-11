<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyPassportController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\IssuePassportController;
use App\Http\Controllers\AdminPanelController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';


Route::resource('passports', PassportController::class);



Route::resource('verify-passports', VerifyPassportController::class);

Route::resource('issue-passports', IssuePassportController::class);




Route::resource('certs', App\Http\Controllers\CertController::class);
