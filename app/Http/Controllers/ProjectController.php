<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Technology;
use App\Support\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['technologies', 'media'])->published()->ordered();

        if ($techSlug = $request->string('tech')->toString()) {
            $query->whereHas('technologies', fn ($q) => $q->where('slug', $techSlug));
        }

        return view(ThemeManager::view('projects-index'), [
            'projects' => $query->get(),
            'technologies' => Technology::orderBy('display_order')->get(),
            'activeTech' => $techSlug ?? null,
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $project->loadMissing(['technologies', 'tags', 'media']);

        $project->increment('view_count');

        $related = Project::with(['technologies', 'media'])
            ->published()
            ->where('id', '!=', $project->id)
            ->whereHas('technologies', fn ($q) =>
                $q->whereIn('technologies.id', $project->technologies->pluck('id'))
            )
            ->limit(3)
            ->get();

        return view(ThemeManager::view('project-show'), [
            'project' => $project,
            'related' => $related,
        ]);
    }
}
