<?php

declare(strict_types=1);

use App\Http\Controllers\Listing;
use Illuminate\Support\Facades\Route;

Route::prefix('listings')->name('listings.')->group(callback: function (): void {
    Route::get('/', Listing\Index::class)->name('index');
    Route::get('/{listing}', Listing\Show::class)->name('show');
});
