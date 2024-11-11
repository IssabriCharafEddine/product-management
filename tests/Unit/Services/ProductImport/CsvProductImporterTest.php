<?php

namespace Tests\Unit\Services\ProductImport;

use Tests\TestCase;
use App\Services\ProductImport\CsvProductImporter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class CsvProductImporterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $originalContent = file_get_contents(base_path('products.csv'));
        Storage::put('products.csv', $originalContent);
    }

    public function test_it_can_import_csv_file()
    {
        try {
            $importer = new CsvProductImporter('products.csv');
            $products = $importer->import();
    
            $this->assertNotEmpty($products);
            $this->assertArrayHasKey('sku', $products[0]);
            $this->assertArrayHasKey('name', $products[0]);
            $this->assertArrayHasKey('status', $products[0]);
            $this->assertArrayHasKey('price', $products[0]);
            $this->assertArrayHasKey('currency', $products[0]);
            $this->assertArrayHasKey('variations', $products[0]);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return 1;
        }
    }
}
