<?php

use App\Lib\Data\Usecases\OAuthAuthentication;
use App\Lib\Infra\OAuth\OAuthAdapter;
use App\Lib\Presentation\Presenters\AuthPresenter;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthPresenter::class)->group(function () {
    Route::get('/auth', 'auth');
});
