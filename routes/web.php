<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactCardController;
use App\Http\Controllers\Admin\JobApplicationResumeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialValueController;
use App\Http\Middleware\UseCardLayout;
use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $projects = Project::query()
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->limit(12)
        ->get()
        ->map(fn (Project $project) => [
            'title' => $project->title,
            'href'  => $project->detail_href,
            'image' => $project->image_url,
        ]);

    return Inertia::render('Home', [
        'projects' => $projects,
    ]);
});

Route::get('/about', function () {
    $teamMembers = TeamMember::query()
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get()
        ->map(fn (TeamMember $member) => [
            'name'        => $member->name,
            'position'    => $member->position,
            'image'       => $member->image_url,
            'description' => $member->description,
        ]);

    return Inertia::render('About', [
        'teamMembers' => $teamMembers,
    ]);
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
Route::get('/works/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/social-values', [SocialValueController::class, 'index'])->name('social-values.index');
Route::get('/social-values/{slug}', [SocialValueController::class, 'show'])->name('social-values.show');

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
