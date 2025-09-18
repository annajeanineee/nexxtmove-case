<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'show']);


