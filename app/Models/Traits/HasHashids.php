<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Helpers\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property int $id
 *
 * @mixin Model
 */
trait HasHashids
{
    public function getRouteKey(): string
    {
        return Hashids::encode($this->id);
    }

    public static function findByRouteKey(string $value): ?self
    {
        return self::query()->where('id', Hashids::decode($value))->first();
    }

    public static function findOrFailByRouteKey(string $value): self
    {
        $instance = self::findByRouteKey($value);

        return $instance ?? throw new ModelNotFoundException();
    }

    public function resolveRouteBinding(mixed $value, $field = null)
    {
        return $this->query()->where('id', Hashids::decode($value))->firstOrFail();
    }
}
