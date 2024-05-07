<?php

namespace Database\Factories;

use App\Models\Berand;
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
            'name' => fake()->company(),
            'description' => fake()->text() ,
            'stock_quantity' => random_int(1,200),
            'photo_path' => fake()->imageUrl() ,
            'categorie_id' => Category::factory(),
            'berand_id' => Berand::factory(),
        ];
    }
}
