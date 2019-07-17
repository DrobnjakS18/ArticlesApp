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
    public $id;
    public $headline;
    public $headPic;
    public $text;
    public $otherPic = [];
    public $otherPicID = [];
    public $userid;
    public $date_updated;


    public function getAll() {

        return DB::table('article')
            ->select('*','article.id as ArtId','users.id as UserId')
            ->join('users','article.user_id','=','users.id')
            ->orderByRaw('date_created desc')
            ->get();
    }


    public function getOne($id) {

        return DB::table('article_other_pic')
            ->select('*','article.id as ArtId','users.id as UserId')
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



    public function getOtherPicByArt($id){

        return DB::table('article_other_pic')
            ->select('*','other_picture.id as picId')
            ->join('other_picture','article_other_pic.pic_id','=','other_picture.id')
            ->where('art_id',$id)
            ->get();

    }


    public function insert() {

        DB::transaction(function (){

            $id = DB::table('article')
                ->insertGetId([
                    'headline' => $this->headline,
                    'path' => $this->headPic,
                    'alt' => $this->headline,
                    'text' => $this->text,
                    'date_updated' => 0,
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
                'date_updated' => 0,
                'user_id' => $this->userid
            ]);

    }


    public function insertOtherPic(){

        DB::transaction(function (){

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
                        'art_id' => $this->id,
                        'pic_id' => $art_pic
                    ]);
            }
        });
    }

    public function UpdateAll(){

        DB::transaction(function (){

            DB::table('article')
                ->where('id',$this->id)
                ->update([
                    'headline' => $this->headline,
                    'path' => $this->headPic,
                    'alt' => $this->headline,
                    'text' => $this->text,
                    'date_updated' => $this->date_updated
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
                        'art_id' => $this->id,
                        'pic_id' => $art_pic
                    ]);
            }
        });
    }

    public function delete($id){

            DB::table('article')
                ->where('id',$id)
                ->delete();

    }




    public function deletOtherPictures(){


        DB::transaction(function (){

            DB::table('article_other_pic')
                ->where('art_id',$this->id)
                ->delete();


            foreach ($this->otherPicID as $picID){

                DB::table('other_picture')
                    ->where('id',$picID)
                    ->delete();
            }

            return DB::table('article')
                ->where('id',$this->id)
                ->delete();

        });

    }
    public function deletOther(){


        DB::transaction(function (){

            DB::table('article_other_pic')
                ->where('pic_id',$this->otherPicID)
                ->delete();


                DB::table('other_picture')
                    ->where('id',$this->otherPicID)
                    ->delete();



        });

    }



    public function UpdateHeadlineAndText($id){

        DB::table('article')
            ->where('id',$id)
            ->update([
                'headline' => $this->headline,
                'text' => $this->text,
                'date_updated' => $this->date_updated
            ]);
    }


    public function UpdateHeadLinePic($id){

        DB::table('article')
            ->where('id',$id)
            ->update([
                'headline' => $this->headline,
                'path' => $this->headPic,
                'alt' => $this->headline,
                'text' => $this->text,
                'date_updated' => $this->date_updated
            ]);
    }



}