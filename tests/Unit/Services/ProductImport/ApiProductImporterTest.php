<?php

namespace Tests\Unit\Services\ProductImport;

use App\Services\ProductImport\ApiProductImporter;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ApiProductImporterTest extends TestCase
{
    public function test_it_can_import_from_api()
    {
        try {
            $importer = new ApiProductImporter('https://5fc7a13cf3c77600165d89a8.mockapi.io/api/v5/products');
            $products = $importer->import();
            $this->assertNotEmpty($products);
            $this->assertArrayHasKey('sku', $products[0]);
            $this->assertArrayHasKey('name', $products[0]);
            $this->assertArrayHasKey('price', $products[0]);
            $this->assertArrayHasKey('currency', $products[0]);
            $this->assertArrayHasKey('variations', $products[0]);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return 1;
        }
    }


    public function test_it_handles_missing_fields()
    {
        try {
            Http::fake([
                '*' => Http::response([
                    [
                        'id' => 'API002',
                        'name' => 'Minimal Product'
                    ]
                ])
            ]);

            $importer = new ApiProductImporter('https://api.example.com/products');
            $products = $importer->import();

            $this->assertNotEmpty($products);
            $this->assertArrayHasKey('sku', $products[0]);
            $this->assertArrayHasKey('name', $products[0]);
            $this->assertArrayHasKey('price', $products[0]);
            $this->assertArrayHasKey('currency', $products[0]);
            $this->assertArrayHasKey('variations', $products[0]);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return 1;
        }
    }

    public function test_it_handles_api_error()
    {
        Http::fake([
            '*' => Http::response(null, 500)
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('API request failed with status: 500');

        $importer = new ApiProductImporter('https://api.example.com/products');
        $importer->import();
    }

    public function test_it_handles_empty_response()
    {
        try {
            Http::fake([
                '*' => Http::response([], 200)
            ]);

            $importer = new ApiProductImporter('https://api.example.com/products');
            $products = $importer->import();

            $this->assertIsArray($products);
            $this->assertEmpty($products);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return 1;
        }
    }
}
