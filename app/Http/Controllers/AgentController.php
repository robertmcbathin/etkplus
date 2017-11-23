<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Mail;
use \App\User;
use \App\Partner;
use App\Mail\PartnerRegistered;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function showDashboard(){
    	$to_pay = DB::table('ETKPLUS_AGENT_ACCOUNTS')
    				->where('user_id',Auth::user()->id)
    				->first();
    	return view('dashboard.agent.index',[
    		'to_pay' => $to_pay
    	]);
    }
}
