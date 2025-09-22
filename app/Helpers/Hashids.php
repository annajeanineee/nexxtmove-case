<?php

declare(strict_types=1);

namespace App\Helpers;

use Sqids\Sqids;

final readonly class Hashids
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    public static function encode(int $id): string
    {
        return new Sqids(minLength: 6)->encode([$id]);
    }

    public static function decode(string $hash): int
    {
        return new Sqids()->decode($hash)[0];
    }
}
