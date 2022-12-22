<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    // fungsi login utama
    // protected $redirectTo = RouteServiceProvider::HOME;

    // fungsi login untuk role
    protected function authenticated() {
        // jika yang login role nya adalah user
        if(Auth::user()->role_id == '1') {
            return redirect('home')->with('success_message', 'Welcome to Dashboard, Admin');
        } else {
            return redirect('home')->with('success_message', 'Welcome to Dashboard, User');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
