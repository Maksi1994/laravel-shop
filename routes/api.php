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
    'prefix' => 'backend'
], function () {
    Route::post('/get-product-list', 'ProductsController@getAll');
    Route::post('/get-product', 'ProductsController@getOne');
    Route::post('/create-product', 'ProductsController@createProduct');
    Route::post('/update-product', 'ProductsController@updateProduct');
    Route::post('/delete-product', 'ProductsController@deleteProduct');
});
