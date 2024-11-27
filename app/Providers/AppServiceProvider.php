<?php

namespace App\Providers;

use App\Interfaces\OrderInterface;
use App\Interfaces\OrderItemServiceInterface;
use App\Interfaces\OrderServiceInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductServiceInterface;
use App\Models\Order;
use App\Models\Product;
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
        $this->app->bind(OrderInterface::class, Order::class);
        $this->app->bind(ProductInterface::class, Product::class);
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
