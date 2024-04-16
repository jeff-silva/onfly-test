<?php

namespace App\Providers;

use App\Repositories\AppUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AppUserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppUserRepositoryInterface::class, AppUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
