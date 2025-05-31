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
                'name' => $this->faker->words(3, true),
                'description' => $this->faker->sentence(3),
                'price' => $this->faker->randomFloat(2, 10, 500),
                'quantity' => $this->faker->numberBetween(1, 100),
                'image' => 'products/sample.jpg',
                'category_id' => Category::inRandomOrder()->first()->id,
            ];
        }
    }

