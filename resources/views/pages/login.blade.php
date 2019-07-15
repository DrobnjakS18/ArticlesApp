@extends('layout.front')

@section('title')
        Login
    @endsection

@section('login')

        <div class="login-center">

            <form  action="{{asset("/log")}}"  method="POST" onsubmit=" return frontProvera()" >
                @csrf
                <h5>Login</h5>
                <div class="form-group" >
                    <input type="text" class="form-control" id="username"  name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary"  >Submit</button>
                <div class="alert alert-danger" id="log_error"></div>
                @if(session('login_error'))
                    <div class="alert alert-danger" >
                        {{session('login_error')}}
                    </div>
                    @endif
            </form>

        </div>



    @endsection


@section("appendJavaScript")
    @parent

    <script type="text/javascript">

        function  frontProvera() {

           var errorArray = [];

           var username = $('#username').val();

           var usernameReg = /^([A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*){4,20}$/;

           if(!usernameReg.test(username)){

               errorArray.push('Bad username. Min 4 , max 20 characters.');

           }

           var pass = $('#password').val();

           var passReg = /^([A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*){4,32}$/;

           if(!passReg.test(pass)){

               errorArray.push("Bad password. Min 4 , max 32 characters.")

           }

           if(errorArray.length > 0 ){

                var displayError = "<ul>";

                for(var i in errorArray){

                    displayError += "<li>" + errorArray[i] + "</li>";
                }

                displayError += "</ul>";


                $("#log_error").html(displayError);
               $('#log_error').show();
                return false;

           }else {

               return true;
           }



        }
    </script>
    @endsection