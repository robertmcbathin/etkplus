<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use \App\Partner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


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
    /**
     * СОЗДАНИЕ ПРЕДПРИЯТИЯ
     */
    public function postCreatePartner(Request $request){
    	/**
    	 * DEFAULTS
    	 */
    	$background_imagename = '/assets/img/partners/etkplus_partner_default.jpg';
    	$logo_imagename = '/assets/img/partners/etkplus_partner_default_logo.png';
    	/**
    	 * GET VARIABLES
    	 */
    	$name 		 = $request->name;
    	$fullname    = $request->fullname;
    	$description = $request->description;
    	$phone 		 = $request->phone;
    	$address 	 = $request->phone;
    	$email 		 = $request->email;
    	$site 		 = $request->site;
    	$comission   = $request->comission;
    	$discount    = $request->discount;
    	$category    = $request->category;
    	$is_active   = $request->is_active;
    	if ($is_active == 'on'){
    		$is_active = 1;
    	} else $is_active = 0;
    	/**
    	 * INSERT ROW
    	 */
    	$partnerId = DB::table('ETKPLUS_PARTNERS')->insertGetId([
    		'name' => $name,
    		'fullname' => $fullname,
    		'description' => $description,
    		'phone' => $phone,
    		'address' => $address,
    		'email' => $email,
    		'site' => $site,
    		'default_comission' => $comission,
    		'default_discount' => $discount,
    		'category' => $category,
    		'is_active' => $is_active
    		]);
    	$partner = \App\Partner::find($partnerId);
    	/**
    	 * CHECK FILES
    	 */
    	$background_image = $request->file('background_image');
        if ($background_image){
          $background_image_extension = $request->file('background_image')->getClientOriginalExtension();
          $background_imagename = '/assets/img/partners/' . $partnerId . '/background.' . $background_image_extension;        	
          Storage::disk('public')->put($background_imagename, File::get($background_image));
          $partner->thumbnail = $background_imagename;
          $partner->save();
        } else {
          $partner->thumbnail = $background_imagename;
          $partner->save();
        }

        $logo_image = $request->file('logo_image');
        if ($logo_image){
          $logo_image_extension = $request->file('logo_image')->getClientOriginalExtension();	
          $logo_imagename = '/assets/img/partners/' . $partnerId . '/logo.' . $logo_image_extension;        	
          Storage::disk('public')->put($logo_imagename, File::get($logo_image));
          $partner->thumbnail = $logo_imagename;
          $partner->save();
        } else {
          $partner->logo = $logo_imagename;
          $partner->save();
        }
        Session::flash('success', 'Создано новое предприятие');
        return redirect()->back();
    }

    public function getPartnerList(){
        $partners = DB::table('ETKPLUS_PARTNERS')
                        ->get();
        return view('dashboard.partner_list',[
            'partners' => $partners
            ]);
    }


    /**
     * AJAX ЗАПРОСЫ
     */
    public function postChangeStatus(Request $request){
        
    }
}
