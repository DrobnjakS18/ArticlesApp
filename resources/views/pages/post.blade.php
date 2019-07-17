@extends('layout.front')

@section('title')

    {{$single->headline}}
    @endsection

@section('single')

    <!-- Sadrzaj -->
    <div class="col-md-8">


        <!-- Title -->
        <h1 class="mt-4">{{$single->headline}}</h1>

        <!-- Author -->
        <p class="lead">
            by
            <a href="{{route('user_articles',['id' => $single->UserId])}}">{{$single->username}}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on {{ date("d M Y. ",strtotime($single->date_created))}}</p>
        @if($single->date_updated != 0)
            <p>Updated on {{ date("d M Y" ,$single->date_updated)}}</p>
            @endif
        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('images').'/'.$single->path}}" alt="{{$single->alt}}">

        <hr>

        <!-- Post Content -->
        <p>{{$single->text}}</p>

        <hr>
        @if(isset($single->pic_id))

            <img class="img-fluid rounded" src="{{asset('images').'/'.$single->other_path}}" alt="{{$single->other_alt}}">
            @endif

    </div>
    <!--// Sadrzaj -->
    @endsection