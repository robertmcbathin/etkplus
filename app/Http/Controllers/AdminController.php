<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AdminController extends Controller
{
    public function showDashboard(){
    	return view('dashboard');
    }
    public function showCreatePartnerPage(){
    	$categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
    					->get();
    	return view('dashboard.create_partner',[
    		'categories' => $categories
    		]);
    }
}
