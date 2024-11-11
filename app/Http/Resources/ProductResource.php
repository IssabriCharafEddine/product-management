<?php
// app/Http/Resources/ProductResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'status' => $this->status,
            'price' => $this->price,
            'currency' => $this->currency,
            'variations' => ProductVariationResource::collection($this->whenLoaded('variations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}