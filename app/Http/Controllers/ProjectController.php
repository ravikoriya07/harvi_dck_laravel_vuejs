<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $projects = Project::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (Project $project) => [
                'title' => $project->title,
                'category' => $project->category,
                'href' => $project->detail_href,
                'image' => $project->image_url,
            ]);

        return Inertia::render('Projects', [
            'projects' => $projects,
        ]);
    }
}
