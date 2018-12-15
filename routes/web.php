<?php

$regexpUUID = '^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$';

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/auth0/callback', 'Auth\Auth0Controller@callback' )->name( 'auth0-callback' );
Route::get('/login', 'Auth\Auth0Controller@login' )->name( 'login' );
Route::get('/logout', 'Auth\Auth0Controller@logout' )->name( 'logout' )->middleware('auth');

/******************************************
 * SPA
 ******************************************/
Route::middleware('auth')->get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard');

Route::prefix('projects')->middleware('auth')->group(function() use ($regexpUUID) {

    Route::get('/', 'ProjectController@index');
    Route::get('/create', 'ProjectController@index');
    Route::get('/edit', 'ProjectController@index');
    Route::post('/', 'ProjectController@store');
    Route::put('/{id}', 'ProjectController@update');
    Route::delete('/{id}', 'ProjectController@destroy');

});
