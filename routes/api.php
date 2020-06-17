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
//
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function () {

    Route::resource('users', 'UserController')
        ->middleware('auth:api')
        ->only(['show','destroy','edit','update','index']);

    Route::resource('tasks', 'TaskController')->middleware('auth:api');
    Route::put('tasks/{task}/status', 'TaskController@changeStatus')->middleware('auth:api');

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'RegisterController');
        Route::post('login', 'LoginController');
        Route::post('logout', 'LogoutController')->middleware('auth:api');

    });

});
