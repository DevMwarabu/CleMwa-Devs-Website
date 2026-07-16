<?php

use Illuminate\Support\Facades\Route;

use App\Models\Service;

Route::get('/', function () {
    return view('welcome', [
        'services' => \App\Models\Service::orderBy('delay')->get(),
        'partners' => \App\Models\Partner::all(),
        'products' => \App\Models\FlagshipProduct::all(),
        'features' => \App\Models\Feature::orderBy('delay')->get(),
        'projects' => \App\Models\Project::orderBy('delay')->get(),
        'processSteps' => \App\Models\ProcessStep::orderBy('step_number')->get(),
        'technologies' => \App\Models\Technology::orderBy('delay')->get(),
        'statistics' => \App\Models\Statistic::orderBy('delay')->get(),
        'testimonials' => \App\Models\Testimonial::orderBy('delay')->get(),
    ]);
});

Route::get('/quote', function () {
    return view('quote', [
        'quoteProjects' => \App\Models\Project::where('requires_quote', true)->get()
    ]);
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/services', function () { return view('services'); });
Route::get('/services/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)->firstOrFail();
    return view('service-details', compact('service'));
});
Route::get('/portfolio', function () { return view('portfolio'); });
Route::get('/projects/{id}', function ($id) {
    $project = \App\Models\Project::findOrFail($id);
    return view('project-details', compact('project'));
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy', ['title' => 'Privacy Policy - CleMwa Developers']);
});

Route::get('/terms-of-service', function () {
    return view('terms-of-service', ['title' => 'Terms of Service - CleMwa Developers']);
});

use App\Http\Controllers\PageController;

// Catch-all route for dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '.*');
