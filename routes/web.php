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
    Route::get('/products/filter/{filter_by}', 'ProductController@filter')->name('client.products.filter');
    Route::get('/product/{id}', 'ProductController@detail')->name('client.products.detail');
    Route::get('/category/{id}', 'CategoryController@detail')->name('client.category.detail');
    Route::get('/category/{id}/filter/{filter_by}', 'CategoryController@filter')->name('client.category.filter');
    Route::get('/carts', 'CartController@index')->name('client.cart.index');
    Route::get('/add-to-cart/{id}', 'CartController@addToCart')->name('client.cart.add');
    Route::get('/increase-one/{id}', 'CartController@increaseOne')->name('client.cart.increase');
    Route::get('/reduce-one/{id}', 'CartController@reduceByOne')->name('client.cart.reduce');
    Route::get('/remove/{id}', 'CartController@removeItem')->name('client.cart.remove');
});
