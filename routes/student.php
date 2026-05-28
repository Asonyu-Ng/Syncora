<?php

use App\Livewire\Student\AiReportGenerator;
use App\Livewire\Student\Applications;
use App\Livewire\Student\Dashboard;
use App\Livewire\Student\InternshipDetails;
use App\Livewire\Student\InternshipSearch;
use App\Livewire\Student\LogbookSubmission;
use App\Livewire\Student\Profile;
use App\Livewire\Student\Settings;
use App\Livewire\Student\TaskBoard;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function (): void {
        Route::redirect('/', '/student/dashboard')->name('home');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::get('/internships', InternshipSearch::class)->name('internships.search');
        Route::get('/internships/{internship}', InternshipDetails::class)->name('internships.show');

        Route::get('/applications', Applications::class)->name('applications.index');
        Route::get('/tasks', TaskBoard::class)->name('tasks.board');
        Route::get('/logbook', LogbookSubmission::class)->name('logbook.index');
        Route::get('/ai-reports', AiReportGenerator::class)->name('reports.ai');

        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/settings', Settings::class)->name('settings');
    });
