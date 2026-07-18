<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Service;
use App\Models\Post;
use App\Models\Testimonial;
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
        $totalTestimonials = Testimonial::count();

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

        // Recent Activity
        $recentLeads = Lead::orderBy('created_at', 'desc')->take(6)->get();
        $recentProjects = Project::select('id', 'title', 'created_at')->orderBy('created_at', 'desc')->take(6)->get();
        $recentPosts = Post::select('id', 'title', 'is_published', 'created_at')->orderBy('created_at', 'desc')->take(6)->get();

        // Content Distribution for Donut Chart
        $contentDistribution = [
            ['name' => 'Projects', 'value' => $totalProjects, 'fill' => '#3b82f6'],      // Blue
            ['name' => 'Services', 'value' => $totalServices, 'fill' => '#8b5cf6'],      // Violet
            ['name' => 'Posts', 'value' => $publishedPosts, 'fill' => '#0ea5e9'],        // Sky
            ['name' => 'Testimonials', 'value' => $totalTestimonials, 'fill' => '#14b8a6'], // Teal
        ];

        return response()->json([
            'metrics' => [
                'leads_this_month' => $leadsThisMonth,
                'total_projects' => $totalProjects,
                'total_services' => $totalServices,
                'published_posts' => $publishedPosts,
                'total_testimonials' => $totalTestimonials,
            ],
            'charts' => [
                'lead_trends' => $leadTrends,
                'content_distribution' => $contentDistribution,
            ],
            'recent' => [
                'leads' => $recentLeads,
                'projects' => $recentProjects,
                'posts' => $recentPosts,
            ]
        ]);
    }
}
