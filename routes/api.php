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
    'prefix' => 'users'
], function () {
    Route::post('/regist', 'UserController@regist');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout')->middleware('auth:api');
    Route::post('/get-auth-user', 'UserController@getAuthUser')->middleware('auth:api');
    Route::post('/get-all-roles', 'UserController@getAllRoles');
});

Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend',
    'middleware' => ['auth:api', 'user:admin']
], function () {

  Route::prefix('/products')->group(function () {

    Route::post('/get-list', 'ProductsController@getAll');
    Route::post('/get-one', 'ProductsController@getOne');
    Route::post('/create', 'ProductsController@create');
    Route::post('/update', 'ProductsController@update');
    Route::post('/delete', 'ProductsController@delete');
  });

  Route::prefix('/categories')->group(function () {

      Route::post('/get-list', 'CategoriesController@getAll');
      Route::post('/get-one', 'CategoriesController@getOne');
      Route::post('/create', 'CategoriesController@create');
      Route::post('/update', 'CategoriesController@update');
      Route::post('/delete', 'CategoriesController@delete');
  });


  Route::prefix('/promotions')->group(function () {

      Route::post('/get-list', 'PromotionsController@getList');
      Route::post('/get-one', 'PromotionsController@getOne');
      Route::post('/create', 'PromotionsController@create');
      Route::post('/update', 'PromotionsController@update');
      Route::post('/delete', 'PromotionsController@delete');

      Route::post('/get-product-list', 'PromotionsController@getProductsList');
      Route::post('/add-product', 'PromotionsController@addProduct');
      Route::post('/delete-product', 'PromotionsController@deleteProduct');
      Route::post('/delete-all-products', 'PromotionsController@removeAllProducts');
  });


  Route::prefix('/orders')->group(function () {

      Route::post('/get-list', 'OrdersController@getList');
      Route::post('/get-one', 'OrdersController@getOne');
      Route::post('/update', 'OrdersController@update');
      Route::post('/delete', 'OrdersController@delete');
  });

  Route::prefix('/params')->group(function () {

      Route::post('/get-list', 'ParamsController@getList');
      Route::post('/get-one', 'ParamsController@getOne');
      Route::post('/create', 'ParamsController@create');
      Route::post('/set-values', 'ParamsController@setValues');
      Route::post('/update', 'ParamsController@update');
      Route::post('/delete', 'ParamsController@delete');
  });

    Route::prefix('/users')->group(function () {
        
        Route::post('/get-list', 'UsersController@getList');
        Route::post('/get-one', 'UsersController@getOne');
        Route::post('/toggle-block', 'UsersController@toggleBlock');
        Route::post('/delete', 'UsersController@delete');
    });

});

Route::group([
    'prefix' => '/product'
], function () {
    Route::post('/get-list', 'ProductsController@getAll');
    Route::post('/get-one', 'ProductsController@getOne');
    Route::post('/get-most-popular', 'ProductsController@getMostPopular');
    Route::post('/get-last-added', 'ProductsController@getLastAdded');
});


Route::group([
    'prefix' => '/order'
], function () {
    Route::post('/get-list', 'OrdersController@getList');
    Route::post('/create', 'OrdersController@create');
    Route::post('/get-one', 'OrdersController@getOne');
    Route::post('/delete', 'OrdersController@delete');
});

Route::group([
    'prefix' => '/promotions'
], function () {
    Route::post('/get-products-by-promotion', 'PromotionsController@getProductsByPromotion');
    Route::post('/get-last-products', 'PromotionsController@getLastProducts');
});

Route::group([
    'prefix' => '/comments'
], function () {
    Route::post('/create', 'CommentsController@create')->middleware('auth:api');
    Route::post('/update', 'CommentsController@update')->middleware('auth:api');
    Route::post('/delete', 'CommentsController@delete')->middleware('auth:api');
    Route::post('/get-product-comments', 'CommentsController@getProductComments');
    Route::post('/get-all-my-comments', 'CommentsController@getAllMyComments')->middleware('auth:api');
});

Route::group([
    'prefix' => '/baskets',
    'middleware' => ['auth:api']
], function () {
    Route::post('/get-basket', 'BasketsController@getBasket');
    Route::post('/save-basket', 'BasketsController@saveBasket');
    Route::post('/delete', 'BasketsController@delete');
});
