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
    	return view('dashboard');
    }
    public function showCreatePartnerPage(){
    	$categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
       ->get();
       $tariffs = DB::table('ETKPLUS_TARIFFS')
       ->get();
       return view('dashboard.create_partner',[
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
        $account_value     = $request->account_value;
        $account_min_value = $request->account_min_value;
        $legal_address     = $request->legal_address;
        $physical_address  = $request->physical_address;
        $inn               = $request->inn;
        $kpp               = $request->kpp;
        $ogrn              = $request->ogrn;
        $category          = $request->category;
        $is_active         = $request->is_active;

        $account_value             = $request->account_value;
        $account_min_value         = $request->account_min_value;
        if ($is_active == 'on'){
          $is_active = 1;
      } else $is_active = 0;
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
                'min_value' => $account_min_value
            ]);
            DB::table('ETKPLUS_PARTNER_BILLING')
                ->insert([
                    'partner_id' => $partnerId,
                    'value' => $account_value,
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
            'tariff' => $tariff
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
    public function postEditPartnerLogos(Request $request){
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
         ->whereIn('role_id',[13,14,15])
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
            Session::flash('success','Отзыв снять с публикации');
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

        return view('dashboard.billing',[
            
        ]);
    }

    /**
     * SALARY
     */
    public function showSalaryPage(){
        $accounts = DB::table('ETKPLUS_AGENT_ACCOUNTS')
                        ->leftJoin('users','ETKPLUS_AGENT_ACCOUNTS.user_id','=','users.id')
                        ->select('ETKPLUS_AGENT_ACCOUNTS.id','ETKPLUS_AGENT_ACCOUNTS.user_id','users.name','users.post','ETKPLUS_AGENT_ACCOUNTS.value')
                        ->get();
        return view('dashboard.salary',[
            'accounts' => $accounts,

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
                    
                ]);
        } catch (Exception $e) {
            
        }
    }
    /**
     * TARIFFS
     */
    public function showTariffListPage(){
        $tariffs = DB::table('ETKPLUS_TARIFFS')
                    ->get();
        return view('dashboard.tariffs',[
            'tariffs' => $tariffs
        ]);
    }

    public function postAddTariff(Request $request){
        $name               = $request->name;
        $description        = $request->description;
        $max_operator_count = $request->max_operator_count;
        $comission          = $request->comission;
        $monthly_payment    = $request->monthly_payment;

        if (DB::table('ETKPLUS_TARIFFS')->insert([
            'name' => $name,
            'description' => $description,
            'max_operator_count' => $max_operator_count,
            'comission' => $comission,
            'monthly_payment' => $monthly_payment
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
    /**
     * AJAX
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
    /**
     * END AJAX
     */
}
