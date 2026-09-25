<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\SubscriptionsController;

// Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('comments', CommentsController::class);
    Route::post('videos/{video}/like', [LikesController::class, 'toggle']);
    Route::post('channel/{channel}/subscription', [SubscriptionsController::class, 'toggle']);
    Route::post('videos', [VideoController::class, 'store']);
    Route::put('videos/{video}', [VideoController::class, 'update']);
    Route::delete('videos/{video}', [VideoController::class, 'destroy']);
    Route::delete('history', [HistoryController::class, 'destroy']);
    Route::get('history', [HistoryController::class, 'index']);
});

Route::get('videos', [VideoController::class, 'index']);
Route::get('videos/{video}', [VideoController::class, 'show']);
