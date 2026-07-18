<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Service;
use App\Models\Post;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $q = $request->query('q');

        if (empty($q) || strlen($q) < 2) {
            return response()->json([
                'leads' => [],
                'projects' => [],
                'services' => [],
                'posts' => [],
            ]);
        }

        // Leads: search name, email, subject
        $leads = Lead::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->orWhere('subject', 'like', "%{$q}%")
            ->select('id', 'name', 'email')
            ->take(5)
            ->get();

        // Projects: search title
        $projects = Project::where('title', 'like', "%{$q}%")
            ->select('id', 'title')
            ->take(5)
            ->get();

        // Services: search name
        $services = Service::where('name', 'like', "%{$q}%")
            ->select('id', 'name')
            ->take(5)
            ->get();

        // Posts: search title
        $posts = Post::where('title', 'like', "%{$q}%")
            ->select('id', 'title')
            ->take(5)
            ->get();

        return response()->json([
            'leads' => $leads,
            'projects' => $projects,
            'services' => $services,
            'posts' => $posts,
        ]);
    }
}
