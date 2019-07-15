<?php
/**
 * Created by PhpStorm.
 * User: DrobnjakS
 * Date: 7/15/2019
 * Time: 8:13 PM
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Article
{

    public $headline;
    public $headPic;
    public $text;
    public $otherPic;


    public function getAll() {

        return DB::table('article')
            ->select('*','article.id as ArtId')
            ->join('picture','article.pic_id','=','picture.id')
            ->join('users','article.user_id','=','users.id')
            ->get();
    }


    public function insert() {

        DB::transaction(function (){

            $id = DB::table('picture')
                ->insertGetId([
                    'path' => $this->headPic,
                    'alt' => $this->headline
                ]);

            DB::table('article')
                ->insert([

                    'headline' => $this->headline,
                    'pic_id' => $id,
                    'text' => $this->text,
                    'date_updated' => 0,
                    'user_id' => 1
                ]);
        });


    }


}