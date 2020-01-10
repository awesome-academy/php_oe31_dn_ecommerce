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
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@index')->name('client.login.get');
    Route::post('/login', 'LoginController@login')->name('client.login.post');
    Route::get('/logout', 'LoginController@logout')->name('client.logout');
    Route::get('/register', 'RegisterController@index')->name('client.register.get');
    Route::post('/register', 'RegisterController@create')->name('client.register.post');
});

Route::group(['namespace' => 'Client'], function () {
    Route::get('/', 'HomeController@index')->name('client.home.index');
    Route::get('/products', 'ProductController@index')->name('client.products.index');
    Route::get('/products/filter', 'ProductController@filter')->name('client.products.filter');
    Route::get('/product/{id}', 'ProductController@detail')->name('client.products.detail');
});
