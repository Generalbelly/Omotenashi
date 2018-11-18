<?php

use Illuminate\Http\Request;

$regexpUUID = '^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$';

Route::prefix('tutorials')->middleware('jwt')->group(function() use ($regexpUUID) {

    Route::get('/', 'API\TutorialController@index');

    Route::post('/', 'API\TutorialController@store');
    Route::put('/{id}', 'API\TutorialController@update');
    Route::delete('/{id}', 'API\TutorialController@destroy');
});
