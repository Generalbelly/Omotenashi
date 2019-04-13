<?php

$regexpUUID = '^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$';

Route::get('/', function () {
    if(Auth::check()) {
        return redirect()->route('dashboard');
    }
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

    Route::get('/', 'ProjectController@index')
        ->name('projects.index');
    Route::get('/create', 'ProjectController@create')
        ->name('projects.create');
    Route::get('/{id}', 'ProjectController@show')
        ->name('projects.show');
//    Route::get('/{id}/edit', 'ProjectController@edit')
//        ->name('projects.edit');
    Route::post('/', 'ProjectController@store')
        ->name('projects.store');
    Route::put('/{id}', 'ProjectController@update')
        ->name('projects.update');
    Route::delete('/{id}', 'ProjectController@destroy')
        ->name('projects.destroy');


    // Tutorials
    Route::get('/{projectId}/tutorials', 'TutorialController@index')
        ->name('tutorials.index');
    Route::get('/{projectId}/tutorials/create', 'TutorialController@create')
        ->name('tutorials.create');
    Route::get('/{projectId}/tutorials/redirect', 'TutorialController@redirect')
        ->name('tutorials.redirect');
    Route::get('/{projectId}/tutorials/{id}', 'TutorialController@show')
        ->name('tutorials.show');
    Route::put('/{projectId}/tutorials/{id}', 'TutorialController@update')
        ->name('tutorials.update');
    Route::delete('/{projectId}/tutorials/{id}', 'TutorialController@destroy')
        ->name('tutorials.destroy');

});

Route::prefix('oauths')->middleware('auth')->group(function() use ($regexpUUID){

    Route::get('/google-analytics/redirect', 'OAuthController@googleAnalyticsRedirect')
        ->name('oauths.google-analytics.redirect');
    Route::delete('/{id}', 'OAuthController@destroy')
        ->name('oauths.destroy');

});

Route::get('/oauths/google-analytics/callback', 'OAuthController@googleAnalyticsCallback')
    ->name('oauths.google-analytics.callback');


Route::prefix('tags')->middleware('auth')->group(function() use ($regexpUUID){
    Route::get('{id}', 'TagController@show')
        ->name('tags.show');
});

Route::prefix('google-analytics')->middleware('auth')->group(function() use ($regexpUUID){

    Route::get('/{project_id}', 'GoogleAnalyticsController@index')
        ->name('google-analytics.index');

});
