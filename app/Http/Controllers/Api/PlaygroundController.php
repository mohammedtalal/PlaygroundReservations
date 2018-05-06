<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Playground;
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
    		// $playground = JWTAuth::parseToken()->toUser();
            // $playground = Playground::find($id);    
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


    // Generate new token
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
}
