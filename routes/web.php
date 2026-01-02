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

// Admin login routes
Route::get('/admin/login', [RunRegistrationController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [RunRegistrationController::class, 'login'])->name('admin.login.post');

// Admin routes (protected)
Route::middleware('admin')->group(function () {
    Route::get('/tanseeq-run/list', [RunRegistrationController::class, 'index'])->name('registrations.list');
    Route::get('/tanseeq-run/export', [RunRegistrationController::class, 'export']);
    Route::get('/tanseeq-run/edit/{id}', [RunRegistrationController::class, 'edit'])->name('registrations.edit');
    Route::put('/tanseeq-run/update/{id}', [RunRegistrationController::class, 'update'])->name('registrations.update');
    Route::get('/admin/logout', [RunRegistrationController::class, 'logout'])->name('admin.logout');
});

