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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', '\App\Http\Controllers\AuthController@authenticate');
    Route::post('register', '\App\Http\Controllers\AuthController@register');
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('users/{id}', '\App\Http\Controllers\AuthController@getusers');
        Route::put('edit/{id}', '\App\Http\Controllers\AuthController@edit');
        Route::get('logout', '\App\Http\Controllers\AuthController@logout');
        Route::resource('solicitud', '\App\Http\Controllers\TareasController');
        Route::get('solicitud/edit/{id}', '\App\Http\Controllers\TareasController@edit');
    });
});
