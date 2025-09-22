<?php

declare(strict_types=1);

namespace App\Http\Controllers\Listing;

use App\Http\Requests\Listing\IndexRequest;
use App\Http\Resources\Listing\IndexResource;
use App\Models\Listing;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Index
{
    public function __invoke(IndexRequest $request): ResourceCollection
    {
        $properties = QueryBuilder::for(Listing::class)
            ->allowedFilters([
                'status',
                AllowedFilter::callback('city', static function ($query, $value): void {
                    if ($value !== null && $value !== '') {
                        $query->whereHas('city', static function ($query) use ($value): void {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                    }
                }),
                AllowedFilter::callback('price_min', static function ($query, $value): void {
                    if ($value !== null && $value !== '') {
                        $query->where('price', '>=', (int) $value);
                    }
                }),
                AllowedFilter::callback('price_max', static function ($query, $value): void {
                    if ($value !== null && $value !== '') {
                        $query->where('price', '<=', (int) $value);
                    }
                }),
            ])
            ->allowedIncludes('city')
            ->get();

        return IndexResource::collection($properties);
    }
}
