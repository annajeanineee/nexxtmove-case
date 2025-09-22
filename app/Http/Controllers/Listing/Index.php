<?php

declare(strict_types=1);

namespace App\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listing\IndexRequest;
use App\Http\Resources\Listing\IndexResource;
use App\Models\Listing;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class Index extends Controller
{
    public function __invoke(IndexRequest $request): ResourceCollection
    {
        $properties = QueryBuilder::for(Listing::class)
            ->allowedFilters(['city', 'status', 'price'])
            ->allowedIncludes('city')
            ->get();

        return IndexResource::collection($properties);
    }
}
