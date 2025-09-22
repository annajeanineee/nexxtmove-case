<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Listing\Status;
use App\Models\City;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'price' => $this->faker->numberBetween(50000, 500000),
            'price_currency' => 'EUR',
            'description' => $this->faker->paragraph(),
            'image' => 'listing-image-example.png',
            'city_id' => City::factory(),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }

    public function city(City $city): self
    {
        return $this->state([
            'city_id' => $city,
        ]);
    }
}
