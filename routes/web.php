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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Applications (Job Postings Only)
    Route::get('/dashboard/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/dashboard/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/dashboard/applications', [ApplicationController::class, 'store'])
        ->name('applications.store')
        ->middleware('throttle:10,1');

    Route::get('/dashboard/applications/{jobPosting}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/dashboard/applications/{jobPosting}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::put('/dashboard/applications/{jobPosting}', [ApplicationController::class, 'update'])
        ->name('applications.update')
        ->middleware('throttle:10,1');

    Route::delete('/dashboard/applications/{jobPosting}', [ApplicationController::class, 'destroy'])
        ->name('applications.destroy')
        ->middleware('throttle:10,1');

    // 2. Match Reports (AI Analysis Only)
    Route::get('/dashboard/matches', [MatchReportController::class, 'index'])->name('matches.index');
    Route::get('/dashboard/matches/create', [MatchReportController::class, 'create'])->name('matches.create');
    Route::post('/dashboard/matches', [MatchReportController::class, 'store'])
        ->name('matches.store')
        ->middleware('throttle:10,1');
    Route::get('/dashboard/matches/{matchReport}', [MatchReportController::class, 'show'])->name('matches.show');

    Route::patch('/dashboard/matches/{matchReport}/status', [MatchReportController::class, 'updateStatus'])
        ->name('matches.updateStatus')
        ->middleware('throttle:10,1');
    Route::delete('/dashboard/matches/{matchReport}', [MatchReportController::class, 'destroy'])
        ->name('matches.destroy')
        ->middleware('throttle:10,1');

    // 3. Resumes
    Route::get('/dashboard/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/dashboard/resumes', [ResumeController::class, 'store'])
        ->name('resumes.store')
        ->middleware('throttle:10,1');
    Route::get('/dashboard/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
    Route::delete('/dashboard/resumes/{resume}', [ResumeController::class, 'destroy'])
        ->name('resumes.destroy')
        ->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';