<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => fake()->words(3, true),
            'sku' => fake()->unique()->bothify('SKU-#######'),
            'price' => fake()->numberBetween(100, 500000000),
            'stock' => fake()->numberBetween(0, 100),
            'description' => fake()->paragraph(),
        ];
    }
}
