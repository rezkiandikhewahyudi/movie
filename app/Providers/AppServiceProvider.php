<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\MovieRepository;

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
        Paginator::useBootstrap();
    }
    public function register()
    {
    $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }
}
