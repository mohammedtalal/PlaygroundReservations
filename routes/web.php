<?php

use App\Playground;
use App\PlaygroundSlot;
use App\Reservation;
use App\Slot;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


Route::Auth();
Auth::routes();
Route::get('test', function() {
	// $user = User::findOrFail(5);
 //        $reservations = Reservation::with('users','playground','slots')
 //            ->where('user_id',$user->id)
 //            ->where('date', '>=', date('Y-m-d'))
 //            ->paginate(10);
 //            return response()->json($reservations);
});

/*================ Start Dashboard Routes  ================*/
Route::group(['middleware' => 'auth:web'], function () {
	Route::get('/', ['as' => 'dashboard','uses' => 'IndexController@index']);
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
	Route::get('admin/PL/create','PlaygroundController@create')->name('playgrounds.create')->middleware('role:owner');
	Route::post('admin/PL/store','PlaygroundController@store')->name('playgrounds.store')->middleware('role:owner');
	Route::get('admin/PL/{id}/edit','PlaygroundController@edit')->name('playgrounds.edit');
	Route::post('admin/PL/{id}/update','PlaygroundController@update')->name('playgrounds.update');
	Route::delete('admin/PL/{id}/destroy','PlaygroundController@destroy')->name('playgrounds.destroy')->middleware('role:admin');

	
	Route::get('admin/PLS','PlaygroundController@ownerPlaygrounds')->name('ownerPlaygrounds.index'); // get All owner playgrounds
	// get owner playground schedule view
	Route::get('admin/PL/{id}/schedule/create','PlaygroundController@createPlaygroundSchedule')->name('playgroundSchedule.create'); 
	Route::post('admin/PL/{id}/schedule/store','PlaygroundController@storePlaygroundSchedule')->name('playgroundSchedule.store'); 
	Route::get('admin/PL/{id}', 'PlaygroundController@getChecks'); // ajax get request to fetch slots based on date

	/*===================== Reserved times Routes ====================*/
	Route::get('admin/PL/{id}/reserved','PlaygroundController@playgroundRreservedHours')->name('playground.reserved');
	Route::get('admin/reserved/{id}', 'PlaygroundController@getReservedHours'); // ajax get request to fetch reserved hours based on date
	


	/*====================  Reservations Routes ====================*/
	Route::get('admin/reservations','ReservationController@index')->name('reservation.index');
	Route::get('admin/reservation/create','ReservationController@create')->name('reservation.create');
	Route::get('admin/cost/{id}','ReservationController@getCost'); //ajax to get playground cost based on choosing playground
	Route::get('admin/available/{id}','ReservationController@getAvailableSlots'); //ajax to get available slots for playground
	Route::post('admin/reservation/store','ReservationController@store')->name('reservation.store');
	Route::get('admin/reservation/{id}/view','ReservationController@view')->name('reservation.view'); // show reservations details

	 /*============================ Paypal routes =============================*/
	Route::get('admin/reservation/online','ReservationController@getPaypal')->name('reservation.getPaypal');
	Route::post('admin/reservation/paypal','ReservationController@postPaypal')->name('reservation.postPaypal');
	Route::get('admin/reservation/status','ReservationController@getPaymentStatus')->name('reservation.status');
	/*============================= End Paypal routes ===========================*/
	
	
});
/*================ End Dashboard Routes  ================*/



// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
// Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');


Route::get('/home', function(){
	return redirect('/dashboard');
});


