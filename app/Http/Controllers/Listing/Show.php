<?php

declare(strict_types=1);

namespace App\Http\Controllers\Listing;

use App\Helpers\Hashids;
use App\Http\Resources\Listing\ShowResource;
use App\Models\Listing;
use Illuminate\Http\Request;

class Show
{
    public function __invoke(Request $request, string $listingRouteKey): ShowResource
    {
        $listing = Listing::with('city')
            ->findOrFail(Hashids::decode($listingRouteKey));

        return ShowResource::make($listing);
    }
}
