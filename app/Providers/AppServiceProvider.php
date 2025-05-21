<?php

namespace App\Providers;

use App\Models\UP;
use App\Services\FonnteService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(FonnteService::class, function ($app) {
            return new FonnteService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::ignoreMigrations();
    }
}
