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

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::get('/products', 'ProductController@index');

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('/user/update', 'AuthController@update');

    Route::post('/products', 'ProductController@create');
    Route::get('/products/favorites', 'ProductController@favorites');
    Route::delete('/products/{product}', 'ProductController@destroy');
    Route::post('/products/{product}/favorite', 'ProductController@toggleFavorite');
});

Route::get('/products/{product}', 'ProductController@show');
