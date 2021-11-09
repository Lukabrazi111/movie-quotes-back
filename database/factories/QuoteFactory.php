<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quote' => $this->faker->text,
            'thumbnail' => $this->faker->image,
            'slug' => $this->faker->slug,
            'movie_id' => $this->faker->unique()->numberBetween(1, 30),
        ];
    }
}
