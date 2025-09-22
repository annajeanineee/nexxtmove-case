<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class IndexResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'title' => $this->resource->title,
            'price' => $this->resource->price,
            'price_currency' => $this->resource->price_currency,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'image_path' => Storage::url($this->resource->image),
            'city' => $this->whenLoaded('city'),
            'url' => route('listings.show', $this->resource),
        ];
    }
}
