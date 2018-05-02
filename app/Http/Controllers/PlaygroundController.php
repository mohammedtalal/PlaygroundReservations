<?php

namespace App\Http\Controllers;

use App\Playground;
use App\Slot;
use App\User;
use File;
use Illuminate\Http\Request;

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
        // dd($request->all());
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
    	$playground = Playground::with('playground_slot')->findOrFail($id);
        dd($playground);
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
            return redirect()->route('playgrounds.index')->with('success','Updated Successfully');
        }
        return redirect()->back()->with('danger','Failed to update');

    }   

    public function destroy($id) {
    	$playground = Playground::findOrFail($id);
        $playground->delete();
        return redirect()->route('playgrounds.index')->with('danger','User deleted successfully');

    }

}
