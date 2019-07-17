<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class HomeContoller extends Controller
{

    private $data = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $article_obj = new Article();


        $this->data['articles'] = $article_obj->getAll();
        return view('pages.home',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.insert_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->customOther == null) {

            $request->validate([

                'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
                'customFile' => 'required|file|mimes:jpg,jpeg,png|max:2000',
                'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
            ]);



            $article_obj = new Article();

            $article_obj->headline = $request->inputHeadline;
            $article_obj->text = $request->inputText;
            $article_obj->userid = session('user')->id;

            $picHead = $request->file('customFile');


            $picName = $picHead->getClientOriginalName();
            $picName = time().$picName;

            try {

                $picHead->move(public_path('images/'),$picName);


                $article_obj->headPic = $picName;


                $article_obj->insertOnlyheadline();



                return redirect()->back()->with('insert_article','Article successfully inserted');

            }catch (\Exception $e){

                \Log::info('Failed to insert article  error: '.$e->getMessage());
                return redirect()->back()->with('insert_article_error',"Article with no other pictures erroe");
            }



        }else {



            $request->validate([

            'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
            'customFile' => 'required|file|mimes:jpg,jpeg,png|max:2000',
            'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
            'customOther.*' => 'file|mimes:jpg,jpeg,png|max:2000',
        ]);

            $article_obj = new Article();

            $article_obj->headline = $request->inputHeadline;
            $article_obj->text = $request->inputText;
            $article_obj->userid = session('user')->id;

            $picHead = $request->file('customFile');


            $picName = $picHead->getClientOriginalName();
            $picName = time().$picName;



            $picOther = $request->file('customOther');




        try {



            $picHead->move(public_path('images/'),$picName);

            foreach ($picOther as $onePic){


                $picOtherName = time().$onePic->getClientOriginalName();
                $onePic->move(public_path('images/'),$picOtherName);
               array_push($article_obj->otherPic,$picOtherName);
            }



            $article_obj->headPic = $picName;


            $article_obj->insert();

            return redirect()->back()->with('insert_article_other_pic','Article successfully inserted');

        }catch (\Exception $e){

            \Log::info('Failed to insert article  error: '.$e->getMessage());
            return redirect()->back()->with('insert_article_error_other_pic',"Article with other pictures error");


        }



        }



    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $article_ojb = new Article();

        $single = $article_ojb->getOne($id);
        $this->data['single'] = $single;

        if($single == null) {

            $single = $article_ojb->getOneNoOtherPIctures($id);
            $this->data['single'] = $single;
        }

//        dd($single);

        return view('pages.post',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $article_obj = new Article();

        try {

            $article = $article_obj->getOne($id);


            if($article == null){

                $articleOtherPic = $article_obj->getOneNoOtherPIctures($id);



                $this->data['upd_art'] = $articleOtherPic;

                return view('pages.update_article',$this->data);

            }else {



                $otherPic = $article_obj->getOtherPicByArt($id);

                $this->data['upd_art'] = $article;
                $this->data['upd_other'] = $otherPic;

                return view('pages.update_article',$this->data);
            }


        }catch (Exception $e) {

            \Log::info('Failed to edit article  error: '.$e->getMessage());

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $article_obj = new Article();
        $article_obj->date_updated = time();


        if($request->customFile == null && $request->customOther == null){



            $request->validate([

                'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
                'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
            ]);


            try {
                $article_obj->headline = $request->inputHeadline;
                $article_obj->text = $request->inputText;

                $article_obj->UpdateHeadlineAndText($id);

                return redirect()->back()->with('update_article','Article successfully updated');

            }catch (\Exception $e){

                \Log::info('Failed to update article  error: '.$e->getMessage());
                return redirect()->back()->with('update_article_error',"Failed to update article please come back later");
            }


        }elseif($request->customOther == null) {

            $request->validate([

                'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
                'customFile' => 'required|file|mimes:jpg,jpeg,png|max:2000',
                'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
            ]);

            $article_obj->headline = $request->inputHeadline;
            $article_obj->text = $request->inputText;

            $picHead = $request->file('customFile');


            $picName = $picHead->getClientOriginalName();
            $picName = time().$picName;


            try {

                $picHead->move(public_path('images/'),$picName);
                $article_obj->headPic = $picName;

                $article_obj->UpdateHeadLinePic($id);

                return redirect()->back()->with('update_article','Article successfully updated');

            }catch(\Exception $e){

                \Log::info('Failed to update article  error: '.$e->getMessage());
                return redirect()->back()->with('update_article_error',"Failed to update article please come back later");
            }


        }elseif($request->customOther != null && $request->customFile == null){

            $request->validate([

                'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
                'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
                'customOther.*' => 'file|mimes:jpg,jpeg,png|max:2000',
            ]);


            $article_obj->headline = $request->inputHeadline;
            $article_obj->text = $request->inputText;
            $article_obj->id = $id;
            $picOther = $request->file('customOther');





            try {

                foreach ($picOther as $onePic){


                    $picOtherName = time().$onePic->getClientOriginalName();
                    $onePic->move(public_path('images/'),$picOtherName);
                    array_push($article_obj->otherPic,$picOtherName);
                }


                $article_obj->insertOtherPic();

                return redirect()->back()->with('update_article','Article successfully updated');

            }catch(\Exception $e) {

                \Log::info('Failed to update article  error: '.$e->getMessage());
                return redirect()->back()->with('update_article_error',"Failed to update article please come back later");
            }



        }else {



            $request->validate([

                'inputHeadline' => 'required|regex:/^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/',
                'customFile' => 'required|file|mimes:jpg,jpeg,png|max:2000',
                'inputText' => 'required|regex:/^[A-Za-z0-9][A-Za-z0-9: _-]*$/',
                'customOther.*' => 'file|mimes:jpg,jpeg,png|max:2000',
            ]);


            $article_obj->headline = $request->inputHeadline;
            $article_obj->text = $request->inputText;
            $article_obj->id = $id;

            $picHead = $request->file('customFile');


            $picName = $picHead->getClientOriginalName();
            $picName = time().$picName;



            $picOther = $request->file('customOther');




            try {



                $picHead->move(public_path('images/'),$picName);

                foreach ($picOther as $onePic){


                    $picOtherName = time().$onePic->getClientOriginalName();
                    $onePic->move(public_path('images/'),$picOtherName);
                    array_push($article_obj->otherPic,$picOtherName);
                }



                $article_obj->headPic = $picName;


                $article_obj->UpdateAll();

                return redirect()->back()->with('update_article','Article successfully updated');

            }catch (\Exception $e){

                \Log::info('Failed to insert article  error: '.$e->getMessage());
                return redirect()->back()->with('update_fail',"Article with other pictures error");



            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $article_obj = new Article();


        try{
            $article = $article_obj->getOne($id);


            if($article == null)
            {

                $articleOtherPic = $article_obj->getOneNoOtherPIctures($id);

                $art_id = $articleOtherPic->ArtId;

                $article_obj->delete($art_id);

                $putanja = public_path('images/').$articleOtherPic->path;



                if (file_exists($putanja)){
                    if (unlink($putanja)) {
                        return redirect()->back();
                    } else {
                        \Log::info('Failed to delete article  error.');
                        return redirect()->back()->with('delete_article_error',"Failed to delete article");
                    }
                } else {
                    \Log::info('Failed to delete article  error.');
                    return redirect()->back()->with('delete_article_error',"Failed to delete article");
                }



            }else {

                $pic_obj = new Article();


                $other_pic = $pic_obj->getOtherPicByArt($id);


                $putanja = [];


                foreach ($other_pic as $pic)
                {
                    array_push($pic_obj->otherPicID,$pic->pic_id);
                    array_push($putanja,public_path('images/').$pic->other_path);
                }

                $headline_pioc = $pic_obj->getOneNoOtherPIctures($id);

                array_push($putanja,public_path('images/').$headline_pioc->path);



                $pic_obj->id = $id;

                $pic_obj->deletOtherPictures();


                foreach ($putanja as $path){
                    unlink($path);

                    }

                    return redirect()->back();

            }

        }catch(\Exception $e){

            \Log::info('Failed to delete article  error: '.$e->getMessage());
            return redirect()->back()->with('insert_article_error_other_pic',"Article with other pictures error");
        }



    }

    public function deleteOther($id){


        $pic_obj = new Article();

        try{

            $other = DB::table('other_picture')->where('id',$id)->first();


            $putanja = public_path('images/').$other->other_path;

            $pic_obj->otherPicID = $id;

            $pic_obj->deletOther();

            if (unlink($putanja)) {
                return redirect()->back();
            } else {
                \Log::info('Failed to delete article  error.');
                return redirect()->back()->with('update_fail',"Failed to delete article");
            }

        }catch(\Exception $e) {

            \Log::info('Failed to delete other pictures  error: '.$e->getMessage());
            return redirect()->back()->with('update_fail',"Failed to delete other picture");


        }

    }
}






