<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- 自前CSS -->
    <link rel="stylesheet" type="text/css" href="css/userInfo.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    
    <title>ユーザ情報</title>
</head>
<body class="main">
    <div class="box1">
    <h4 class="menu">ユーザ情報編集</h4>
        <b>ユーザ名：</b>{{$userData['name']}} <br>
        <b>メールアドレス：</b>{{$userData['email']}} <br>
        <b>イチオシの一冊：</b>{{$userData['favoriteBook']}} <br>
        <b>好きな著者：</b>{{$userData['favoriteAuthor']}} <br>
        <b>自由記述欄：</b>{{$userData['freeText']}}<br>
    </div>

        <!-- モーダルを開くボタン・リンク -->
    <!--TODO:foreach文で出す際にdata-targetとidを感想のIDにする-->
    <div>
        
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleBook">
            ユーザー情報の編集
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleBook" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">感想</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{--内容--}}
                        <form action="/changeName" method="post" accept-charset="UTF-8">
		                {{ csrf_field() }}
                        <b>ユーザー名：</b><input type="text" name="name" value="{{$userData['name']}}"><br>
                        <b>メールアドレス：</b><input type="text" name="email" value="{{$userData['email']}}"><br>
                        <b>イチオシの一冊：</b><input type="text" name="favoriteBook" value="{{$userData['favoriteBook']}}"><br>
                        <b>好きな著者：</b><input type="text" name="favoriteAuthor" value="{{$userData['favoriteAuthor']}}"><br>
                        <b>自由記述欄：</b><input type="text" name="freeText" value="{{$userData['freeText']}}"><br>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

    <a class="link" href="/userCancel">退会したい</a>

</body>
</html>