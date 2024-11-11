<?php

namespace App\Services\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getAllPaginated(int $perPage, array $filters = []): LengthAwarePaginator;
    public function getProduct(Product $product): Product;
    public function createProduct(array $data): Product;
    public function updateProduct(Product $product, array $data): Product;
    public function deleteProduct(Product $product): void;
}