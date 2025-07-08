<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyPassportController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\IssuePassportController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ApplicantController;

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

require __DIR__.'/auth.php';


Route::resource('passports', PassportController::class);



Route::get('applicants/send', [ApplicantController::class, 'showSend'])->name('applicants.show-send');
Route::post('applicants/send', [ApplicantController::class, 'send'])->name('applicants.send');

Route::resource('applicants', ApplicantController::class);

Route::resource('verify-passports', VerifyPassportController::class);

Route::resource('issue-passports', IssuePassportController::class);


Route::get('/ppdashboard', function () {
    return view('passport.dashboard');
})->middleware(['auth', 'verified'])->name('ppdashboard');

Route::get('/leaveApplication', function () {
    return view('leaveApplication.index');
})->middleware(['auth', 'verified'])->name('leaveApplication');




Route::resource('applicants', App\Http\Controllers\ApplicantController::class);
