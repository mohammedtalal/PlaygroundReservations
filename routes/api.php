<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'auth:api'], function () {

});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
 
Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('playgrounds','Api\PlaygroundController@index');
	// Route::get('my-acc','Api\PlaygroundController@show');
	Route::get('{id}/playground','Api\PlaygroundController@show');
	Route::get('token','Api\PlaygroundController@token');
    Route::get('logout', 'Api\AuthController@logout');
});