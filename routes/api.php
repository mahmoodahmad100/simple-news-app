<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::apiResource('articles', ArticleController::class)
        ->only(['index', 'show']);
        
    Route::group(['prefix' => 'preferences', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [UserPreferenceController::class, 'get']);
        Route::put('/', [UserPreferenceController::class, 'update']);
    });
});