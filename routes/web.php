<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactCardController;
use App\Http\Controllers\Admin\JobApplicationResumeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialValueController;
use App\Http\Middleware\UseCardLayout;
use App\Models\Project;
use App\Models\TeamDepartment;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $projects = Project::query()
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get()
        ->map(fn (Project $project) => [
            'title' => $project->title,
            'href'  => $project->detail_href,
            'image' => $project->image_url,
        ]);

    return Inertia::render('Home', [
        'projects' => $projects,
        'services' => ServiceController::listingPayload(),
    ]);
});

Route::get('/about', function () {
    $teamGroups = TeamDepartment::query()
        ->orderBy('sort_order')
        ->orderBy('id')
        ->with(['members' => fn ($query) => $query->orderBy('sort_order')->orderBy('id')])
        ->get()
        ->map(fn (TeamDepartment $department) => [
            'name'    => $department->name,
            'members' => $department->members->map(fn (TeamMember $member) => [
                'name'        => $member->name,
                'position'    => $member->position,
                'image'       => $member->image_url,
                'description' => $member->description,
            ])->values(),
        ])
        ->filter(fn (array $group) => $group['members']->isNotEmpty())
        ->values();

    return Inertia::render('About', [
        'teamGroups' => $teamGroups,
    ]);
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

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
