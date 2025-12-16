<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
Route::get('/', function () {
    return redirect()->route('login');
});

// PWA Manifest Route
Route::get('/manifest.webmanifest', function () {
    $path = public_path('manifest.webmanifest');
    if (!file_exists($path)) {
        abort(404);
    }
    return response(file_get_contents($path), 200)
        ->header('Content-Type', 'application/manifest+json')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('manifest');

// PWA Service Worker Route
Route::get('/sw.js', function () {
    $path = public_path('sw.js');
    if (!file_exists($path)) {
        abort(404);
    }
    return response(file_get_contents($path), 200)
        ->header('Content-Type', 'application/javascript')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('sw');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/toggle-complete', [TaskController::class, 'toggleComplete'])
        ->name('tasks.toggle-complete');
    
    // Team
    Route::resource('team', TeamController::class)
        ->parameters([
            'team' => 'teamMember',
        ]);
    
    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';