<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo()
    {
        // User role check and redirect
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            return RouteServiceProvider::HOME;
        elseif(in_array('user', Auth::user()->roles->pluck('slug')->toArray())):
            return RouteServiceProvider::HOME;
        elseif(in_array('customer', Auth::user()->roles->pluck('slug')->toArray())):
            return URL::previous();
        endif;
    }

    /**
     * Redirect to previous page on logout
     * Speically done for frontend stores
     */
    protected function loggedOut(Request $request) {
        return redirect(URL::previous());
    }
}
