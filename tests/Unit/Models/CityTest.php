<?php

declare(strict_types=1);

namespace Unit\Models;

use App\Models\City;
use App\Models\Listing;
use PHPUnit\Framework\Attributes\Test;
use Tests\IntegrationTestCase;

class CityTest extends IntegrationTestCase
{
    #[Test]
    public function factory_creates_a_valid_city(): void
    {
        $city = City::factory()->create();

        $this->assertNotNull($city->id);
        $this->assertNotEmpty($city->name);
        $this->assertNotEmpty($city->country);
    }

    #[Test]
    public function has_many_listings_relation_works(): void
    {
        $city = City::factory()->create();
        $listings = Listing::factory()->count(2)->city($city)->create();

        $this->assertCount(2, $city->listings);
        $this->assertEqualsCanonicalizing($listings->pluck('id')->all(), $city->listings->pluck('id')->all());
    }
}
