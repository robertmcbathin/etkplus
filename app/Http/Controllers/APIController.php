<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \App\User;
class APIController extends Controller
{
    public function showUser($id){
    	$user = DB::table('users')
    				->where('id',$id)
    				->first();
    	if (($user->role_id >= 20) && ($user->role_id < 25)){
    	return response()->json([
    	    	'id' => $id,
    	    	'user' => $user
    	    ],200);
    	} else {
    	return response()->json([
    	    	'status' => 'error',
    	    	'errorText' => 'Недостаточно прав'
    	    ],200);
    	}
    }
}
