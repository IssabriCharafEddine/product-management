<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $productData;
    private $existingProductId;

    public function __construct(array $productData, ?int $existingProductId)
    {
        $this->productData = $productData;
        $this->existingProductId = $existingProductId;
    }

    public function handle()
    {
        try {
            if ($this->productData['sku'] === null) {
                Log::warning('Skipping product import due to null SKU.', ['productData' => $this->productData]);
                return;
            }

            sleep(2);

            DB::transaction(function () {
                $product = Product::updateOrCreate(
                    ['sku' => $this->productData['sku']],
                    [
                        'name' => $this->productData['name'],
                        'status' => $this->productData['status'],
                        'price' => $this->productData['price'],
                        'currency' => $this->productData['currency'],
                        'image' => $this->productData['image'] ?? null
                    ]
                );

                $variationsData = [];

                if (isset($this->productData['variations'])) {
                    foreach ($this->productData['variations'] as $variation) {
                        if (isset($variation['name']) && isset($variation['value'])) {
                            $variationsData[] = [
                                'options' => json_encode([
                                    'name' => $variation['name'],
                                    'value' => $variation['value']
                                ], JSON_UNESCAPED_UNICODE),
                                'quantity' => $variation['quantity'] ?? 0,
                                'is_available' => ($variation['quantity'] ?? 0) > 0
                            ];
                        } elseif (isset($variation['quantity'])) {
                            $options = [];
                            foreach ($variation as $key => $value) {
                                if (!in_array($key, ['id', 'productId', 'quantity', 'additional_price'])) {
                                    $options[$key] = $value;
                                }
                            }

                            $variationsData[] = [
                                'options' => json_encode($options, JSON_UNESCAPED_UNICODE),
                                'quantity' => $variation['quantity'],
                                'is_available' => $variation['quantity'] > 0,
                                'additional_price' => $variation['additional_price'] ?? 0
                            ];
                        } else {
                            Log::warning("Invalid variation format", ['variation' => $variation]);
                        }
                    }
                }

                foreach ($variationsData as $variationData) {
                    $product->variations()->updateOrCreate(
                        ['options' => $variationData['options']],
                        [
                            'quantity' => $variationData['quantity'],
                            'is_available' => $variationData['is_available'],
                            'additional_price' => $variationData['additional_price'] ?? 0
                        ]
                    );
                }

                SendWarehouseNotification::dispatch($product);
                NotifyCustomersAboutStock::dispatch($product);
                UpdateThirdPartyProduct::dispatch($product);
            });
        } catch (\Exception $e) {

            Log::error('ProcessProductImport failed', [
                'productData' => $this->productData,
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }
}
