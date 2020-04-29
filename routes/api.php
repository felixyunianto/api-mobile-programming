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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('user', 'API\UserController@index');

Route::get('shop', 'API\StoreController@index');
Route::post('shop', 'API\StoreController@store');
Route::get('shop/{id}', 'API\StoreController@show');
Route::put('shop/{id}', 'API\StoreController@update');
Route::delete('shop/{id}', 'API\StoreController@destroy');