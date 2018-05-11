<?php

namespace App\Http\Controllers;

use App\Playground;
use App\Reservation;
use App\Slot;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
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
        // dD($request->all());
        $this->validate($request, [
            'playground_id' => 'required',
            'date' => 'required|after_or_equal:'.date("Y-m-d"),
            'slot_id' => 'required',
            'user_id' => 'nullable',
            'payment_type' => 'required|integer',
            'playground_cost' => 'required',
        ]);
        if ($reservation = Reservation::create($request->all())) {
            return redirect()->back()->with('success','Reservation Done');
        }
        return redirect()->back()->with('danger','Reservation Failed');
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