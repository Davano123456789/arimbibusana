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
            $pendingOrdersCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $userId = \Illuminate\Support\Facades\Auth::id();
                $cartCount = \App\Models\Cart::where('user_id', $userId)->sum('quantity');
                $pendingOrdersCount = \App\Models\Order::where('user_id', $userId)
                    ->whereIn('status', ['unpaid', 'pending'])
                    ->count();
            }
            $view->with([
                'cartCount' => $cartCount,
                'pendingOrdersCount' => $pendingOrdersCount
            ]);
        });

        // Share settings with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \App\Models\Setting::all()->pluck('value', 'key');
            $view->with('settings', $settings);
        });
    }
}
