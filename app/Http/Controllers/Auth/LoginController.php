<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
            Session::flash('login', 'Successfully login');
            $this->redirectTo = route('admin.dashboard');
            # jika id 2
        } elseif (Auth::check() && Auth::user()->role->id == 2) {
            # jalankan ini
            Session::flash('login', 'Successfully login');
            $this->redirectTo = route('toplevel.dashboard');
        } else {
            # selain role id 1 dan 2 jalnkan ini
            Session::flash('login', 'Successfully login');
            $this->redirectTo = route('operator.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $validation = \Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required'
        ])->validate();


        if ($request->isMethod('post')) {
            $data = $request->input();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('toplevel.dashboard');
            } elseif (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('operator.dashboard');
            } else {
                Session::flash('error', 'Please again check email dan passsword');
                return redirect('/');
            }
        }
        return redirect('/');
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
