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

            @if(count($other_pic) > 1)

            <div class="slider">

                <a href="#0" class="next control">Next</a>
                <a href="#0" class="prev control">Prev</a>

                <ul>
                    @foreach($other_pic  as $pic)
                        <li class="c"> <img class="img-fluid rounded" width="750px" height="450px" src="{{asset('images').'/'.$pic->other_path}}" alt="{{$pic->other_alt}}"></li>
                    @endforeach
                </ul>


            </div>
                @else
                    @foreach($other_pic  as $pic)
                        <div class="one_pic">
                            <li class="c"> <img class="img-fluid rounded" width="750px" height="450px" src="{{asset('images').'/'.$pic->other_path}}" alt="{{$pic->other_alt}}"></li>

                        </div>

                    @endforeach
                @endif

            @endif

    </div>
    <!--// Sadrzaj -->
    @endsection


@section('appendJavaScript')
    @parent

    <script type="text/javascript">

        $(function() {

            var slideCount =  $(".slider ul li").length;
            var slideWidth =  $(".slider ul li").width();
            var slideHeight =  $(".slider ul li").height();
            var slideUlWidth =  slideCount * slideWidth;

            $(".slider").css({"max-width":slideWidth, "height": slideHeight});
            $(".slider ul").css({"width":slideUlWidth, "margin-left": - slideWidth });
            $(".slider ul li:last-child").prependTo($(".slider ul"));

            function moveLeft() {
                $(".slider ul").stop().animate({
                    left: + slideWidth
                },700, function() {
                    $(".slider ul li:last-child").prependTo($(".slider ul"));
                    $(".slider ul").css("left","");
                });
            }

            function moveRight() {
                $(".slider ul").stop().animate({
                    left: - slideWidth
                },700, function() {
                    $(".slider ul li:first-child").appendTo($(".slider ul"));
                    $(".slider ul").css("left","");
                });
            }


            $(".next").on("click",function(){
                moveRight();
            });

            $(".prev").on("click",function(){
                moveLeft();
            });


        });
    </script>
    @endsection