<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Mail;
use \App\User;
use \App\Partner;
use \App\Review;
use App\Mail\PartnerRegistered;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \CsvReader;
use App\Mail\SendDistribution;


class AdminController extends Controller
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

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function showDashboard(){
        $cashback_to_pay = DB::table('ETK_CARDS')
                                ->sum('cashback_to_pay');
        $cashback_payed = DB::table('ETK_CARDS')
                                ->sum('cashback_payed');

    	return view('dashboard',[
            'cashback_to_pay' => $cashback_to_pay,
            'cashback_payed' => $cashback_payed
        ]);
    }
    public function showCreatePartnerPage(){
    	$categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
       ->get();
       $tariffs = DB::table('ETKPLUS_TARIFFS')
       ->get();
       $companies = DB::table('companies')
                      ->orderBy('name')
                      ->get();
       return view('dashboard.create_partner',[
          'categories' => $categories,
          'tariffs' => $tariffs,
          'companies' => $companies
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
        $category          = $request->category;
        $is_active         = $request->is_active;
        $is_shop         = $request->is_shop;
        $company_id     = $request->company_id;

        if ($is_active == 'on'){
          $is_active = 1;
      } else $is_active = 0;
        if ($is_shop == 'on'){
          $is_shop = 1;
      } else $is_shop = 0;
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
                'tariff_id' => $tariff->id,
                'contract_id' => $contract_id,
                'category' => $category,
                'is_active' => $is_active,
                'created_by' => $user_id,
                'company_id' => $company_id
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
                /**
                 * ЕСЛИ ПРЕДПРИЯТИЕ СОЗДАЕТСЯ КАК МАГАЗИН
                 */
            if ($is_shop == 1){
              DB::table('ETKTRADE_SHOPS')
                ->insert([
                  'name' => $name,
                  'fullname' => $fullname,
                  'company_id' => $company_id,
                  'partner_id' => $partnerId
                ]);
            }
          
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

    /**
     * SHOW COMPANIES
     */
    public function getCompaniesList(){
      $companies = DB::table('companies')
                    ->orderBy('name', 'asc')
                    ->paginate(20);
        return view('dashboard.companies_list',[
          'companies' => $companies
      ]);
    }
    /**
     * CREATE COMPANY
     */
    public function postCreateCompany(Request $request){
      $name              = $request->name;
      $legal_name        = $request->legal_name;
      $legal_address     = $request->legal_address;
      $physical_address  = $request->physical_address;
      $inn               = $request->inn;
      $kpp               = $request->kpp;
      $ogrn              = $request->ogrn;
      $checking_account  = $request->checking_account;
      $bik               = $request->bik;
      $corr_account      = $request->corr_account;

      try {
      DB::table('companies')
        ->insert([
          'name' => $name,
          'legal_name' => $legal_name,
          'legal_address' => $legal_address,
          'physical_address' => $physical_address,
          'inn' => $inn,
          'kpp' => $kpp,
          'ogrn' => $ogrn,
          'checking_account' => $checking_account,
          'bik' => $bik,
          'corr_account' => $corr_account
        ]); 
      } catch (Exception $e) {
        Session::flash('error', 'При добавлении возникла ошибка: ' .  $e);
        return redirect()->back();
      }
      Session::flash('success', 'Контрагент успешно добавлен');
      return redirect()->back();
    }

    /**
     * EDIT COMPANY
     */
    public function postEditCompany(Request $request){
      $company_id        = $request->company_id;
      $name              = $request->name;
      $legal_name        = $request->legal_name;
      $legal_address     = $request->legal_address;
      $physical_address  = $request->physical_address;
      $inn               = $request->inn;
      $kpp               = $request->kpp;
      $ogrn              = $request->ogrn;
      $checking_account  = $request->checking_account;
      $bik               = $request->bik;
      $corr_account      = $request->corr_account;

      try {
      DB::table('companies')
        ->where('id',$company_id)
        ->update([
          'name' => $name,
          'legal_name' => $legal_name,
          'legal_address' => $legal_address,
          'physical_address' => $physical_address,
          'inn' => $inn,
          'kpp' => $kpp,
          'ogrn' => $ogrn,
          'checking_account' => $checking_account,
          'bik' => $bik,
          'corr_account' => $corr_account
        ]); 
      } catch (Exception $e) {
        Session::flash('error', 'При изменении возникла ошибка: ' .  $e);
        return redirect()->back();
      }
      Session::flash('success', 'Данные контрагента успешно изменены');
      return redirect()->back();
    }

    /**
     * DELETE COMPANY
     */
    public function postDeleteCompany(Request $request){
      $company_id = $request->company_id;

      try {
      DB::table('companies')
        ->where('id',$company_id)
        ->delete(); 
      } catch (Exception $e) {
        Session::flash('error', 'При удалении возникла ошибка: ' .  $e);
        return redirect()->back();
      }
      Session::flash('success', 'Контрагент успешно удален');
      return redirect()->back();
    }


    public function getPartnerList(){
        $partners = DB::table('ETKPLUS_PARTNERS')
        ->join('ETKPLUS_PARTNER_CATEGORIES','ETKPLUS_PARTNERS.category','=','ETKPLUS_PARTNER_CATEGORIES.id')
        ->select('ETKPLUS_PARTNERS.*','ETKPLUS_PARTNER_CATEGORIES.name as category_name','ETKPLUS_PARTNER_CATEGORIES.id as category_id')
        ->paginate(20);
        $addresses = DB::table('ETKPLUS_ADDRESSES')
        ->get();
        $gallery_items = DB::table('ETKPLUS_PARTNER_PHOTOS')
        ->get();
        $discounts = DB::table('ETKPLUS_PARTNER_DISCOUNTS')
        ->get();
        $bonuses = DB::table('ETKPLUS_PARTNER_BONUSES')
        ->get();
        return view('dashboard.partner_list',[
            'partners' => $partners,
            'gallery_items' => $gallery_items,
            'addresses' => $addresses,
            'discounts' => $discounts,
            'bonuses' => $bonuses
        ]);
    }


/**
 * [getVisitsList description]
 * @return [type] [description]
 */
public function getVisitsList(){
    $visits = DB::table('ETKPLUS_VISITS')
    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
    ->leftJoin('users','ETKPLUS_VISITS.user_id', '=', 'users.id')
    ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as user_name')
    ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
    ->paginate(50);
    return view('dashboard.visits_list',[
        'visits' => $visits
    ]);
}

public function getCard($card_number){
    $card = DB::table('ETK_CARDS')
                ->where('num', $this->modifyToFullNumber($card_number))
                ->first();
    $operations = DB::table('ETKPLUS_VISITS')
                    ->where('card_number',$card_number)
                    ->orderBy('created_at','desc')
                    ->get();
    return view('dashboard.card');
}
/**
 * [getVisitsList description]
 * @return [type] [description]
 */
public function getVisitsListByParam($sort_param){
    switch ($sort_param) {
        case 'amount':
            $visits = DB::table('ETKPLUS_VISITS')
                ->selectRaw('ETKPLUS_VISITS.card_chip, sum(ETKPLUS_VISITS.bill) as bill_sum')
                ->groupBy('ETKPLUS_VISITS.card_chip')
                ->orderBy('bill_sum', 'DESC')
                ->paginate(50);
            dd($visits);
            break;
        
        default:
            # code...
            break;
    }

    $visits = DB::table('ETKPLUS_VISITS')
    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
    ->leftJoin('users','ETKPLUS_VISITS.user_id', '=', 'users.id')
    ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as user_name')
    ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
    ->paginate(50);
    return view('dashboard.visits_list',[
        'visits' => $visits
    ]);
}
    /**
     * [getVisitsList description]
     * @return [type] [description]
     */
    public function getPartnerPage($partner_id){
        $partner = Partner::find($partner_id);
        $visits = DB::table('ETKPLUS_VISITS')
          ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
          ->leftJoin('users','ETKPLUS_VISITS.operator_id', '=', 'users.id')
          ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name','users.name as operator')
          ->where('ETKPLUS_VISITS.partner_id', $partner_id)
          ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
          ->paginate(50);

        $company = DB::table('companies')
                        ->where('id',$partner->company_id)
                        ->first();
        $companies = DB::table('companies')
                        ->orderBy('name')
                        ->get();                  
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
        return view('dashboard.partner_page',[
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
            'tags' => $tags,
            'company' => $company,
            'companies' => $companies
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
        $company_id       = $request->company_id;  
        $discount         = $request->discount;
        $category         = $request->category;
        $is_active        = $request->is_active;
        $company_id       = $request->company_id;
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
                'category' => $category,
                'is_active' => $is_active,
                'updated_by' => $user_id,
                'company_id' => $company_id
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
    

    public function showOperationsPage(){
         $visits = DB::table('ETKPLUS_VISITS')
        ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_VISITS.partner_id', '=', 'ETKPLUS_PARTNERS.id')
        ->select('ETKPLUS_VISITS.*','ETKPLUS_PARTNERS.name as partner_name')
        ->orderBy('ETKPLUS_VISITS.created_at', 'DESC')
        ->paginate(50);
        return view('dashboard.operations',[
            'visits' => $visits
        ]);
    }

    public function showUserListPage(){
         $users = DB::table('users')
         ->whereIn('role_id',[1,13,14,15,21])
         ->get();
        return view('dashboard.users',[
            'users' => $users
        ]);
    }

    public function postAddUser(Request $request){
        $name          = $request->name;
        $email         = $request->email;
        $phone        = $request->phone;
        $temp_password = $request->password;
        $password      = bcrypt($temp_password);
        $post          = $request->post;
        $role_id       = $request->role_id;
        $is_active     = 1;

        $agent = new \App\User;
        $agent->name = $name;
        $agent->username = $email;
        $agent->email = $email;
        $agent->phone = $phone;
        $agent->temp_password = $temp_password;
        $agent->password = $password;
        $agent->post = $post;
        $agent->role_id = $role_id;
        $agent->is_active = $is_active;
        if ($agent->save()){
            Session::flash('success','Пользователь добавлен');
            return redirect()->back();
        } else {
            Session::flash('error','Добавить пользователя не удалось');
            return redirect()->back();
        }
    }

/**
 * REVIEWS
 */
    public function showReviewListPage(){
        $reviews = DB::table('ETKPLUS_REVIEWS')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_PARTNERS.id','=','ETKPLUS_REVIEWS.partner_id')
                    ->leftJoin('users','users.id','=','ETKPLUS_REVIEWS.user_id')
                    ->select('ETKPLUS_REVIEWS.*','users.name as username','ETKPLUS_PARTNERS.name as partnername')
                     ->orderBy('created_at','desc')
                    ->paginate(50);
        return view('dashboard.reviews',[
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
     * CATEGORIES
     */
    public function showCategoryListPage(){
        $categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                    ->get();
        return view('dashboard.categories',[
            'categories' => $categories
        ]);
    }

    public function postAddCategory(Request $request){
        $name          = $request->name;
        $description   = $request->description;
        $icon          = $request->phone;

        if (DB::table('ETKPLUS_PARTNER_CATEGORIES')->insert(['name' => $name, 'description' => $description, 'icon' => $icon])){
            Session::flash('success','Категория добавлена');
            return redirect()->back();
        } else {
            Session::flash('error','Добавить категорию не удалось');
            return redirect()->back();
        }
    }

    /**
     * BILLING
     */
    public function showBillingPage(){
        $accounts_sum = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
                            ->sum('value');
        $accounts_sum = number_format($accounts_sum,2);
        /**
         * СЧЕТА
         * @var [type]
         */
        $bills_sum = DB::table('ETKPLUS_PARTNER_BILLING')
                            ->where('status',0)
                            ->sum('value');
        $bills_count = DB::table('ETKPLUS_PARTNER_BILLING')
                            ->where('status',0)
                            ->count('id');
        $payments = DB::table('ETKPLUS_PARTNER_BILLING')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_PARTNERS.id','=','ETKPLUS_PARTNER_BILLING.partner_id')
                    ->where('type',1)
                    ->where('status',0)
                    ->select('ETKPLUS_PARTNER_BILLING.*','ETKPLUS_PARTNERS.fullname as name')
                    ->orderBy('created_at','DESC')
                    ->paginate(50);
        $archive_payments = DB::table('ETKPLUS_PARTNER_BILLING')
                    ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_PARTNERS.id','=','ETKPLUS_PARTNER_BILLING.partner_id')
                    ->where('status',2)
                    ->select('ETKPLUS_PARTNER_BILLING.*','ETKPLUS_PARTNERS.fullname as name')
                    ->orderBy('created_at','DESC')
                    ->paginate(50);
        return view('dashboard.billing',[
            'payments' => $payments,
            'accounts_sum' => $accounts_sum,
            'bills_sum' => $bills_sum,
            'bills_count' => $bills_count,
            'archive_payments' => $archive_payments
        ]);
    }

    public function postIncreaseAccount(Request $request){
        $bill_id = $request->bill_id;
        $partner_id = $request->partner_id;
        $reason = $request->reason;
        $to_increase = $request->to_increase;

        /**
         * ЗАГРУЗКА ДАННЫХ О ПАРТНЕРЕ
         */
        $partner = DB::table('ETKPLUS_PARTNERS')
                    ->where('id',$partner_id)
                    ->first();
        /**
         * ЗАГРУЗКА ДАННЫХ О СЧЕТЕ ПАРТНЕРА
         */
        $account = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
                    ->where('partner_id',$partner_id)
                    ->first();

        $new_account_value = $account->value + $to_increase;
        /**
         * НАЧИСЛИТЬ ПРОЦЕНТЫ АГЕНТУ
         */
        $agent_id = $partner->created_by;
        /**
         * ЕСЛИ СЧЕТ ЗА ПОДКЛЮЧЕНИЕ, ТО 20%
         */
        switch ($reason) {
          case 1:
            $agent_to_increase = $to_increase/5;
            break;
          case 2:
            $agent_to_increase = $to_increase/10;
            break;          
          default:
            break;
        }
        
        $agent_account = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                            ->where('user_id',$agent_id)
                            ->first();
        $new_agent_account_value = $agent_account->value + $agent_to_increase;
        try {
            DB::table('ETKPLUS_PARTNER_ACCOUNTS')
              ->where('partner_id',$partner_id)
              ->update(['value' => $new_account_value]);
            DB::table('ETKPLUS_PARTNER_BILLING')
                ->where('id',$bill_id)
                ->update(['status' => 2]);
            DB::table('ETKPLUS_AGENT_ACCOUNTS')
                ->where('user_id',$agent_id)
                ->update([
                    'value' => $new_agent_account_value
                ]);

        } catch (Exception $e) {
            Session::flash('error', $e);
            return redirect()->back();
        }
        Session::flash('success','Баланс обновлен');
        return redirect()->back();
    }

    /**
     * SALARY
     */
    public function showSalaryPage(){
        $salary_sum = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                            ->sum('value');
        $accounts = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                        ->leftJoin('users','ETKPLUS_AGENT_ACCOUNTS.user_id','=','users.id')
                        ->select('ETKPLUS_AGENT_ACCOUNTS.id','ETKPLUS_AGENT_ACCOUNTS.user_id','users.name','users.post','ETKPLUS_AGENT_ACCOUNTS.value')
                        ->get();
        return view('dashboard.salary',[
            'accounts' => $accounts,
            'salary_sum' => $salary_sum
        ]);
    }

    public function postPaySalary(Request $request){
        $to_pay = $request->to_pay;
        $user_id = $request->user_id;
        $agent = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                    ->where('user_id',$user_id)
                    ->first();
        if ($to_pay > $agent->value){
            Session::flash('error','Нельзя списать сумму больше начисленной');
            return redirect()->back();
        }
        try {
            $balance = $agent->value - $to_pay;
            DB::table('ETKPLUS_AGENT_ACCOUNTS')
                ->where('user_id', $user_id)
                ->update([
                    'value' => $balance
                ]);
            DB::table('ETKPLUS_AGENT_BILLING_HISTORY')
                ->insert([
                    'user_id' => $user_id,
                    'accrued' => $to_pay,
                    'action_type' => 1
                ]);
        } catch (Exception $e) {
            
        }
    }
    /**
     * TARIFFS
     */
    public function showTariffListPage(){
        $tariffs = DB::table('ETKPLUS_TARIFFS')
                    ->join('users','ETKPLUS_TARIFFS.created_by','=','users.id')
                    ->select('ETKPLUS_TARIFFS.*','users.name as created_by')
                    ->get();
        return view('dashboard.tariffs',[
            'tariffs' => $tariffs
        ]);
    }

    public function postAddTariff(Request $request){
        $name               = $request->name;
        $description        = $request->description;
        $max_operator_count = $request->max_operator_count;
        $max_service_points = $request->max_service_points;
        $comission          = $request->comission;
        $cashback           = $request->cashback;
        $monthly_payment    = $request->monthly_payment;

        if ($cashback > $comission) {
          Session::flash('error','Значение кэшбэка не может быть меньше размера комиссии');
          return redirect()->back();
        }
        if (DB::table('ETKPLUS_TARIFFS')->insert([
            'name' => $name,
            'description' => $description,
            'max_operator_count' => $max_operator_count,
            'max_service_points' => $max_service_points,
            'comission' => $comission,
            'cashback' => $cashback,
            'monthly_payment' => $monthly_payment,
            'created_by' => Auth::user()->id

        ])){
            Session::flash('success', 'Тариф успешно добавлен');
            return redirect()->back();
        } else {
            Session::flash('error', 'Добавить тариф не удалось');
            return redirect()->back();            
        }
    }

    public function postChangeTariff(Request $request){
        $partner_id = $request->partner_id;
        $tariff     = $request->tariff;
        $partner = \App\Partner::find($partner_id);
        $partner->tariff_id = $tariff;
        if ($partner->save()){
            Session::flash('success', 'Тариф успешно изменен');
            return redirect()->back();
        } else {
            Session::flash('error', 'Изменить тариф не удалось');
            return redirect()->back();            
        }
    }

    public function postEditTariff(Request $request){
        $tariff_id          = $request->tariff_id;
        $name               = $request->name;
        $description        = $request->description;
        $max_operator_count = $request->max_operator_count;
        $max_service_points = $request->max_service_points;
        $comission          = $request->comission;
        $cashback           = $request->cashback;
        $monthly_payment    = $request->monthly_payment;

        if ($cashback > $comission) {
          Session::flash('error','Значение кэшбэка не может быть меньше размера комиссии');
          return redirect()->back();
        }
        try {
            DB::table('ETKPLUS_TARIFFS')
              ->where('id',$tariff_id)
              ->update([
                'name' => $name,
                'description' => $description,
                'max_operator_count' => $max_operator_count,
                'max_service_points' => $max_service_points,
                'comission' => $comission,
                'cashback' => $cashback,
                'monthly_payment' => $monthly_payment
              ]);
        } catch (Exception $e) {
            Session::flash('error','Сохранить изменения не удалось');
            return redirect()->back();
        }
        Session::flash('success','Изменения сохранены');
        return redirect()->back();
    }

    /**
     * CHAT
     */
    
    public function showChatPage($partner_id = NULL){
        return view('dashboard.chat',[
        ]);
    }
    /**
     * EMAILS
     */
    public function showEmailsPage(){
        $recipients = DB::table('users')
                        ->whereNotNull('email')
                        ->where('is_email_receiver',1)
                        ->get();
        $recipients_count = DB::table('users')
                                ->whereNotNull('email')
                                ->where('is_email_receiver',1)
                                ->count();
        $test_recipients = DB::table('users')
                                ->whereNotNull('email')
                                ->where('is_email_receiver',1)
                                ->where('role_id','<',2)
                                ->get();
        $distributions = DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
                            ->get();        
        return view('dashboard.emails',[
            'recipients_count' => $recipients_count,
            'distributions' => $distributions,
            'test_recipients' => $test_recipients
        ]);
    }


    public function sendEmailDistribution(Request $request){
      $distribution_id = $request->distribution_id;
      $last_sended_email_id = $request->last_sended_email_id;

      $distribution = DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
                        ->where('id',$distribution_id)
                        ->first();
      $recipients = DB::table('users')
                      ->whereNotNull('email')
                      ->where('is_email_receiver',1)
                      ->where('id', '>', $last_sended_email_id)
                      ->get();  
      dd($recipients);
      $email_subject      = $distribution->title;
      $email_text         = $distribution->text;   
      $email_client       = $distribution->client;
      $email_client_email = $distribution->client_email;

      $email_count = 0;
      foreach ($recipients as $recipient) {
        try {
        Mail::to($recipient->email)->send(new SendDistribution($email_subject, $email_client, $email_client_email, $email_text));
        ++$email_count;
        DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
          ->where('id',$distribution->id)
          ->update([
            'sent_emails_count' => $email_count,
            'last_email' => $recipient->email
          ]);
        DB::table('SYS_LOG')
          ->insert([
            'action_type' => 25,
            'message' => date('Y-m-d H:i:s') . ' | Отправлено письмо по рассылке ' . $email_subject . ' пользователю ' . $recipient->email
          ]); 
        } catch (Exception $e) {
          DB::table('SYS_LOG')
          ->insert([
            'action_type' => 25,
            'message' => date('Y-m-d H:i:s') . ' | Не отправлено письмо по рассылке ' . $email_subject . ' пользователю ' . $recipient->email
          ]); 
        }

      }
      DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
          ->where('id',$distribution->id)
          ->update([
            'status' => 2
          ]);
      Session::flash('success','Успешно отправлено на ' . $email_count . ' адресов');
      return redirect()->back();
    }


    public function sendTestEmailDistribution(Request $request){
      $distribution_id = $request->distribution_id;

      $distribution = DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
                        ->where('id',$distribution_id)
                        ->first();
      $test_recipients = DB::table('users')
                             ->whereNotNull('email')
                             ->where('is_email_receiver',1)
                             ->where('role_id','<',3)
                             ->get();  

      $email_subject      = $distribution->title;
      $email_text         = $distribution->text;   
      $email_client       = $distribution->client;
      $email_client_email = $distribution->client_email;

      $email_count = 0;
      foreach ($test_recipients as $test_recipient) {
        Mail::to($test_recipient->email)->send(new SendDistribution($email_subject, $email_client, $email_client_email, $email_text));
        ++$email_count;
        DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
          ->where('id',$distribution->id)
          ->update([
            'sent_emails_count' => $email_count,
            'last_email' => $test_recipient->email
          ]);
        DB::table('SYS_LOG')
          ->insert([
            'action_type' => 25,
            'message' => date('Y-m-d H:i:s') . ' | Отправлено тестовое письмо по рассылке ' . $email_subject . ' пользователю ' . $test_recipient->email
          ]);

      }
      DB::table('ETKPLUS_ADMIN_EMAIL_DISTRIBUTIONS')
          ->where('id',$distribution->id)
          ->update([
            'status' => 1
          ]);
      Session::flash('success','Успешно отправлено на ' . $email_count . ' адресов');
      return redirect()->back();
    }
    /**
     * LOGS
     */
    public function showLogPage($type = NULL){
        $log_types = DB::table('SYS_LOG_ACTION_TYPES')
                        /*->where('ecosystem_id',2)*/
                        ->get();
        if (isset($type)){
           $logs = DB::table('SYS_LOG')
                    ->where('action_type',$type)
                    ->orderBy('created_at','DESC')
                    ->paginate(50); 
                } else $logs = NULL;
        $current_type = DB::table('SYS_LOG_ACTION_TYPES')
                            ->where('id',$type)
                            ->first();

        return view('dashboard.log',[
            'log_types' => $log_types,
            'logs' => $logs,
            'current_type' => $current_type
        ]);
    }


/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
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
 *
 *
 *
 *
 *
 *
 * 
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * 
 */

    public function showShopCategoriesPage(){
      $categories = DB::table('ETKTRADE_CATEGORIES')
                      ->get();
      $levels = DB::table('ETKTRADE_CATEGORIES')
                  ->selectRaw('DISTINCT level')
                  ->get();
      return view('dashboard.trade.categories',[
        'categories' => $categories,
        'levels' => $levels
      ]);
    }

    public function postAddShopCategory(Request $request){
      $title = $request->title;
      $description = $request->description;
      $level = $request->level;
      $parent_id = $request->parent_id;

      try {
        if ($level == 1) {
          DB::table('ETKTRADE_CATEGORIES')
            ->insert([
              'title' => $title,
              'description' => $description,
              'level' => 1,
              'parent' => 0
            ]);
        } else {
          $parent = DB::table('ETKTRADE_CATEGORIES')
                      ->where('id',$parent_id)
                      ->first();
          DB::table('ETKTRADE_CATEGORIES')
            ->insert([
              'title' => $title,
              'description' => $description,
              'level' => ++$parent->level,
              'parent' => $parent->id
            ]);
        }
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
      Session::flash('success','Категория добавлена');
      return redirect()->back();
    }

    public function postEditShopCategory(Request $request){
      $category_id = $request->category_id;
      $title = $request->title;
      $description = $request->description;
      $level = $request->level;
      $parent_id = $request->parent_id;

      try {
        if ($level == 1) {
          DB::table('ETKTRADE_CATEGORIES')
            ->where('id',$category_id)
            ->update([
              'title' => $title,
              'description' => $description,
              'level' => 1,
              'parent' => 0
            ]);
        } else {
          $parent = DB::table('ETKTRADE_CATEGORIES')
                      ->where('id',$parent_id)
                      ->first();
          DB::table('ETKTRADE_CATEGORIES')
            ->where('id',$category_id)
            ->update([
              'title' => $title,
              'description' => $description,
              'level' => ++$parent->level,
              'parent' => $parent->id
            ]);
        }
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
      Session::flash('success','Категория изменена');
      return redirect()->back();            
    }


    public function postDeleteShopCategory(Request $request){
      $category_id = $request->category_id;

      try {
        DB::table('ETKTRADE_CATEGORIES')
          ->where('id',$category_id)
          ->delete();
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();        
      }
      Session::flash('success','Категория удалена');
      return redirect()->back();
    }

    /**
     * SHOPS
     * @return [type] [description]
     */
    public function showShopShopsPage(){
      $shops = DB::table('ETKTRADE_SHOPS')
                  ->leftJoin('ETKTRADE_SHOP_TYPES','ETKTRADE_SHOP_TYPES.id', '=', 'ETKTRADE_SHOPS.type')
                  ->leftJoin('companies','companies.id','=','ETKTRADE_SHOPS.company_id')
                  ->leftJoin('ETKPLUS_PARTNERS','ETKPLUS_PARTNERS.id','=','ETKTRADE_SHOPS.partner_id')
                  ->select('ETKTRADE_SHOPS.*','ETKTRADE_SHOP_TYPES.name as shop_type', 'ETKPLUS_PARTNERS.name as partner_name','companies.name as company_name')
                  ->get();
      $companies = DB::table('companies')
                    ->get();
      $partners = DB::table('ETKPLUS_PARTNERS')
                    ->get();
      $shop_types = DB::table('ETKTRADE_SHOP_TYPES')
                    ->get();
      return view('dashboard.trade.shops',[
        'shops' => $shops,
        'companies' => $companies,
        'partners' => $partners,
        'shop_types' => $shop_types
      ]);
    }

    public function postAddShopShop(Request $request){
      $name = $request->name;
      $fullname = $request->fullname;
      $description = $request->description;
      $company_id = $request->company_id;
      $partner_id = $request->partner_id;
      $min_sale = $request->min_sale;

      try {
          DB::table('ETKTRADE_SHOPS')
            ->insert([
              'name' => $name,
              'fullname' => $fullname,
              'description' => $description,
              'company_id' => $company_id,
              'partner_id' => $partner_id,
              'min_sale' => $min_sale
            ]);
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
      Session::flash('success','Магазин добавлен');
      return redirect()->back();
    }


    public function postEditShopShop(Request $request){
      $shop_id = $request->shop_id;
      $name = $request->name;
      $fullname = $request->fullname;
      $description = $request->description;
      $company_id = $request->company_id;
      $partner_id = $request->partner_id;
      $min_sale = $request->min_sale;

      try {
          DB::table('ETKTRADE_SHOPS')
            ->where('id',$shop_id)
            ->update([
              'name' => $name,
              'fullname' => $fullname,
              'description' => $description,
              'company_id' => $company_id,
              'partner_id' => $partner_id,
              'min_sale' => $min_sale
            ]);
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();
      }
      Session::flash('success','Магазин изменен');
      return redirect()->back();            
    }

    public function postDeleteShopShop(Request $request){
      $shop_id = $request->shop_id;

      try {
        DB::table('ETKTRADE_SHOPS')
          ->where('id',$shop_id)
          ->delete();
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();        
      }
      Session::flash('success','Магазин удален');
      return redirect()->back();
    }

/**
 * GOODS
 * @return [type] [description]
 */
    public function showShopGoodsPage(){
      $goods = DB::table('ETKTRADE_PRODUCTS')
                  ->leftJoin('ETKTRADE_SHOPS','ETKTRADE_SHOPS.id', '=', 'ETKTRADE_PRODUCTS.shop_id')
                  ->leftJoin('ETKTRADE_CATEGORIES','ETKTRADE_CATEGORIES.id','=','ETKTRADE_PRODUCTS.category_id')
                  ->select('ETKTRADE_PRODUCTS.*','ETKTRADE_SHOPS.name as shop_name', 'ETKTRADE_CATEGORIES.title as category')
                  ->orderBy('created_at','desc')
                  ->limit(100)
                  ->paginate(50);
      $categories = DB::table('ETKTRADE_CATEGORIES')
                    ->orderBy('level')
                    ->get();
      $shops = DB::table('ETKTRADE_SHOPS')
                    ->get();
      return view('dashboard.trade.goods',[
        'shops' => $shops,
        'goods' => $goods,
        'categories' => $categories
      ]);
    }

    public function postEditShopGood(Request $request){
      $good_id = $request->good_id;
      $name = $request->name;
      $fullname = $request->fullname;
      $description = $request->description;
      $price = $request->price;
      $price_without_discount = $request->price_without_discount;
      $price_cost = $request->price_cost;
      $shop_id = $request->shop_id;
      $category_id = $request->category_id;

      try {
        DB::table('ETKTRADE_PRODUCTS')
          ->where('id', $good_id)
          ->update([
            'name' => $name,
            'fullname' => $fullname,
            'description' => $description,
            'price' => $price,
            'price_without_discount' => $price_without_discount,
            'price_cost' => $price_cost,
            'shop_id' => $shop_id,
            'category_id' => $category_id
          ]);
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();         
      }

      Session::flash('success','Информация о товаре изменена');
      return redirect()->back();
    }

    public function postAddShopGoodsCsv(Request $request){
      $catalog     = $request->file('catalog');
      $shop_id     = $request->shop_id;
      $category_id = $request->category_id;

      if ($request->file('catalog')->isValid()){
        $reader = CsvReader::open($catalog);
        $success_counter = 0;
        $error_counter = 0;
        while (($line = $reader->readline()) !==  false){
          try {
            $product = DB::table('ETKTRADE_PRODUCTS')->where('diff_shop_article',$line[4])->first();
            if ($product){
              $error_counter++;
            } else {
              DB::table('ETKTRADE_PRODUCTS')->insert([
                'name' => $line[2],
                'fullname' => $line[2],
                'description' => $line[5],
                'price_cost' => $line[0],
                'diff_shop_article' => $line[4],
                'diff_shop_link' => $line[3],
                'sizes' => $line[7],
                'image' => $line[8],
                'image_small' => $line[9],
                'category_id' => $category_id,
                'shop_id' => $shop_id
              ]);
              $success_counter++;
            }
          } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();  
          }

        }
      Session::flash('success','Товары испортированы.' . 'Успешно: ' . $success_counter . '. С ошибками: ' . $error_counter);
      return redirect()->back(); 
      }

    }

    public function postDeleteShopGood(Request $request){
      $good_id = $request->good_id;

      try {
        DB::table('ETKTRADE_PRODUCTS')
          ->where('id',$good_id)
          ->delete();
      } catch (Exception $e) {
        Session::flash('error',$e);
        return redirect()->back();        
      }
      Session::flash('success','Товар удален');
      return redirect()->back();
    }
    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * 
     * AJAX
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * 
     */
    public function ajaxSearchPartnerList(Request $request){
        $search_string = $request->searchString;
        $results = DB::table('ETKPLUS_PARTNERS')
        ->where('name','like','%' . $search_string . '%')
        ->orWhere('contract_id','like', $search_string . '%')
        ->get();

        if ($results == NULL)
            return response()->json(['message' => 'error'],200);
        if ($results !== NULL)
            return response()->json(['message' => 'success',  'results' => $results],200);
    }

    public function ajaxAddTag(Request $request){
      $partner_id = $request->partner_id;
      $text = $request->text;
      try {
        $query = DB::table('ETKPLUS_PARTNER_TAGS')
          ->insert([
            'partner_id' => $partner_id,
            'text' => $text
          ]);
      } catch (Exception $e) {
        
      }
      if ($query == NULL)
          return response()->json(['message' => 'error'],200);
      if ($query !== NULL)
          return response()->json(['message' => 'success'],200);
    }

    public function ajaxDeleteTag(Request $request){
      $partner_id = $request->partner_id;
      $text = $request->text;
      try {
        $query = DB::table('ETKPLUS_PARTNER_TAGS')
          ->where('text',$text)
          ->where('partner_id',$partner_id)
          ->delete();
      } catch (Exception $e) {
        
      }
      if ($query == NULL)
          return response()->json(['message' => 'error'],200);
      if ($query !== NULL)
          return response()->json(['message' => 'success'],200);
    }
    /**
     * END AJAX
     */
}
