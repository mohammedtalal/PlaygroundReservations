<?php

namespace App\Http\Controllers;

use App\Playground;
use App\PlaygroundSlot;
use App\Reservation;
use App\Slot;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class PlaygroundController extends Controller
{
    
    public function index() {
        $playgrounds = Playground::with('user')->paginate(10);
    	return view('playgrounds.index',compact('playgrounds'));
    }

    public function view($id) {
        $playground = Playground::findOrFail($id);
        return view('playgrounds.view',compact('playground'));
    }

    public function create() {
        $users = User::all();
        $slots = Slot::all();
        return view('playgrounds.create',compact('users','slots'));
    }

    public function store(Request $request) {
    	$this->validate($request, [
            'name' => 'required|max:100',
            'address' => 'required',
            'details' => 'required',
            'user_id' => 'required',
            'cost'    => 'required|numeric'
        ]);
         if ($playground = Playground::create($request->all())) {
            $playground->uploadFile('image',$playground);
            return redirect()->route('ownerPlaygrounds.index')->with('success','Created Playground Successfully');
        }
        return redirect()->back()->with('danger','Failed to save');
    }

    public function edit($id) {
    	$playground = Playground::findOrFail($id);
        $users = User::all();
        $slots = Slot::all();
        return view('playgrounds.edit',compact('playground', 'users', 'slots'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|max:120',
            'address' => 'required',
            'details' => 'required',
            'user_id' => 'required',
            'cost'    => 'required|numeric'
        ]);

        $playground = Playground::findOrFail($id);
         if ($playground->update($request->all())) {
            $playground->uploadFile('image',$playground);
            return redirect()->route('ownerPlaygrounds.index')->with('success','Updated Successfully');
        }
        return redirect()->back()->with('danger','Failed to update');
    }   

    public function destroy($id) {
    	$playground = Playground::findOrFail($id);
        $playground->delete();
        return redirect()->route('playgrounds.index')->with('danger','User deleted successfully');
    }

    public function ownerPlaygrounds() {
        $playgrounds = Playground::with('user')->where('user_id',auth()->id())->get();
        return view('playgrounds.show',compact('playgrounds'));
    }

    // create new playground schedule
    public function createPlaygroundSchedule($id) {
        $playground = Playground::findOrFail($id);
        return view('playgrounds.schedule',compact('playground'));
    }

    public function getChecks($id) {
        $date = Input::get('date'); // get date from  calendar input
        $playgroundId = request()->route('id'); // get olaygroundId from current url 

        $playground = Playground::find($playgroundId);
        $checkedSlots = $playground->slots()->wherePivot('date','=',$date)->get();
        
        $slotsHasNotChecked = $checkedSlots->pluck('id'); // get others slots that not checked to comparing using it
        // comparing between checked befor and nonChecked slots to fetch collection of not checkedbox's
        $nonCheckedSlots = Slot::whereNotIn('id',$slotsHasNotChecked)->get(); 

        $allSlots = SLot::all();
        return response()->json(['checkedSlots' => $checkedSlots, 'nonCheckedSlots' => $nonCheckedSlots, 'allSlots' => $allSlots]);
    }
    
    // store new playground slots (to pivot table)
    public function storePlaygroundSchedule(Request $request, $id) {
        $this->validate($request, [
            'date' => 'required',
            'slots' => 'required|min:1',
        ]); 
        $playground = Playground::findOrFail($id);
        
        if (isset($request->slots)) {
            $playground->slots()->detach($playground->slots->pluck('id')->toArray(),['date' => $request->date]);
            $playground->slots()->attach($request->slots,['date' => $request->date]);
        } else {
            $playground->slots()->sync(array());
        }
        return redirect()->route('ownerPlaygrounds.index',$playground->id)->with('success','process success');
    }

    public function playgroundRreservedHours($id) {
        $playground = Playground::findOrFail($id);
        $reservations = Reservation::with('users','playground','slots')
            ->where('playground_id',$playground->id)
            ->where('date', '>=', date('Y-m-d'))
            ->orderBy('date','desc')
            ->paginate(10);
        return view('playgrounds.reservedTimes',compact('reservations'));
    }

    /* ajax get request to get reserved hours based on date */
    public function getReservedHours() {
        $date = Input::get('date'); // get date from  calendar input
        
    }
}
