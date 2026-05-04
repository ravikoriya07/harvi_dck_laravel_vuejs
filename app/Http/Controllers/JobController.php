<?php

namespace App\Http\Controllers;

use App\Enums\JobCategoryStatus;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = JobCategory::where('status', JobCategoryStatus::Active)
            ->orderBy('name')
            ->get(['id', 'name']);

        $jobs = Job::with('jobCategory')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%")
                      ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('category'), fn ($q) => $q->where('job_category_id', $request->category))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Job $job) => [
                'id'          => $job->id,
                'slug'        => $job->slug,
                'href'        => $job->slug ? "/jobs/{$job->slug}" : "/jobs/{$job->id}",
                'title'       => $job->title,
                'category'    => $job->jobCategory?->name,
                'description' => $job->description,
                'posted_at'   => $job->created_at->diffForHumans(),
            ]);

        return Inertia::render('Jobs', [
            'jobs'       => $jobs,
            'categories' => $categories,
            'filters'    => $request->only(['search', 'category']),
        ]);
    }

    public function show(string $slug): Response
    {
        $job = Job::with('jobCategory')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug);
                if (is_numeric($slug)) {
                    $q->orWhere('id', (int) $slug);
                }
            })
            ->firstOrFail();

        return Inertia::render('JobDetail', [
            'job' => [
                'id'          => $job->id,
                'slug'        => $job->slug,
                'title'       => $job->title,
                'category'    => $job->jobCategory?->name,
                'description' => $job->description,
                'posted_at'   => $job->created_at->diffForHumans(),
                'posted_date' => $job->created_at->format('d M Y'),
            ],
        ]);
    }
}
