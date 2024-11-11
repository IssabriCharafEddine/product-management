<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'options' => $this->options,
            'quantity' => $this->quantity,
            'is_available' => $this->is_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}