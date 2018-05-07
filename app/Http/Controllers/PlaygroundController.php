<?php

namespace App\Http\Controllers;

use App\Playground;
use App\PlaygroundSlot;
use App\Slot;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class PlaygroundController extends Controller
{
    protected $model;
    public function __construct(Playground $model) {
        $this->model = $model;
    }
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
            'image'    => 'image'

        ]);
         if ($playground = Playground::create($request->all())) {
            $playground->uploadFile('image',$playground);
            
            // check if owner selected hours
            if (isset($request->slots)) {
                $playground->slots()->sync($request->slots);   
            } else {
                $playground->slots()->sync(array());
            }
            return redirect()->route('playgrounds.index')->with('success','Created Playground Successfully');
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
        ]);

        $playground = Playground::findOrFail($id);

         if ($playground->update($request->all())) {
            $playground->uploadFile('image',$playground);
            
            if (isset($request->slots)) {
                $playground->slots()->sync($request->slots);   
            } else {
                $playground->slots()->sync(array());
            }
            return redirect()->back()->with('success','Updated Successfully');
        }
        return redirect()->back()->with('danger','Failed to update');
    }   

    public function destroy($id) {
    	$playground = Playground::findOrFail($id);
        $playground->delete();
        return redirect()->route('playgrounds.index')->with('danger','User deleted successfully');
    }

    public function ownerPlaygrounds($id) {
        $playgrounds = Playground::with('user')->where('user_id', $id)->get();
        return view('playgrounds.show',compact('playgrounds'));
    }

    public function getChecks() {
        $date = Input::get('date');
        $myId = URl::current();
        $playground = Playground::find(2);
        $checkedSlots = $playground->slots()->wherePivot('date','=',$date)->get();
        // $checkedSlots = Slot::has('playgrounds')->wherePivot('date','=',$date)->get();
        // dd($checkedSlots);
        $nonCheckedSlots = Slot::doesnthave('playgrounds')->get();
        $allSlots = SLot::all();
        return response()->json(['checkedSlots' => $checkedSlots, 'nonCheckedSlots' => $nonCheckedSlots, 'allSlots' => $allSlots]);
    }

    // create new playground schedule
    public function createPlaygroundSchedule($id) {
        $playground = Playground::findOrFail($id);
        $slotsDosntHavePlayground = Slot::doesnthave('playgrounds')->get();
        // $past = $playground->slots()->wherePivot('date','!=','2018-05-06')->get();
        // dd($slotsDosntHavePlayground);
        // $slots = Slot::all();
        return view('playgrounds.schedule',compact('playground','slots', 'slotsDosntHavePlayground'));
    }

    // store new playground slots (to pivot table)
    public function storePlaygroundSchedule(Request $request, $id) {
        $this->validate($request, [
            'date' => 'required',
            'slots' => 'required|min:1',
        ]); 
        $playground = Playground::findOrFail($id);
        
        if (isset($request->slots)) {
            $playground->slots()->detach($request->slots,['date' => $request->date]);
            $playground->slots()->attach($request->slots,['date' => $request->date]);
        } else {
            $playground->slots()->sync(array());
        }
        return redirect()->route('ownerPlaygrounds.index',$playground->id)->with('success','process success');
    }
}
