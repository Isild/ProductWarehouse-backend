<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductModelFactory extends Factory
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
            'description' => $this->faker->text,
            'salary' => [
                $this->faker->numberBetween(1,1000),
                $this->faker->numberBetween(1,1000),
                $this->faker->numberBetween(1,1000),
            ]
        ];
    }
}
