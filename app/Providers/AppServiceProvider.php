<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\FooterPage;

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
        // Share active footer pages with public layouts
        View::composer(['layouts.public', 'public.*'], function ($view) {
            // Check if table exists first to avoid errors during migrations
            if (\Schema::hasTable('footer_pages')) {
                $view->with('publicFooterPages', FooterPage::where('status', 'active')->get());
            } else {
                $view->with('publicFooterPages', collect());
            }
        });
    }
}
