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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();
Route::apiResource('business', 'BusinessController');
Route::apiResource('category', 'CategoryController');

Route::post('/image/{business}', 'ImageController@store');
Route::put('/image/{image}', 'ImageController@update');
