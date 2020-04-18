<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => ['auth:api']], function () {

    // Users API
    Route::group(['prefix' => 'user', 'name' => 'user.', 'namespace' => 'User'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@update');

        Route::get('/orders', 'OrderController@index');
        Route::post('/orders', 'OrderController@store');
        Route::get('/orders/{order}', 'OrderController@show');
        Route::post('/orders/{order}', 'OrderController@update');
//        Route::post('/orders/{order}/delete', 'OrderController@destroy');
    });

    // Charity Users API
    Route::group(['prefix' => 'charity', 'name' => 'charity.', 'namespace' => 'Charity'], function () {
        Route::get('/orders', 'OrderController@index');
        Route::get('/profile', 'CharityController@index');
        Route::post('/profile', 'CharityController@update');
    });

    // Collection Point Users API
    Route::group(['prefix' => 'collection-point', 'name' => 'collection-point.', 'namespace' => 'CollectionPoint'], function () {
        Route::get('/orders', 'OrderController@index');
        Route::get('/profile', 'CollectionPointController@index');
        Route::post('/profile', 'CollectionPointController@update');
    });

    Route::get('logout', 'AuthController@logout');
});
