<?php

namespace App\Services\ProductSync;

use App\Models\Product;
use App\Jobs\ProcessProductImport;

class ProductSynchronizer
{
    public function syncProducts(array $products)
    {
        $existingSkus = Product::whereNotNull('sku')->pluck('id', 'sku')->toArray();
        $processedSkus = [];

        foreach ($products as $productData) {
            if ($productData['sku'] !== null) {
                ProcessProductImport::dispatch($productData, $existingSkus[$productData['sku']] ?? null);
                $processedSkus[] = $productData['sku'];
            }
        }

        Product::whereNotIn('sku', $processedSkus)
            ->whereNull('deleted_at')
            ->update([
                'deletion_reason' => 'Removed during synchronization',
                'deleted_at' => now()
            ]);
    }
}