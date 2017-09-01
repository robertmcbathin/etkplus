<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use \App\User;
use \App\Review;

class SiteController extends Controller
{
    public function showIndex(){
        $partners = DB::table('ETKPLUS_PARTNERS')
                      ->join('ETKPLUS_PARTNER_PHOTOS', 'ETKPLUS_PARTNERS.id', '=', 'ETKPLUS_PARTNER_PHOTOS.partner_id')
                      ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNER_PHOTOS.logo', 'ETKPLUS_PARTNER_PHOTOS.thumbnail')
                      ->orderBy('ETKPLUS_PARTNERS.created_at')
                      ->get();

        return view('index',[
            'partners' => $partners
            ]);
    }
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

    public function showPartner($id){
        $partner = DB::table('ETKPLUS_PARTNERS')
                      ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                      ->where('ETKPLUS_PARTNERS.id', $id)
                      ->where('ETKPLUS_PARTNERS.is_active',1)
                      ->first();
        $addresses = DB::table('ETKPLUS_ADDRESSES')
                        ->where('partner_id', $id)
                        ->get();
        $category_name = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                            ->where('id', $id)
                            ->first();
        $rating = DB::table('ETKPLUS_REVIEWS')
                    ->where('partner_id', $partner->id)
                    ->selectRaw('AVG(rating) as rating')
                    ->first();
        $rating = round($rating->rating,1);
        return view('pages.partner',[
            'partner' => $partner,
            'addresses' => $addresses,
            'category_name' => $category_name,
            'rating' => $rating
            ]);
    }
    public function showProfilePage($id){
        $user = \App\User::find($id);
        $reviews = DB::table('ETKPLUS_REVIEWS')
                     ->join('ETKPLUS_PARTNERS','ETKPLUS_REVIEWS.partner_id','=','ETKPLUS_PARTNERS.id')
                     ->where('user_id',$id)
                     ->select('ETKPLUS_REVIEWS.title','ETKPLUS_REVIEWS.description','ETKPLUS_REVIEWS.rating','ETKPLUS_REVIEWS.created_at','ETKPLUS_REVIEWS.updated_at','ETKPLUS_PARTNERS.logo','ETKPLUS_REVIEWS.partner_id','ETKPLUS_PARTNERS.name')
                     ->get();
        if (Auth::user()){
            $auth_user_id = Auth::user()->id;
        }
        return view('profile',[
            'user' => $user,
            'reviews' => $reviews,
            'auth_user_id' => $auth_user_id 
            ]);
    }
}
