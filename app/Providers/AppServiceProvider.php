<?php

namespace App\Providers;

use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Services\OrderItemSevice;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(OrderItemServiceInterface::class, OrderItemSevice::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        // TODO implement service interfaces
        //$this->app->bind(OrderItemInterface::class, OrderService::class);
        //$this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
