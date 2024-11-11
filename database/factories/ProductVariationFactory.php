<?php
namespace Database\Factories;

use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;

    public function definition(): array
    {
        return [
            'options' => [
                'color' => $this->faker->colorName,
                'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            ],
            'quantity' => $this->faker->numberBetween(0, 100),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}