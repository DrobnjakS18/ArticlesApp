@if(session('user'))
    <!-- Navigacija -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

        <div class="container">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="{{asset('/articles')}}">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('insert_article')}}">Insert Article</a>
                    </li>

                </ul>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{session('user')->username}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{asset('/log')}}">Logout</a>
                        </li>
                    </ul>

                </div>




        </div>

    </nav>
    <!--// Navigacija -->
@endif