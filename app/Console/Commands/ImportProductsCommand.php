<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductImport\CsvProductImporter;
use App\Services\ProductImport\ApiProductImporter;
use App\Services\ProductSync\ProductSynchronizer;

class ImportProductsCommand extends Command
{
    protected $signature = 'products:import {source=csv} {--file=products.csv}';
    protected $description = 'Import products from CSV file or API';

    private $productSynchronizer;

    public function __construct(ProductSynchronizer $productSynchronizer)
    {
        parent::__construct();
        $this->productSynchronizer = $productSynchronizer;
    }

    public function handle()
    {
        $source = $this->argument('source');
        
        try {
            $importer = match($source) {
                'csv' => new CsvProductImporter($this->option('file')),
                'api' => new ApiProductImporter(
                    'https://5fc7a13cf3c77600165d89a8.mockapi.io/api/v5/products'
                ),
                default => throw new \InvalidArgumentException('Invalid source')
            };

            $this->info('Starting product import...');
            $products = $importer->import();
            $this->productSynchronizer->syncProducts($products);
            
            $this->info('Product import completed successfully.');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            dd($e);
            $this->error("Import failed: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}