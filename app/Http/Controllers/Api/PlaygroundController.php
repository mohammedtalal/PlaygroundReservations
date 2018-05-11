<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Playground;
use App\Slot;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlaygroundController extends BaseController
{
    public function index() {
    	$playgrounds = Playground::all();
    	if (! empty($playgrounds)) {
    		return $this->sendResponse($playgrounds,'Playground retrieved successfully');
    	}
    	return $this->sendError('Data not found.');
    }

    // fetch playgrounds that belongs to auth user
    public function show(User $id){
        try {    
            $playground = Playground::with('user')->where('user_id', auth()->user()->id)->get();

    		if (! $playground) {
    			return $this->response->errorNotFound('playground not found');
    		}
    	} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    		return $this->response->error("Token is invalid");
    	} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    		return $this->response->error("Token has expired");
    	} catch (\Tymon\JWTAuth\Exceptions\TokenBlackListedException $e) {
    		return $this->response->error("Token is blacklisted");
    	}
    	return $this->sendResponse($playground,'Playground Details');
    }


    // Generate new token (Refresh token)
    public function token() {
    	$token = JWTAuth::getToken();
    	if (! $token) {
    		return $this->response->errorUnauthorized('Token is invalid');
    	}
    	try {
    		$refreshToken =  JWTAuth::refresh($token);
    	} catch (JWTException $e) {
    		$this->response->error('Something went wrong');    		
    	}
    	if (!refreshToken) {
    		return $this->e($refreshToken, 'Generated new token');
    	}
    	return $this->sendError('Something went wrong cant generate new token');
    }

    // ajax request
    public function getChecked($id) {  
        $playground = Playground::find($id);
        $date = request('date');
        $checkedSlots = $playground->slots()->wherePivot('date','=',$date)->get();
        if ($checkedSlots->isEmpty()) {
            return $this->sendError(['Not found available hours on '.$date], $checkedSlots);
        } 
            return $this->sendResponse([
                'number of available hours '=>$checkedSlots->count(),
                'available hours' => $checkedSlots
                ],  'Available hours retrieved successfully');
    }

    public function getNonChecked($id) {
        $date = request('date');
        $playground = Playground::find($id);
        $checkedSlots = $playground->slots()->wherePivot('date','=',$date)->get();
        $slotsHasNotChecked = $checkedSlots->pluck('id'); // get others slots that not checked to comparing using it
        // comparing between checked befor and nonChecked slots to fetch collection of not checkedbox's
        $nonCheckedSlots = Slot::whereNotIn('id',$slotsHasNotChecked)->get(); 
        if ($nonCheckedSlots->isEmpty()) {
            return $this->sendError('Sorry all hours reserved on '.$date, $checkedSlots);
        }
        return $this->sendResponse([
            'number of un-available hours' => $nonCheckedSlots->count(),
            'Un-available hours'=> $nonCheckedSlots
            ], 'Retrieve Un-available hours successfully');
    }
}