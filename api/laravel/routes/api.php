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

// ->middleware('check.cookie');
Route::get('/posts', 'PostController@index');

Route::post('/auth', 'LoginController@authenticate');
Route::post('/upload', 'PostController@store');

// ->middleware('check.cookie')


