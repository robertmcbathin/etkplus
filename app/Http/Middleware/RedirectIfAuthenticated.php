<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    protected $cardholder_role = 31;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()){
              $auth_user_id = Auth::user()->id;
            }
            if(Auth::user()->role_id >= $this->cardholder_role)
            {
                return redirect()->route('profile.show-profile-page.get');
            } else {
                return return redirect()->route('dashboard.show-dashboard.get');
            }
        }

        return $next($request);
    }
}
