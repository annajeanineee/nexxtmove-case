<?php

declare(strict_types=1);

namespace App\Http\Resources\Listing;

use App\Http\Resources\City\CityResource;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Listing
 */
class ShowResource extends JsonResource
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
            'image_path' => Storage::url($this->resource->image),
            'status' => $this->resource->status,
            'city' => $this->whenLoaded('city', CityResource::make($this->resource->city)),
        ];
    }
}
