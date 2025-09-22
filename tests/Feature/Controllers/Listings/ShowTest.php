<?php

declare(strict_types=1);

namespace Feature\Controllers\Listings;

use App\Models\City;
use App\Models\Listing;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

class ShowTest extends FeatureTestCase
{
    #[Test]
    public function it_can_load_the_show_endpoint(): void
    {
        $listing = Listing::factory()->create();

        $response = $this->getJson(route('listings.show', $listing));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'title', 'price', 'price_currency', 'description', 'status'],
            ])
            ->assertJsonPath('data.id', $listing->id);
    }

    #[Test]
    public function show_resource_contains_image_path(): void
    {
        $listing = Listing::factory()->create(['image' => 'foo.png']);

        $response = $this->getJson(route('listings.show', $listing));
        $response->assertOk()->assertJson(fn ($json) => $json
            ->where('data.image_path', fn ($path) => is_string($path) && str_ends_with($path, 'foo.png'))
        );
    }

    #[Test]
    public function it_includes_city_when_requested(): void
    {
        $city = City::factory()->create();
        $listing = Listing::factory()->create(['city_id' => $city->id]);

        $response = $this->getJson(route('listings.show', [$listing, 'include' => 'city']));
        $response->assertOk()
            ->assertJsonPath('data.city.id', $city->getRouteKey());
    }

    #[Test]
    public function it_returns_404_for_nonexistent_listing(): void
    {
        $response = $this->getJson(route('listings.show', 999999));
        $response->assertStatus(404);
    }
}
