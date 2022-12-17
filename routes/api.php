<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventTypeController;
use App\Http\Controllers\API\EventController;

Route::controller(AuthController::class)->prefix('auth')->group(function() {
    Route::post('register', 'register');

    Route::post('login', 'login');
});

Route::controller(EventTypeController::class)->prefix('event-types')->group(function() {
    Route::get('/get-single/{eventType}', 'getSingle');

    Route::get('/get-time-slots/{eventType}', 'getTimeSlots');
});

Route::controller(EventController::class)->prefix('events')->group(function() {
   Route::get('get-single/{event}', 'getSingle');

   Route::post('/store', 'store');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::put('auth/update-profile', [AuthController::class, 'updateProfile']);

    Route::controller(EventTypeController::class)->prefix('event-types')->group(function() {
        Route::get('/list', 'list');

        Route::post('/store', 'store');
    });

    Route::get('events/list', [EventController::class, 'list']);
});
