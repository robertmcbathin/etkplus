<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
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
        View::share(['categories' => $categories]);
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
