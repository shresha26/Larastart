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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login','App\Http\Controllers\API\Authcontroller@login');
// Route::post('register','App\Http\Controllers\API\AuthController@register');
// Route::get('logout','Api\AuthController@logout');
//Route::get('save_user_info','Api\AuthController@saveUserInfo')->middleware('jwtAuth');

Route::get('usersList','App\Http\Controllers\API\TransactionController@usersList');
Route::get('userTypeList','App\Http\Controllers\API\UserController@userTypeList');
Route::apiResources(['user' => 'App\Http\Controllers\API\UserController']);
Route::apiResources(['buses' => 'App\Http\Controllers\API\BusController']);
Route::apiResources(['driver' => 'App\Http\Controllers\API\BusdriverlistController']);
Route::apiResources(['transactions' => 'App\Http\Controllers\API\TransactionController']);
//Route::apiResources(['buses.driver' => 'App\Http\Controllers\API\BusdriverlistController']);
Route::get('profile','App\Http\Controllers\API\UserController@profile');
Route::put('profile','App\Http\Controllers\API\UserController@updateprofile');
