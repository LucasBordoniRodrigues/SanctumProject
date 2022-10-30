<?php

use Illuminate\Support\Facades\Route;

use App\Lib\Main\Factories\Apis\Auth\AuthApiFactory;

Route::post("/auth", [AuthApiFactory::class, 'makeAuthApi']);