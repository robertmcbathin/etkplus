<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use Mail;
use \App\User;
use \App\Partner;
use App\Mail\PartnerRegistered;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class PartnerController extends Controller
{
	/**
	 * SYSTEM FUNCTIONS
	 */
	/**
   * [modifyToFullNumber description]
   * @param  [type] $number [description]
   * @return [type]         [description]
   */
  public function modifyToFullNumber($number){
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
  

    public function getCreateOperation(){
    	$partner = DB::table('ETKPLUS_PARTNERS')
    				->where('id', Auth::user()->partner_id)
    				->first();
      $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
                      ->where('partner_id',$partner->id)
                      ->get();
      $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
                    ->where('partner_id',$partner->id)
                    ->get();
    	return view('dashboard.partner.create-operation',[
    		'partner' => $partner,
        'discounts' => $discounts,
        'bonuses' => $bonuses
    	]);
    }
    /**
     * AJAX
     */
    public function ajaxCheckCardAndOperations(Request $request){
      $card_number = $this->modifyToFullNumber($request->card_number);
      $card = DB::table('ETK_CARDS')
                ->where('num', $card_number)
                ->first();
      /**
       * ПРОВЕРКА НА БОНУСЫ
       * @var [type]
       */
      if ($user_bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
      				->where('partner_id', $request->partner_id)
      				->where('card_number',$request->card_number)
      				->first() == NULL){
      	$user_bonuses = 0;
      } else {
      	$user_bonuses = $bonuses->value;
      };
      /**
       * ПРОВЕРКА ВИЗИТОВ
       */
      if (($visit_count = DB::table('ETKPLUS_VISITS')
      				->where('card_number',$request->card_number)
      				->where('partner_id', $request->partner_id)
      				->count()) == NULL){
      	$visit_count = 0;
      };
      if (($visit_summary = DB::table('ETKPLUS_VISITS')
      				->where('card_number',$request->card_number)
      				->where('partner_id', $request->partner_id)
      				->sum('ETKPLUS_VISITS.bill')) == NULL){
      	$visit_summary = 0;
      };
      /**
       * СПИСОК СКИДОК
       * @var [type]
       */
      $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
                      ->where('partner_id',$request->partner_id)
                      ->get();
      $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
                    ->where('partner_id',$request->partner_id)
                    ->get();
      if ($card == NULL)
        return response()->json(['message' => 'error'],200);
      if ($card !== NULL)
        return response()->json(['message' => 'success', 'card' => $card, 'user_bonuses' => $user_bonuses, 'visit_count' => $visit_count, 'visit_summary' => $visit_summary,
          'discounts' => $discounts, 'bonuses' => $bonuses],200);
    }

    public function postCreateOperation(Request $request){
      $partner_id  = $request->partner_id;
      $operator_id = $request->operator_id;
      $card_number = $request->card_number;
      $bill        = $request->bill;
      $discount    = $request->discount;
      $bonus       = $request->bonus;
      $sub_bonus   = $request->sub_bonus;
      dd($request);
    }
}
