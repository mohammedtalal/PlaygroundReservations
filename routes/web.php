<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::Auth();
Auth::routes();

/*================ Start Dashboard Routes  ================*/
Route::group(['middleware' => 'auth:web'], function () {
	// Route::get('/', ['as' => 'dashboard','uses' => 'IndexController@index']);
	Route::get('/dashboard', ['as' => 'dashboard','uses' => 'IndexController@index']);


	/*==================== Users Routes ====================*/
	Route::get('admin/users','UserController@index')->name('users.index');
	Route::get('admin/user/{id}/view','UserController@view')->name('users.view');
	Route::get('admin/user/create','UserController@create')->name('users.create');
	Route::post('admin/user/store','UserController@store')->name('users.store');
	Route::get('admin/user/{id}/edit','UserController@edit')->name('users.edit');
	Route::post('admin/user/{id}/update','UserController@update')->name('users.update');
	Route::delete('admin/user/{id}/destroy','UserController@destroy')->name('users.destroy');

	/*==================== Playgrounds Routes ====================*/
	Route::get('admin/PL','PlaygroundController@index')->name('playgrounds.index')->middleware('role:admin');
	Route::get('admin/PL/{id}/view','PlaygroundController@view')->name('playgrounds.view');
	Route::get('admin/PL/create','PlaygroundController@create')->name('playgrounds.create')->middleware('role:admin');
	Route::post('admin/PL/store','PlaygroundController@store')->name('playgrounds.store')->middleware('role:admin');
	Route::get('admin/PL/{id}/edit','PlaygroundController@edit')->name('playgrounds.edit');
	Route::post('admin/PL/{id}/update','PlaygroundController@update')->name('playgrounds.update');
	Route::delete('admin/PL/{id}/destroy','PlaygroundController@destroy')->name('playgrounds.destroy')->middleware('role:admin');

	// fetch owner playgrounds
	Route::get('admin/{id}/PL','PlaygroundController@ownerPlaygrounds')->name('ownerPlaygrounds.index'); 

	/*==================== Playground_Slots Routes ====================*/
	Route::get('admin/schedules','SlotController@index')->name('playgroundSlot.index');
	Route::get('admin/schedules/{id}/view','SlotController@view')->name('playgroundSlot.view');
	Route::get('admin/schedules/create','SlotController@create')->name('playgroundSlot.create');
	Route::post('admin/schedules/store','SlotController@store')->name('playgroundSlot.store');
	Route::get('admin/schedules/{id}/edit','SlotController@edit')->name('playgroundSlot.edit');
	Route::post('admin/schedules/{id}/update','SlotController@update')->name('playgroundSlot.update');
	Route::delete('admin/schedules/{id}/destroy','SlotController@destroy')->name('playgroundSlot.destroy');
});
/*================ End Dashboard Routes  ================*/



// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
// Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');


Route::get('/home', 'HomeController@index')->name('home');


