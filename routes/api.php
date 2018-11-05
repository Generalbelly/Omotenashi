<?php

use Illuminate\Http\Request;

$regexpUUID = '^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$';

Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You dont't need any token to access."]);
});

Route::group(['middleware' => 'cors'], function() {

    Route::prefix('tutorials')->middleware('jwt')->group(function() use ($regexpUUID) {

        Route::get('/', 'API\TutorialController@index');

        Route::post('/store', 'API\TutorialController@store');
    });

});

