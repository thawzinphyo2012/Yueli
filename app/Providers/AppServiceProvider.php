<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class);
    }

    public function boot(): void
    {
        View::composer(['layouts.storefront', 'layouts.admin', 'storefront.*', 'partials.*'], function ($view) {
            $cart = app(CartService::class);
            $siteName = 'Yueli Studio';
            $tagline = 'Editorial clothing for modern quiet luxury.';

            try {
                if (Schema::hasTable('settings')) {
                    $siteName = Setting::get('site_name', $siteName);
                    $tagline = Setting::get('tagline', $tagline);
                }
            } catch (\Throwable) {
                // Database may not be ready during early boot/migrations.
            }

            $view->with([
                'cartCount' => $cart->count(),
                'siteName' => $siteName,
                'siteTagline' => $tagline,
            ]);
        });
    }
}
