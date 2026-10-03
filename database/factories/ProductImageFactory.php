<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'path' => fake()->imageUrl(900, 1100, 'fashion'),
            'alt_text' => fake()->sentence(4),
            'sort_order' => 0,
            'is_primary' => true,
        ];
    }
}
