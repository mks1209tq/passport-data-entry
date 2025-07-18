<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyLeaveRequestController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\IssueLeaveController;
use App\Http\Controllers\LRAdminPanelController;


Route::resource('leave-requests', App\Http\Controllers\LeaveRequestController::class);


Route::middleware('auth')->group(function () {
    Route::get('/LRadminpanel', [LRAdminPanelController::class, 'index'])->name('LRadminpanel.index');
    Route::POST('/lr-set-admin', [LRAdminPanelController::class, 'setAdmin'])->name('lr-set-admin');
    Route::POST('/lr-set-verifier', [LRAdminPanelController::class, 'setVerifier'])->name('lr-set-verifier');
    Route::POST('/assign-leaves', [LRAdminPanelController::class, 'assignLeaves'])->name('assign-leaves');
    Route::POST('/lr-assign-users', [LRAdminPanelController::class, 'assignUsers'])->name('lr-assign-users');
    Route::POST('/lr-assign-verifiers', [LRAdminPanelController::class, 'assignVerifiers'])->name('lr-assign-verifiers');
    Route::POST('/remove-leaves-assignments', [LRAdminPanelController::class, 'removeLeaveAssignments'])->name('remove-leaves-assignments');
    Route::POST('/remove-verifier-assignments', [LRAdminPanelController::class, 'removeVerifierAssignments'])->name('remove-verifier-assignments');
});




Route::resource('verify-passports', VerifyPassportController::class);

Route::resource('issue-passports', IssuePassportController::class);


Route::get('/lrdashboard', function () {
    return view('leaveRequest.dashboard');
})->middleware(['auth', 'verified'])->name('lrdashboard');


Route::get('/leaveApplication', function () {
    return view('leaveApplication.index');
})->middleware(['auth', 'verified'])->name('leaveApplication');




