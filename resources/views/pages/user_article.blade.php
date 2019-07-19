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

                    console.log(data);
                    var tmp = "";
                    for (var i in data) {

                        tmp += '  <div class="card mb-4">\n'
                        tmp += '                <img class="card-img-top"   src="/images/' + data[i].path + '" alt="' + data[i].alt + '">\n'
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
                error: function (xhr,Status,Error) {

                    var status = xhr.status;

                    switch (status) {

                        case 404:
                            alert('Failed to find user articles.');
                            break;
                        case 400:
                            alert('Bad request.');
                            break;
                        default:
                            alert('Failed to delete image.Error' +Status);
                            break;



                    }
                }
            })
        });


        function deleteArticle(id) {

            $.ajax({
                method:'GET',
                url:'/articles/delete/'+ id,
                dataType:'json',
                success:function (data) {
                        alert(data);
                },
                error:function (xhr,Status,Error) {

                    var status = xhr.status;



                    switch (status) {

                        case 404:
                            alert('Failed to delete image.');
                            break;
                        case 400:
                            alert('Failed to delete image.Bad request');
                            break;
                        default:
                            alert('Failed to delete image.Error' +Status + 'status ' + status);
                            break;



                    }
                }
            });
        }



    </script>

    @endsection

