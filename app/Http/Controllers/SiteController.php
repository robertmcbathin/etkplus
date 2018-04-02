<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;
use Auth;
use Carbon\Carbon;
use \App\User;
use \App\Review;

class SiteController extends Controller
{

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

    public function showIndex(){
        $partners = DB::table('ETKPLUS_PARTNERS')
                      ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at', 
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                      ->where('ETKPLUS_PARTNERS.is_active',1)
                      ->where('ETKPLUS_PARTNERS.published',1)
                      ->orderBy('created_at', 'DESC')
                      ->limit(9)
                      ->get();

        return view('index',[
            'partners' => $partners
            ]);
    }

    public function showAbout(){
      return view('about');
    }

    public function showPartnership(){
      return view('partnership');
    }

    public function showPartnershipLoyalty(){
      return view('partnership.loyalty');
    }

    public function showCategory($id){
      $partners = DB::table('ETKPLUS_PARTNERS')
              ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
              ->where('ETKPLUS_PARTNERS.is_active',1)
              ->where('ETKPLUS_PARTNERS.published',1)
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
                        'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description', 'ETKPLUS_PARTNERS.tariff_id')
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
         * СКИДКИ
         */
        $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
                      ->where('partner_id',$partner->id)
                      ->get();
        /**
         * БОНУСЫ
         */
        $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
                      ->where('partner_id',$partner->id)
                      ->get();
        /**
         * КЭШБЭК
         */
        $tariff = DB::table('ETKPLUS_TARIFFS')
        ->where('id',$partner->tariff_id)
        ->first(); 
        $cashback = $tariff->cashback; 
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
             ->where('ETKPLUS_REVIEWS.published',1)
             ->select('ETKPLUS_REVIEWS.*','ETKPLUS_PARTNERS.logo','ETKPLUS_PARTNERS.name','users.profile_image')
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
            'reviews' => $reviews,
            'discounts' => $discounts,
            'bonuses' => $bonuses,
            'cashback' => $cashback
            ]);
    }
    /**
     * ВСЕ ОТЗЫВЫ
     */
    
    public function showPartnerReviewsPage($id){
    $partner = DB::table('ETKPLUS_PARTNERS')
                  ->select('ETKPLUS_PARTNERS.id','ETKPLUS_PARTNERS.name','ETKPLUS_PARTNERS.fullname','ETKPLUS_PARTNERS.created_at', 'ETKPLUS_PARTNERS.updated_at',
                    'ETKPLUS_PARTNERS.rating','ETKPLUS_PARTNERS.default_discount','ETKPLUS_PARTNERS.default_cashback','ETKPLUS_PARTNERS.logo', 'ETKPLUS_PARTNERS.thumbnail', 'ETKPLUS_PARTNERS.address', 'ETKPLUS_PARTNERS.site', 'ETKPLUS_PARTNERS.description')
                  ->where('ETKPLUS_PARTNERS.id', $id)
                  ->where('ETKPLUS_PARTNERS.is_active',1)
                  ->where('ETKPLUS_PARTNERS.published',1)
                  ->first();
    $reviews = DB::table('ETKPLUS_REVIEWS')
                ->join('ETKPLUS_PARTNERS','ETKPLUS_REVIEWS.partner_id','=','ETKPLUS_PARTNERS.id')
                ->join('users','ETKPLUS_REVIEWS.user_id', '=', 'users.id')
                ->where('ETKPLUS_REVIEWS.partner_id', $partner->id)
                ->where('ETKPLUS_REVIEWS.published',1)
                ->select('ETKPLUS_REVIEWS.*','ETKPLUS_PARTNERS.logo','ETKPLUS_PARTNERS.name','users.profile_image')
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

public function showRules(){
  return view('rules');
}

public function showContacts(){
  return view('contacts');
}

public function showOffer(){
  return view('offer');
}

public function postCreateInvoice(Request $request){
  /**
   * INIT VARIABLES
   */
  $contract_id = $request->contract_id;
  $name = $request->name;
  $inn = $request->inn;
  $kpp = $request->kpp;
  $legal_address = $request->legal_address;
  $phone = $request->phone;
  $value = $request->value;
  /**
   * СОЗДАНИЕ СЧЕТА
   */
  $partner = DB::table('ETKPLUS_PARTNERS')
               ->where('contract_id',$contract_id)
               ->first();
  if ($partner !== NULL){
    $contract_id = $partner->contract_id;
  } else {
    Session::flash('Такого договора не существует, попробуйте снова');
    return redirect()->back();
  }

  $bill_id = DB::table('ETKPLUS_PARTNER_BILLING')
                      ->insertGetId([
                        'partner_id' => $partner->id,
                        'type' => 1,
                        'status' => 0,
                        'value' => $value
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
  $html .= '<h3>Счет на оплату №' . $bill_number . ' по договору №' . $contract_id .  ' от ' . $date_by->format('d.m.Y') . '</h3>';
  $html .= '<hr>';
  $html .= '<p>Поставщик: <b>ООО "ЕТК", ИНН 2130080498, 428000, Чувашская - Чувашия Респ, Чебоксары г, Тракторостроителей пр-кт, дом №6б, тел.: (8352) 49-25-85, 36-03-30, 36-33-30</b></p>';
  $html .= '<p>Покупатель: <b>' . $name . ', ИНН ' . $inn . ', КПП ' . $kpp . ', ' . $legal_address . ', тел.: ' . $phone . '</b></p>';
  $html .= '<table style="width:100%; border-collapse: separate; border: 2px solid black;">';
  $html .= '<tr><td><b>№</b></td><td><b>Товары (работы, услуги)</b></td><td><b>Кол-во</b></td><td><b>Ед.</b></td><td><b>Цена</b></td><td><b>Сумма</b></td></tr>';
  $html .= '<tr><td>1</td><td>Услуги системы лояльности (авансовый платеж)</td><td>1</td><td>шт</td><td>' . number_format($value,2,',', ' ') . '</td><td>' . number_format($value,2,',', ' ') . '</td></tr>';
  $html .= '</table></br>';
  $html .= '<table style="width:100%; border-collapse: none; border: none; text-align: right;" align="right">';
  $html .= '<tr><td style="width:100%;"><b>Итого: ' . number_format($value,2,',', ' ') . '</b></td></tr>';
  $html .= '<tr><td style="width:100%;"><b>Без налога (НДС)   -</b></td></tr>';
  $html .= '<tr><td style="width:100%;"><b>Всего к оплате: ' . number_format($value,2,',', ' ') . '</b></td></tr>';
  $html .= '</table></br>';
  $html .= '<p>Всего наименований 1, на сумму ' . number_format($value,2,',', ' ') . ' руб.</p>';
  $html .= '<p><b>' . $this->num2str($value) . '</b></p>';
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

    /**
     * AJAX FUNCTIONS
     */
    public function ajaxCheckContractId(Request $request){
      $contract_id = $request->contractId;
      if (($partner = DB::table('ETKPLUS_PARTNERS')->where('contract_id',$contract_id)->first()) !== NULL){ return response()->json(['message' => 'success'],200); } else return response()->json(['message' => 'error'],200);
    }

    public function ajaxSearchInCategories(Request $request){
      $text = $request->text;

      $info_results = DB::table('ETKPLUS_PARTNERS')
                        ->where('name','like','%' . $text . '%')
                        ->orWhere('fullname','like','%' . $text . '%')
                        ->orWhere('description','like','%' . $text . '%')
                        ->select('ETKPLUS_PARTNERS.id');
      $tags_results = DB::table('ETKPLUS_PARTNER_TAGS')
                        ->where('text','like','%' . $text . '%')
                        ->select('ETKPLUS_PARTNER_TAGS.partner_id as id')
                        ->union($info_results)
                        ->get();

      $partner_ids = [];
      foreach ($tags_results as $tags_result) {
        $partner_ids[] = $tags_result->id;
      }
      $results = DB::table('ETKPLUS_PARTNERS')
                    ->whereIn('id',$partner_ids)
                    ->select('id','thumbnail','logo','name')
                    ->get();
      if ($results !== NULL){ return response()->json(['message' => 'success', 'results' => $results],200); } else return response()->json(['message' => 'error'],200);                  
    }

    public function ajaxSearchContractId(Request $request){

    }

}
