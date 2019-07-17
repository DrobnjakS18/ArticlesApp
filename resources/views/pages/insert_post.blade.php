@extends('layout.front')

@section('title')

        Insert Article
    @endsection


@section('insert')

    <div class="forms">
        @if(session('insert_article'))
            <div class="alert alert-success">
                {{session('insert_article')}}
            </div>
        @endif
        @if(session('insert_article_other_pic'))
            <div class="alert alert-success">
                {{session('insert_article_other_pic')}}
            </div>
        @endif
        @if(session('insert_article_error'))
            <div class="alert alert-danger">
                {{session('insert_article_error')}}
            </div>
        @endif
        @if(session('insert_article_error_other_pic'))
            <div class="alert alert-danger">
                {{session('insert_article_error_other_pic')}}
            </div>
        @endif
        <h2>Insert article</h2>
        <form action="{{asset('/articles')}}"  method="POST" enctype="multipart/form-data" onsubmit="return InsertProvera()">
            @csrf
            <div class="form-group">
                <label for="inputHeadline">Healine</label>
                <input type="text" class="form-control" id="inputHeadline" name="inputHeadline">
            </div>
            <div class="form-row">
                <label for="customFile">Headline picture</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputText">Text</label>
                <textarea class="form-control" id="inputText" name="inputText"></textarea>
            </div>

                <label for="customOther">Other pictures</label>
                <div class="input-group increment">
                    <div >
                        <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                    </div>
                </div>
                <div class="clone hide">
                    <div class="control-group input-group" style="margin-top:10px">
                        <input type="file" name="customOther[]" class="form-control">
                        <div >
                            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                        </div>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-bottom: 10px;">Submit</button>
        </form>
        <div class="alert alert-danger" id="insert_error"></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>



    @endsection


@section('appendJavaScript')
    @parent

    <script type="text/javascript">

        function InsertProvera() {

            var errorArray = [];

            var headline = $('#inputHeadline').val();

            var headlineReg = /^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/;

            if(!headlineReg.test(headline)){

              errorArray.push('Bad headline. max 50 chra, first letter uppercase.')

            }

            var headlinePic = $('#customFile').val();

            var headlinePicReg = /\.(jpg|jpeg|png)$/;


            if(!headlinePicReg.test(headlinePic)){

                errorArray.push('Bad picture.');

            }

            var text = $('#inputText').val();

            var textReg = /^[\w][\w\s]*$/;

            if(!textReg.test(text)) {

                errorArray.push("Bad text.");
            }

            var otherPic = $('#customOther').val();

            if(otherPic != null) {


                if(!headlinePicReg.test(otherPic)){

                    errorArray.push('Bad picture.');

                }
            }




            if(errorArray.length > 0 ){

                var displayError = "<ul>";

                for(var i in errorArray){

                    displayError += "<li>" + errorArray[i] + "</li>";
                }

                displayError += "</ul>";


                $("#insert_error").html(displayError);
                $('#insert_error').show();

                return false;

            }else {

                return true;
            }


        }
    </script>



    <script type="text/javascript">
        $(document).ready(function() {

            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".control-group").remove();
            });

        });
    </script>

    @endsection