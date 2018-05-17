<?php

namespace App\Http\Controllers;

use App\Playground;
use App\Reservation;
use App\Slot;
use Illuminate\Http\Request;
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


class ReservationController extends Controller
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
    public function getPaypal() {
        $playgrounds = Playground::with('user')->where('user_id',auth()->id())->get();
        return view('reservations.paypal', compact('playgrounds'));
    }
    public function postPaypal(Request $request) {
        $this->validate($request,$this->rules);

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
        $redirectUrls->setReturnUrl(route('reservation.status'))
            ->setCancelUrl(route('reservation.status'));

        // Payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $request = clone $payment;

        try {
            $payment->create($this->api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return redirect()->route('reservation.postPaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return redirect()->route('reservation.postPaypal');
            } //end else
        } //end catch
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        } //end foreach
        \Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            // return response()->json(['settings'  => $payment, 'approval link'    => $redirect_url]);
            return Redirect::away($redirect_url);
        } 
        \Session::put('error', 'Unknown error occurred');
            return Redirect::route('reservation.postPaypal');
    } //end postPaypaly

    public function getPaymentStatus() {
        
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        \Session::forget('paypal_payment_id');

        if (empty(request('PayerID')) || empty(request('token'))) {
            \Session::put('error', 'Payment failed');
                return redirect()->route('reservation.getPaypal')->with('danger','Payment failed');
        }
        $payment = Payment::get($payment_id, $this->api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->api_context);
        if ($result->getState() == 'approved') {
            \Session::put('success', 'Payment success');
                return redirect()->route('reservation.getPaypal')->with('success','Payment Success');
        }
            \Session::put('error', 'Payment failed');
                return redirect()->route('reservation.getPaypal')->with('danger','Payment failed');
    } //wnd getPaymentStatus





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$playgrounds = Playground::with('user')->where('user_id',auth()->id())->paginate(10);
        return view('reservations.index',compact('playgrounds'));
    }

    // stop this methood until know customer requirements
    public function view($id) {
        $playground = Playground::findOrFail($id);

        $mm = $playground->slots()->pluck('slot_id');
    	return view('reservations.view', compact('playground','usersHasReserve'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$playgrounds = Playground::with('user')->where('user_id',auth()->id())->get();
        return view('reservations.create', compact('playgrounds'));
    }

    public function getAvailableSlots($id) {
    	$date = request('date'); // get date from  calendar input
        $playgroundId = request()->route('id'); // get playgroundId from current url 
        
        $playground = Playground::find($playgroundId);
        // fetch reserved slots 
        $reservedSlotsIds = $playground->reservations->pluck('slot_id');

        // fetch Un-Reserved slots 
        $checkedSlots = $playground->slots()->wherePivot('date','=',$date)->whereNotIn('slot_id',$reservedSlotsIds)->get();

        return response()->json($checkedSlots);
    }

    // ajax to trigger playground cost based on choosing playground 
    public function getCost($id) {
        $playgroundId = request()->route('id');
        $playground = Playground::find($playgroundId);
        return response()->json($playground);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'playground_id' => 'required',
            'date' => 'required|after_or_equal:'.date("Y-m-d"),
            'slot_id' => 'required',
            'user_id' => 'nullable',
            'payment_type' => 'required|min:0|max:1',
            'playground_cost' => 'required',
        ]);
        if ($reservation = Reservation::create($request->all())) {
            return redirect()->back()->with('success','Reservation Done');
        }
        return redirect()->back()->with('danger','Reservation Failed');
    }
}