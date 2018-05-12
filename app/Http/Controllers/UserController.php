<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $rules;
    public function __construct(){
        $this->rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required'
            ];
    }

    public function index() {
        $users = User::with('role')->paginate(10);
    	return view('users.index',compact('users'));
    }

    public function view($id) {
        $user = User::findOrFail($id);
        return view('users.view',compact('user'));
    }

    public function create() {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request) {
        $this->validate($request, $this->rules);
         if ($user = User::create($request->all())) {
            return redirect()->route('users.index')->with('success','Created User Successfully');
        }
        return redirect()->back()->with('danger','Failed to save');

    }

    public function edit($id) {
    	$user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit',compact('user','roles'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);
        if ($user->update($request->all())) {
            return redirect()->route('users.index')->with('success','Updated Successfully');
        }
        return redirect()->back()->with('danger','Failed to update');
    }   

    public function destroy($id) {
    	$user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('danger','User deleted successfully');

    }
}
