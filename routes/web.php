<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'IndexController@index')->name('home');

Route::get('email/verify/{user}/{hash}', 'AuthController@verify')->name('auth.verification.verify');

Route::group(['middleware' => ['auth']], function () {
    Route::get('email/verified', 'AuthController@verified')->name('auth.verification.verified');
});
