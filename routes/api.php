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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::group([
    'namespace' => 'Auth',
    'prefix' => 'auth'
], function () {
    Route::post('/regist', 'RegisterController@register');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
    Route::post('/get-curr-user', 'LoginController@getAuthUser');
});


Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend/product'
], function () {
    Route::post('/get-list', 'ProductsController@getAll');
    Route::post('/get-one', 'ProductsController@getOne');
    Route::post('/create', 'ProductsController@create');
    Route::post('/update', 'ProductsController@update');
    Route::post('/delete', 'ProductsController@delete');
});

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend/category'
], function () {
    Route::post('/get-list', 'CategoriesController@getAll');
    Route::post('/get-one', 'CategoriesController@getOne');
    Route::post('/create', 'CategoriesController@create');
    Route::post('/update', 'CategoriesController@update');
    Route::post('/delete', 'CategoriesController@delete');
});


Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend/promotion'
], function () {
    Route::post('/get-list', 'PromotionsController@getAll');

    Route::post('/get-product-list', 'PromotionsController@getProductsList');
    Route::post('/get-product', 'PromotionsController@getProduct');
    Route::post('/add-product', 'PromotionsController@addProduct');
    Route::post('/update-product', 'PromotionsController@addProduct');
    Route::post('/delete-product', 'PromotionsController@deleteProduct');

    Route::post('/get-one', 'PromotionsController@getOne');
    Route::post('/create', 'PromotionsController@create');
    Route::post('/update', 'PromotionsController@update');
    Route::post('/delete', 'PromotionsController@delete');
});

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend/order'
], function () {
    Route::post('/get-list', 'OrdersController@getList');
    Route::post('/get-one', 'OrdersController@getOne');
    Route::post('/set-products', 'OrdersController@setProducts');
    Route::post('/update', 'OrdersController@update');
    Route::post('/delete', 'OrdersController@delete');
});

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend/param'
], function () {
    Route::post('/get-list', 'ParamsController@getList');
    Route::post('/get-one', 'ParamsController@getOne');
    Route::post('/create', 'ParamsController@create');
    Route::post('/set-values', 'ParamsController@setValues');
    Route::post('/update', 'ParamsController@update');
    Route::post('/delete', 'ParamsController@delete');
});

Route::group([
    'prefix' => '/product'
], function () {
    Route::post('/get-list', 'ProductsController@getAll');
    Route::post('/get-one', 'ProductsController@getOne');
});