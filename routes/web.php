<?php
// routes/web.php
use App\Http\Controllers\RunRegistrationController;

// Root route - redirect to registration
Route::get('/', function () {
    return redirect('/tanseeq-run');
});

// Registration routes (public)
Route::get('/tanseeq-run', [RunRegistrationController::class, 'create']);
Route::post('/tanseeq-run', [RunRegistrationController::class, 'store']);
Route::get('/api/employee', [RunRegistrationController::class, 'getEmployee']);
Route::get('/api/check-database', [RunRegistrationController::class, 'checkDatabase']); // Diagnostic endpoint
Route::get('/api/check-deadline', [RunRegistrationController::class, 'checkDeadlineStatus']); // Check current deadline status
Route::get('/api/test-deadline', [RunRegistrationController::class, 'testDeadline']); // Test deadline at different times
Route::get('/api/check-admin-status', [RunRegistrationController::class, 'checkAdminStatus'])->middleware('admin'); // Admin status diagnostic

// Admin login and registration routes
Route::get('/admin/login', [RunRegistrationController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [RunRegistrationController::class, 'login'])->name('admin.login.post');

// Admin registration (only accessible by super admins)
Route::middleware('admin')->group(function () {
    Route::get('/admin/register', [RunRegistrationController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [RunRegistrationController::class, 'register'])->name('admin.register.post');
});

// Admin routes (protected)
Route::middleware('admin')->group(function () {
    Route::get('/tanseeq-run/list', [RunRegistrationController::class, 'index'])->name('registrations.list');
    Route::get('/tanseeq-run/export', [RunRegistrationController::class, 'export']);
    Route::get('/tanseeq-run/export-presentees', [RunRegistrationController::class, 'exportPresentees'])->name('registrations.export.presentees');
    Route::get('/tanseeq-run/edit/{id}', [RunRegistrationController::class, 'edit'])->name('registrations.edit');
    Route::put('/tanseeq-run/update/{id}', [RunRegistrationController::class, 'update'])->name('registrations.update');
    Route::get('/admin/logout', [RunRegistrationController::class, 'logout'])->name('admin.logout');
    
    // Attendance routes
    Route::get('/tanseeq-run/attendance', [RunRegistrationController::class, 'showAttendance'])->name('attendance.show');
    Route::get('/tanseeq-run/attendance/export', [RunRegistrationController::class, 'exportAttendance'])->name('attendance.export');
    Route::post('/api/search-employee', [RunRegistrationController::class, 'searchEmployee'])->name('attendance.search');
    Route::post('/api/mark-attendance', [RunRegistrationController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/tanseeq-run/attendance/reset', [RunRegistrationController::class, 'resetAttendance'])->name('attendance.reset');
});
