<?php

declare(strict_types=1);

namespace Feature\Controllers\Listings;

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
}
