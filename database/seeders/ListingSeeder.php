<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (City::query()->cursor() as $city) {
            Listing::factory()
                ->count(6)
                ->city($city)
                ->create();
        }
    }
}
