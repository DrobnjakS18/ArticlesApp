@extends('layout.front')

@section('title')
    Home page
    @endsection

@section('home')

    <!-- Sadrzaj -->
    <div class="col-md-8">
        @if(session('login_success'))
            <div class="alert alert-success">
                {{ session('login_success') }}
            </div>
        @endif
        <h1 class="my-4">Latest Articles
        </h1>
            <div class="all_articles"></div>

        @foreach($articles as $article)
        <!-- Blog Post -->
        <div class="card mb-4">
            <img class="card-img-top"   height="200"src="{{asset('images')."/".$article->path}}" alt="{{$article->alt}}">
            <div class="card-body">
                    <h2 class="card-title">{{$article->headline}}</h2>
                <p class="card-text">{{str_limit($article->text,240)}}</p>
                <a href="{{route('single_article',['id' => $article->ArtId])}}" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
                Posted on {{ date("d M Y. H:i:s",strtotime($article->date_created))}} by
                <a href="{{route('user_articles',['id' => $article->UserId])}}">{{$article->username}}</a>
            </div>
        </div>
        <!--// Blog Post -->
        @endforeach
            <div id="pagination_center">
                {{$articles->links()}}

            </div>

    </div>
    <!--// Sadrzaj -->
    @endsection


{{--@section('appendJavaScript')--}}
    {{--@parent--}}

    {{--<script type="text/javascript">--}}

        {{--// $( document ).ready(function () {--}}
        {{--//--}}
        {{--//     $.ajax({--}}
        {{--//         type: "GET",--}}
        {{--//         url: '/articles/all',--}}
        {{--//         dataType: 'json',--}}
        {{--//         success: function (data) {--}}
        {{--//--}}
        {{--//--}}
        {{--//--}}
        {{--//             var data = data.articles.data;--}}
        {{--//--}}
        {{--//--}}
        {{--//             var tmp = "";--}}
        {{--//             for(var i in data ){--}}
        {{--//--}}
        {{--//                 tmp += '  <div class="card mb-4">\n'--}}
        {{--//                 tmp +='                <img class="card-img-top"   height="200" src="/images/'+data[i].path+'" alt="'+data[i].alt+'">\n'--}}
        {{--//                 tmp +='                <div class="card-body">\n'--}}
        {{--//                 tmp +='                    <h2 class="card-title">'+data[i].headline+'</h2>\n'--}}
        {{--//                 tmp +='                    <p class="card-text">'+data[i].text.substr(0,240)+'</p>\n'--}}
        {{--//                 tmp +='                    <a href="/articles/'+data[i].ArtId+'" class="btn btn-primary">Read More &rarr;</a>\n'--}}
        {{--//                 tmp +='                </div>\n'--}}
        {{--//                 tmp +='                <div class="card-footer text-muted">\n'--}}
        {{--//                 tmp +='                    Posted on '+data[i].date_created+'\n'--}}
        {{--//                 tmp += '<a href="" >'+data[i].username+'</a>'--}}
        {{--//                 tmp +='                </div>\n'--}}
        {{--//                 tmp +='            </div>';--}}
        {{--//--}}
        {{--//             }--}}
        {{--//--}}
        {{--//--}}
        {{--//--}}
        {{--//             $('.all_articles').html(tmp);--}}
        {{--//--}}
        {{--//--}}
        {{--//--}}
        {{--//         },--}}
        {{--//         error: function () {--}}
        {{--//--}}
        {{--//         }--}}
        {{--//--}}
        {{--//     })--}}
        {{--//--}}
        {{--// });--}}

    {{--</script>--}}

{{--@endsection--}}