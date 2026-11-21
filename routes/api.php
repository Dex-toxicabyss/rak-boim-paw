<?php

use App\Http\Controllers\Api\PublicStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/services', [PublicStatusController::class, 'services']);
    Route::get('/storages/track', [PublicStatusController::class, 'track']);
});
