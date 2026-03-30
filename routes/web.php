<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MatchReportController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Applications
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [ApplicationController::class, 'store'])
            ->name('applications.store')
            ->middleware('throttle:10,1');
        Route::get('/applications/{jobPosting}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{jobPosting}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{jobPosting}', [ApplicationController::class, 'update'])
            ->name('applications.update')
            ->middleware('throttle:10,1');
        Route::delete('/applications/{jobPosting}', [ApplicationController::class, 'destroy'])
            ->name('applications.destroy')
            ->middleware('throttle:10,1');

        // Match Reports
        Route::get('/matches', [MatchReportController::class, 'index'])->name('matches.index');
        Route::get('/matches/create', [MatchReportController::class, 'create'])->name('matches.create');
        Route::post('/matches', [MatchReportController::class, 'store'])
            ->name('matches.store')
            ->middleware('throttle:10,1');
        Route::get('/matches/{matchReport}', [MatchReportController::class, 'show'])->name('matches.show');
        Route::patch('/matches/{matchReport}/status', [MatchReportController::class, 'updateStatus'])
            ->name('matches.updateStatus')
            ->middleware('throttle:10,1');
        Route::delete('/matches/{matchReport}', [MatchReportController::class, 'destroy'])
            ->name('matches.destroy')
            ->middleware('throttle:10,1');

        // Resumes
        Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
        Route::post('/resumes', [ResumeController::class, 'store'])
            ->name('resumes.store')
            ->middleware('throttle:10,1');
        Route::get('/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
        Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])
            ->name('resumes.destroy')
            ->middleware('throttle:10,1');
    });
});

require __DIR__ . '/auth.php';