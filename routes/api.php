<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*php
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


Route::apiResources(['user' => 'App\Http\Controllers\API\UserController']);
Route::apiResources(['buses' => 'App\Http\Controllers\API\BusController']);
Route::get('profile','App\Http\Controllers\API\UserController@profile');
Route::put('profile','App\Http\Controllers\API\UserController@updateprofile');
