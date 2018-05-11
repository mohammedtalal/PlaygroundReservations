<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Playground;
use App\Reservation;
use App\Slot;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class NormalUserController extends BaseController
{
    public function index() {
    	$playgrounds = Playground::with('user')->paginate(10);
    	if (! empty($playgrounds)) {
    		return $this->sendResponse($playgrounds, "Playgrounds retrieved successfully");
    	}
    	return $this->sendError('Failed to retrieve playgrounds');
    }

    public function view($id) {
    	$playground = Playground::find($id);
    	if (! empty($playground)) {
    		$successMsg = ucfirst($playground->name)." Playground Information";
    		return $this->sendResponse($playground,$successMsg);
    	}
    	return $this->sendError('Failed to retrieve playground information');
    }


    /*
    	@var date: get date as post request to fetch available hours found on this date
    	@var playgroundId: fetch it from ajax request on url 
    	available function to get all available hours on specific playground and specific date 
     */
    public function available($id) {
    	$date = request('date'); // get date from  calendar input
        $playgroundId = request()->route('id'); // get playgroundId from current url 
        
        $playground = Playground::find($playgroundId);
        // fetch reserved slots 
        $reservedSlotsIds = $playground->reservations->pluck('slot_id');
        // fetch Un-Reserved slots 
        $availablhours = $playground->slots()->wherePivot('date','=',$date)->whereNotIn('slot_id',$reservedSlotsIds)->get();

        if ($availablhours->isEmpty()) {
            return $this->sendError(['Not found available hours on '.$date], $availablhours);
        } 
            return $this->sendResponse([
                'number of available hours '=>$availablhours->count(),
                'Playground' => $playground,
                'available hours' => $availablhours
                ],  'Playground available hours retrieved successfully');
    }


    /*
    	payment types is [0,1] 
    	0 => manual payment
    	1 => online payment
    */
    public function reserve(Request $request, $id) {
    	$this->validate($request, [
            'playground_id' => 'required',
            'date' => 'required|after_or_equal:'.date("Y-m-d"),
            'slot_id' => 'required',
            'user_id' => 'nullable',
            'payment_type' => 'required|integer',
            'playground_cost' => 'required'
        ]);
        if ($request->payment_type == 0) {
	        if ($reservation = Reservation::create($request->all())) {
	            return $this->sendResponse($reservation, 'Reservation created successfully');
	        } // end if request equal 0
        } //end if reservation created 
    }
}
