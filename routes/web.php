<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectToRoleDashboard;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return app(RedirectToRoleDashboard::class)->handle(request(), fn () => redirect()->to('/__dashboards'));
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/__dashboards', 'dashboards')->name('dashboards.index');

    Route::get('/profile', function () {
        $role = auth()->user()?->role;

        return match ($role) {
            'student' => redirect()->route('student.profile'),
            'supervisor' => redirect()->route('supervisor.profile'),
            'company' => redirect()->route('company.profile'),
            default => redirect()->route('profile.edit'),
        };
    });

    Route::get('/account', function (Request $request) {
        if ($request->user()?->role === 'student') {
            return redirect()->route('student.profile');
        }

        return app(ProfileController::class)->edit($request);
    })->name('profile.edit');

    Route::patch('/account', function (ProfileUpdateRequest $request) {
        if ($request->user()?->role === 'student') {
            abort(403);
        }

        return app(ProfileController::class)->update($request);
    })->name('profile.update');

    Route::delete('/account', function (Request $request) {
        if ($request->user()?->role === 'student') {
            abort(403);
        }

        return app(ProfileController::class)->destroy($request);
    })->name('profile.destroy');
});

require __DIR__.'/student.php';

require __DIR__.'/admin.php';

require __DIR__.'/supervisor.php';

require __DIR__.'/company.php';

require __DIR__.'/auth.php';
