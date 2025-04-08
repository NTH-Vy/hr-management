<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // User Management
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/create', [AdminController::class, 'createUser']);
    Route::post('/users', [AdminController::class, 'storeUser']);
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    
    // Position Management
    Route::get('/positions', [AdminController::class, 'positions']);
    Route::get('/positions/create', [AdminController::class, 'createPosition']);
    Route::post('/positions', [AdminController::class, 'storePosition']);
    Route::get('/positions/{id}/edit', [AdminController::class, 'editPosition']);
    Route::put('/positions/{id}', [AdminController::class, 'updatePosition']);
    Route::delete('/positions/{id}', [AdminController::class, 'deletePosition']);
    
    // Attendance Management
    Route::get('/attendances', [AdminController::class, 'attendances']);
    Route::get('/attendances/{id}/edit', [AdminController::class, 'editAttendance']);
    
    // Salary Management
    Route::get('/salaries', [AdminController::class, 'salaries']);
    Route::get('/salaries/create', [AdminController::class, 'createSalary']);
    Route::get('/salaries/{id}/edit', [AdminController::class, 'editSalary']);
    Route::post('/salaries', [AdminController::class, 'storeSalary']);
    Route::post('/salaries/{id}/pay', [AdminController::class, 'paySalary']);
    
    // Rewards & Disciplines
    Route::get('/rewards-disciplines', [AdminController::class, 'rewardsDisciplines']);
    Route::get('/rewards-disciplines/create', [AdminController::class, 'createRewardsDiscipline']);
    Route::get('/rewards-disciplines/{id}/edit', [AdminController::class, 'editRewardsDiscipline']);
    Route::post('/rewards-disciplines', [AdminController::class, 'storeRewardsDiscipline']);
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports.index');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
});

// Employee Routes
Route::prefix('employee')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard']);
    Route::post('/check-in', [EmployeeController::class, 'checkIn']);
    Route::post('/check-out', [EmployeeController::class, 'checkOut']);
    Route::get('/profile', [EmployeeController::class, 'editProfile'])->name('employee.profile');
    Route::post('/profile', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');
    Route::get('/attendance-history', [EmployeeController::class, 'attendanceHistory']);
});

// Redirect root to appropriate dashboard
Route::redirect('/', '/login');