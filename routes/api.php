<?php

use App\Http\Controllers\CommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\SubscriptionsController;

// Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('videos', VideoController::class);
    Route::apiResource('comments', CommentsController::class);
    Route::post('videos/{video}/like', [LikesController::class, 'toggle']);
    Route::post('channel/{channel}/subscription', [SubscriptionsController::class, 'toggle']);
});