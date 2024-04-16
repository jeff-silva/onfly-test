<?php

namespace App\Providers;

use App\Repositories\AppUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AppUserRepositoryInterface;
use App\Repositories\FinancialExpenseRepository;
use App\Contracts\FinancialExpenseRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppUserRepositoryInterface::class, AppUserRepository::class);
        $this->app->bind(FinancialExpenseRepositoryInterface::class, FinancialExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
