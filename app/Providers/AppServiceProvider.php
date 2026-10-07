<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DynamicObject;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {

            $dynamicObjects = DynamicObject::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            $view->with('dynamicObjects', $dynamicObjects);
        });
    }
}
