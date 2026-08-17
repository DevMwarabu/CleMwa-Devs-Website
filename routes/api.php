<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\DropdownOptionController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'stats']);
    Route::get('/search', [SearchController::class, 'global']);

    // Leads
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{lead}', [LeadController::class, 'show']);
    Route::put('/leads/{lead}', [LeadController::class, 'update']);
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);

    // Projects — full CRUD
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

    // Services — full CRUD
    Route::get('/services', [\App\Http\Controllers\Api\ServiceController::class, 'index']);
    Route::post('/services', [\App\Http\Controllers\Api\ServiceController::class, 'store']);
    Route::get('/services/{service}', [\App\Http\Controllers\Api\ServiceController::class, 'show']);
    Route::put('/services/{service}', [\App\Http\Controllers\Api\ServiceController::class, 'update']);
    Route::delete('/services/{service}', [\App\Http\Controllers\Api\ServiceController::class, 'destroy']);

    // Posts — full CRUD
    Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index']);
    Route::post('/posts', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::get('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'show']);
    Route::put('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'update']);
    Route::delete('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'destroy']);

    // Testimonials — full CRUD
    Route::get('/testimonials', [\App\Http\Controllers\Api\TestimonialController::class, 'index']);
    Route::post('/testimonials', [\App\Http\Controllers\Api\TestimonialController::class, 'store']);
    Route::get('/testimonials/{testimonial}', [\App\Http\Controllers\Api\TestimonialController::class, 'show']);
    Route::put('/testimonials/{testimonial}', [\App\Http\Controllers\Api\TestimonialController::class, 'update']);
    Route::delete('/testimonials/{testimonial}', [\App\Http\Controllers\Api\TestimonialController::class, 'destroy']);

    // Flagship Products — full CRUD
    Route::get('/products', [\App\Http\Controllers\Api\FlagshipProductController::class, 'index']);
    Route::post('/products', [\App\Http\Controllers\Api\FlagshipProductController::class, 'store']);
    Route::get('/products/{flagshipProduct}', [\App\Http\Controllers\Api\FlagshipProductController::class, 'show']);
    Route::put('/products/{flagshipProduct}', [\App\Http\Controllers\Api\FlagshipProductController::class, 'update']);
    Route::delete('/products/{flagshipProduct}', [\App\Http\Controllers\Api\FlagshipProductController::class, 'destroy']);

    // File uploads
    Route::post('/upload/image', [UploadController::class, 'image']);

    // Dropdown options (Settings-managed select lists: project type, status, color theme, ...)
    Route::get('/dropdown-options/groups', [DropdownOptionController::class, 'groups']);
    Route::post('/dropdown-options/reorder', [DropdownOptionController::class, 'reorder']);
    Route::get('/dropdown-options', [DropdownOptionController::class, 'index']);
    Route::post('/dropdown-options', [DropdownOptionController::class, 'store']);
    Route::put('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'update']);
    Route::delete('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'destroy']);

    // Page Settings (Customize Site)
    Route::get('/page-settings/{page}', [\App\Http\Controllers\Api\PageSettingsController::class, 'show']);
    Route::put('/page-settings/{page}', [\App\Http\Controllers\Api\PageSettingsController::class, 'update']);

    // Office Locations — full CRUD
    Route::get('/office-locations', [\App\Http\Controllers\Api\OfficeLocationController::class, 'index']);
    Route::post('/office-locations', [\App\Http\Controllers\Api\OfficeLocationController::class, 'store']);
    Route::get('/office-locations/{officeLocation}', [\App\Http\Controllers\Api\OfficeLocationController::class, 'show']);
    Route::put('/office-locations/{officeLocation}', [\App\Http\Controllers\Api\OfficeLocationController::class, 'update']);
    Route::delete('/office-locations/{officeLocation}', [\App\Http\Controllers\Api\OfficeLocationController::class, 'destroy']);

    // Newsletter Subscribers — read + remove (created via the public site)
    Route::get('/newsletter-subscribers', [\App\Http\Controllers\Api\NewsletterSubscriberController::class, 'index']);
    Route::delete('/newsletter-subscribers/{newsletterSubscriber}', [\App\Http\Controllers\Api\NewsletterSubscriberController::class, 'destroy']);

    // Presence (who's online, and on which admin page)
    Route::post('/presence/heartbeat', [\App\Http\Controllers\Api\PresenceController::class, 'heartbeat']);
    Route::get('/presence', [\App\Http\Controllers\Api\PresenceController::class, 'index']);

    // Team Members — full CRUD
    Route::get('/team-members', [\App\Http\Controllers\Api\TeamMemberController::class, 'index']);
    Route::post('/team-members', [\App\Http\Controllers\Api\TeamMemberController::class, 'store']);
    Route::get('/team-members/{teamMember}', [\App\Http\Controllers\Api\TeamMemberController::class, 'show']);
    Route::put('/team-members/{teamMember}', [\App\Http\Controllers\Api\TeamMemberController::class, 'update']);
    Route::delete('/team-members/{teamMember}', [\App\Http\Controllers\Api\TeamMemberController::class, 'destroy']);

    // Users — full CRUD
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\Api\UserController::class, 'store']);
    Route::get('/users/{user}', [\App\Http\Controllers\Api\UserController::class, 'show']);
    Route::put('/users/{user}', [\App\Http\Controllers\Api\UserController::class, 'update']);
    Route::delete('/users/{user}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);
    Route::post('/users/{user}/send-reset-link', [\App\Http\Controllers\Api\UserController::class, 'sendResetLink']);
});
