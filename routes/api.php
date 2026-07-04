<?php

use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('articles', ArticleController::class)
        ->only(['index', 'show']);
    Route::apiResource('preferences', UserPreferenceController::class)
        ->only(['update', 'show'])
        ->middleware('auth:sanctum');
});