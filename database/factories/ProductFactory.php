<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->numberBetween(59000, 249000);

        return [
            'category_id' => Category::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'material' => fake()->randomElement(['Voal premium', 'Satin silk', 'Jersey elastis', 'Chiffon premium']),
            'price' => $price,
            'discount_price' => fake()->boolean(35) ? $price - fake()->numberBetween(10000, 30000) : null,
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
            'is_new' => fake()->boolean(25),
            'views_count' => fake()->numberBetween(0, 5000),
        ];
    }
}
