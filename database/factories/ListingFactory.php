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
            'title' => $this->faker->sentence(2),
            'price' => $this->faker->numberBetween(300000, 900000),
            'price_currency' => 'EUR',
            'description' => $this->faker->paragraph(),
            'image' => 'listing-image-example.png',
            'city_id' => City::factory(),
            'status' => $this->faker->randomElement(Status::cases()),
            'street' => $this->faker->streetName(),
            'house_number' => (string) $this->faker->numberBetween(1, 999),
            'house_number_addition' => $this->faker->boolean(30) ? $this->faker->randomLetter() : null,
            'postal_code' => strtoupper($this->faker->bothify('#### ??')),
        ];
    }

    public function city(City $city): self
    {
        return $this->state([
            'city_id' => $city,
        ]);
    }
}
