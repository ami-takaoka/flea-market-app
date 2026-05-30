<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),

            'email' => $this->faker->unique()->safeEmail(),

            'password' => Hash::make('password'),

            'postal_code' => '123-4567',

            'address' => $this->faker->address(),

            'building' => $this->faker->secondaryAddress(),

            'image' => 'sample.jpg',

            'email_verified_at' => now(),
        ];
    }
}