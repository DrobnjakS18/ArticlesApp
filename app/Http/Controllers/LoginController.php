<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {

        return view('pages.login');
    }

    public function log(Request $request){

        $user = $request->username;
        $pass = $request->password;

        $log_obj = new Users();

        $log = $log_obj->login($user,$pass);

        session(['user' => $log]);

        if(session('user')){

            return redirect('/articles')->with('login_success',"Welcome ".session('user')->username);
        }else{
            \Log::info('Ip address '.$request->ip().', user not found');
            return redirect()->back()->with('login_error','User not found');
        }

    }


    public function logout(){

        session()->flush();
        return redirect('/');
    }
}
