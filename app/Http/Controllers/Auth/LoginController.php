<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # jika role id 1
        if (Auth::check() && Auth::user()->role->id == 1) {
            # jalankan ini
            $this->redirectTo = route('admin.dashboard')->with('status', 'Data successfully Updated');
            # jika id 2
        } elseif (Auth::check() && Auth::user()->role->id == 2) {
            # jalankan ini
            $this->redirectTo = route('toplevel.dashboard');
        } else {
            # selain role id 1 dan 2 jalnkan ini
            $this->redirectTo = route('operator.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}