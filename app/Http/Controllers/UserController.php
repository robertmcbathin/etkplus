<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Session;
use \App\Review;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * SYSTEM FUNCTIONS
     */
    /**
   * [modifyToFullNumber description]
   * @param  [type] $number [description]
   * @return [type]         [description]
   */
    protected function modifyToShortNumber($num){
        return substr_replace($num, '', 1,1);
    }

    protected function modifyToFullNumber($number){
      $card_num_part2 = substr($number,1,2);
      $card_num_part3  = substr($number,3,6);
      if ($card_num_part2 !== 99){ $prefix = '01'; } else {$prefix = '02';}
      $full_card_number = $prefix . $card_num_part2 . $card_num_part3;
      return $full_card_number;
    }
  /**
   * END SYSTEM FUNCTIONS
   * @return [type] [description]
   */
    public function showProfilePage(){
        $usercards = DB::table('ETK_CARD_USERS')
                        ->where('user_id', Auth::user()->id)
                        ->get();
        $cards = [];
        foreach ($usercards as $usercard) {
            $cards[] = $usercard->number;
        }
        /**
         * МАССИВ КАРТ С НОМЕРАМИ ФОРМАТА B
         * @var array
         */
        $b_cards = [];
        foreach ($usercards as $usercard) {
            $b_cards[] = $this->modifyToFullNumber($usercard->number);
        }
        $visits = DB::table('ETKPLUS_VISITS')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id','=','ETKPLUS_PARTNERS.id')
                    ->select('ETKPLUS_VISITS.id','ETKPLUS_VISITS.partner_id','ETKPLUS_VISITS.card_number','ETKPLUS_VISITS.bill','ETKPLUS_VISITS.bill_with_discount','ETKPLUS_VISITS.cashback','ETKPLUS_VISITS.bonus','ETKPLUS_VISITS.discount','ETKPLUS_VISITS.is_reviewed','ETKPLUS_VISITS.created_at','ETKPLUS_VISITS.updated_at',
                        'ETKPLUS_PARTNERS.logo','ETKPLUS_PARTNERS.name')
                    ->whereIn('card_number', $cards)
                    ->orderBy('created_at','DESC')
                    ->paginate(5);
        $bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_PARTNER_USER_BONUSES.partner_id','=','ETKPLUS_PARTNERS.id')
                    ->select('ETKPLUS_PARTNER_USER_BONUSES.*','ETKPLUS_PARTNERS.logo','ETKPLUS_PARTNERS.name')
                    ->whereIn('card_number',$cards)
                    ->get();
        $cashbacks = DB::table('ETK_CARDS')
                        ->whereIn('num',$b_cards)
                        ->select('ETK_CARDS.num','ETK_CARDS.cashback_to_pay','ETK_CARDS.cashback_payed')
                        ->get();
        /**
         * ВОЗВРАТ ЗНАЧЕНИЯ НОМЕРА
         */
        foreach ($cashbacks as $cashback) {
            $cashback->num = $this->modifyToShortNumber($cashback->num);
        }
    	return view('profile',[
            'visits' => $visits,
            'bonuses' => $bonuses,
            'cashbacks' => $cashbacks
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
