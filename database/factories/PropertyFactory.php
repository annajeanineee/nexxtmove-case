<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        $statuses = ['available','under_offer','sold','rented'];

        return [
            'address'     => fake()->address(),
            'price'       => fake()->numberBetween(175000, 950000),
            'city'        => fake()->city(),
            'status'      => fake()->randomElement($statuses),
            'description' => fake()->paragraph(),
            'bedrooms'    => fake()->numberBetween(1, 8),
            'bathrooms'   => fake()->numberBetween(1, 5),
            'balcony'     => fake()->boolean(30),
            'garden'     => fake()->boolean(30),
        ];
    }
}
