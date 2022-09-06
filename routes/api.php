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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'public'], function () {
    Route::group(['prefix' => 'publicaciones'], function () {
        Route::get('', 'App\Http\Controllers\PublicacionController@create');
    });
});
Route::group(['prefix' => 'users'], function () {
    Route::post('login', 'App\Http\Controllers\UserController@login');
    Route::get('loginverify', 'App\Http\Controllers\UserController@loginverify');
});
// Route::group(['prefix'=>'admin','middleware' => 'auth:api'],function(){
Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'categoria'], function () {
        Route::post('', 'App\Http\Controllers\CategoriaProductoController@create');
        Route::get('', 'App\Http\Controllers\CategoriaProductoController@getAll');
        Route::get('/{id}', 'App\Http\Controllers\CategoriaProductoController@getOne');
        Route::put('/{id}', 'App\Http\Controllers\CategoriaProductoController@update');
        Route::delete('/{id}', 'App\Http\Controllers\CategoriaProductoController@destroy');
        Route::get('restore/{id}', 'App\Http\Controllers\CategoriaProductoController@restore');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::post('', 'App\Http\Controllers\UserController@register');
        Route::get('', 'App\Http\Controllers\UserController@getAll');
        Route::post('login', 'App\Http\Controllers\UserController@login');
        Route::get('/{id}', 'App\Http\Controllers\UserController@getOne');
        Route::put('/{id}', 'App\Http\Controllers\UserController@update');
        Route::delete('/{id}', 'App\Http\Controllers\UserController@destroy');
    });
    Route::group(['prefix' => 'producto'], function () {
        Route::post('', 'App\Http\Controllers\ProductoController@create');
        Route::get('', 'App\Http\Controllers\ProductoController@getAll');
        Route::get('not_in_publications', 'App\Http\Controllers\ProductoController@getAllNotInPublication');
        Route::get('in_publications', 'App\Http\Controllers\ProductoController@getAllInPublication');
        Route::get('/{id}', 'App\Http\Controllers\ProductoController@getOne');
        Route::post('update/{id}', 'App\Http\Controllers\ProductoController@update');
        Route::delete('/{id}', 'App\Http\Controllers\ProductoController@destroy');
    });
    Route::group(['prefix' => 'producto-precio'], function () {
        Route::post('', 'App\Http\Controllers\ProductoController@create');
        Route::get('', 'App\Http\Controllers\ProductoController@getAll');
        Route::get('/{id}', 'App\Http\Controllers\ProductoController@getOne');
        Route::put('/{id}', 'App\Http\Controllers\ProductoController@update');
        Route::delete('/{id}', 'App\Http\Controllers\ProductoController@destroy');
    });
    Route::group(['prefix' => 'producto-imagen'], function () {
        Route::post('', 'App\Http\Controllers\ProductoController@create');
        Route::get('', 'App\Http\Controllers\ProductoController@getAll');
        Route::get('/{id}', 'App\Http\Controllers\ProductoController@getOne');
        Route::put('/{id}', 'App\Http\Controllers\ProductoController@update');
        Route::delete('/{id}', 'App\Http\Controllers\ProductoController@destroy');
    });
    Route::group(['prefix' => 'publicacion'], function () {
        Route::post('', 'App\Http\Controllers\PublicacionController@create');
        Route::get('', 'App\Http\Controllers\PublicacionController@getAll');
        Route::get('/{id}', 'App\Http\Controllers\PublicacionController@getOne');
        Route::put('/{id}', 'App\Http\Controllers\PublicacionController@update');
        Route::delete('/{id}', 'App\Http\Controllers\PublicacionController@destroy');
    });
});
