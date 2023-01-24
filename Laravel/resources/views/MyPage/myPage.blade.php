<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/Mypage.css">
    <title>マイページ</title>
    @if(session('message') != '')
    <script>
       alert("{{session('message')}}");
    </script>
    @endif
</head>

<body>
    @auth
    <div class="main">
        <div class="menuBar">
            @include('MenuBar')
        </div>
        <div class="page">マイページ</div>
        <div class="box1">
            <h1 class="content">ユーザ情報</h1>
            <a class="link" href="/userInfo">ユーザ情報を編集する</a>
            <p class="data">
                <b class="bold">ユーザ名：</b>{{Auth::user()->name}} <br>
                @if(Auth::user()->email == $myData['userEmail'])
                <b class="bold">メールアドレス：</b>{{Auth::user()->email}}
                @endif <br>
                <b class="bold">イチオシの一冊：</b>{{$myData['favoriteBook']}} <br>
                <b class="bold">好きな著者：</b>{{$myData['favoriteAuthor']}} <br>
                <b class="bold">自由記述欄：</b>{{$myData['freeText']}}
            </p>
        </div>
        <br>
        <br>
        <div class="list">
            <div class="box2">
                <h1 class="content">フォロー</h1>
                @if($followLists != "")
                <div>
                    <p class="data">
                        @foreach($followLists as $followList)
                        <a class="link" href="{{route('user',['userID' => $followList['followerID']])}}"> {{$followList['followerName']}}</a>
                        <br>
                        @endforeach
                    </p>
                </div>
                @else
                <br>
                フォローしている人はいません。
                @endif
                </p>
            </div>
            <div class="box2">
                {{-- TODO:隙間などはCSSに変更 --}}
                <h1 class="content">読みたい本リスト</h1>
                @if($myWantToBookdatas != "")
                <div>
                    <p class="data">
                        @foreach($myWantToBookdatas as $myWantToBookdata)
                        {{$myWantToBookdata['book']}}
                        <br>
                        @endforeach
                    </p>
                    <a class="link" href="/wantToBooks">もっと見る</a>
                </div>
                @else
                <br>
                読みたい本は登録されていません。
                @endif
            </div>
            <div class="box2">
                <h1 class="content">読んだ本リスト</h1>
                @if($myFinishedBookdatas != "")
                <div>
                    <p class="data">
                        @foreach($myFinishedBookdatas as $myFinishedBookdata)
                        {{$myFinishedBookdata['book']}}
                        <br>
                        @endforeach
                    </p>
                    <a class="link" href="/finishedBooks">もっと見る</a>
                </div>
                @else
                <br>
                読んだ本はありません。
                @endif
            </div>
        </div>
        @endauth
        <div>
            <a class="toppagelink" href="/">TOPへ</a>
        </div>
        <br>
    </div>
</body>

</html>