<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectToRoleDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::view('/__dashboards', 'dashboards')->name('dashboards.index');

    Route::get('/dashboard', function () {
        return app(RedirectToRoleDashboard::class)->handle(request(), function () {
            return redirect()->to('/__dashboards');
        });
    })->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'student'])->middleware('role:student')->name('student.dashboard');
    Route::get('/supervisor/dashboard', [DashboardController::class, 'supervisor'])->middleware('role:supervisor')->name('supervisor.dashboard');
    Route::get('/company/dashboard', [DashboardController::class, 'company'])->middleware('role:company')->name('company.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
