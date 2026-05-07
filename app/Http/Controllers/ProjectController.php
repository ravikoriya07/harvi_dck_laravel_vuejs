<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (Project $project) => [
                'title'    => $project->title,
                'category' => $project->category,
                'href'     => $project->detail_href,
                'image'    => $project->image_url,
            ]);

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }

    public function show(string $slug): Response
    {
        $project = Project::query()
            ->where('slug', $slug)
            ->with('galleryImages')
            ->firstOrFail();

        // Build ordered ID list to find prev/next
        $orderedIds = Project::orderBy('sort_order')->orderBy('id')->pluck('id')->toArray();
        $currentIndex = array_search($project->id, $orderedIds);

        $prevId = ($currentIndex > 0) ? $orderedIds[$currentIndex - 1] : null;
        $nextId = ($currentIndex < count($orderedIds) - 1) ? $orderedIds[$currentIndex + 1] : null;

        $prevProject = $prevId ? Project::find($prevId) : null;
        $nextProject = $nextId ? Project::find($nextId) : null;

        return Inertia::render('ProjectDetail', [
            'project' => [
                'title'       => $project->title,
                'slug'        => $project->slug,
                'category'    => $project->category,
                'image'       => $project->image_url,
                'value'       => $project->value,
                'date'        => $project->date,
                'status'      => $project->status,
                'client'      => $project->client,
                'scope'       => $project->scope,
                'description' => $project->description,
                'gallery'     => $project->gallery_urls,
            ],
            'prevProject' => $prevProject ? [
                'title' => $prevProject->title,
                'href'  => $prevProject->detail_href,
            ] : null,
            'nextProject' => $nextProject ? [
                'title' => $nextProject->title,
                'href'  => $nextProject->detail_href,
            ] : null,
        ]);
    }
}
