<?php

declare(strict_types=1);

namespace App\Http\Controllers\Listing;

use App\Http\Requests\Listing\IndexRequest;
use App\Http\Resources\Listing\IndexResource;
use App\Models\Listing;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class Index
{
    public function __invoke(IndexRequest $request): ResourceCollection
    {
        $validated = $request->validated();
        $perPage = isset($validated['per_page']) && is_numeric($validated['per_page'])
            ? (int) $validated['per_page']
            : 12;

        $builder = QueryBuilder::for(Listing::class)
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
            ->allowedSorts([
                'price',
                AllowedSort::callback('city', static function ($query, bool $descending): void {
                    $query->leftJoin('cities', 'cities.id', '=', 'listings.city_id')
                        ->orderBy('cities.name', $descending ? 'desc' : 'asc')
                        ->select('listings.*');
                }),
            ])
            ->allowedIncludes('city');

        $includes = (string) ($validated['include'] ?? '');
        if ($includes !== '' && str_contains($includes, 'city')) {
            $builder->with('city');
        }

        $properties = $builder->paginate($perPage)->withQueryString();

        return IndexResource::collection($properties);
    }
}
