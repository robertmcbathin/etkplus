<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('show-dashboard', function($user){
            return $user->role_id < 31;
        });
        Gate::define('show-dashboard-admin', function($user){
            return $user->role_id < 10;
        });
        Gate::define('show-dashboard-partner', function($user){
            return (($user->role_id < 25) && ($user->role_id >= 20));
        });
        Gate::define('show-dashboard-partner-admin', function($user){
            return (($user->role_id <= 21) &&  ($user->role_id >= 20));
        });
        Gate::define('show-dashboard-partner-admin-shop', function($user){
            return ($user->role_id == 20);
        });
        Gate::define('show-dashboard-agent', function($user){
            return (($user->role_id == 15) || ($user->role_id == 14));
        });
        Gate::define('show-dashboard-accountant', function($user){
            return ($user->role_id == 13);
        });
    }
}
