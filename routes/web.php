<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Applications (Job Postings Only)
    Route::get('/dashboard/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/dashboard/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/dashboard/applications', [ApplicationController::class, 'store'])->name('applications.store');

    // 2. Match Reports (AI Analysis Only)
    Route::get('/dashboard/matches', [MatchReportController::class, 'index'])->name('matches.index');
    Route::get('/dashboard/matches/create', [MatchReportController::class, 'create'])->name('matches.create');
    Route::post('/dashboard/matches', [MatchReportController::class, 'store'])->name('matches.store');
    Route::get('/dashboard/matches/{matchReport}', [MatchReportController::class, 'show'])->name('matches.show');

    // 3. Resumes
    Route::get('/dashboard/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/dashboard/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    Route::get('/dashboard/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
    Route::delete('/dashboard/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';