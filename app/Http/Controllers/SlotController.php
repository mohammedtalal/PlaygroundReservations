<?php

namespace App\Http\Controllers;

use App\Playground;
use App\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
	public function index() {
        $slots = Slot::with('playgrounds')->paginate(10);
    	return view('playgroundSlot.index',compact('slots'));
    }

    public function view($id) {
        $slot = Slot::findOrFail($id);
        return view('playgroundSlot.view',compact('slot'));
    }

    public function create() {
        $slots = Slot::all();
        $playgrounds = Playground::all();
        return view('playgroundSlot.create',compact('playgrounds','slots'));
    }

    public function store(Request $request) {
    	$this->validate($request, [
            'playground_id' => 'required|integer',
        ]);
    	$playground = $request->get('playground_id');
        if (isset($request->slots) && isset($request->playground_id)  ) {
            $playground->slots()->sync($request->slots);   
            return redirect()->route('playgroundSlot.index')->with('success','Created Playground Successfully');
        } else {
            $playground->slots()->sync(array());
        }

        
    }

    public function edit($id) {
    	$playground = Playground::findOrFail($id)->slots()->get();
        dd($playground);
        $ss = $playground->slots;
        $users = User::all();
        $slots = Slot::all();
        return view('playgroundSlot.edit',compact('playground', 'users', 'slots'));
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
            return redirect()->route('playgroundSlot.index')->with('success','Updated Successfully');
        }
        return redirect()->back()->with('danger','Failed to update');

    }   

    public function destroy($id) {
    	$playground = Playground::findOrFail($id);
        $playground->delete();
        return redirect()->route('playgroundSlot.index')->with('danger','User deleted successfully');

    }
}
