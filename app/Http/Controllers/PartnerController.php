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
    	return view('dashboard.partner.create-operation',[
    		'partner' => $partner
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
      if ($bonuses = DB::table('ETKPLUS_BONUSES')
      				->where('partner_id', $request->partner_id)
      				->where('card_number',$request->card_number)
      				->first() == NULL){
      	$bonuses = 0;
      } else {
      	$bonuses = $bonuses->value;
      };
      /**
       * ПРОВЕРКА ВИЗИТОВ
       */
      if ($visit_count = DB::table('ETKPLUS_VISITS')
      				->where('card_number',$request->card_number)
      				->where('partner_id', $request->partner_id)
      				->count() == NULL){
      	$visit_count = 0;
      };
      if ($visit_summary = DB::table('ETKPLUS_VISITS')
      				->where('card_number',$request->card_number)
      				->where('partner_id', $request->partner_id)
      				->count() == NULL){
      	$visit_summary = 0;
      };

      if ($card == NULL)
        return response()->json(['message' => 'error'],200);
      if ($card !== NULL)
        return response()->json(['message' => 'success', 'card' => $card, 'bonuses' => $bonuses, 'visit_count' => $visit_count, 'visit_summary' => $visit_summary],200);
    }
}
