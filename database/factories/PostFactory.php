<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'medium_id' => Str::random(12),
            'title' => Str::random(10),
            'content' => Str::random(256),
            'canonicalUrl' => $this->faker->url()
        ];
    }
}
