<?php
// database/factories/ProductFactory.php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->productName,
            'sku' => $this->faker->unique()->ean8,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => 'USD',
        ];
    }
}