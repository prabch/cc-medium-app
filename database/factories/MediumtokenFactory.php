<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MediumtokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => Str::random(64),
            'medium_user_id' => Str::random(64),
            'username' => Str::random(10),
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(50, 50, 'cats'),
        ];
    }
}
