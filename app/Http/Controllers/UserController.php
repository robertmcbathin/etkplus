<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfilePage(){
    	$user = Auth::user();
    	return view('profile',[
    		'user' => $user
    		]);
    }
}
