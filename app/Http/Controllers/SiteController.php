<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use \App\User;
use \App\Review;

class SiteController extends Controller
{
    public function showIndex(){
        $partners = DB::table('ETKPLUS_PARTNERS')
                      ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                      ->where('ETKPLUS_PARTNERS.is_active',1)
                      ->orderBy('created_at', 'DESC')
                      ->limit(9)
                      ->get();

        return view('index',[
            'partners' => $partners
            ]);
    }
    public function showCategory($id){
      $partners = DB::table('ETKPLUS_PARTNERS')
              ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
              ->where('ETKPLUS_PARTNERS.is_active',1)
              ->where('ETKPLUS_PARTNERS.category',$id)
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
/**
 * PARTNER METHODS
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
    public function showPartner($id){
        $rating = 2.5;
        $review_count = 0;
        $reviews = null;

        $partner = DB::table('ETKPLUS_PARTNERS')
                      ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                      ->where('ETKPLUS_PARTNERS.id', $id)
                      ->where('ETKPLUS_PARTNERS.is_active',1)
                      ->first();
        if ($partner == null) return redirect()->back();
        $addresses = DB::table('ETKPLUS_ADDRESSES')
                        ->where('partner_id', $id)
                        ->get();
        $category_name = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                            ->where('id', $id)
                            ->first();
        /**
         * СЧИТАЕМ РЕЙТИНГ
         * 
         */
        $rating = DB::table('ETKPLUS_REVIEWS')
                    ->where('partner_id', $partner->id)
                    ->selectRaw('AVG(rating) as rating')
                    ->first();
        $star_rating = round($rating->rating,0);
        $rating = round($rating->rating,1);
        /**
         * КОЛИЧЕСТВО ПРОГОЛОСОВАВШИХ
         */
        $review_count = DB::table('ETKPLUS_REVIEWS')
                    ->where('partner_id', $partner->id)
                    ->count();
        /**
         * ПУТИ К ФОТО
         */
        $partner_images = DB::table('ETKPLUS_PARTNER_PHOTOS')
                            ->where('partner_id', $partner->id)
                            ->get();
        /**
         * ОТЗЫВЫ
         */
        $reviews = DB::table('ETKPLUS_REVIEWS')
             ->join('ETKPLUS_PARTNERS','ETKPLUS_REVIEWS.partner_id','=','ETKPLUS_PARTNERS.id')
             ->join('users','ETKPLUS_REVIEWS.user_id', '=', 'users.id')
             ->where('ETKPLUS_REVIEWS.partner_id',$partner->id)
             ->select('ETKPLUS_REVIEWS.title','ETKPLUS_REVIEWS.description','ETKPLUS_REVIEWS.rating','ETKPLUS_REVIEWS.created_at','ETKPLUS_REVIEWS.updated_at','ETKPLUS_PARTNERS.logo','ETKPLUS_REVIEWS.partner_id','ETKPLUS_PARTNERS.name','users.profile_image','ETKPLUS_REVIEWS.user_id')
             ->limit(9)
             ->orderBy('created_at','DESC')
             ->get();
        /**
         * УДОБОЧИТАЕМЫЕ ДАТА И ВРЕМЯ, ЦВЕТ БЭКГРАУНДА
         */
        Carbon::setLocale('ru');
        foreach ($reviews as $review) {
          $non_formatted_date = new Carbon($review->created_at);
          $date = $non_formatted_date->diffForHumans();
          switch ($review->rating){
            case 5:
                $review->background_color = 'green';
                break;
            case 4:
                $review->background_color = 'green';
                break;
            case 3:
                $review->background_color = 'yellow';
                break;
            case 2:
                $review->background_color = 'yellow';
                break;
            case 1:
                $review->background_color = 'orange';
                break;
            default:
                $review->background_color = 'blue';
                break;                
          }
          $review->created_at = $date;
         }
        return view('pages.partner',[
            'partner' => $partner,
            'addresses' => $addresses,
            'category_name' => $category_name,
            'star_rating' => $star_rating,
            'rating' => $rating,
            'review_count' => $review_count,
            'partner_images' => $partner_images,
            'reviews' => $reviews
            ]);
    }
    /**
     * ВСЕ ОТЗЫВЫ
     */
    
    public function showPartnerReviewsPage($id){
      $id = $id;
    $partner = DB::table('ETKPLUS_PARTNERS')
                  ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                    'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                  ->where('ETKPLUS_PARTNERS.id', $id)
                  ->where('ETKPLUS_PARTNERS.is_active',1)
                  ->first();
    $reviews = DB::table('ETKPLUS_REVIEWS')
                ->join('ETKPLUS_PARTNERS','ETKPLUS_REVIEWS.partner_id','=','ETKPLUS_PARTNERS.id')
                ->join('users','ETKPLUS_REVIEWS.user_id', '=', 'users.id')
                ->where('partner_id', $id)
                ->select('ETKPLUS_REVIEWS.title','ETKPLUS_REVIEWS.description','ETKPLUS_REVIEWS.rating','ETKPLUS_REVIEWS.created_at','ETKPLUS_REVIEWS.updated_at','ETKPLUS_PARTNERS.logo','ETKPLUS_REVIEWS.partner_id','ETKPLUS_PARTNERS.name','users.profile_image','ETKPLUS_REVIEWS.user_id')
                ->orderBy('created_at','DESC')
                ->paginate(12);
        /**
     * УДОБОЧИТАЕМЫЕ ДАТА И ВРЕМЯ, ЦВЕТ БЭКГРАУНДА
     */
    Carbon::setLocale('ru');
    foreach ($reviews as $review) {
      $non_formatted_date = new Carbon($review->created_at);
      $date = $non_formatted_date->diffForHumans();
      switch ($review->rating){
        case 5:
            $review->background_color = 'green';
            break;
        case 4:
            $review->background_color = 'green';
            break;
        case 3:
            $review->background_color = 'yellow';
            break;
        case 2:
            $review->background_color = 'yellow';
            break;
        case 1:
            $review->background_color = 'orange';
            break;
        default:
            $review->background_color = 'blue';
            break;                
      }
      $review->created_at = $date;
     }
    /**
     * СЧИТАЕМ РЕЙТИНГ
     * 
     */
    $rating = DB::table('ETKPLUS_REVIEWS')
                ->where('partner_id', $id)
                ->selectRaw('AVG(rating) as rating')
                ->first();
    $star_rating = round($rating->rating,0);
    $rating = round($rating->rating,1);
    /**
     * КОЛИЧЕСТВО ПРОГОЛОСОВАВШИХ
     */
    $review_count = DB::table('ETKPLUS_REVIEWS')
                ->where('partner_id', $id)
                ->count();
    return view('pages.partner_reviews',[
      'partner' => $partner,
      'star_rating' => $star_rating,
      'rating' => $rating,
      'review_count' => $review_count,
      'reviews' => $reviews
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
        return view('pages.show-user-profile-page',[
            'user' => $user,
            'reviews' => $reviews
            ]);
    }
}
