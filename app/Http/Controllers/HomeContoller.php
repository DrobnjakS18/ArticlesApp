<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

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
                return redirect()->back()->with('insert_article_error',"Application is not working, please come back later");
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
            return redirect()->back()->with('insert_article_error_other_pic',"Application is not working, please come back later");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
