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

// Unauthenticated
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('forgot-password', 'PasswordResetController@index');

// Authenticated
Route::group(['middleware' => ['auth:api']], function () {

    // Users API
    Route::group(['prefix' => 'user', 'name' => 'user.', 'namespace' => 'User'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@update');

        Route::get('/orders', 'OrderController@index');
        Route::post('/orders', 'OrderController@store');
        Route::get('/orders/check', 'OrderController@check');
        Route::get('/orders/today', 'OrderController@today');
        Route::get('/orders/{order}', 'OrderController@show');
        Route::post('/orders/{order}', 'OrderController@update');
    });

    // Charity Users API
    Route::group(['prefix' => 'charity', 'name' => 'charity.', 'namespace' => 'Charity'], function () {
        Route::get('/', 'CharityController@index');
        Route::post('/', 'CharityController@update');

        Route::get('/orders', 'OrderController@index');
    });

    // Collection Point Users API
    Route::group(['prefix' => 'collection-point', 'name' => 'collection-point.', 'namespace' => 'CollectionPoint'], function () {
        Route::get('/', 'CollectionPointController@index');
        Route::post('/', 'CollectionPointController@update');

        Route::get('/orders', 'OrderController@index');
    });

    Route::get('/charities', 'CharityController@index');
    Route::get('/collection-points/near-me', 'CollectionPointController@indexNearMe');
    Route::get('/collection-points/{id}', 'CollectionPointController@show');
    Route::get('/collection-points', 'CollectionPointController@index');

    Route::post('logout', 'AuthController@logout');
});
