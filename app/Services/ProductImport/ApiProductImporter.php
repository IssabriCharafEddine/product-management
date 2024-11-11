<?php
namespace App\Services\ProductImport;

use Illuminate\Support\Facades\Http;

class ApiProductImporter implements ProductImporterInterface
{
    private $apiUrl;

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function import(): array
    {
        try {
            $response = Http::get($this->apiUrl);

            if (!$response->successful()) {
                throw new \RuntimeException(
                    "API request failed with status: {$response->status()}"
                );
            }

            $products = $response->json();

            return array_map(function ($product) {
                return [
                    'sku' => $product['id'] ?? null,
                    'name' => $product['name'] ?? null,
                    'status' => $product['status'] ?? null,
                    'currency' => $product['currency'] ?? null,
                    'description' => $product['description'] ?? null,
                    'price' => $product['price'] ?? 0.00,
                    'variations' => $product['variations'] ?? [],
                    'image' => $product['image'] ?? null,
                ];
            }, $products);

        } catch (\Exception $e) {
            throw new \RuntimeException(
                "API import failed: {$e->getMessage()}"
            );
        }
    }
}