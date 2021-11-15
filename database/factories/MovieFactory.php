<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
              'en' => $this->faker->sentence(),
              'ka' => $this->faker->sentence(),
            ],
        ];
    }
}
