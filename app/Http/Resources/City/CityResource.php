<?php

declare(strict_types=1);

namespace App\Http\Resources\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class CityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'name' => $this->resource->name,
            'country' => $this->resource->country,
        ];
    }
}
