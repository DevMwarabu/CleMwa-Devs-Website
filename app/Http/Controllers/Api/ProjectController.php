<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Paginated list with server-side search and filtering.
     */
    public function index(Request $request)
    {
        $query = Project::query();

        // Full-text search
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        // Project type filter
        if ($type = $request->query('type')) {
            $query->where('project_type', $type);
        }

        // Featured filter
        if ($request->query('featured') === 'true') {
            $query->where('is_featured', true);
        }

        $projects = $query->select(
            'id', 'title', 'slug', 'client_name', 'industry',
            'project_type', 'status', 'is_featured', 'image_url',
            'tags', 'technologies', 'completion_date', 'live_url', 'created_at'
        )
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString();

        return response()->json($projects);
    }

    /**
     * Store a new project.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'slug'                  => 'nullable|string|unique:projects,slug|max:255',
            'subtitle'              => 'nullable|string|max:255',
            'short_description'     => 'nullable|string',
            'description'           => 'nullable|string',
            'content'               => 'nullable|string',
            'challenge'             => 'nullable|string',
            'solution'              => 'nullable|string',
            'results'               => 'nullable|string',
            'client_name'           => 'nullable|string|max:255',
            'client_logo_url'       => 'nullable|url|max:500',
            'industry'              => 'nullable|string|max:255',
            'project_type'          => 'nullable|string|max:100',
            'image_url'             => 'nullable|string|max:500',
            'gallery'               => 'nullable|array',
            'tags'                  => 'nullable|array',
            'technologies'          => 'nullable|array',
            'features_delivered'    => 'nullable|array',
            'stats'                 => 'nullable|array',
            'requires_quote'        => 'boolean',
            'color_theme'           => 'nullable|string|max:50',
            'delay'                 => 'nullable|integer',
            'status'                => 'nullable|string|max:50',
            'is_featured'           => 'boolean',
            'completion_year'       => 'nullable|string|max:10',
            'completion_date'       => 'nullable|date',
            'live_url'              => 'nullable|url|max:500',
            'testimonial_name'      => 'nullable|string|max:255',
            'testimonial_role'      => 'nullable|string|max:255',
            'testimonial_company'   => 'nullable|string|max:255',
            'testimonial_quote'     => 'nullable|string',
            'testimonial_photo_url' => 'nullable|string|max:500',
            'testimonial_rating'    => 'nullable|integer|min:1|max:5',
            'seo_title'             => 'nullable|string|max:255',
            'seo_description'       => 'nullable|string',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    /**
     * Get a single project.
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update an existing project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'slug'                  => "nullable|string|unique:projects,slug,{$project->id}|max:255",
            'subtitle'              => 'nullable|string|max:255',
            'short_description'     => 'nullable|string',
            'description'           => 'nullable|string',
            'content'               => 'nullable|string',
            'challenge'             => 'nullable|string',
            'solution'              => 'nullable|string',
            'results'               => 'nullable|string',
            'client_name'           => 'nullable|string|max:255',
            'client_logo_url'       => 'nullable|string|max:500',
            'industry'              => 'nullable|string|max:255',
            'project_type'          => 'nullable|string|max:100',
            'image_url'             => 'nullable|string|max:500',
            'gallery'               => 'nullable|array',
            'tags'                  => 'nullable|array',
            'technologies'          => 'nullable|array',
            'features_delivered'    => 'nullable|array',
            'stats'                 => 'nullable|array',
            'requires_quote'        => 'boolean',
            'color_theme'           => 'nullable|string|max:50',
            'delay'                 => 'nullable|integer',
            'status'                => 'nullable|string|max:50',
            'is_featured'           => 'boolean',
            'completion_year'       => 'nullable|string|max:10',
            'completion_date'       => 'nullable|date',
            'live_url'              => 'nullable|string|max:500',
            'testimonial_name'      => 'nullable|string|max:255',
            'testimonial_role'      => 'nullable|string|max:255',
            'testimonial_company'   => 'nullable|string|max:255',
            'testimonial_quote'     => 'nullable|string',
            'testimonial_photo_url' => 'nullable|string|max:500',
            'testimonial_rating'    => 'nullable|integer|min:1|max:5',
            'seo_title'             => 'nullable|string|max:255',
            'seo_description'       => 'nullable|string',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    /**
     * Delete a project.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully.'], 200);
    }
}
