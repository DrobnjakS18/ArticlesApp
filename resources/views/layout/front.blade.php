<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>ArticleApp | @yield('title')</title>

    @section('appednCSS')
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/blog-home.css')}}" rel="stylesheet">
    @show

</head>

<body>
@include('components.nav')

<div class="container">

    <div class="row">

        @yield('home')
        @yield('login')
        @yield('single')
        @yield('insert')
        @yield('user_articles')
        @yield('update')

    </div>

</div>

@include('components.footer')


@section('appendJavaScript')
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
@show
</body>

</html>
