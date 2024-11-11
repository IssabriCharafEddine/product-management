<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductFilterRequest $request): AnonymousResourceCollection
    {
        $filters = $request->validated();
        $products = $this->productService->getAllPaginated(20, $filters);
        return ProductResource::collection($products);
    }
    public function show(Product $product): ProductResource
    {
        $product = $this->productService->getProduct($product);
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $updatedProduct = $this->productService->updateProduct($product, $request->validated());
        return new ProductResource($updatedProduct);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->deleteProduct($product);
        return response()->json(null, 204);
    }
}
