<?php
// app/Providers/ProductServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProductImport\ProductImporterInterface;
use App\Services\ProductImport\CsvProductImporter;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductImporterInterface::class, function ($app) {
            return new CsvProductImporter(config('services.product.import_file', 'products.csv'));
        });
    }

    public function boot(): void
    {
        //
    }
}