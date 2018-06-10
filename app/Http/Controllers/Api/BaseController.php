<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller as Controller;
use App\Playground;
use Illuminate\Http\Request;


class BaseController extends Controller
{

    public function sendResponse($result=[], $message=[], $slots=[])
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }


    public function playgroundTransform(Playground $playground){
        return [
            'name'      => $playground->name,
            'details'   => $playground->details,
            'address'   => $playground->address,
            'cost'      => $playground->cost,
            'image'      => $playground->image,
            'user_id'      => $playground->user_id,
        ];
    }
}