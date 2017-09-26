<?php

namespace App\Http\Controllers\Auth;

use Auth;
use DB;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    protected $cardholder_role = 31;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request){
        /**
         * СУЩЕСТВУЕТ ЛИ ПОЛЬЗОВАТЕЛЬ
         * @var [type]
         */
        $user_isset = DB::table('users')
        ->where('email',$request->email)
        ->first();
        /**
         * ЕСЛИ ПОЛЬЗОВАТЕЛЬ СУЩЕСТВУЕТ
         */
        if ($user_isset !== NULL){
            /**
             * ЕСЛИ ПОЛЬЗОВАТЕЛЬ АКТИВИРОВАН
             * @var [type]
             */
            if ($user_isset->is_active == 1){
                /**
                 * ЕСЛИ ПОПЫТКА ЛОГИНА ПРОШЛА УСПЕШНО
                 */
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                    /**
                     * ЕСЛИ ЭТО ДЕРЖАТЕЛЬ КАРТЫ, ТО ОТПРАВИТЬ ЕГО НА СТРАНИЦУ ПРОФИЛЯ
                     */
                    if ($user_isset->role_id >= 31){
                        return redirect()->route('profile.show-profile-page.get');
                    } else
                        /**
                         * ЕСЛИ ЭТО ПАРТНЕР ИЛИ АДМИН - ТО В ПАНЕЛЬ УПРАВЛЕНИЯ
                         */
                        if (($user_isset->role_id < 25) && ($user_isset->role_id > 20))
                        {
                            return redirect()->route('dashboard.partner.show-dashboard.get');
                        } else if ($user_isset->role_id < 15)
                        {
                            return redirect()->route('dashboard.show-dashboard.get');
                        }
                }
            } else {
                /**
                 * ПОЛЬЗОВАТЕЛЬ НЕ АКТИВИРОВАН
                 */
                Session::flash('error', 'Данный аккаунт не активирован! Проверьте почту, указанную при регистрации в личном кабинете ЕТК.');
                return redirect()->route('login');
            }
        } else {
            /**
             * ПОЛЬЗОВАТЕЛЬ НЕ СУЩЕСТВУЕТ
             */
            Session::flash('error', 'Данный аккаунт не существует или был удален');
            return redirect()->route('login');
        } 
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('site.show-index.get');
    }

    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
        // Authentication passed...
            if (Auth::user()){
              $auth_user_id = Auth::user()->id;
            }
            if(Auth::user()->role_id >= 31)
            {
                return redirect()->intended('profile.show-profile-page.get');
            } if (($user_isset->role_id < 25) && ($user_isset->role_id > 20)){
                return redirect()->intended('dashboard.partner.show-dashboard.get');
            } else if ($user_isset->role_id < 15){
                return redirect()->intended('dashboard.show-dashboard.get');
            }
        }
    }
}
