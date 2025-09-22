<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Listing\Status;
use App\Models\Traits\HasHashids;
use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property int $price
 * @property int $city_id
 * @property City $city
 * @property Status $status
 * @property string $image
 * @property string $street
 * @property int $house_number
 * @property ?string $house_number_addition
 * @property string $postal_code
 * @property-read string $address
 *
 * @method static ListingFactory factory()
 */
class Listing extends Model
{
    /** @use HasFactory<ListingFactory> @ */
    use HasFactory, HasHashids;

    protected $fillable = [
        'title',
        'price',
        'price_currency',
        'description',
        'image',
        'city_id',
        'status',
        'street',
        'house_number',
        'house_number_addition',
        'postal_code',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return Attribute<string, never>
     */
    public function address(): Attribute
    {
        return Attribute::get(fn (): string => implode(', ', array_filter(
                [
                    trim($this->street . ' ' . $this->house_number . ($this->house_number_addition ?? '')),
                    $this->postal_code,
                    optional($this->city)->name,
                ],
                static fn ($part): bool => $part !== null && $part !== '')
            ));
    }
}
