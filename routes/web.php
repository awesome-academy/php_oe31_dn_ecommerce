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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/login', 'LoginController@loginGet')->name('admin.login.get');
    Route::post('/login', 'LoginController@loginPost')->name('admin.login.post');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::group(['middleware' => ['admin-auth']], function () {
        Route::get('/', 'HomeController@index')->name('admin.home.index');
        Route::get('/statistic', 'HomeController@statistic');
        Route::get('/users', 'UserController@index')->name('admin.users.index');
        Route::get('/users/lock/{id}', 'UserController@lock')->name('admin.user.lock');
        Route::get('/users/active/{id}', 'UserController@active')->name('admin.user.active');
        Route::resource('categories', 'CategoryController');
        Route::get('category/delete/{id}', 'CategoryController@delete')->name('admin.category.delete');
        Route::resource('products', 'ProductController');
        Route::get('product/delete/{id}', 'ProductController@delete')->name('admin.product.delete');
        Route::resource('orders', 'OrderController')->except(['edit', 'destroy']);
        Route::get('/order/pending/{id}', 'OrderController@changePending')->name('admin.order.change-pending');
        Route::get('/order/success/{id}', 'OrderController@changeSuccess')->name('admin.order.change-success');
        Route::get('/order/cancel/{id}', 'OrderController@changeCancel')->name('admin.order.change-cancel');
        Route::get('/order/delete/{id}', 'OrderController@delete')->name('admin.order.delete');
        Route::resource('suggests', 'SuggestController')->only('index');
        Route::get('/suggest/delete/{id}', 'SuggestController@delete')->name('admin.suggest.delete');
    });
});

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
    Route::get('/product/comment', 'ProductController@comment')->name('client.products.comment');
    Route::post('/product/comment/{id}', 'ProductController@comment')->name('client.products.comment');
    Route::post('/product/rating/{id}', 'ProductController@rating')->name('client.products.rating');
    Route::get('/suggest', 'SuggestController@suggestGet')->name('client.suggest.get');
    Route::post('/suggest', 'SuggestController@suggestPost')->name('client.suggest.post');
    Route::get('/category/{id}', 'CategoryController@detail')->name('client.category.detail');
    Route::get('/category/{id}/filter/{filter_by}', 'CategoryController@filter')->name('client.category.filter');
    Route::get('/carts', 'CartController@index')->name('client.cart.index');
    Route::get('/add-to-cart/{id}', 'CartController@addToCart')->name('client.cart.add');
    Route::get('/increase-one/{id}', 'CartController@increaseOne')->name('client.cart.increase');
    Route::get('/reduce-one/{id}', 'CartController@reduceByOne')->name('client.cart.reduce');
    Route::get('/remove/{id}', 'CartController@removeItem')->name('client.cart.remove');
    Route::get('/orders', 'OrderController@index')->name('client.orders.index');
    Route::post('/orders', 'OrderController@create')->name('client.orders.create');
    Route::get('/orders/histories', 'OrderController@histories')->name('client.orders.histories');
    Route::get('/orders/history/{id}', 'OrderController@detail')->name('client.orders.detail');
    Route::get('/orders/history/increase-one/{id}', 'OrderController@increaseOne')->name('client.orders.increase');
    Route::get('/orders/history/reduce-one/{id}', 'OrderController@reduceOne')->name('client.orders.reduce');
    Route::get('/orders/history/remove-item/{id}', 'OrderController@removeItem')->name('client.orders.remove_item');
    Route::get('/orders/delete/{id}', 'OrderController@delete')->name('client.orders.delete');
    Route::get('/user/profile', 'UserController@profile')->name('client.user.profile');
    Route::post('/user/update', 'UserController@update')->name('client.user.update');
    Route::get('/category/{id}/filter/{filter_by}', 'CategoryController@filter')->name('client.category.filter');
    Route::get('/carts', 'CartController@index')->name('client.cart.index');
    Route::get('/add-to-cart/{id}', 'CartController@addToCart')->name('client.cart.add');
    Route::get('/increase-one/{id}', 'CartController@increaseOne')->name('client.cart.increase');
    Route::get('/reduce-one/{id}', 'CartController@reduceByOne')->name('client.cart.reduce');
    Route::get('/remove/{id}', 'CartController@removeItem')->name('client.cart.remove');
});
