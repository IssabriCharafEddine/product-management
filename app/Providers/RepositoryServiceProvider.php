<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }
}