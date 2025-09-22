<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasHashids;
use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $country
 *
 * @method static CityFactory factory()
 */
class City extends Model
{
    /** @use HasFactory<CityFactory> */
    use HasFactory, HasHashids;

    protected $fillable = [
        'name',
        'country',
    ];

    /**
     * @return HasMany<Listing, $this>
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
