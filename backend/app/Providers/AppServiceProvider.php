<?php

namespace App\Providers;

use App\Repository\CategoryRepository;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Repository\Contracts\OrderRepositoryInterface;
use App\Repository\Contracts\ProductRepositoryInterface;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
