<?php

use App\Http\Controllers\QuoteController;
use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiTokenMiddleware::class)->group(function () {
    // Routes to get quotes
    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::get('/quotes/refresh', [QuoteController::class, 'refresh']);
});
