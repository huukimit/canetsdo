<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;

use Socialize , Debugbar;

class AuthServiceController extends Controller {

    protected $auth_network = ['facebook', 'twitter', 'google', 'github'];

    function __construct() {
        // \Debugbar::disable();
    }

    function authAction($network = '') {
        if (! in_array($network, $this->auth_network) ) {
            return redirect()->route('Home');
        }else{
            $user = Socialize::with('github')->user();
            //Socialize::with('facebook')->redirect();
            dd($user);
            //return $this->$network();
        }
    }

    function facebook(){
        echo 'Hello';
    }

}
