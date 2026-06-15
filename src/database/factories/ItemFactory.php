<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'name' => $this->faker->words(2, true),

            'brand' => $this->faker->company(),

            'image' => 'sample.jpg',

            'price' => $this->faker->numberBetween(1000, 10000),

            'description' => $this->faker->sentence(),

            'condition' => $this->faker->numberBetween(
                Item::CONDITION_GOOD,
                Item::CONDITION_BAD
            ),

            'status' => Item::STATUS_ON_SALE,
        ];
    }
}