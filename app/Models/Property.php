<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'property';

    protected $fillable = [
        'address','price','city','status','description','bedrooms','bathrooms','balcony','garden'
    ];

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_UNDER_OFFER = 'under_offer';
    public const STATUS_SOLD = 'sold';
    public const STATUS_RENTED = 'rented';
}
