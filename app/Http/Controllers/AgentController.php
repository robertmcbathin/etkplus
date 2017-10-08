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
    	return view('dashboard.agent.index');
    }
}
