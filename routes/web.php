<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectToRoleDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return app(RedirectToRoleDashboard::class)->handle(request(), fn () => redirect()->to('/__dashboards'));
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('/__dashboards', 'dashboards')->name('dashboards.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/student.php';

require __DIR__.'/admin.php';

require __DIR__.'/supervisor.php';

require __DIR__.'/company.php';

require __DIR__.'/auth.php';
