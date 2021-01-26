<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => 'API\UserController'
]);

/**
 * Client ID: 1
 * Client secret: dPxrujaWPUFMM8zW4mFQCQnf5awOz7SPZ9O1aPjU
 * Password grant client created successfully.
 * Client ID: 2
 * Client secret: GRrlwI4EMy2BnenBrhFwJRjX0OKibrToAZ2yK4vk
 */