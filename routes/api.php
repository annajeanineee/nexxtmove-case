<?php

use Illuminate\Support\Facades\Route;

Route::get('/properties', function () {
    return response()->json([
        'data' => [],
        'meta' => ['total' => 0],
    ]);
});
