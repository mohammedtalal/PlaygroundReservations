<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index() {
    	return view('users.index');
    }

    public function create() {
        return view('users.create');
    	
    }

    public function store() {
    	
    }

    public function edit() {
    	
    }

    public function update() {
    	
    }

    public function destroy() {
    	
    }
}