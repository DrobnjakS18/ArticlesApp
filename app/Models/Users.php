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

    public function user_articles($id){

        return DB::table('article')
            ->select('*','article.id as ArtID','users.id as UserId')
            ->join('users','article.user_id','=','users.id')
            ->where('article.user_id',$id)
            ->orderByRaw('date_created desc')
            ->get();
    }

    public function getUser($id){

        return  DB::table('users')
            ->where('id',$id)
            ->first();

    }

}