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
                'links',
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }

    #[Test]
    public function it_applies_default_pagination_when_missing(): void
    {
        Listing::factory()->count(20)->create();

        $response = $this->getJson(route('listings.index'));

        $response->assertOk()
            ->assertJsonCount(12, 'data')
            ->assertJsonPath('meta.per_page', 12)
            ->assertJsonPath('meta.current_page', 1);
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
                ->where('data.0.city.id', $city->getRouteKey())
                ->has('links')
                ->has('meta')
            );
    }

    #[Test]
    public function it_paginates_results_and_respects_per_page(): void
    {
        Listing::factory()->count(15)->create();

        $response = $this->getJson(route('listings.index', ['per_page' => 8]));

        $response->assertOk()
            ->assertJsonCount(8, 'data')
            ->assertJsonPath('meta.per_page', 8)
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonPath('meta.last_page', 2)
            ->assertJsonPath('meta.total', 15);

        // Go to page 2
        $response = $this->getJson(route('listings.index', ['per_page' => 8, 'page' => 2]));
        $response->assertOk()
            ->assertJsonCount(7, 'data')
            ->assertJsonPath('meta.current_page', 2);
    }

    #[Test]
    public function it_can_filter_by_city_name(): void
    {
        $amsterdam = City::factory()->create(['name' => 'Amsterdam']);
        $rotterdam = City::factory()->create(['name' => 'Rotterdam']);
        Listing::factory()->count(2)->city($amsterdam)->create();
        Listing::factory()->count(2)->city($rotterdam)->create();

        $response = $this->getJson(route('listings.index', ['filter' => ['city' => 'Amst'], 'include' => 'city', 'per_page' => 50]));

        $response->assertOk()
            ->assertJson(fn ($json) => $json
                ->has('data', 2)
                ->where('data.0.city.name', 'Amsterdam')
                ->etc()
            );
    }

    #[Test]
    public function it_can_filter_by_price_range(): void
    {
        Listing::factory()->create(['price' => 100000]);
        Listing::factory()->create(['price' => 200000]);
        Listing::factory()->create(['price' => 300000]);

        $response = $this->getJson(route('listings.index', ['filter' => ['price_min' => 150000, 'price_max' => 250000]]));

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.price', 200000);
    }

    #[Test]
    public function it_returns_empty_when_price_min_greater_than_price_max(): void
    {
        Listing::factory()->create(['price' => 100000]);
        Listing::factory()->create(['price' => 200000]);

        $response = $this->getJson(route('listings.index', ['filter' => ['price_min' => 300000, 'price_max' => 100000]]));
        $response->assertOk()->assertJsonCount(0, 'data');
    }

    #[Test]
    public function it_can_sort_by_price_ascending_and_descending(): void
    {
        Listing::factory()->create(['price' => 100000]);
        Listing::factory()->create(['price' => 300000]);

        // ascending
        $response = $this->getJson(route('listings.index', ['sort' => 'price']));
        $response->assertOk()->assertJsonPath('data.0.price', 100000);

        // descending
        $response = $this->getJson(route('listings.index', ['sort' => '-price']));
        $response->assertOk()->assertJsonPath('data.0.price', 300000);
    }

    #[Test]
    public function it_can_sort_by_city_name_ascending_and_descending(): void
    {
        $amsterdam = City::factory()->create(['name' => 'Amsterdam']);
        $rotterdam = City::factory()->create(['name' => 'Rotterdam']);
        Listing::factory()->create(['city_id' => $rotterdam->id, 'title' => 'R1']);
        Listing::factory()->create(['city_id' => $amsterdam->id, 'title' => 'A1']);

        // ascending: Amsterdam first
        $response = $this->getJson(route('listings.index', ['sort' => 'city', 'include' => 'city', 'per_page' => 50]));
        $response->assertOk()->assertJsonPath('data.0.city.name', 'Amsterdam');

        // descending: Rotterdam first
        $response = $this->getJson(route('listings.index', ['sort' => '-city', 'include' => 'city', 'per_page' => 50]));
        $response->assertOk()->assertJsonPath('data.0.city.name', 'Rotterdam');
    }

    #[Test]
    public function it_rejects_invalid_status_filter(): void
    {
        $response = $this->getJson(route('listings.index', ['filter' => ['status' => 'invalid']]));
        $response->assertStatus(422);
    }

    #[Test]
    public function it_rejects_invalid_pagination_params(): void
    {
        // per_page must be integer within bounds
        $this->getJson(route('listings.index', ['per_page' => 'foo']))->assertStatus(422);
        $this->getJson(route('listings.index', ['per_page' => 0]))->assertStatus(422);
        $this->getJson(route('listings.index', ['per_page' => 101]))->assertStatus(422);

        // page must be integer >= 1
        $this->getJson(route('listings.index', ['page' => 'bar']))->assertStatus(422);
        $this->getJson(route('listings.index', ['page' => 0]))->assertStatus(422);
    }

    #[Test]
    public function it_returns_empty_for_out_of_range_page(): void
    {
        Listing::factory()->count(10)->create();

        $response = $this->getJson(route('listings.index', ['per_page' => 5, 'page' => 999]));
        $response->assertOk()
            ->assertJsonCount(0, 'data');
    }

    #[Test]
    public function index_resource_contains_image_path_and_url(): void
    {
        $listing = Listing::factory()->create(['image' => 'test-image.png']);

        $response = $this->getJson(route('listings.index', ['per_page' => 50]));
        $response->assertOk()
            ->assertJson(fn ($json) => $json
                ->whereType('data.0.image_path', 'string')
                ->where('data.0.url', route('listings.show', $listing))
                ->etc()
            );

        $imagePath = $response->json('data.0.image_path');
        $this->assertIsString($imagePath);
        $this->assertStringEndsWith('test-image.png', $imagePath);
    }
}
