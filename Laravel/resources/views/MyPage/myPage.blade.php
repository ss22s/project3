<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    <title>マイページ</title>
</head>

<body>

    <!--データ表示のみ-->
    <h3>マイページ</h3>
    <hr>
    @auth
    <div>
        <h4 style="display: inline;">ユーザ情報</h4>
        &emsp;&emsp;<a href="/userInfo">ユーザ情報を編集する</a>
        <p style="margin-left:20px">
            <b>ユーザ名：</b>{{Auth::user()->name}} <br>
            @if(Auth::user()->email == $myData['userEmail'])
            <b>メールアドレス：</b>{{Auth::user()->email}}
            @endif <br>
            <b>イチオシの一冊：</b>{{$myData['favoriteBook']}} <br>
            <b>好きな著者：</b>{{$myData['favoriteAuther']}} <br>
            <b>自由記述欄：</b>{{$myData['freeText']}}
        </p>
    </div>
    <hr>
    <div>
        設定した目標冊数/月に対しての達成度グラフを表示する
    </div>
    <hr>
    <div>
        <b>フォロー</b>
        @if($followLists != "")
        <div>
            <p style="margin-left:20px">
                @foreach($followLists as $followList)
                {{$followList['followerName']}}
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
    <hr>
    <div>
        {{-- TODO:隙間などはCSSに変更 --}}
        <b>読みたい本リスト</b>
        @if($myWantToBookdatas != "")
        &emsp;&emsp; <a href="/wantToBooks">もっと見る</a>
        <div>
            <p style="margin-left:20px">
                @foreach($myWantToBookdatas as $myWantToBookdata)
                {{$myWantToBookdata['book']}}
                <br>
                @endforeach
            </p>
        </div>
        @else
        <br>
        読みたい本は登録されていません。
        @endif
    </div>
    <hr>
    <div>
        <b>読んだ本リスト</b>
        @if($myFinishedBookdatas != "")
        &emsp;&emsp; <a href="/finishedBooks">もっと見る</a>
        <div>
            <p style="margin-left:20px">
                @foreach($myFinishedBookdatas as $myFinishedBookdata)
                {{$myFinishedBookdata['book']}}
                <br>
                @endforeach
            </p>
        </div>
        @else
        <br>
        読んだ本はありません。
        @endif
    </div>
    @endauth
    <hr>
    <h4><a href="/">TOPへ</a> </h4>
</body>

</html>