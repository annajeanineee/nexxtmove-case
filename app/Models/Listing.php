<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Listing\Status;
use App\Models\Traits\HasHashids;
use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property int $price
 * @property City $city
 * @property Status $status
 * @property string $image
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
        'city',
        'status',
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
}
