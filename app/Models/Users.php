<?php
/**
 * Created by PhpStorm.
 * User: DrobnjakS
 * Date: 7/15/2019
 * Time: 3:27 PM
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Users
{

    public function login($user,$pass){

        return DB::table('users')
            ->select('*')
            ->where([
                'username' => $user,
                'password' => md5($pass)
            ])
            ->first();
    }

}