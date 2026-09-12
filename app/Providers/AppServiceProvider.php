<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip() . '|' . $request->input('email'));
        });

        \Illuminate\Support\Facades\View::composer('components.footer', function ($view) {
            $view->with('footerServices', \App\Models\Service::limit(5)->get());
            $view->with('footerProducts', \App\Models\FlagshipProduct::limit(4)->get());
            $view->with('isHiring', \App\Models\JobListing::count() > 0);
            $view->with('footerContact', \App\Models\ContactSetting::first());
            $view->with('footerOffice', \App\Models\OfficeLocation::where('is_primary', true)->first()
                ?? \App\Models\OfficeLocation::orderBy('order_column')->first());
            $view->with('footerAbout', \App\Models\AboutSetting::first());
            $view->with('foundedEvent', \App\Models\TimelineEvent::orderBy('order_column')->first());
        });
    }
}
