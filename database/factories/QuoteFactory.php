<?php

namespace Database\Factories;

use App\Models\Movie;
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
            'thumbnail' => $this->faker->image('public/storage/images', 640, 480, null, false),
            'movie_id' => Movie::factory(),
        ];
    }
}
