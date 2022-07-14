<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    
    <title>マイページ</title>
</head>
<body>
    
<!--データ表示のみ-->
マイページ
<hr>
<!-- @guest
ログインしてください<br>
<a href="/login">ログイン</a><br>
@endguest -->
@auth
<div>
    <b>ユーザ名：</b>{{Auth::user()->name}} <br>
    <b>イチオシの一冊：</b>{{$myData['favoriteBook']}} <br>
    <b>好きな著者：</b>{{$myData['favoriteAuther']}} <br>
    <b>自由記述欄：</b>{{$myData['freeText']}}
</div>
<hr>
<div>
設定した目標冊数/月に対しての達成度グラフを表示する
</div>
<hr>
<div>
    <b>フォロー</b>
    <div>
    @foreach($followLists as $followList)
    {{$followList['followerName']}}
    <br>
    @endforeach
    </div>
</div>
<hr>
<div>
    <b>読みたい本リスト</b>
    <div>
    @foreach($myWantToBookdatas as $myWantToBookdata)
    {{$myWantToBookdata['book']}}
    <br>
    @endforeach
    </div>
</div>
<hr>
<div>
    <b>読んだ本リスト</b>
    <div>
    @foreach($myFinishedBookdatas as $myFinishedBookdata)
    {{$myFinishedBookdata['book']}}
    <br>
    @endforeach
    </div>
</div>
@endauth

</body>
</html>
