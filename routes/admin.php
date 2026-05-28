<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\ActivityLogs;
use App\Livewire\Admin\AnalyticsDashboard;
use App\Livewire\Admin\CompaniesManagement;
use App\Livewire\Admin\InternshipsMonitoring;
use App\Livewire\Admin\NotificationsManagement;
use App\Livewire\Admin\ReportsManagement;
use App\Livewire\Admin\SystemSettings;
use App\Livewire\Admin\UniversitiesManagement;
use App\Livewire\Admin\UsersManagement;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::redirect('/', '/admin/dashboard')->name('home');

        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::get('/users', UsersManagement::class)->name('users.index');
        Route::get('/universities', UniversitiesManagement::class)->name('universities.index');
        Route::get('/companies', CompaniesManagement::class)->name('companies.index');
        Route::get('/internships', InternshipsMonitoring::class)->name('internships.index');
        Route::get('/analytics', AnalyticsDashboard::class)->name('analytics.index');
        Route::get('/reports', ReportsManagement::class)->name('reports.index');
        Route::get('/notifications', NotificationsManagement::class)->name('notifications.index');
        Route::get('/settings', SystemSettings::class)->name('settings');
        Route::get('/activity-logs', ActivityLogs::class)->name('activity-logs.index');
    });
