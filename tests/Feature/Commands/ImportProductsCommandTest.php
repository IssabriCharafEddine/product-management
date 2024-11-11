<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportProductsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $csvContent = "sku,name,status,price,currency,variations\n" .
            "SKU001,Test Product,active,99.99,USD,\"[{\"\"options\"\":{\"\"color\"\":\"\"red\"\"}}]\"\n";

        Storage::put('products.csv', $csvContent);

        Http::fake([
            'https://5fc7a13cf3c77600165d89a8.mockapi.io/api/v5/products' => Http::response([
                [
                    'id' => 'API001',
                    'name' => 'API Product',
                    'status' => 'active',
                    'price' => 199.99,
                    'currency' => 'USD',
                    'variations' => [
                        [
                            'color' => 'blue',
                            'quantity' => 10
                        ]
                    ]
                ]
            ], 200)
        ]);
    }

    public function test_it_can_import_products_from_csv()
    {
        $this->artisan('products:import csv')
            ->assertSuccessful();
    }

    public function test_it_can_import_products_from_api()
    {
        $this->artisan('products:import api')
            ->assertSuccessful();
    }

}
