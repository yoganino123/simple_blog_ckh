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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('category')->group(function () {
        Route::post('/', 'CategoryController@store');
        Route::put('/{id}', 'CategoryController@update');
        Route::delete('/{id}', 'CategoryController@delete');
    }); 

    Route::prefix('news')->group(function(){
        Route::post('/', 'NewsController@store');
        Route::put('/{id}', 'NewsController@update');
        Route::delete('/{id}', 'NewsController@delete');
    
    });

});

Route::post('/login', 'UserController@login');
Route::post('/registrasi', 'UserController@registrasi');

Route::prefix('category')->group(function () {
    Route::get('/', 'CategoryController@get');
    Route::get('/{id}', 'CategoryController@get');
   
});

Route::prefix('news')->group(function(){
    Route::get('/', 'NewsController@get');
    Route::get('/{id}', 'NewsController@get');
    

});


