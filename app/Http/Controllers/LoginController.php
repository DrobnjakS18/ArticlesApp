<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use \Psy\Util\Json;


class LoginController extends Controller
{
    private $data = [];

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




    public function user($id) {


        $user_obj = new Users();

//        $user_art = $user_obj->user_articles($id);
//
//        $this->data['user_art'] = $user_art;

        $user = $user_obj->getUser($id);
        $this->data['user'] = $user;

        return view('pages.user_article',$this->data);

    }

    public function showUserAritcles($id) {

        $user_obj = new Users();

        $user_art = $user_obj->user_articles($id);


        return Json::encode($user_art);

    }

}
