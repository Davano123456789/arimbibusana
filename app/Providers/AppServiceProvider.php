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
        // Share cart count with all views
        \Illuminate\Support\Facades\View::composer(['layouts.navbar', 'resources.views.layouts.navbar'], function ($view) {
            $cartCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $cartCount = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->sum('quantity');
            }
            $view->with('cartCount', $cartCount);
        });

        // Share settings with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \App\Models\Setting::all()->pluck('value', 'key');
            $view->with('settings', $settings);
        });
    }
}
