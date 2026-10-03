<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Seed the storefront catalog with a repeatable demo dataset.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pashmina', 'description' => 'Flowy silhouettes for effortless everyday styling.', 'sort_order' => 1],
            ['name' => 'Voal', 'description' => 'Lightweight, breathable, and easy to style.', 'sort_order' => 2],
            ['name' => 'Square', 'description' => 'Timeless square scarves for every occasion.', 'sort_order' => 3],
            ['name' => 'Inner', 'description' => 'Comfortable essentials to keep every look in place.', 'sort_order' => 4],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    ...$categoryData,
                    'slug' => Str::slug($categoryData['name']),
                    'is_active' => true,
                ],
            );

            foreach ($this->productsForCategory($category->name) as $productData) {
                $product = Product::updateOrCreate(
                    ['slug' => $productData['slug']],
                    [
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'material' => $productData['material'],
                        'price' => $productData['price'],
                        'discount_price' => $productData['discount_price'],
                        'is_featured' => $productData['is_featured'],
                        'is_new' => $productData['is_new'],
                        'category_id' => $category->id,
                        'is_active' => true,
                    ],
                );

                $this->seedVariants($product, $productData['price']);
                $product->images()->updateOrCreate(
                    ['sort_order' => 0],
                    [
                        'path' => $productData['image'],
                        'alt_text' => $product->name,
                        'is_primary' => true,
                    ],
                );
            }
        }
    }

    private function productsForCategory(string $category): array
    {
        return match ($category) {
            'Pashmina' => [
                $this->product('Pashmina Satin Moonlight', 149000, 179000, true, false, 'https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?auto=format&fit=crop&w=900&q=85'),
                $this->product('Pashmina Cloud Cream', 129000, null, false, true, 'https://images.unsplash.com/photo-1605763240000-7e93b172d754?auto=format&fit=crop&w=900&q=85'),
            ],
            'Voal' => [
                $this->product('Voal Paris Rose', 119000, null, true, true, 'https://images.unsplash.com/photo-1584184924103-e310d9dc82fc?auto=format&fit=crop&w=900&q=85'),
                $this->product('Voal Mauve Dream', 109000, null, false, false, 'https://images.unsplash.com/photo-1590736969955-71cc94901144?auto=format&fit=crop&w=900&q=85'),
            ],
            'Square' => [
                $this->product('Square Silk Earth', 159000, 189000, true, false, 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=85'),
            ],
            'Inner' => [
                $this->product('Inner Jersey Nude', 59000, null, false, false, 'https://images.unsplash.com/photo-1610652492500-ded49ceeb378?auto=format&fit=crop&w=900&q=85'),
            ],
            default => [],
        };
    }

    private function product(string $name, int $price, ?int $discountPrice, bool $featured, bool $new, string $image): array
    {
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Koleksi Kembang Hijab yang lembut, ringan, dan nyaman untuk menemani setiap momen.',
            'material' => 'Premium selected fabric',
            'price' => $price,
            'discount_price' => $discountPrice,
            'is_featured' => $featured,
            'is_new' => $new,
            'image' => $image,
        ];
    }

    private function seedVariants(Product $product, int $price): void
    {
        foreach ([
            ['color' => 'Black', 'size' => '110 x 110'],
            ['color' => 'Cream', 'size' => '110 x 110'],
            ['color' => 'Dusty Pink', 'size' => '115 x 115'],
        ] as $index => $variantData) {
            $product->variants()->updateOrCreate(
                ['sku' => 'KH-'.$product->id.'-'.($index + 1)],
                [
                    ...$variantData,
                    'stock' => $index === 2 ? 8 : 24,
                    'reserved_stock' => 0,
                    'price' => $price,
                    'is_active' => true,
                ],
            );
        }
    }
}
