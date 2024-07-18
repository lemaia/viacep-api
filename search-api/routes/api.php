<?php

use App\Http\Controllers\SearchZipController;
use Illuminate\Support\Facades\Route;

Route::get('/search/local/{zips}', SearchZipController::class);
