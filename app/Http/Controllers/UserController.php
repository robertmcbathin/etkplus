<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Session;
use \App\Review;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfilePage(){
        /**
         * ПРОВЕРКА НА АУТЕНТИФИКАЦИЮ
         */
    	if (Auth::user()){
    		$user = Auth::user();
    	} else
    	return redirect()->route('login');
        /**
         * ЗАГРУЗКА ДАННЫХ
         */
        $visits = DB::table('ETKPLUS_VISITS')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id','=','ETKPLUS_PARTNERS.id')
                    ->select('ETKPLUS_VISITS.id','ETKPLUS_VISITS.partner_id','ETKPLUS_VISITS.user_id','ETKPLUS_VISITS.bill','ETKPLUS_VISITS.bill_with_discount','ETKPLUS_VISITS.cashback','ETKPLUS_VISITS.bonus','ETKPLUS_VISITS.discount','ETKPLUS_VISITS.is_reviewed','ETKPLUS_VISITS.created_at','ETKPLUS_VISITS.updated_at',
                        'ETKPLUS_PARTNERS.logo','ETKPLUS_PARTNERS.name')
                    ->where('user_id',$user->id)
                    ->orderBy('created_at','DESC')
                    ->paginate(10);
    	return view('profile',[
    		'user' => $user,
    		'auth_user_id' => $user->id,
            'visits' => $visits
    		]);
    }
    /**
     * СОХРАНЕНИЕ ОТЗЫВА О ПОСЕЩЕНИИ
     */
    public function leaveReview(Request $request){
        if (!$request->rating){
            $rating = 2.5;
        }
        $user_id = $request->user_id;
        $partner_id = $request->partner_id;
        $rating = $request->rating;
        $title = $request->review_title;
        $description = $request->review_description;
        $visit_id = $request->visit_id;
        /**
         * СОЗДАНИЕ ОТЗЫВА
         */
        $review = new \App\Review;
        $review->user_id = $user_id;
        $review->partner_id = $partner_id;
        $review->rating = $rating;
        $review->title = $title;
        $review->description = $description;
        if ($review->save()){
        /**
         * ОТМЕТКА О СОХРАНЕНИИ ОТЗЫВА
         */
            DB::table('ETKPLUS_VISITS')
                ->where('id',$visit_id)
                ->update(['is_reviewed' => 1]);
            Session::flash('success','Отзыв успешно сохранен');
            return redirect()->back();
        } else {
            Session::flash('error','Не удалось сохранить отзыв, попробуйте позже');
            return redirect()->back();
        }

    }
}
