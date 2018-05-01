<?php

namespace App\Http\Controllers;

use App\Playground;
use App\User;
use Illuminate\Http\Request;
use File;

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
        return view('playgrounds.create',compact('users'));
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

            return redirect()->route('playgrounds.index')->with('success','Created Playground Successfully');
        }
        return redirect()->back()->with('danger','Failed to save');
    }

    public function edit($id) {
    	$playground = Playground::findOrFail($id);
        $users = User::all();
        return view('playgrounds.edit',compact('playground', 'users'));
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
            // dd($playground);
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
