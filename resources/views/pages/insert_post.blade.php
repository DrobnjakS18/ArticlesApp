@extends('layout.front')

@section('title')

        Insert Article
    @endsection


@section('insert')

    <div class="forms">
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

            <div class="form-row">
                <label for="customOther">Other pictures</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customOther" name="customOther">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-bottom: 10px;">Sign in</button>
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

    {{--<script type="text/javascript">--}}

        {{--function InsertProvera() {--}}

            {{--var errorArray = [];--}}

            {{--var headline = $('#inputHeadline').val();--}}

            {{--var headlineReg = /^[A-Z0-9][A-z0-9\s!?.:]{1,50}$/;--}}

            {{--if(!headlineReg.test(headline)){--}}

              {{--errorArray.push('Bad headline. max 50 chra')--}}

            {{--}--}}

            {{--var headlinePic = $('#customFile').val();--}}

            {{--var headlinePicReg = /\.(jpg|jpeg|png)$/;--}}

            {{--if(!headlinePicReg.test(headlinePic)){--}}

                {{--errorArray.push('Bad picture.');--}}

            {{--}--}}

            {{--var text = $('#inputText').val();--}}

            {{--var textReg = /^[\w][\w\s]*$/;--}}

            {{--if(!textReg.test(text)) {--}}

                {{--errorArray.push("Bad text.");--}}
            {{--}--}}

            {{--var otherPic = $('#customOther').val();--}}


            {{--if(!headlinePicReg.test(otherPic)){--}}

                {{--errorArray.push('Bad picture.');--}}

            {{--}--}}


            {{--if(errorArray.length > 0 ){--}}

                {{--var displayError = "<ul>";--}}

                {{--for(var i in errorArray){--}}

                    {{--displayError += "<li>" + errorArray[i] + "</li>";--}}
                {{--}--}}

                {{--displayError += "</ul>";--}}


                {{--$("#insert_error").html(displayError);--}}
                {{--$('#insert_error').show();--}}

                {{--return false;--}}

            {{--}else {--}}

                {{--return true;--}}
            {{--}--}}


        {{--}--}}
    {{--</script>--}}

    @endsection