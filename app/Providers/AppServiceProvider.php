<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Evaluation;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\Report;
use App\Models\Task;
use App\Policies\ApplicationPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\InternshipPolicy;
use App\Policies\LogbookPolicy;
use App\Policies\ReportPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Internship::class, InternshipPolicy::class);
        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Logbook::class, LogbookPolicy::class);
        Gate::policy(Report::class, ReportPolicy::class);
        Gate::policy(Evaluation::class, EvaluationPolicy::class);
    }
}
