<?php
namespace App\Http\Controllers;

use Auth;
use Hash;
use Input;
use Session;
use App\Http\Controllers\Controller;
//use Illuminate\Routing\Controller;

class AuthController extends Controller {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('dashboard');
        }
    }

    public function login() {
        if (Auth::check()) {
            return redirect()->intended('secret/users');
        }
        return view('auth.login');
    }

    public function postLogin() {
        $check = Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password')]);
        if ($check) {
            return redirect()->intended('secret');
        } else {
            Session::flash('login_fail', 'Username or password is wrong');
            return redirect()->intended('auth/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('auth/login');
    }   
}