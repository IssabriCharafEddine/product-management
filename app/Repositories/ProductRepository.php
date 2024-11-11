<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Product::with('variations')->paginate($perPage);
    }

    public function getAllPaginated(int $perPage, array $filters = []): LengthAwarePaginator
    {
        $query = Product::query()->with('variations');

        if (!empty($filters['sku'])) {
            $query->where('sku', 'like', '%' . $filters['sku'] . '%');
        }

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        if (!empty($filters['sort_by'])) {
            $direction = $filters['sort_direction'] ?? 'asc';
            $query->orderBy($filters['sort_by'], $direction);
        }

        return $query->paginate($filters['per_page'] ?? $perPage);
    }

    public function find(int $id): ?Product
    {
        return Product::with('variations')->find($id);
    }

    public function findWithVariations(Product $product): Product
    {
        return $product->load('variations');
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product, string $reason): void
    {
        $product->update(['deletion_reason' => $reason]);
        $product->delete();
    }

    public function createVariations(Product $product, array $variations): void
    {
        foreach ($variations as $variation) {
            $product->variations()->create([
                'options' => $variation['options'],
                'quantity' => $variation['quantity'],
                'is_available' => $variation['quantity'] > 0
            ]);
        }
    }

    public function deleteVariations(Product $product): void
    {
        $product->variations()->delete();
    }
}
