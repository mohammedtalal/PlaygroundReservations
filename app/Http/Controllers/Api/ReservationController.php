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

class ReservationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playgrounds = Playground::with('user')->where('user_id',auth()->id())->paginate(10);
        if (! empty($playgrounds)) {
            return $this->sendResponse($playgrounds, 'Retrieved all reservations');
        }
        return $this->sendError('Data not found.');
    }

    public function view($id) {
        $playground = Playground::findOrFail($id);

        // fetch reserved slots 
        $reservedSlotsIds = $playground->reservations;
        // fetch Un-Reserved slots 
        $checkedSlots = $playground->slots()->wherePivot('slot_id','=',$reservedSlotsIds)->get();

        return view('reservations.view', compact('playground','reservedSlotsIds'));
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
            'payment_type' => 'required|integer'
        ]);
        $reservation = new Reservation;
        $reservation->playground_id = $request->playground_id;
        $reservation->date = $request->date;
        $reservation->slot_id = $request->slot_id;
        $reservation->user_id = $request->user_id;
        $reservation->payment_type = $request->payment_type;

       if ( $reservation->save()) {
            return $this->sendResponse($reservation,'Reservation Done');
       }
            return $this->sendError('Reservation Failed');
       

        // if ( $reservation = Reservation::create($request->all())) {
        //     return $this->sendResponse($reservation,'Reservation Done');
        // };
        //     return $this->sendError('Reservation Failed');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}