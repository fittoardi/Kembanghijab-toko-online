<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        $color = fake()->randomElement(['Black', 'Cream', 'Brown', 'Dusty Pink', 'Mauve']);
        $size = fake()->randomElement(['110 x 110', '115 x 115']);

        return [
            'product_id' => Product::factory(),
            'sku' => 'KH-'.fake()->unique()->bothify('???###'),
            'color' => $color,
            'size' => $size,
            'stock' => fake()->numberBetween(0, 50),
            'reserved_stock' => 0,
            'price' => null,
            'is_active' => true,
        ];
    }
}
