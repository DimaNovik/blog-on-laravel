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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/notary_actions', 'CalcController@actions');
Route::get('/notary_services/{id}', 'CalcController@services');
Route::get('/notary_service_price/{id}', 'CalcController@price');
Route::post('/notary_order', 'CalcController@create');
Route::get('/notary_order_user/{id}', 'CalcController@orders');