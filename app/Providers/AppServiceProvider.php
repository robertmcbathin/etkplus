<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                        ->orderBy('name','ASC')
                        ->get();
      /*  $balance = DB::table('ETKPLUS_PARTNER_ACCOUNTS')
                     ->where('partner_id',Auth::user()->partner_id)
                     ->first();*/
        View::share([
            'categories' => $categories,
         //   'balance' => $balance
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
