<?php

use App\Livewire\Supervisor\Calendar;
use App\Livewire\Supervisor\Dashboard;
use App\Livewire\Supervisor\Interns;
use App\Livewire\Supervisor\InternshipMonitoring;
use App\Livewire\Supervisor\LogbookApproval;
use App\Livewire\Supervisor\Messages;
use App\Livewire\Supervisor\Profile;
use App\Livewire\Supervisor\ReportsReview;
use App\Livewire\Supervisor\Settings;
use App\Livewire\Supervisor\StudentsManagement;
use App\Livewire\Supervisor\Submissions;
use App\Livewire\Supervisor\StudentEvaluation;
use App\Livewire\Supervisor\TaskAssignment;
use App\Livewire\Supervisor\Verifications;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function (): void {
        Route::redirect('/', '/supervisor/dashboard')->name('home');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::get('/students', StudentsManagement::class)->name('students.index');
        Route::get('/tasks', TaskAssignment::class)->name('tasks.index');
        Route::get('/logbooks', LogbookApproval::class)->name('logbooks.index');
        Route::get('/evaluations', StudentEvaluation::class)->name('evaluations.index');
        Route::get('/monitoring', InternshipMonitoring::class)->name('monitoring.index');
        Route::get('/reports', ReportsReview::class)->name('reports.index');
        Route::get('/calendar', Calendar::class)->name('calendar');

        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/settings', Settings::class)->name('settings');

        Route::get('/interns', Interns::class)->name('interns.index');
        Route::get('/verifications', Verifications::class)->name('verifications.index');
        Route::get('/submissions', Submissions::class)->name('submissions.index');
        Route::get('/messages', Messages::class)->name('messages.index');
    });
