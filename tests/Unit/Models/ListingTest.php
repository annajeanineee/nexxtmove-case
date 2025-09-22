<?php

declare(strict_types=1);

namespace Unit\Models;

use App\Enums\Listing\Status;
use App\Models\City;
use App\Models\Listing;
use PHPUnit\Framework\Attributes\Test;
use Tests\IntegrationTestCase;

class ListingTest extends IntegrationTestCase
{
    #[Test]
    public function factory_creates_a_valid_listing(): void
    {
        $listing = Listing::factory()->create();

        $this->assertNotNull($listing->id);
        $this->assertNotEmpty($listing->title);
        $this->assertIsInt($listing->price);
        $this->assertSame('EUR', $listing->price_currency);
        $this->assertInstanceOf(Status::class, $listing->status);
    }

    #[Test]
    public function status_is_cast_to_enum(): void
    {
        $listing = Listing::factory()->create(['status' => Status::AVAILABLE]);

        $this->assertInstanceOf(Status::class, $listing->status);
        $this->assertEquals(Status::AVAILABLE, $listing->status);
    }

    #[Test]
    public function belongs_to_city_relation_works(): void
    {
        $city = City::factory()->create();
        $listing = Listing::factory()->city($city)->create();

        $this->assertFalse($listing->relationLoaded('city'));
        $this->assertEquals($city->id, $listing->city->id);
    }
}
