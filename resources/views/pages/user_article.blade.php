@extends('layout.front')
@section('title')
    User Articles
    @endsection

@section('user_articles')

    <!-- Sadrzaj -->
    <div class="col-md-8">
        @if(session('delete_article_error'))
            <div class="alert alert-danger">
                {{ session('delete_article_error') }}
            </div>
        @endif
        @if(session('login_success'))
            <div class="alert alert-success">
                {{ session('login_success') }}
            </div>
        @endif
        <h1 class="my-4">{{$user->username}} articles
        </h1>
            <div class="user_aritcle"></div>
        {{--@foreach($user_art as $article)--}}
        {{--<!-- Blog Post -->--}}
            {{--<div class="card mb-4">--}}
                {{--<img class="card-img-top"   height="200"src="{{asset('images')."/".$article->path}}" alt="{{$article->alt}}">--}}
                {{--<div class="card-body">--}}
                    {{--<h2 class="card-title">{{$article->headline}}</h2>--}}
                    {{--<p class="card-text">{{str_limit($article->text,240)}}</p>--}}
                    {{--<a href="{{route('single_article',['id' => $article->ArtID])}}" class="btn btn-primary">Read More &rarr;</a>--}}
                    {{--@if(session('user')->id == $user->id)--}}
                    {{--<a href="{{route('edit_article',['id' => $article->ArtID])}}" class="btn btn-success">Update</a>--}}
                    {{--<a href="" onclick="deleteArticle({{$article->ArtID}})" class="btn btn-danger">Delete</a>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="card-footer text-muted">--}}
                    {{--Posted on {{$article->date_created}}--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--// Blog Post -->--}}
        {{--@endforeach--}}

    </div>
    @endsection


@section('appendJavaScript')
    @parent

    <script type="text/javascript">



        $( document ).ready(function () {

            $.ajax({
                type: "GET",
                url: '/user/show_articles/{{$user->id}}',
                dataType: 'json',
                success: function (data) {


                    var tmp = "";
                    for (var i in data) {

                        tmp += '  <div class="card mb-4">\n'
                        tmp += '                <img class="card-img-top"   height="200" src="/images/' + data[i].path + '" alt="' + data[i].alt + '">\n'
                        tmp += '                <div class="card-body">\n'
                        tmp += '                    <h2 class="card-title">' + data[i].headline + '</h2>\n'
                        tmp += '                    <p class="card-text">' + data[i].text.substr(0,240)+ '</p>\n'
                        tmp += '                    <a href="/articles/' + data[i].ArtID + '" class="btn btn-primary">Read More &rarr;</a>\n'
                        tmp += '                    @if(session('user')->id == $user->id)'
                        tmp += '                    <a href="/articles/edit/' + data[i].ArtID + '" class="btn btn-success">Update</a>\n'
                        tmp += '                    <a href="" onclick="deleteArticle(' + data[i].ArtID + ')" class="btn btn-danger">Delete</a>\n'
                        tmp += '                    @endif'
                        tmp += '                </div>\n'
                        tmp += '                <div class="card-footer text-muted">\n'
                        tmp += '                    Posted on ' + data[i].date_created + '\n'
                        tmp += '                </div>\n'
                        tmp += '            </div>';

                    }

                    $('.user_aritcle').html(tmp);
                },
                error: function () {

                }
            })
        });


        function deleteArticle(id) {

            $.ajax({
                method:'GET',
                url:'/articles/delete/'+id,
                dataType:'json',
                success:function () {

                },
                error:function () {

                }
            });
        }



    </script>

    @endsection
