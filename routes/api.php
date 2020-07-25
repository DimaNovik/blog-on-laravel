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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::prefix('user')->group( function() {
//
//});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'auth:api'], static function () {
    Route::get('/notary_actions', 'CalcController@actions');
    Route::get('/notary_once_action/{id}', 'CalcController@once_action');
    Route::get('/notary_once_service/{id}', 'CalcController@once_service');
    Route::get('/notary_services/{id}', 'CalcController@services');
    Route::get('/notary_service_price/{id}', 'CalcController@price');
    Route::post('/notary_order', 'CalcController@create');
    Route::get('/notary_order_user/{id}', 'CalcController@orders');
    Route::post('/notary_order_update/{id}', 'CalcController@order_update');
});

Route::get('/notary_groups', 'CalcController@get_notary_groups');

// for calc users
Route::post('user/login', 'AuthCalcController@login')->name('login');
Route::post('/register', 'AuthCalcController@register');
