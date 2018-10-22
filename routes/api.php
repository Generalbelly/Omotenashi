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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You dont't need any token to access."]);
});

Route::middleware('jwt')->get('/private', function (Request $request) {
    return response()->json(["message" => "Access token is valid. Welcome to this private endpoint."]);
});
