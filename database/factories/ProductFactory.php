<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        $category = Category::inRandomOrder()->first();

        $subCategory = SubCategory::where('category_id', $category->id)
            ->inRandomOrder()
            ->first();

        $price = fake()->randomFloat(2, 500, 50000);
        $salePrice = fake()->randomFloat(2, 300, $price);

        return [
            'category_id' => $category->id,
            'sub_category_id' => $subCategory?->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'vendor_id' => Vendor::inRandomOrder()->first()->id,

            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => $price,
            'sale_price' => $salePrice,
            'stock' => fake()->numberBetween(5, 100),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####??')),
            'thumbnail' => null,
            'status' => true,
            'featured' => fake()->boolean(30),
        ];
    }
}