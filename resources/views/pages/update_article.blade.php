@extends('layout.front')

@section('title')
        Update Article
    @endsection


@section('update')

    <div class="forms">
        @if(session('update_article'))
            <div class="alert alert-success">
                {{session('update_article')}}
            </div>
        @endif
            @if(session('update_fail'))
                <div class="alert alert-danger">
                    {{session('update_fail')}}
                </div>
            @endif
    <form action="{{route('update_aricle',['id' => $upd_art->ArtId])}}"  method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="form-group">
            <label for="inputHeadline">Healine</label>
            <input type="text" class="form-control" id="inputHeadline" name="inputHeadline" value="{{$upd_art->headline}}">
        </div>
        <div class="form-row">
            <label for="customFile">Headline picture</label>

            <img  class="rounded float-left" src="{{asset('images').'/'.$upd_art->path}}" alt="{{$upd_art->alt}}" />

            <div class="custom-file">

                <input type="file" class="custom-file-input" id="customFile" name="customFile">
                <label class="custom-file-label" for="customFile">Change Headline Picture</label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputText">Text</label>
            <textarea class="form-control" id="inputText" name="inputText" >{{$upd_art->text}}</textarea>
        </div>

        <label for="customOther">Other pictures</label>
        @if(isset($upd_art->art_id))
            @foreach($upd_other as $other)
                <div class="update_image">

                    <img  class="rounded float-left" src="{{asset('images').'/'.$other->other_path}}" alt="{{$other->other_alt}}" width="200px" height="200px"/>
                </div>
                <a href="" onclick="deleteOtherPic({{$other->picId }})" class="badge badge-danger" style="padding: 10px">Delete</a>

            @endforeach
        @endif
        <div class="input-group increment" style="margin-top: 20px">

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
    </div>
    @endsection


@section('appendJavaScript')
    @parent

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

        function deleteOtherPic(id) {

            $.ajax({

                method:'GET',
                url:'/other/' +id,
                dataType:'json',
                success:function () {

                },
                error:function () {

                }
            });
        }



    </script>

@endsection