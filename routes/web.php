<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome', [
        'services' => \App\Models\Service::orderBy('delay')->take(3)->get(),
        'partners' => \App\Models\Partner::all(),
        'products' => \App\Models\FlagshipProduct::all(),
        'features' => \App\Models\Feature::orderBy('delay')->get(),
        'projects' => \App\Models\Project::orderBy('delay')->take(4)->get(),
        'processSteps' => \App\Models\ProcessStep::orderBy('step_number')->get(),
        'technologies' => \App\Models\Technology::orderBy('delay')->get(),
        'statistics' => \App\Models\Statistic::orderBy('delay')->take(4)->get(),
        'testimonials' => \App\Models\Testimonial::latest()->take(3)->get(),
    ]);
});

Route::get('/quote', function () {
    return view('quote', [
        'quoteProjects' => \App\Models\Project::where('requires_quote', true)->get()
    ]);
});

Route::redirect('/request-quote', '/quote');

use App\Http\Controllers\ServicesController;

Route::get('/services', [ServicesController::class, 'index']);
Route::get('/services/{slug}', [ServicesController::class, 'show']);
use App\Http\Controllers\PortfolioController;

Route::get('/portfolio', [PortfolioController::class, 'index']);
Route::get('/projects/{slug}', [PortfolioController::class, 'show']);

use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);

use App\Http\Controllers\AboutController;

Route::get('/about', [AboutController::class, 'index']);

use App\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);

use App\Http\Controllers\CareersController;

Route::get('/careers', [CareersController::class, 'index']);
Route::get('/careers/{slug}', [CareersController::class, 'show']);

Route::get('/privacy-policy', function () {
    return view('privacy-policy', ['title' => 'Privacy Policy - CleMwa Developers']);
});

Route::get('/terms-of-service', function () {
    return view('terms-of-service', ['title' => 'Terms of Service - CleMwa Developers']);
});

Route::get('/cookie-policy', function () {
    return view('cookie-policy', ['title' => 'Cookie Policy - CleMwa Developers']);
});

Route::get('/security', function () {
    return view('security', ['title' => 'Security - CleMwa Developers']);
});

// Redirect old /admin URL → React dashboard
Route::redirect('/admin', '/dashboard', 301);

Route::get('/dashboard', function () {
    $publishedPosts = \App\Models\Post::where('is_published', true)->count();
    $pendingTestimonials = \App\Models\Testimonial::where('is_approved', false)->count();
    $totalProjects = \App\Models\Project::count();
    $totalServices = \App\Models\Service::count();

    $leadsThisMonth = \App\Models\Lead::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    $recentLeads = \App\Models\Lead::latest()->take(5)->get();

    return Inertia::render('Dashboard', [
        'stats' => [
            'published_posts' => $publishedPosts,
            'pending_testimonials' => $pendingTestimonials,
            'total_projects' => $totalProjects,
            'total_services' => $totalServices,
            'leads_this_month' => $leadsThisMonth,
        ],
        'recentLeads' => $recentLeads,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\PageController;

// Catch-all route for dynamic pages — must stay last.
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '.*');
