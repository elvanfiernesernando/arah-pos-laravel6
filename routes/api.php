<?php

use Illuminate\Http\Request;

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

// Route::post('login', 'ApiController@login');
// Route::post('register', 'ApiController@register');

// Route::group(['middleware' => 'auth:api'], function(){
//     Route::post('details', 'ApiController@details');
//     Route::get('products', 'ApiController@getProducts');
// });

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::post('products', 'Api\TransactionController@getProducts');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/detail', 'Api\UserController@details');
    Route::post('logout', 'Api\UserController@logout');
});
