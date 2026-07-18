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
});
