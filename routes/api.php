<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'auth:api'], function () {

});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
 
Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('playgrounds','Api\PlaygroundController@index');
	/*
		id 	=> user id

	 */
	Route::get('{id}/playgrounds','Api\PlaygroundController@show');
	Route::get('token','Api\PlaygroundController@token');
    Route::get('logout', 'Api\AuthController@logout');

    // post request by sending $date to fetch (available, unavailable) hours 
	Route::post('playground/{id}/available','Api\PlaygroundController@getChecked');
	Route::post('playground/{id}/unavailable','Api\PlaygroundController@getNonChecked');


	/* ==================== Reservations Routes ==========================*/
	Route::get('admin/reservations','Api\ReservationController@index');
	Route::get('admin/reservation/create','Api\ReservationController@create');
	Route::post('admin/reservation/store','Api\ReservationController@store');


	/* ==================== normal user routes ==========================*/
	Route::get('playgrounds','Api\NormalUserController@index')->middleware('role:user');
	Route::get('playground/{id}','Api\NormalUserController@view')->middleware('role:user');
	Route::post('playground/{id}/available','Api\NormalUserController@available')->middleware('role:user'); // post requet date
	Route::post('playground/{id}/reserve','Api\NormalUserController@reserve')->name('playground.reserve')->middleware('role:user');


	/*============================  Normal User Reservation Paypal routes =============================*/
	// Route::get('reservation/online','ReservationController@getPaypal')->name('reservation.getPaypal');
	// Route::post('admin/reservation/paypal','ReservationController@postPaypal')->name('reservation.postPaypal');
	// Route::get('admin/reservation/status','ReservationController@getPaymentStatus')->name('reservation.status');
	/*============================= End Paypal routes ===========================*/

});
