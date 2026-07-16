<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('components.footer', function ($view) {
            $view->with('footerServices', \App\Models\Service::limit(5)->get());
            $view->with('footerProducts', \App\Models\FlagshipProduct::limit(4)->get());
        });
    }
}
