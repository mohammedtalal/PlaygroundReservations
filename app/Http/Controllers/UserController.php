<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index() {
        $users = User::with('role')->get();
    	return view('users.index',compact('users'));
    }

    public function create() {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request) {
    	$this->validate(request(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->api_token = str_random(60);

        $user->save();
        return redirect()->route('users.index')->with('success','Created User Successfully');;
    }

    public function edit($id) {
    	$user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit',compact('user','roles'));
    }

    public function update(Request $request, $id) {
        $this->validate(request(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->api_token = str_random(60);

        $user->save();
        return redirect()->route('users.index')->with('success','Updated Successfully');
    }   

    public function destroy($id) {
    	$user = User::findOrFail($id);
        $user->delete();
        $user->role->delete();
        return redirect()->route('users.index')->with('danger','User deleted successfully');

    }
}
