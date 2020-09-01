<?php

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

Route::get('/', 'HomeController@index');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/{slug}', 'HomeController@pages')->name('pages.pages');
Route::get('/pages/anons/{id}', 'HomeController@anons')->name('post.anons');
Route::get('/pages/allposts', 'AllPostsController@index');
Route::post('/pages/register', 'AuthController@register')->name('register');
Route::post('/pages/login', 'AuthController@login')->name('login');
Route::get('/pages/logout', 'AuthController@logout');
Route::get('/pages/calculator', 'CalcController@index');
Route::get('/pages/calculator/pdf-create/{id}','CalcController@create_pdf');
Route::get('/pages/calculator/score-pdf-create/{id}','CalcController@create_score_pdf');
Route::get('/pages/calculator/registry-pdf-create/{id}','CalcController@create_registry_pdf');

Route::group(['prefix'=>'page', 'namespace'=>'Admin', 'middleware'=>'admin'], function (){
    Route::get('/admin', 'DashboardController@index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/categories_doc', 'CategoryDocController');
    Route::resource('/pages', 'PagesController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/anonses', 'AnonsesController');
    Route::resource('/users', 'UserController');
    Route::resource('/documents', 'DocumentsController');
});

Route::group([ 'middleware'=>'role'], function (){
    Route::get('/pages/cabinet', 'CategoryDocController@index');
    Route::get('/documents/{id}', 'DocumentsController@index')->name('doc.show');
});


