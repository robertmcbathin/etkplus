<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Http\Response;
use Mail;
use \App\User;
use \App\Partner;
use Carbon\Carbon;
use App\Mail\PartnerRegistered;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
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

    public function showDashboard(){
    	/**
    	 * ACCOUNT VALUE
    	 * @var [type]
    	 */
    	$account = DB::table('ETKPLUS_AGENT_ACCOUNTS')
    				->where('user_id',Auth::user()->id)
    				->first();
    	$to_pay = $account->value;

    	/**
    	 * PARTNER COUNT
    	 */
    	$partners_count = DB::table('ETKPLUS_PARTNERS')
    						->where('created_by',Auth::user()->id)
    						->count();

    	return view('dashboard.agent.index',[
    		'to_pay' => $to_pay,
    		'partners_count' => $partners_count
    	]);
    }

    public function getPartnerList(){
        $partners = DB::table('ETKPLUS_PARTNERS')
        ->join('ETKPLUS_PARTNER_CATEGORIES','ETKPLUS_PARTNERS.category','=','ETKPLUS_PARTNER_CATEGORIES.id')
        ->select('ETKPLUS_PARTNERS.*','ETKPLUS_PARTNER_CATEGORIES.name as category_name','ETKPLUS_PARTNER_CATEGORIES.id as category_id')
        ->where('created_by',Auth::user()->id)
        ->paginate(20);
        $addresses = DB::table('ETKPLUS_ADDRESSES')
        ->get();
        $gallery_items = DB::table('ETKPLUS_PARTNER_PHOTOS')
        ->get();
        $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
        ->get();
        $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
        ->get();
        return view('dashboard.agent.partner_list',[
            'partners' => $partners,
            'gallery_items' => $gallery_items,
            'addresses' => $addresses,
            'discounts' => $discounts,
            'bonuses' => $bonuses
        ]);
    }

    /**
     * AJAX
     */
    public function ajaxSearchPartnerList(Request $request){
        $search_string = $request->searchString;
        $results = DB::table('ETKPLUS_PARTNERS')
        ->where('created_by',Auth::user()->id)
        ->where('name','like','%' . $search_string . '%')

        ->get();

        if ($results == NULL)
            return response()->json(['message' => 'error'],200);
        if ($results !== NULL)
            return response()->json(['message' => 'success',  'results' => $results],200);
    }

    public function showCreatePartnerPage(){
    	$categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
          ->get();
       $tariffs = DB::table('ETKPLUS_TARIFFS')
       ->get();
       return view('dashboard.agent.create_partner',[
          'categories' => $categories,
          'tariffs' => $tariffs
      ]);
   }

    /**
     * СОЗДАНИЕ ПРЕДПРИЯТИЯ
     */
    public function postCreatePartner(Request $request){
    	/**
    	 * DEFAULTS
    	 */
    	$background_imagename = '/assets/img/partners/etkplus_partner_default.jpg';
    	$logo_imagename = '/assets/img/partners/etkplus_partner_default_logo.png';
    	/**
    	 * GET VARIABLES
    	 */
        $user_id           = $request->user_id;
        $name 		       = $request->name;
        $fullname          = $request->fullname;
        $description       = $request->description;
        $phone 		       = $request->phone;
        $address 	       = $request->address;
        $email 		       = $request->email;
        $site 		       = $request->site;
        $tariff            = $request->tariff;
        $contract_id       = $request->contract_id;
        $admin_name        = $request->admin_name;
        $legal_address     = $request->legal_address;
        $physical_address  = $request->physical_address;
        $inn               = $request->inn;
        $kpp               = $request->kpp;
        $ogrn              = $request->ogrn;
        $category          = $request->category;
        $is_active         = $request->is_active;

        if ($is_active == 'on'){
          $is_active = 1;
      } else $is_active = 0;
      /**
       * ПРОВЕРКА EMAIL
       */
      if($user = DB::table('users')->where('email',$email)->first()){
        Session::flash('error','Пользователь с таким email уже зарегистрирован, используйте другой адрес');
        return redirect()->back();
      }

      /**
       * ПРОВЕРКА РАСШИРЕНИЙ
       */
      $logo_image_extension = $request->file('logo_image')->getClientOriginalExtension();
      if ($logo_image_extension !== 'png'){
      	Session::flash('error','Логотип должен быть в формате png');
        return redirect()->back();
      }
      $background_image_extension = $request->file('background_image')->getClientOriginalExtension();
      if ($background_image_extension !== 'jpg'){
      	Session::flash('error','Фон должен быть в формате jpg');
        return redirect()->back();      	
      }
        /**
         * Сумма тарифа
         */
        $tariff = DB::table('ETKPLUS_TARIFFS')
                    ->where('id',$tariff)
                    ->first();
        $connection_price = $tariff->connection_price;
        $account_value = $tariff->start_account_value;
    	/**
    	 * INSERT ROW
    	 */
        try {
            $partnerId = DB::table('ETKPLUS_PARTNERS')->insertGetId([
                'name' => $name,
                'fullname' => $fullname,
                'description' => $description,
                'phone' => $phone,
                'address' => $address,
                'email' => $email,
                'site' => $site,
                'tariff_id' => $tariff,
                'contract_id' => $contract_id,
                'legal_address' => $legal_address,
                'physical_address' => $physical_address,
                'inn' => $inn,
                'kpp' => $kpp,
                'ogrn' => $ogrn,
                'category' => $category,
                'is_active' => $is_active,
                'created_by' => $user_id
            ]);
            $partner = \App\Partner::find($partnerId);   
            DB::table('ETKPLUS_PARTNER_ACCOUNTS')
            ->insert([
                'partner_id' => $partnerId,
                'value' => $account_value,
                'min_value' => 0
            ]);
            DB::table('ETKPLUS_PARTNER_BILLING')
                ->insert([
                    'partner_id' => $partnerId,
                    'value' => $connection_price,
                    'status' => 0,
                    'type' => 0
                ]);
        } catch (Exception $e) {
            Session::flash('error', $e);
            return redirect()->back();
        }

    	/**
    	 * CHECK FILES
    	 */
    	$background_image = $request->file('background_image');
        if ($background_image){
          $background_image_extension = $request->file('background_image')->getClientOriginalExtension();
          $background_imagename = '/assets/img/partners/' . $partnerId . '/background.' . $background_image_extension;        	
          Storage::disk('public')->put($background_imagename, File::get($background_image));
          $partner->thumbnail = $background_imagename;
          $partner->save();
      } else {
          $partner->thumbnail = $background_imagename;
          $partner->save();
      }

      $logo_image = $request->file('logo_image');
      if ($logo_image){
          $logo_image_extension = $request->file('logo_image')->getClientOriginalExtension();	
          $logo_imagename = '/assets/img/partners/' . $partnerId . '/logo.' . $logo_image_extension;        	
          Storage::disk('public')->put($logo_imagename, File::get($logo_image));
          $partner->logo = $logo_imagename;
          $partner->save();
      } else {
          $partner->logo = $logo_imagename;
          $partner->save();
      }
        /**
         * CREATE USER
         * @var [type]
         */
        $user = new \App\User;
        $user->username = $email;
        $user->email = $email;
        $user->name = $admin_name;
        $user->partner_id = $partnerId;
        /**
         * GENERATE PASSWORD
         */
        $password = $this->generateRandomString(); //TO SEND VIA EMAIL
        $encrypted_password = bcrypt($password);
        /**
         * 
         */
        $user->password = $encrypted_password;
        $user->phone = $phone;
        $user->profile_image = $partner->logo;
        $user->role_id = 21;
        $user->is_active = 1;
        $user->save();
        /**
         * SEND EMAIL
         */
        try {
            Mail::to($email)->send(new PartnerRegistered($email,$password));
        } catch (Exception $e) {
            Session::flash('error', $e);
            return redirect()->back();
        }
        /**
         * USER CREATED
         */
        Session::flash('success', 'Создано новое предприятие');
        return redirect()->back();
    }

    public function getPartnerPage($partner_id){

        $partner = Partner::find($partner_id);
        if ($partner->created_by !== Auth::user()->id){
        	Session::flash('error','Недостаточно прав');
        	return redirect()->back();
        }
        $visits = DB::table('ETKPLUS_VISITS')
          ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
          ->leftJoin('users','ETKPLUS_VISITS.operator_id', '=', 'users.id')
          ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as operator')
          ->where('ETKPLUS_VISITS.partner_id', $partner_id)
          ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
          ->paginate(50);

        $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
        ->where('partner_id',$partner_id)
        ->get();
        $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
        ->where('partner_id',$partner_id)
        ->get();
        $earnings = DB::table('ETKPLUS_VISITS')
        ->where('partner_id',$partner_id)
        ->sum('bill');
        $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
        ->where('partner_id',$partner_id)
        ->first();
        $addresses = DB::table('ETKPLUS_ADDRESSES')
        ->where('partner_id', $partner_id)
        ->get();
        $gallery_items = DB::table('ETKPLUS_PARTNER_PHOTOS')
        ->where('partner_id', $partner_id)
        ->get();
        $accounts = DB::table('users')
                        ->where('partner_id',$partner_id)
                        ->get();
        $billings = DB::table('ETKPLUS_PARTNER_BILLING')
                        ->where('partner_id',$partner_id)
                        ->paginate(10);
        $tariffs = DB::table('ETKPLUS_TARIFFS')
                    ->get();
        $tariff = DB::table('ETKPLUS_TARIFFS')
                    ->where('id',$partner->tariff_id)
                    ->first();
        $tags = DB::table('ETKPLUS_PARTNER_TAGS')
                  ->where('partner_id',$partner->id)
                  ->get();
        return view('dashboard.agent.partner_page',[
            'partner' => $partner,
            'visits' => $visits,
            'earnings' => $earnings,
            'balance' => $balance,
            'gallery_items' => $gallery_items,
            'addresses' => $addresses,
            'discounts' => $discounts,
            'bonuses' => $bonuses,
            'accounts' => $accounts,
            'billings' => $billings,
            'tariffs' => $tariffs,
            'tariff' => $tariff,
            'tags' => $tags
        ]);
    }

 /**
 * [postDeletePartner description]
 * @param  Request $request [description]
 * @return [type]           [description]
 */
public function postDeletePartner(Request $request){
    $user_id = $request->user_id;
    $partner_id = $request->partner_id;
    try {
      DB::table('ETKPLUS_PARTNERS')
      ->where('id', $partner_id)
      ->delete();   
  } catch (Exception $e) {
    Session::flash('error',$e);
    return redirect()->back();
}
try {
    $dir_path = '/assets/img/partners/' . $partner_id;
    Storage::disk('public')->deleteDirectory($dir_path);   
} catch (Exception $e) {
    Session::flash('error',$e);
    return redirect()->back();      
}
try {
    DB::table('ETKPLUS_ADDRESSES')
    ->where('partner_id',$partner_id)
    ->delete();
} catch (Exception $e) {
    Session::flash('error',$e);
    return redirect()->back();    
}
Session::flash('success','Предприятие успешно удалено');
return redirect()->back();    
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
        $category         = $request->category;
        $is_active        = $request->is_active;
        if ($is_active == 'on'){
            $is_active = 1;
        } else $is_active = 0;
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
                'category' => $category,
                'is_active' => $is_active,
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
    

public function postCreateConnectionInvoice(Request $request){
  /**
   * INIT VARIABLES
   */
  $partner_id = $request->partner_id;
  /**
   * СОЗДАНИЕ СЧЕТА
   */
  $partner = DB::table('ETKPLUS_PARTNERS')
               ->where('id',$partner_id)
               ->first();
  if ($partner !== NULL){
    $contract_id = $partner->contract_id;
    $name = $partner->fullname;
    $inn = $partner->inn;
    $kpp = $partner->kpp;
    $legal_address = $partner->legal_address;
    $phone = $partner->phone;
    $tariff = DB::table('ETKPLUS_TARIFFS')
            ->where('id',$partner->tariff_id)
            ->first();
    $value = $tariff->connection_price; 
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
  $html .= '<tr><td>1</td><td>Подключение к системе лояльности</td><td>1</td><td>шт</td><td>' . number_format($value,2,',', ' ') . '</td><td>' . number_format($value,2,',', ' ') . '</td></tr>';
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

public function postCreateServiceInvoice(Request $request){
  /**
   * INIT VARIABLES
   */
  $partner_id = $request->partner_id;
  $value = $request->value;
  /**
   * СОЗДАНИЕ СЧЕТА
   */
  $partner = DB::table('ETKPLUS_PARTNERS')
               ->where('id',$partner_id)
               ->first();
  if ($partner !== NULL){
    $contract_id = $partner->contract_id;
    $name = $partner->fullname;
    $inn = $partner->inn;
    $kpp = $partner->kpp;
    $legal_address = $partner->legal_address;
    $phone = $partner->phone;
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
     * BILLING
     */
    public function showBillingPage(){
        $accounts_sum = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
        					->join('ETKPLUS_PARTNERS', 'ETKPLUS_PARTNER_ACCOUNTS.partner_id','=','ETKPLUS_PARTNERS.id')
        					->where('ETKPLUS_PARTNERS.created_by',Auth::user()->id)
                            ->sum('value');

        $accounts_sum = number_format($accounts_sum,2);


        /**
         * СЧЕТА
         * @var [type]
         */
        $accounts = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
                	  ->join('ETKPLUS_PARTNERS', 'ETKPLUS_PARTNER_ACCOUNTS.partner_id','=','ETKPLUS_PARTNERS.id')
        			  ->where('ETKPLUS_PARTNERS.created_by',Auth::user()->id)
        			  ->get();
        return view('dashboard.agent.billing',[
            'accounts_sum' => $accounts_sum,
            'accounts' => $accounts

        ]);
    }


    /**
     * SALARY
     */
    public function showSalaryPage(){
        $account = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                        ->leftJoin('users','ETKPLUS_AGENT_ACCOUNTS.user_id','=','users.id')
                        ->where('ETKPLUS_AGENT_ACCOUNTS.user_id',Auth::user()->id)
                        ->select('ETKPLUS_AGENT_ACCOUNTS.id','ETKPLUS_AGENT_ACCOUNTS.user_id','users.name','users.post','ETKPLUS_AGENT_ACCOUNTS.value')
                        ->first();
        return view('dashboard.agent.salary',[
            'account' => $account,
        ]);
    }



}
