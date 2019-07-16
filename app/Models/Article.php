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
//    public $id;
    public $headline;
    public $headPic;
    public $text;
    public $otherPic = [];
    public $otherPicID = [];
    public $userid;


    public function getAll() {

        return DB::table('article')
            ->select('*','article.id as ArtId','users.id as UserId')
            ->join('users','article.user_id','=','users.id')
            ->orderByRaw('date_created desc')
            ->get();
    }


    public function getOne($id) {

        return DB::table('article_other_pic')
            ->select('*','article.id as ArtID','users.id as UserId')
            ->join('article','article_other_pic.art_id','=','article.id')
            ->join('other_picture', 'article_other_pic.pic_id','=','other_picture.id')
            ->join('users','article.user_id','=','users.id')
            ->where('article.id',$id)
            ->first();

    }

    public  function  getOneNoOtherPIctures($id){

        return DB::table('article')
            ->select('*','article.id as ArtId','users.id as UserId')
            ->join('users','article.user_id','=','users.id')
            ->where('article.id',$id)
            ->first();
    }


    public function insert() {

        DB::transaction(function (){

            $id = DB::table('article')
                ->insertGetId([
                    'headline' => $this->headline,
                    'path' => $this->headPic,
                    'alt' => $this->headline,
                    'text' => $this->text,
//                    'date_updated' => 0,
                    'user_id' => $this->userid
                ]);

           foreach ($this->otherPic as $pic) {

              array_push($this->otherPicID,DB::table('other_picture')
                  ->insertGetId([

                      'other_path' => $pic,
                      'other_alt' => $this->headline,
                  ]));
           }


           foreach ($this->otherPicID as $art_pic){

               DB::table('article_other_pic')
                   ->insert([
                       'art_id' => $id,
                       'pic_id' => $art_pic
                   ]);
           }

        });


    }


    public  function insertOnlyheadline() {

        DB::table('article')
            ->insert([
                'headline' => $this->headline,
                'path' => $this->headPic,
                'alt' => $this->headline,
                'text' => $this->text,
//                'date_updated' => 0,
                'user_id' => $this->userid
            ]);

    }


    public function delete($id){

            DB::table('article')
                ->where('id',$id)
                ->delete();

    }


}