<?php

use Illuminate\Support\Facades\Route;
use App\Lib\Main\Factories\Apis\Auth\AuthApiFactory;

/**
 * Authenticate a user
 */

Route::post("/auth", [AuthApiFactory::class, 'makeLaravelApi']);

/**
 * Check if user is auth and can send sms
 */
Route::get("/check-auth", function () {
    return response()->json(['auth' => true]);
})->middleware(['auth:sanctum', 'abilities:send-sms']);
