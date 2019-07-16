@extends('layout.front')
@section('title')

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
        @foreach($user_art as $article)
        <!-- Blog Post -->
            <div class="card mb-4">
                <img class="card-img-top"   height="200"src="{{asset('images')."/".$article->path}}" alt="{{$article->alt}}">
                <div class="card-body">
                    <h2 class="card-title">{{$article->headline}}</h2>
                    <p class="card-text">{{str_limit($article->text,240)}}</p>
                    <a href="{{route('single_article',['id' => $article->ArtID])}}" class="btn btn-primary">Read More &rarr;</a>
                    <a href="#" class="btn btn-success">Update</a>
                    <a href="{{route('delete_art',['id' => $article->ArtID])}}" class="btn btn-danger">Delete</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{$article->date_created}} by
                    <a href="{{route('user_articles',['id' => $article->UserId])}}">{{$article->username}}</a>
                </div>
            </div>
            <!--// Blog Post -->
        @endforeach

    </div>
    @endsection





