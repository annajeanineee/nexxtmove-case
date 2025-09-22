<?php

declare(strict_types=1);

namespace App\Enums\Listing;

enum Status: string
{
    case AVAILABLE = 'available';
    case SOLD = 'sold';
    case PENDING = 'pending';
}
