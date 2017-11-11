<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;
use View;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        $categories = DB::table('ETKPLUS_PARTNER_CATEGORIES')
                        ->orderBy('name','ASC')
                        ->get();
        View::share([
            'categories' => $categories,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
        $this->app['request']->server->set('HTTPS', true);
}
    }
}
