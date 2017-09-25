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
use App\Mail\OperatorCreated;
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
      if (($user_bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
      				->where('partner_id', $request->partner_id)
      				->where('card_number',$request->card_number)
      				->first()) == NULL){
      	$user_bonuses = 0;
      } else {
      	$user_bonuses = $user_bonuses->value;
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

      if ($card_number == NULL){
        Session::flash('error', 'Не введен номер карты, введите номер карты еще раз и нажмите "Найти"');
        return redirect()->back();        
      } else {
        try {
          $card = DB::table('ETK_CARDS')
            ->where('num',$this->modifyToFullNumber($card_number))
            ->first();
          $card_chip = $card->chip; 
        } catch (Exception $e) {
         Session::flash('error', $e);
         return redirect()->back();     
        }
      }
      /**
       * ПРОВЕРКА НА ПОЛОЖИТЕЛЬНОСТЬ
       */
      if ($bill < 0){
        Session::flash('error', 'Счет не может принимать отрицательное значение');
        return redirect()->back();
      }
      if ($discount < 0){
        Session::flash('error', 'Размер скидки не может принимать отрицательное значение');
        return redirect()->back();
      }
      if ($bonus < 0){
        Session::flash('error', 'Начисленный бонус не может принимать отрицательное значение');
        return redirect()->back();
      }
      if ($sub_bonus < 0){
        Session::flash('error', 'Нельзя списать отрицательный бонус');
        return redirect()->back();
      }
      /**
       * 
       */
      /**
       * ПРОВЕРКА СПИСАНИЯ БОНУСОВ
       */
      if (($user_bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
        ->where('partner_id', $partner_id)
        ->where('card_number',$card_number)
        ->first()) == NULL){
      try {
          DB::table('ETKPLUS_PARTNER_USER_BONUSES')
            ->insert([
              'partner_id' => $partner_id,
              'card_number' => $card_number,
              'value' => 0
            ]);
        } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();
        }
      }

      if (($user_bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
        ->where('partner_id', $partner_id)
        ->where('card_number',$card_number)
        ->first()) !== NULL){
        if ($sub_bonus > $user_bonuses->value){
          Session::flash('error', 'Нельзя списать бонусов больше, чем есть у клиента');
          return redirect()->back();
        }
      }
      /**
       * 
       */
      /**
       * ВЫЧИСЛЕНИЕ СКИДОК, БОНУСОВ И КЭШБЭКА
       */
      $bill_with_discount = ($bill - ($bill*($discount/100)) - $bonus);

      $partner = \App\Partner::find($partner_id);
      $cashback = ($bill*($partner->default_cashback/100));
      try {
        $user_bonuses = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
        ->where('partner_id', $partner_id)
        ->where('card_number',$card_number)
        ->first();
        $new_user_bonus_value = ($user_bonuses->value + $bonus - $sub_bonus);

      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }

      /**
       * 
       */
      try {
        DB::transaction(function() use ($partner_id,$operator_id,$card_number,$card_chip,$bill,$bill_with_discount,$bonus,$sub_bonus,$discount,$cashback,$new_user_bonus_value) {
          DB::table('ETKPLUS_VISITS')
            ->insert([
              'partner_id' => $partner_id,
              'operator_id' => $operator_id,
              'card_number' => $card_number,
              'card_chip' => $card_chip,
              'bill' => $bill,
              'bill_with_discount' => $bill_with_discount,
              'bonus' => $bonus,
              'sub_bonus' => $sub_bonus,
              'discount' => $discount,
              'cashback' => $cashback   
            ]);
          DB::table('ETKPLUS_PARTNER_USER_BONUSES')
            ->where('card_number',$card_number)
            ->where('partner_id', $partner_id)
            ->update([
              'value' => $new_user_bonus_value
            ]);
        }); 
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
        Session::flash('success','Операция успешно проведена');
        return redirect()->back();
    }

    /**
     * ОПЕРАТОРЫ
     */
    public function getShowOperatorsList(){
      $partner_id = Auth::user()->partner_id;
      $partner = \App\Partner::find($partner_id);

      $operators = DB::table('users')
                      ->where('partner_id',$partner_id)
                      ->get();
      return view('dashboard.partner.operators_list',[
        'partner' => $partner,
        'operators' => $operators
      ]);
    }
    public function postCreateOperator(Request $request){
      define('OPERATOR_ROLE_ID',22);

      $partner_id = $request->partner_id;
      $name       = $request->name;
      $email      = $request->email;
      $password   = $request->password;
      $post       = $request->post;
      $role_id    = OPERATOR_ROLE_ID;
      $is_active  = 1;

      $partner = \App\Partner::find($partner_id);
      if (($operator = DB::table('users')
                        ->where('email',$email)
                        ->first()) !== NULL){
        Session::flash('error','Пользователь с таким email уже существует. Вероятно, он зарегистрирован в личном кабинете ЕТК. Выберите другой email.');
        return redirect()->back();
      } else {
        try {
         // Mail::to($email)->send(new OperatorCreated($email,$password,$partner->name));
          $operator = new \App\User;
          $operator->name = $name;
          $operator->partner_id = $partner_id;
          $operator->email = $email;
          $operator->username = $email;
          $operator->password = bcrypt($password);
          $operator->post = $post;
          $operator->role_id = $role_id;
          $operator->is_active = $is_active;
          $operator->save(); 
        } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();
        }
        Session::flash('success','Оператор успешно создан. На указанный email отправлено письмо с паролем');
        return redirect()->back();
      }
    }

    public function postDeleteOperator(Request $request){
      $operator_id = $request->operator_id;
      try {
        DB::table('users')
          ->where('id',$operator_id)
          ->delete();
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
        Session::flash('success','Оператор успешно удален');
        return redirect()->back();      
    }

    public function postEditOperator(Request $request){
      $operator_id = $request->operator_id;
      $name        = $request->name;
      $email       = $request->email;
      $post        = $request->post;

      try {
        DB::table('users')
          ->where('id',$operator_id)
          ->update([
            'name' => $name,
            'username' => $email,
            'email' => $email,
            'post' => $post
          ]);
      } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();
      }
        Session::flash('success','Данные успешно изменены');
        return redirect()->back();      
    }

    public function postEditOperatorPassword(Request $request){
      $operator_id     = $request->operator_id;
      $password        = bcrypt($request->password);

      try {
        DB::table('users')
          ->where('id',$operator_id)
          ->update([
            'password' => $password
          ]);
      } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();
      }
        Session::flash('success','Пароль успешно изменен');
        return redirect()->back();      
    }
    /**
     * 
     */
}