<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Brand;

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
    Paginator::useBootstrapFive(); //

    View::composer('client.partials.navbar', function ($view) {
        $categories = Cache::remember('navbar_categories', now()->addHours(1), function () {
            return Category::select('cateid', 'catename', 'slug')
                ->where('status', 1)
                ->orderBy('catename')
                ->take(10)
                ->get();
        });

        $brands = Cache::remember('navbar_brands', now()->addHours(1), function () {
            return Brand::select('id', 'brandname', 'slug')
                ->where('status', 1)
                ->orderBy('brandname')
                ->take(10)
                ->get();
        });

        $view->with(compact('categories', 'brands'));
    });
}
}
