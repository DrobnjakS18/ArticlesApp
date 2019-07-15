@extends('layout.front')

@section('title')

    STAVITI NAZIV PROSLEDJENOG HEADLINE ZA TITLE
    @endsection

@section('single')
    <!-- Sadrzaj -->
    <div class="col-md-8">


        <!-- Title -->
        <h1 class="mt-4">Post Title</h1>

        <!-- Author -->
        <p class="lead">
            by
            <a href="#">Start Bootstrap</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on January 1, 2018 at 12:00 PM</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset('/images/post1.jpg')}}" alt="">

        <hr>

        <!-- Post Content -->
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>

        <hr>


    </div>
    <!--// Sadrzaj -->
    @endsection