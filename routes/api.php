<?php


Route::get('/allBlogs', 'Api\NewsApiController@allBlogs');
Route::get('/blog/{id}', 'Api\NewsApiController@show');

Route::get('/blogWidget', 'Api\NewsApiController@blogWidget');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});