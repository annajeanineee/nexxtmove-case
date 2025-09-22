<?php

declare(strict_types=1);

namespace Feature\Controllers\Listings;

use App\Models\City;
use App\Models\Listing;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

class IndexTest extends FeatureTestCase
{
    #[Test]
    public function it_can_load_the_endpoint(): void
    {
        $response = $this->get(route('listings.index'));

        $response->assertOk();
    }

    #[Test]
    public function it_returns_a_collection_of_listings(): void
    {
        Listing::factory()->count(3)->create();

        $response = $this->getJson(route('listings.index'));

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'title', 'price', 'price_currency', 'description', 'status', 'url'],
                ],
            ]);
    }

    #[Test]
    public function it_can_include_city_relationship(): void
    {
        $city = City::factory()->create();
        Listing::factory()->count(2)->city($city)->create();

        $response = $this->getJson(route('listings.index', ['include' => 'city']));

        $response->assertOk()
            ->assertJson(fn ($json) => $json
                ->has('data', 2)
                ->has('data.0.city')
                ->where('data.0.city.id', $city->id)
            );
    }
}
