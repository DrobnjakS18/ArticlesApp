@extends('layout.front')

@section('title')

        Insert Article
    @endsection


@section('insert')

    <div class="forms">

        <h2>Insert article</h2>
        <form enctype="multipart/form-data" id="insert_article">
            {{ csrf_field() }}
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
                <textarea class="form-control" id="inputText" name="inputText" rows="10" ></textarea>
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
                <input type="hidden" id="user_id" name="user_id" value="{{session('user')->id}}"/>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-bottom: 10px;" ">Submit</button>
        </form>
        <div class="alert alert-danger" id="insert_error"></div>
            <div class="alert alert-danger" id="ajax_error"></div>
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

        $(document).ready(function () {

            $('#insert_article').on('submit', function (event) {
                event.preventDefault();

                var errorArray = [];

                var headline = $('#inputHeadline').val();

                var headlineReg = /^[\s\S]{1,144}$/;

                if(!headlineReg.test(headline)){

                errorArray.push('Bad headline. max 50 chra, first letter uppercase.')

                }

                var headlinePic = document.getElementById('customFile');

                var headPicValue = headlinePic.value;

                var headlinePicReg = /\.(jpg|jpeg|png)$/;


                if(!headlinePicReg.test(headPicValue)){

                errorArray.push('Invalid image file.');

                }

                var text = $('#inputText').val();

                var textReg = /^[\s\S]*$/;

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


                }else{

                    $('#insert_error').hide();
                    $.ajax({

                        method: 'POST',
                        url: '/articles',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType:false,
                        cache:false,
                        processData: false,
                        success: function (data) {
                            alert(data);
                        },
                        error:function (xhr,Status,Error) {

                            var status = xhr.status;

                            switch (status) {

                                case 422:
                                    alert('You entered invalid data.');
                                    break;
                                case 400:
                                    alert('Bad request.');
                                    break;
                                default:
                                    alert('Failed to insert adricle.Error' + Status + 'status ' + status);
                                    break;
                            }

                        }

                    });


                }


            });


            $(document).ready(function () {

            $(".btn-success").click(function () {
            var html = $(".clone").html();
            $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function () {
            $(this).parents(".control-group").remove();
            });

            });

        });


    </script>



    @endsection