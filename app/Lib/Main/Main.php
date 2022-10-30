<?php

use App\Lib\Main\Factories\Apis\Auth\AuthApiFactory;
use Illuminate\Support\Facades\Route;

Route::post("/auth", [AuthApiFactory::class, 'makeAuthApi']);