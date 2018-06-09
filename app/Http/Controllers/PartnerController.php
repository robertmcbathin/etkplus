<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Session;
use Auth;
use Mail;
use \App\User;
use \App\Partner;
use \App\Bill;
use Carbon\Carbon;
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

  /**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
  protected function num2str($num) {
    $nul='ноль';
    $ten=array(
      array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
      array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
  $unit=array( // Units
    array('копейка' ,'копейки' ,'копеек',  1),
    array('рубль'   ,'рубля'   ,'рублей'    ,0),
    array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
    array('миллион' ,'миллиона','миллионов' ,0),
    array('миллиард','милиарда','миллиардов',0),
  );
  //
  list($rub,$kop) = explode(',',sprintf("%015.2f", floatval($num)));
  $out = array();
  if (intval($rub)>0) {
    foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
      if (!intval($v)) continue;
      $uk = sizeof($unit)-$uk-1; // unit key
      $gender = $unit[$uk][3];
      list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
      // mega-logic
      $out[] = $hundred[$i1]; # 1xx-9xx
      if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
      else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
      // units without rub & kop
      if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
    } //foreach
  }
  else $out[] = $nul;
  $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
  $out[] = $kop.' '. $this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
  return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
protected function morph($n, $f1, $f2, $f5) {
  $n = abs(intval($n)) % 100;
  if ($n>10 && $n<20) return $f5;
  $n = $n % 10;
  if ($n>1 && $n<5) return $f2;
  if ($n==1) return $f1;
  return $f5;
}
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
  
  public function showDashboard(){
    $partner = \App\Partner::find(Auth::user()->partner_id);
    $user = \App\User::find(Auth::user()->id);
    $visits = DB::table('ETKPLUS_VISITS')
    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
    ->leftJoin('users','ETKPLUS_VISITS.operator_id', '=', 'users.id')
    ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as operator')
    ->where('ETKPLUS_VISITS.partner_id', $partner->id)
    ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
    ->paginate(50);
    $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
    ->where('partner_id',$partner->id)
    ->get();
    $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
    ->where('partner_id',$partner->id)
    ->get();
    $earnings = DB::table('ETKPLUS_VISITS')
    ->where('partner_id',$partner->id)
    ->sum('bill');
    $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
    ->where('partner_id',$partner->id)
    ->first();
    $addresses = DB::table('ETKPLUS_ADDRESSES')
    ->where('partner_id', $partner->id)
    ->get();
    $gallery_items = DB::table('ETKPLUS_PARTNER_PHOTOS')
    ->where('partner_id', $partner->id)
    ->get();
    $accounts = DB::table('users')
    ->where('partner_id',$partner->id)
    ->get();
    $billings = DB::table('ETKPLUS_PARTNER_BILLING')
    ->where('partner_id',$partner->id)
    ->paginate(10);
    $tariffs = DB::table('ETKPLUS_TARIFFS')
    ->get();
    $tariff = DB::table('ETKPLUS_TARIFFS')
    ->where('id',$partner->tariff_id)
    ->first();

    $manager = DB::table('users')
                ->where('id',$partner->created_by)
                ->first();

    return view('dashboard.partner.index',[
      'partner' => $partner,
      'user' => $user,
      'earnings' => $earnings,
      'balance' => $balance,
      'addresses' => $addresses,
      'bonuses' => $bonuses,
      'discounts' => $discounts,
      'visits' => $visits,
      'accounts' => $accounts,
      'billings' => $billings,
      'tariffs' => $tariffs,
      'tariff' => $tariff,
      'gallery_items' => $gallery_items,
      'manager' => $manager
    ]);
  }

  public function getShowOperations(){
    $operations = DB::table('ETKPLUS_VISITS')
    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
    ->leftJoin('users','ETKPLUS_VISITS.operator_id', '=', 'users.id')
    ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as operator')
    ->where('ETKPLUS_VISITS.partner_id', Auth::user()->partner_id)
    ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
    ->paginate(50);

      $partner = \App\Partner::find(Auth::user()->partner_id);
      $manager = DB::table('users')
            ->where('id',$partner->created_by)
            ->first();
      $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
        ->where('partner_id',$partner->id)
        ->first();
    return view('dashboard.partner.operations_list',[
      'operations' => $operations,
      'manager' => $manager,
      'balance' => $balance,
    ]);
  }
    /**
     * [getCreateOperation description]
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
      $partner = \App\Partner::find($partner_id);
      /**
       * ПРОВЕРКА ФИКСИРОВАННОГО БОНУСА
       */
      if ($bonus == 'null'){
        $bonus = ($bill*$partner->default_bonus)/100;
      }
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
          Session::flash('error', 'Нельзя списать бонусов больше, чем есть на карте');
          return redirect()->back();
        }
      }
      /**
       * ПРОВЕРКА БАЛАНСА, ДОСТУПНОГО ДЛЯ ПРОВЕДЕНИЯ ОПЕРАЦИИ
       */
      $current_balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
      ->where('partner_id',$partner_id)
      ->first();

      /**
       * ВЫЧИСЛЕНИЕ СКИДОК, БОНУСОВ И КЭШБЭКА
       */
      $discount_value = ($bill*($discount/100));
      $bill_with_discount = (($bill - $discount_value) - $sub_bonus);
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
       * НОМЕР КАРТЫ ПО ФОРМАТУ В
       */
      $b_card_number = $this->modifyToFullNumber($card_number);
      /**
       * ДОСТАТОЧНО ЛИ СРЕДСТВ НА АККАУНТЕ
       */
      $partner = DB::table('ETKPLUS_PARTNERS')
                    ->where('id',$partner_id)
                    ->first();
      $tariff = DB::table('ETKPLUS_TARIFFS')
      ->where('id',$partner->tariff_id)
      ->first();
      /*
      *  РАСЧЕТ КЭШБЭКА
       */
      $partner = \App\Partner::find($partner_id);
      /**
       * LIFETIME КЭШБЭКА
       */
      $cashback_lifetime = Carbon::now();
      $cashback_lifetime->addYear();
      /**
       * ЗНАЧЕНИЕ КЭШБЭКА ДЛЯ ЗАЧИСЛЕНИЯ НА КАРТУ
       */
      $cashback = ceil(($bill*($tariff->cashback/100))); //ОКРУГЛЯЕМ КЭШБЭК В БОЛЬШУЮ СТОРОНУ
      if (($current_balance->value - ($bill*$tariff->comission/100)) < $current_balance->min_value ){
        Session::flash('error','Недостаточно средств для проведения транзакции');
        return redirect()->back();
      } else {
        $comission = ($bill*$tariff->comission/100);
        $new_balance = ($current_balance->value - $comission);
      }
      
      try {
        DB::transaction(function() use ($partner_id,$operator_id,$card_number,$card_chip,$bill,$bill_with_discount,$bonus,$sub_bonus,$discount,$discount_value,$comission,$cashback,$new_user_bonus_value,$new_balance,$b_card_number,$cashback_lifetime) {
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
            'discount_value' => $discount_value,
            'comission' => $comission,
            'cashback' => $cashback   
          ]);
          DB::table('ETKPLUS_PARTNER_USER_BONUSES')
          ->where('card_number',$card_number)
          ->where('partner_id', $partner_id)
          ->update([
            'value' => $new_user_bonus_value
          ]);
          DB::table('ETKPLUS_PARTNER_ACCOUNTS')
          ->where('partner_id',$partner_id)
          ->update(['value' => $new_balance]);
            /**
             * КЭШБЭК
             */
            DB::table('ETK_CARDS')
            ->where('num',$b_card_number)
            ->update(['cashback_to_pay' => $cashback]);
          }); 
        DB::table('ETKPLUS_CASHBACKS')
        ->insert([
          'card_number' => $card_number,
          'value' => $cashback,
          'status' => 1,
          'lifetime' => $cashback_lifetime
        ]);
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
      $lastname   = $request->lastname;
      $email      = $request->email;
      $password   = $request->password;
      $post       = $request->post;
      $role_id    = 22;
      $is_active  = 1;

      $partner = \App\Partner::find($partner_id);
      if (($isset_operator = DB::table('users')
        ->where('email',$email)
        ->first()) !== NULL){
        Session::flash('error','Пользователь с таким email уже существует. Вероятно, он зарегистрирован в личном кабинете ЕТК. Выберите другой email.');
        return redirect()->back();
      } else {
        try {
          $operator = new \App\User;
          $operator->name = $name;
          $operator->lastname = $lastname;
          $operator->partner_id = $partner_id;
          $operator->email = $email;
          $operator->username = $email;
          $operator->password = bcrypt($password);
          $operator->post = $post;
          $operator->role_id = $role_id;
          $operator->is_active = $is_active;
          $operator->profile_image = 'https://etk21.ru/images/account_circle.png';
          $operator->save(); 
          Mail::to($email)->send(new OperatorCreated($email,$password,$partner->name));
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
     * ОТЗЫВЫ
     */
    public function getShowReviews(){
      $partner_id = Auth::user()->partner_id;
      $reviews = DB::table('ETKPLUS_REVIEWS')
      ->where('partner_id',$partner_id)
      ->paginate(10);

      return view('dashboard.partner.reviews',[
        'reviews' => $reviews
      ]);
    }

    public function postApproveReview(Request $request){
        $review_id = $request->review_id;
        $approved_by = $request->approved_by;

        $review = \App\Review::find($review_id);
        $review->published = 1;
        $review->approved_by = $approved_by;
        if ($review->save()){
            Session::flash('success','Отзыв одобрен');
            return redirect()->back();
        } else {
            Session::flash('error','Не удалось одобрить отзыв');
            return redirect()->back();            
        }
        
    }

    public function postDisapproveReview(Request $request){
        $review_id = $request->review_id;
        $approved_by = $request->approved_by;

        $review = \App\Review::find($review_id);
        $review->published = 0;
        $review->approved_by = $approved_by;
        if ($review->save()){
            Session::flash('success','Отзыв снят с публикации');
            return redirect()->back();
        } else {
            Session::flash('error','Не удалось снять отзыв с публикации');
            return redirect()->back();            
        }
      }
    /**
     * ОПЛАТА УСЛУГ
     */
    public function getBillingPage(){
      $partner = \App\Partner::find(Auth::user()->partner_id);
      $billings = DB::table('ETKPLUS_PARTNER_BILLING')
      ->where('partner_id',$partner->id)
      ->paginate(10);
      return view('dashboard.partner.billing',[
        'partner' => $partner,
        'billings' => $billings 
      ]);
    }

    public function postAddInvoice(Request $request){
  /**
   * ДАННЫЕ ПО ОРГАНИЗАЦИИ
   */
  $partner = \App\Partner::find($request->partner_id);
  /**
   * СОЗДАНИЕ СЧЕТА
   */
  
  $bill_id = DB::table('ETKPLUS_PARTNER_BILLING')
  ->insertGetId([
    'partner_id' => $request->partner_id,
    'type' => 1,
    'status' => 0,
    'value' => $request->value
  ]);
  $bill_number = 's' .$bill_id;
  $bill = DB::table('ETKPLUS_PARTNER_BILLING')
  ->where('id',$bill_id)
  ->update(['bill_number' => $bill_number]);
  setlocale(LC_ALL, 'ru_RU.UTF-8');
  $date_by = Carbon::now();

  $invoice = \App::make('snappy.pdf');
  $html = '<small class="text-center">Внимание! Оплата данного счета означает согласие с условиями оказания услуг. Пополнение виртуального счета производится по факту поступления денежных средств на расчетный счет Поставщика.</small>';
  $html .= '<table style="width:100%; border-collapse: separate; border: 1px solid black;">';
  $html .= '<tr><td>ЧУВАШСКОЕ ОТДЕЛЕНИЕ №8613</td><td>БИК</td><td>049706609</td></tr>';
  $html .= '<tr><td>ПАО СБЕРБАНК Г. ЧЕБОКСАРЫ</td><td></td><td></td></tr>';
  $html .= '<tr><td>Банк получателя</td><td>Счет №</td><td>30101810300000000609</td></tr>';
  $html .= '</table>';
  $html .= '<table style="width:100%; border-collapse: separate; border: 1px solid black;">';
  $html .= '<tr><td>ИНН 210080498</td><td>КПП 213001001</td><td>Счет №40702810375000004536</td></tr>';
  $html .= '<tr><td>ООО "Единая транспортная карта"</td><td></td><td></td></tr>';
  $html .= '<tr><td>Получатель</td><td></td><td></td></tr>';
  $html .= '</table>';
  $html .= '<h3>Счет на оплату №' . $bill_number . ' по договору №' . $partner->contract_id . ' от ' . $date_by->format('d.m.Y') . '</h3>';
  $html .= '<hr>';
  $html .= '<p>Поставщик: <b>ООО "ЕТК", ИНН 2130080498, 428000, Чувашская - Чувашия Респ, Чебоксары г, Тракторостроителей пр-кт, дом №6б, тел.: (8352) 49-25-85, 36-03-30, 36-33-30</b></p>';
  $html .= '<p>Покупатель: <b>' . $partner->fullname . ', ИНН ' . $partner->inn . ', КПП ' . $partner->kpp . ', ' . $partner->legal_address . ', тел.: ' . $partner->phone . '</b></p>';
  $html .= '<table style="width:100%; border-collapse: separate; border: 2px solid black;">';
  $html .= '<tr><td><b>№</b></td><td><b>Товары (работы, услуги)</b></td><td><b>Кол-во</b></td><td><b>Ед.</b></td><td><b>Цена</b></td><td><b>Сумма</b></td></tr>';
  $html .= '<tr><td>1</td><td>Услуги системы лояльности (авансовый платеж)</td><td>1</td><td>шт</td><td>' . number_format($request->value,2,',', ' ') . '</td><td>' . number_format($request->value,2,',', ' ') . '</td></tr>';
  $html .= '</table></br>';
  $html .= '<table style="width:100%; border-collapse: none; border: none; text-align: right;" align="right">';
  $html .= '<tr><td style="width:100%;"><b>Итого: ' . number_format($request->value,2,',', ' ') . '</b></td></tr>';
  $html .= '<tr><td style="width:100%;"><b>Без налога (НДС)   -</b></td></tr>';
  $html .= '<tr><td style="width:100%;"><b>Всего к оплате: ' . number_format($request->value,2,',', ' ') . '</b></td></tr>';
  $html .= '</table></br>';
  $html .= '<p>Всего наименований 1, на сумму ' . number_format($request->value,2,',', ' ') . ' руб.</p>';
  $html .= '<p><b>' . $this->num2str($request->value) . '</b></p>';
  $html .= '<hr></br></br>';
  $html .= '<table style="width:100%; border-collapse: none; border: none;">';
  $html .= '<tr>';
  $html .= '<td style="width: 20%;">Руководитель</br></br></br></br>Бухгалтер</td>';
  $html .= '<td style="width: 60%; text-align: right;"><img src="http://etkplus-beta.ru/images/signs.jpg"></td>';
  $html .= '<td style="width: 20%;">/Горбунов А.Е./</br></br></br></br>/Казакова Т.В./</td>';
  $html .= '</tr>';
  $html .= '</table></br>';

  
  $invoice_name = '/tmp/invoice-' . $partner->contract_id . '-' . date('dmY-His');
  $invoice->generateFromHtml($html,$invoice_name);
  $invoice_output = 'invoice-' . $partner->contract_id . '-' . date('dmY-His');
  $content_disposition = 'attachment; filename="' . $invoice_output . '.pdf"';
  return new Response(
    $invoice->getOutputFromHtml($html,array(
      'encoding' => 'utf-8'
    )),
    200,
    array(
      'Content-Type'          => 'application/pdf',
      'Content-Disposition'   => $content_disposition
    )
  );
}

public function createTestPDF(){
  $snappy = \App::make('snappy.pdf');
  $html = '<h1>Bill</h1><p>You owe me money, dude.</p>';
     // $snappy->generateFromHtml($html, '/tmp/bill-125.pdf');
     // $snappy->generate('http://www.github.com', '/tmp/github.pdf');
//Or output:
  return new Response(
    $snappy->getOutputFromHtml($invoice),
    200,
    array(
      'Content-Type'          => 'application/pdf',
      'Content-Disposition'   => 'attachment; filename="file.pdf"'
    )
  );
}



public function postEditPartner(Request $request){
        /**
         * GET VARIABLES
         */
        $partner_id       = $request->partner_id;
        $user_id          = $request->user_id;
        $name             = $request->name;
        $fullname         = $request->fullname;
        $description      = $request->description;
        $phone            = $request->phone;
        $address          = $request->phone;
        $email            = $request->email;
        $site             = $request->site;
        $comission        = $request->comission;
        $contract_id      = $request->contract_id;
        $legal_address    = $request->legal_address;
        $physical_address = $request->physical_address;
        $inn              = $request->inn;
        $kpp              = $request->kpp;
        $ogrn             = $request->ogrn;  
        $discount         = $request->discount;
        /**
         * SAVE CHANGES
         */
        try {
            DB::table('ETKPLUS_PARTNERS')
            ->where('id',$partner_id)
            ->update([
                'name' => $name,
                'fullname' => $fullname,
                'description' => $description,
                'phone' => $phone,
                'address' => $address,
                'email' => $email,
                'site' => $site,
                'default_comission' => $comission,
                'default_discount' => $discount,
                'contract_id' => $contract_id,
                'legal_address' => $legal_address,
                'physical_address' => $physical_address,
                'inn' => $inn,
                'kpp' => $kpp,
                'ogrn' => $ogrn,
                'updated_by' => $user_id
            ]);   
        } catch (Exception $e) {
            Session::flash('error',$e);
            return redirect()->back();  
        }
        Session::flash('success','Данные организации успешно изменены');
        return redirect()->back();   
    }

    /**
     * [postEditPartnerLogos description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postEditPartnerLogo(Request $request){
        $partner_id  = $request->partner_id;
        $user_id     = $request->user_id;

        $partner = \App\Partner::find($partner_id);

      $logo_image = $request->file('logo_image');
      if ($logo_image){
          $logo_image_extension = $request->file('logo_image')->getClientOriginalExtension();   
          $logo_imagename = '/assets/img/partners/' . $partner->id . '/logo.' . $logo_image_extension;            
          Storage::disk('public')->put($logo_imagename, File::get($logo_image));
          $partner->logo = $logo_imagename;
          $partner->save();
      }
      Session::flash('success', 'Изменения сохранены');
      return redirect()->back();
  }

    public function postEditPartnerBackground(Request $request){
        $partner_id  = $request->partner_id;
        $user_id     = $request->user_id;

        $partner = \App\Partner::find($partner_id);
        $background_image = $request->file('background_image');
        if ($background_image){
          $background_image_extension = $request->file('background_image')->getClientOriginalExtension();
          $background_imagename = '/assets/img/partners/' . $partner->id . '/background.' . $background_image_extension;          
          Storage::disk('public')->put($background_imagename, File::get($background_image));
          $partner->thumbnail = $background_imagename;
          $partner->save();
      } 

      Session::flash('success', 'Изменения сохранены');
      return redirect()->back();
  }


  /**
 * GALLERY ITEMS
 *
 *
 * 
 * @param  Request $request [description]
 * @return [type]           [description]
 */
public function postEditGalleryItem(Request $request){
    $gallery_item_id = $request->gallery_item_id;
    $image_caption = $request->image_caption;
    DB::table('ETKPLUS_PARTNER_PHOTOS')
    ->where('id', $gallery_item_id)
    ->update(['image_caption' => $image_caption]);
    Session::flash('success','Название элемента галереи успешно изменено');
    return redirect()->back();
}
public function postLoadGallery(Request $request){
    $partner_id = $request->partner_id;
    $partner = \App\Partner::find($partner_id);
    foreach ($request->gallery as $gallery_item) {
        if ($gallery_item){
            $picture_extension = $gallery_item->getClientOriginalExtension();
            $image_size = getimagesize($gallery_item);
            $image_width = $image_size[0];
            $image_height = $image_size[1];
            $picture_name = '/assets/img/partners/' . $partner->id .'/gallery' . '/' . $this->generateRandomString() . '.' . $picture_extension;
            Storage::disk('public')->put($picture_name, File::get($gallery_item));
            DB::table('ETKPLUS_PARTNER_PHOTOS')
            ->insert([
                'partner_id' => $partner_id,
                'image_path' => $picture_name,
                'image_width' => $image_width,
                'image_height' => $image_height
            ]);

        } else {
            Session::flash('error', 'Произошла ошибка, файлы загрузить не удалось');
            return redirect()->back();
        }
    }
    Session::flash('success','Изображения загружены. Необходимо дать им названия');
    return redirect()->back();
}
    /**
     * [postDeleteGalleryItem description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    
  public function postDeleteGalleryItem(Request $request){
        $gallery_item_id = $request->gallery_item_id;
        $gallery_item_path = $request->image_path;
        DB::table('ETKPLUS_PARTNER_PHOTOS')
        ->where('id', $gallery_item_id)
        ->delete();
        try {
            Storage::disk('public')->delete($gallery_item_path);   
        } catch (Exception $e) {
            Session::flash('error',$e);
            return redirect()->back();      
        }
        Session::flash('success','Изображение удалено');
        return redirect()->back();
    }

    /**
     * ADDRESSES
     *
     * 
     */
    public function postAddPartnerAddress(Request $request){
        $partner_id = $request->partner_id;
        $name       = $request->name;
        $text       = $request->text;
        $comment    = $request->comment;
        $schedule   = $request->schedule;
        $phones     = $request->phones;
        $latitude   = $request->latitude;
        $longitude  = $request->longitude;
        try {
            DB::table('ETKPLUS_ADDRESSES')
            ->insert([
                'partner_id' => $partner_id,
                'name' => $name,
                'text' => $text,
                'comment' => $comment,
                'schedule' => $schedule,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'phones' => $phones
            ]);
            Session::flash('success','Адрес успешно добавлен');
            return redirect()->back();

        } catch (Exception $e) {
            Session::flash('error',$e);
            return redirect()->back();              
        }
    }
    public function postDeletePartnerAddress(Request $request){
        $address_id = $request->address_id;
        try {
            DB::table('ETKPLUS_ADDRESSES')
            ->where('id',$address_id)
            ->delete();
            Session::flash('success','Адрес успешно удален');
            return redirect()->back();
        } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();           
      }
  }
    /**
     * END OF ADDRESSES
     */
    
        /**
     * DISCOUNTS
     */
    public function postAddPartnerDiscount(Request $request){
        $partner_id  = $request->partner_id;
        $description = $request->description;
        $value       = $request->value;
        $lifetime = date_create_from_format('d/m/Y',$request->lifetime);
        if (intval($value) == 0){
            Session::flash('error', 'Значение должно быть целым числом');
            return redirect()->back(); 
        }
        try {
            DB::table('ETKPLUS_PARTNER_DISCOUNTS')
            ->insert([
                'partner_id' => $partner_id,
                'value' => $value,
                'description' => $description,
                'lifetime' => $lifetime
            ]);
            Session::flash('success','Скидка успешно добавлена');
            return redirect()->back();

        } catch (Exception $e) {
            Session::flash('error',$e);
            return redirect()->back();              
        }
    }
    public function postDeletePartnerDiscount(Request $request){
        $discount_id = $request->discount_id;
        try {
            DB::table('ETKPLUS_PARTNER_DISCOUNTS')
            ->where('id',$discount_id)
            ->delete();
            Session::flash('success','Скидка успешно удалена');
            return redirect()->back();
        } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();           
      }
  }
    /**
     * END OF DUSCOUNTS
     */
    
        /**
     * DISCOUNTS
     */
    public function postAddPartnerBonus(Request $request){
        $partner_id  = $request->partner_id;
        $description = $request->description;
        $type        = $request->type;
        $value       = $request->value;
        $lifetime = date_create_from_format('d/m/Y',$request->lifetime);
        if (!(is_numeric($value))){
            Session::flash('error', 'Значение должно быть числом');
            return redirect()->back(); 
        }
        if (intval($value) == 0){
            Session::flash('error', 'Значение должно быть целым числом');
            return redirect()->back(); 
        }
        try {
            DB::table('ETKPLUS_PARTNER_BONUSES')
            ->insert([
                'partner_id' => $partner_id,
                'value' => $value,
                'description' => $description,
                'type' => $type,
                'lifetime' => $lifetime
            ]);
            Session::flash('success','Бонус успешно добавлен');
            return redirect()->back();

        } catch (Exception $e) {
            Session::flash('error',$e);
            return redirect()->back();              
        }
    }
    public function postDeletePartnerBonus(Request $request){
        $bonus_id = $request->bonus_id;
        try {
            DB::table('ETKPLUS_PARTNER_BONUSES')
            ->where('id',$bonus_id)
            ->delete();
            Session::flash('success','Бонус успешно удален');
            return redirect()->back();
        } catch (Exception $e) {
          Session::flash('error',$e);
          return redirect()->back();           
      }
  }
    /**
     * END OF DUSCOUNTS
     */
    
    public function getCardNumberPage($card_number){



      $card = DB::table('ETK_CARDS')
              ->where('num',$this->modifyToFullNumber($card_number))
              ->first();
      $bonus_sum = DB::table('ETKPLUS_PARTNER_USER_BONUSES')
                      ->where('card_number',$card_number)
                      ->where('partner_id',Auth::user()->partner_id)
                      ->first();
      if (($visit_count = DB::table('ETKPLUS_VISITS')
        ->where('card_number',$card_number)
        ->where('partner_id', Auth::user()->partner_id)
        ->count()) == NULL){
        $visit_count = 0;
      };

      if (($visit_summary = DB::table('ETKPLUS_VISITS')
        ->where('card_number',$card_number)
        ->where('partner_id', Auth::user()->partner_id)
        ->sum('ETKPLUS_VISITS.bill')) == NULL){
        $visit_summary = 0;
      };

      $operations = DB::table('ETKPLUS_VISITS')
                      ->where('partner_id',Auth::user()->partner_id)
                      ->where('card_number',$card_number)
                      ->orderBy('created_at','desc')
                      ->paginate(25);

      $partner = \App\Partner::find(Auth::user()->partner_id);
      $manager = DB::table('users')
            ->where('id',$partner->created_by)
            ->first();
      $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
        ->where('partner_id',$partner->id)
        ->first();
      return view('dashboard.partner.card',[
        'card' => $card,
        'bonus_sum' => $bonus_sum,
        'visit_count' => $visit_count,
        'visit_summary' => $visit_summary,
        'manager' => $manager,
        'balance' => $balance,
        'operations' => $operations
      ]);
    }

    public function getOperatorPage($operator_id){
      $operator = DB::table('users')
                    ->where('id',$operator_id)
                    ->first();

      if (($visit_count = DB::table('ETKPLUS_VISITS')
        ->where('operator_id',$operator_id)
        ->where('partner_id', Auth::user()->partner_id)
        ->count()) == NULL){
        $visit_count = 0;
      };

      if (($visit_summary = DB::table('ETKPLUS_VISITS')
        ->where('operator_id',$operator_id)
        ->where('partner_id', Auth::user()->partner_id)
        ->sum('ETKPLUS_VISITS.bill')) == NULL){
        $visit_summary = 0;
      };

      $operations = DB::table('ETKPLUS_VISITS')
                      ->where('partner_id',Auth::user()->partner_id)
                      ->where('operator_id',$operator_id)
                      ->orderBy('created_at','desc')
                      ->paginate(25);

      $partner = \App\Partner::find(Auth::user()->partner_id);
      $manager = DB::table('users')
            ->where('id',$partner->created_by)
            ->first();
      $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
        ->where('partner_id',$partner->id)
        ->first();

      return view('dashboard.partner.operator',[
        'operator' => $operator,
        'manager' => $manager,
        'balance' => $balance,
        'visit_count' => $visit_count,
        'visit_summary' => $visit_summary,
        'operations' => $operations
      ]);
    }


    public function getSettings(){
      $partner = \App\Partner::find(Auth::user()->partner_id);
      $default_discount = $partner->default_discount;
      $default_bonus = $partner->default_bonus;
      return view('dashboard.partner.settings',[
        'default_discount' => $default_discount,
        'default_bonus' => $default_bonus
      ]);
    }

    public function postSaveSettings(Request $request){
      $default_discount = $request->fixed_discount;
      $default_bonus    = $request->fixed_bonus;

      $partner = \App\Partner::find(Auth::user()->partner_id);
      $partner_id = $partner->id;
      if (DB::table('ETKPLUS_PARTNERS')
        ->where('id',$partner_id)
        ->update([
          'default_discount' => $default_discount,
          'default_bonus' => $default_bonus
        ])) {
        Session::flash('success','Настройки сохранены');
        return redirect()->back();
      } else{
        Session::flash('error','Изменить настройки не удалось');
        return redirect()->back();
      }
    }
    
    /** 
    *
    *
    *
    *
    * ETKTRADE
    *
    *
    *
    *
    *
    **/
    public function showShopProductsPage(){
      $user = DB::table('users')
                ->where('id',Auth::user()->id)
                ->first();
    $partner = DB::table('ETKPLUS_PARTNERS')
                ->where('id',$user->partner_id)
                ->first();
    $shop = DB::table('ETKTRADE_SHOPS')
              ->where('partner_id',$partner->id)
              ->first();
    $products = DB::table('ETKTRADE_PRODUCTS')
    ->leftJoin('ETKTRADE_SHOPS','ETKTRADE_SHOPS.id', '=', 'ETKTRADE_PRODUCTS.shop_id')
    ->leftJoin('ETKTRADE_CATEGORIES','ETKTRADE_CATEGORIES.id','=','ETKTRADE_PRODUCTS.category_id')
    ->leftJoin('ETKTRADE_AVAILABILITY_TYPES','ETKTRADE_AVAILABILITY_TYPES.id','=','ETKTRADE_PRODUCTS.availability')
    ->where('shop_id',$shop->id)
    ->select('ETKTRADE_PRODUCTS.*','ETKTRADE_SHOPS.name as shop_name', 'ETKTRADE_CATEGORIES.title as category','ETKTRADE_AVAILABILITY_TYPES.title as availability_status')
    ->orderBy('created_at','desc')
    ->limit(100)
    ->paginate(50);
    $categories = DB::table('ETKTRADE_CATEGORIES')
    ->orderBy('id')
    ->get();
    return view('dashboard.trade.partner.products',[
      'products' => $products,
      'categories' => $categories
    ]);
    }

    public function getShopAddProduct(){
      $categories = DB::table('ETKTRADE_CATEGORIES')
      ->orderBy('id')
      ->get();
      $shops = DB::table('ETKTRADE_SHOPS')
      ->join('ETKTRADE_SHOP_TYPES', 'ETKTRADE_SHOP_TYPES.id', '=' , 'ETKTRADE_SHOPS.type')
      ->select('ETKTRADE_SHOPS.*', 'ETKTRADE_SHOP_TYPES.name as type_name')
      ->get();
      $brands = DB::table('ETKTRADE_BRANDS')
      ->orderBy('name')
      ->get();
      $availability_types = DB::table('ETKTRADE_AVAILABILITY_TYPES')
      ->get();
      $manufacturers = DB::table('ETKTRADE_MANUFACTURERS')
      ->orderBy('title')
      ->get();
      return view('dashboard.trade.partner.add_product_item',[
        'categories' => $categories,
        'shops' => $shops,
        'brands' => $brands,
        'availability_types' => $availability_types,
        'manufacturers' => $manufacturers
      ]);
    }

    public function postDeleteProduct(Request $request){

    }

    /** 
    *
    *
    *
    *
    * END ETKTRADE
    *
    *
    *
    *
    *
    **/
}
