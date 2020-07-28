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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', 'AuthCalcController@login');
    Route::post('/register', 'AuthCalcController@register');
    Route::post('/me', 'AuthCalcController@me');
    Route::post('/logout', 'AuthCalcController@logout');

});

Route::group(['middleware' => 'auth'], static function () {
    Route::get('/notary_actions', 'CalcController@actions');
    Route::get('/notary_once_action/{id}', 'CalcController@once_action');
    Route::get('/notary_once_service/{id}', 'CalcController@once_service');
    Route::get('/notary_services/{id}', 'CalcController@services');
    Route::get('/notary_service_price/{id}', 'CalcController@price');
    Route::post('/notary_order', 'CalcController@create');
    Route::get('/notary_order_user/{id}', 'CalcController@orders');
    Route::post('/notary_order_update/{id}', 'CalcController@order_update');
    Route::post('/notary_price_update/{id}', 'CalcController@price_update');
    Route::get('/user_group/{id}', 'CalcController@get_user_group');
    Route::post('/service_update/{id}', 'CalcController@service_update');
});

Route::get('/notary_groups', 'CalcController@get_notary_groups');

// for calc users



