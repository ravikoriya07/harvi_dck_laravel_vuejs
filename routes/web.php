<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactCardController;
use App\Http\Controllers\Admin\JobApplicationResumeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\UseCardLayout;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/about', function () {
    return Inertia::render('About');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/services', function () {
    return Inertia::render('Services');
});

Route::get('/services/{slug}', function () {
    return Inertia::render('Services');
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

Route::get('/blog',        [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/cards/{slug}', [ContactCardController::class, 'show'])
    ->middleware(UseCardLayout::class);

Route::middleware('auth')->group(function (): void {
    Route::get('/admin/job-applications/{jobApplication}/resume', JobApplicationResumeController::class)
        ->name('admin.job-applications.resume.download');
});
