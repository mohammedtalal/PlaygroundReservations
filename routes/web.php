<?php


Route::Auth();
Auth::routes();

/*================ Start Dashboard Routes  ================*/
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', ['as' => 'dashboard','uses' => 'IndexController@index']);
	Route::get('/dashboard', ['as' => 'dashboard','uses' => 'IndexController@index']);
});
/*================ End Dashboard Routes  ================*/




Route::get('/home', 'HomeController@index')->name('home');

Route::get('users','UserController@index')->name('users');
