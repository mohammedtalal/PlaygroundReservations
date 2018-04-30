<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::Auth();
Auth::routes();

/*================ Start Dashboard Routes  ================*/
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', ['as' => 'dashboard','uses' => 'IndexController@index']);
	Route::get('/dashboard', ['as' => 'dashboard','uses' => 'IndexController@index']);
});
/*================ End Dashboard Routes  ================*/
Route::group(['middleware' => 'auth:web'], function () {
	Route::get('admin/users','UserController@index')->name('users.index');
	Route::get('admin/user/create','UserController@create')->name('users.create');
	Route::post('admin/user/store','UserController@store')->name('users.store');
	Route::get('admin/edit/{id}','UserController@edit')->name('users.edit');
	Route::post('admin/update/{id}','UserController@update')->name('users.update');
	Route::post('admin/user/destroy','UserController@destroy')->name('users.destroy');
});

Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function () {
	
});



Route::get('/home', 'HomeController@index')->name('home');


