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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class NormalUserController extends BaseController
{

    private $api_context;
    private $rules;
    public function __construct() {
        // rules
        $this->rules = [
            'playground_id' => 'required',
            'date' => 'required|after_or_equal:'.date("Y-m-d"),
            'slot_id' => 'required',
            'user_id' => 'nullable',
            'payment_type' => 'required|min:0|max:1',
            'playground_cost' => 'required'
        ];
         /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->api_context->setConfig($paypal_conf['settings']);
    }

    public function index() {
    	 $playgrounds = Playground::with('user')->paginate(10);

    	if (! empty($playgrounds)) {
    		return $this->sendResponse($playgrounds, "Playgrounds retrieved successfully");
    	}
    	return $this->sendError('Failed to retrieve playgrounds');
    }


    /*
        To show one playground details send post request by playground id ,
        the name of variable will ble (id)
    */
    public function view() {
        $id = request('id');
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
    public function available() {
    	$date = request('date'); // get date from  calendar input
        $id = request('id'); // get playgroundId from current url 
            
        $playground = Playground::find($id);
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
    public function reserve(Request $request) {
    	$this->validate($request, $this->rules);
        if ($request->payment_type == 0) {
	        if ($reservation = Reservation::create($request->all())) {
	            return $this->sendResponse($reservation, 'Reservation created successfully');
	        } // end if request equal 0
        } //end if reservation created 
    }

    public function postPaypal(Request $request) {
        $this->validate($request,$this->rules);
        if ($request->payment_type == 0) {
            return $this->sendError('Payment type must be correct to continue online payment');
        } 
        $playground = Playground::find($request->playground_id);
        $slot = Slot::find($request->slot_id);

         // set payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // items
        $item1 = new Item();
        $item1->setName($playground->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setDescription('Reservation ' . ucfirst($playground->name) . 'from '.$slot->from.' to '.$slot->to. ucfirst($slot->status))
            ->setPrice($playground->cost);

        // item list
        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        // amount
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($playground->cost);

        // Transactions
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Reservation ' . ucfirst($playground->name) . ' playground hour from '.$slot->from.' to '.$slot->to . ucfirst($slot->status));

        // redirect url 
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('user.success'))
            ->setCancelUrl(route('user.fail'));

        // Payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $request = clone $payment;

        try {
            $payment->create($this->api_context);

            // return $payment;
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return $this->sendError('Connection Timeout');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return $this->sendError('Some error occur, sorry for inconvenient');
            } //end else
        } //end catch

        \Session::put('paypal_payment_id', $payment->getId());

         // set form data on session (reservation data)
             $data = request()->all();
             $data['user_id'] = auth()->id();
            \Session(['reservation_data' => $data]);


        if (isset($payment)) {
            return response()->json(['result' => $payment->toArray(), 'approval link'    => $payment->getApprovalLink()]);
        } 
        \Session::put('error', 'Unknown error occurred');
            return $this->sendError('Unknown error occurred');
    } //end postPaypaly function


    public function success() {

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return response()->json('Payment Fail');
        }

        /** Get reservation data] befor session clear */
        $reservation_data = \Session::get('reservation_data');
        /** clear the session Reservation data **/
        \Session::forget('reservation_data');


        $paymentId = Input::get('paymentId');
        $payment = Payment::get($paymentId,$this->api_context); 
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']); 
        $result = $payment->execute($execution, $this->api_context);

        if ($result->getState() == 'approved') {
            /** store reservation data into DB   */
            Reservation::create($reservation_data);
            return response()->json(["status"  => true, "message" => "Payment Success and Playground reserved done"]);
        }
            return response()->json('Payment Fail');
    }
    public function fail(){
        return $this->sendError("User Cancelled the Approval");
    }
}
