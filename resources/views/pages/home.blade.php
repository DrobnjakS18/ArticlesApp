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

    </div>
    <!--// Sadrzaj -->
    @endsection