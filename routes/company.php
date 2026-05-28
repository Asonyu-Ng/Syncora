<?php

use App\Livewire\Company\ActiveInterns;
use App\Livewire\Company\ApplicantsManagement;
use App\Livewire\Company\Dashboard;
use App\Livewire\Company\InternEvaluation;
use App\Livewire\Company\InternshipManagement;
use App\Livewire\Company\PostInternship;
use App\Livewire\Company\Profile;
use App\Livewire\Company\Reports;
use App\Livewire\Company\Settings;
use App\Livewire\Company\TaskAssignment;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:company'])
    ->prefix('company')
    ->name('company.')
    ->group(function (): void {
        Route::redirect('/', '/company/dashboard')->name('home');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::get('/internships', InternshipManagement::class)->name('internships.index');
        Route::get('/internships/create', PostInternship::class)->name('internships.create');

        Route::get('/applicants', ApplicantsManagement::class)->name('applicants.index');
        Route::get('/interns', ActiveInterns::class)->name('interns.index');

        Route::get('/tasks', TaskAssignment::class)->name('tasks.index');
        Route::get('/evaluations', InternEvaluation::class)->name('evaluations.index');
        Route::get('/reports', Reports::class)->name('reports.index');

        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/settings', Settings::class)->name('settings');
    });

