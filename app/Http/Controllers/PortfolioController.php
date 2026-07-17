<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\PortfolioSetting;
use App\Models\Technology;
use App\Models\Faq;

class PortfolioController extends Controller
{
    public function index()
    {
        $settings = PortfolioSetting::first();
        $projects = Project::orderBy('delay')->get();
        $featuredProjects = Project::where('is_featured', true)->orderBy('delay')->get();
        $technologies = Technology::orderBy('delay')->get()->unique('name');
        
        // Extract unique industries and project types from projects
        $industries = $projects->pluck('industry')->filter()->unique()->values();
        $categories = $projects->pluck('project_type')->filter()->unique()->values();
        $faqs = Faq::orderBy('order_column')->get();

        return view('portfolio', compact(
            'settings',
            'projects',
            'featuredProjects',
            'technologies',
            'industries',
            'categories',
            'faqs'
        ));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        
        $relatedProjects = Project::where('project_type', $project->project_type)
            ->where('id', '!=', $project->id)
            ->limit(3)
            ->get();

        return view('project-details', compact('project', 'relatedProjects'));
    }
}

