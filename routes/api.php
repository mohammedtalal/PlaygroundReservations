<?php

use Illuminate\Http\Request;


Route::group(['middleware' => 'auth:api'], function () {

});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
 
Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('playgrounds','Api\PlaygroundController@index');

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
	Route::get('user/PLS','Api\NormalUserController@index')->middleware('role:user');
	Route::post('user/PL','Api\NormalUserController@view')->name('playground.view')->middleware('role:user'); // send PL(id)to show PL details
	Route::post('user/PL/available','Api\NormalUserController@available')->middleware('role:user'); // post requet (id,date)
	Route::post('user/PL/reserve','Api\NormalUserController@reserve')->name('playground.reserve')->middleware('role:user'); // reserve manual

	Route::post('user/PL/paypal','Api\NormalUserController@postPaypal')->name('user.postPaypal'); // reserve using paypal



	/*============================  Normal User Reservation Paypal routes =============================*/
	// Route::get('reservation/online','ReservationController@getPaypal')->name('reservation.getPaypal');
	// Route::post('admin/reservation/paypal','ReservationController@postPaypal')->name('reservation.postPaypal');
	// Route::get('admin/reservation/status','ReservationController@getPaymentStatus')->name('reservation.status');
	/*============================= End Paypal routes ===========================*/

});
	Route::get('user/PL/success','Api\NormalUserController@success')->name('user.success');
	Route::get('user/PL/fail','Api\NormalUserController@fail')->name('user.fail');
	