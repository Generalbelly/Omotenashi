<?php

$regexpUUID = '^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$';

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/auth0/callback', 'Auth\Auth0Controller@callback' )->name( 'auth0-callback' );
Route::get('/login', 'Auth\Auth0Controller@login' )->name( 'login' );
Route::get('/logout', 'Auth\Auth0Controller@logout' )->name( 'logout' )->middleware('auth');

//Route::prefix('users')->middleware('auth')->group(function() use ($regexpUUID) {
//
//    Route::get('/', 'UserController@index')->name('user.index');
//
//});

/******************************************
 * SPA
 ******************************************/
Route::middleware('auth')->get('/dashboard', function() {
    return view('spa');
})->name('dashboard');
