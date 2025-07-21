<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyPassportController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\IssuePassportController;
use App\Http\Controllers\AdminPanelController;






Route::middleware('auth')->group(function () {

 
    Route::get('/adminpanel', [AdminPanelController::class, 'index'])->name('adminpanel.index');
    Route::POST('/assign-passports', [AdminPanelController::class, 'assignPassports'])->name('assign-passports');
    Route::POST('/assign-users', [AdminPanelController::class, 'assignUsers'])->name('assign-users');
    Route::POST('/assign-verifiers', [AdminPanelController::class, 'assignVerifiers'])->name('assign-verifiers');
    Route::POST('/set-admin', [AdminPanelController::class, 'setAdmin'])->name('set-admin');
    Route::POST('/set-verifier', [AdminPanelController::class, 'setVerifier'])->name('set-verifier');
    Route::POST('/remove-verifier-assignments', [AdminPanelController::class, 'removeVerifierAssignments'])->name('remove-verifier-assignments');
    Route::POST('/remove-passport-assignments', [AdminPanelController::class, 'removePassportAssignments'])->name('remove-passport-assignments');
});



Route::resource('passports', PassportController::class);






Route::resource('verify-passports', VerifyPassportController::class);

Route::resource('issue-passports', IssuePassportController::class);


Route::get('/ppdashboard', function () {
    return view('passport.dashboard');
})->middleware(['auth', 'verified'])->name('ppdashboard');








