<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SiteController extends Controller
{
    public function showCategory($id){
    	$partners = DB::table('ETKPLUS_PARTNERS')
    				  ->join('ETKPLUS_PARTNER_PHOTOS', 'ETKPLUS_PARTNERS.id', '=', 'ETKPLUS_PARTNER_PHOTOS.partner_id')
    				  ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
    				  	'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNER_PHOTOS.logo', 'ETKPLUS_PARTNER_PHOTOS.thumbnail')
    				  ->where('ETKPLUS_PARTNERS.category', $id)
    				  ->where('ETKPLUS_PARTNERS.is_active',1)
    				  ->orderBy('ETKPLUS_PARTNERS.created_at')
    				  ->get();
    	$category_name = DB::table('ETKPLUS_PARTNER_CATEGORIES')
    						->where('id', $id)
    						->first();
    	return view('pages.category',[
    		'partners' => $partners,
    		'category_name' => $category_name
    		]);
    }

    public function showCategories(){
        $categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                        ->orderBy('name')
                        ->get();
        return view('pages.categories');
    }
}
