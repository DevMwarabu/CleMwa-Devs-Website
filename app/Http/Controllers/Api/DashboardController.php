<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Service;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $leadsThisMonth = Lead::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $totalProjects = Project::count();
        $totalServices = Service::count();
        $publishedPosts = Post::where('is_published', true)->count();

        // Lead Trends (last 6 months)
        $leadTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $leadTrends[] = [
                'month' => $month->format('M'),
                'count' => Lead::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count()
            ];
        }

        // Recent Leads
        $recentLeads = Lead::orderBy('created_at', 'desc')->take(5)->get();

        return response()->json([
            'metrics' => [
                'leads_this_month' => $leadsThisMonth,
                'total_projects' => $totalProjects,
                'total_services' => $totalServices,
                'published_posts' => $publishedPosts,
            ],
            'charts' => [
                'lead_trends' => $leadTrends
            ],
            'recent_leads' => $recentLeads
        ]);
    }
}
