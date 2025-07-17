<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyLeaveRequestController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\IssueLeaveController;
use App\Http\Controllers\LRAdminPanelController;


Route::resource('leave-requests', App\Http\Controllers\LeaveRequestController::class);


Route::middleware('auth')->group(function () {
    Route::get('/LRadminpanel', [LRAdminPanelController::class, 'index'])->name('LRadminpanel.index');
    Route::POST('/set-admin', [LRAdminPanelController::class, 'setAdmin'])->name('set-admin');
    Route::POST('/assign-leaves', [LRAdminPanelController::class, 'assignLeaves'])->name('assign-leaves');
    Route::POST('/assign-users', [LRAdminPanelController::class, 'assignUsers'])->name('assign-users');
    Route::POST('/assign-verifiers', [LRAdminPanelController::class, 'assignVerifiers'])->name('assign-verifiers');
});




Route::resource('verify-passports', VerifyPassportController::class);

Route::resource('issue-passports', IssuePassportController::class);


Route::get('/lrdashboard', function () {
    return view('leaveRequest.dashboard');
})->middleware(['auth', 'verified'])->name('lrdashboard');


Route::get('/leaveApplication', function () {
    return view('leaveApplication.index');
})->middleware(['auth', 'verified'])->name('leaveApplication');




