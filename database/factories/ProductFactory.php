<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->paragraph(),
            'content' => $this->faker->paragraph(),
            'price' => 100000,
            'thumbnail' => $this->faker->paragraph(),
            'category_id' => 1,
        ];
    }
}