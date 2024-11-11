<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllPaginated(int $perPage, array $filters = []): LengthAwarePaginator
    {
        return $this->productRepository->getAllPaginated($perPage, $filters);
    }

    public function getProduct(Product $product): Product
    {
        return $this->productRepository->findWithVariations($product);
    }

    public function createProduct(array $data): Product
    {
        $product = $this->productRepository->create($data);

        if (isset($data['variations'])) {
            $this->productRepository->createVariations($product, $data['variations']);
        }

        return $this->productRepository->findWithVariations($product);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product = $this->productRepository->update($product, $data);

        if (isset($data['variations'])) {
            $this->productRepository->deleteVariations($product);
            $this->productRepository->createVariations($product, $data['variations']);
        }

        return $this->productRepository->findWithVariations($product);
    }

    public function deleteProduct(Product $product): void
    {
        $this->productRepository->delete($product, 'Manually deleted');
    }
}