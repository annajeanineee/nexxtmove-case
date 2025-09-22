<?php

declare(strict_types=1);

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Http\Resources\Listing\ShowResource;
use App\Models\Listing;

class Show extends Controller
{
    public function __invoke(Listing $listing): ShowResource
    {
        return ShowResource::make($listing);
    }
}
