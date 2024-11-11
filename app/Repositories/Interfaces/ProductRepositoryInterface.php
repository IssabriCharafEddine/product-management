<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;
    public function getAllPaginated(int $perPage, array $filters = []): LengthAwarePaginator;
    public function findWithVariations(Product $product): Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product, string $reason): void;
    public function createVariations(Product $product, array $variations): void;
    public function deleteVariations(Product $product): void;
}