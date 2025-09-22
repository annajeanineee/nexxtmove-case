<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'price' => $this->resource->price,
            'price_currency' => $this->resource->price_currency,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'city' => $this->whenLoaded('city'),
            'url' => route('listings.show', $this->resource),
        ];
    }
}
