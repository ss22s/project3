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
    @if($followLists != "")
    <div>
    @foreach($followLists as $followList)
    {{$followList['followerName']}}
    <br>
    @endforeach
    </div>
    @else
    <br>
    フォローしている人はいません。
    @endif 
</div>
<hr>
<div>
    {{-- TODO:隙間などはCSSに変更 --}}
    <b>読みたい本リスト</b>
    @if($myWantToBookdatas != "")
    &emsp;&emsp; <a href="">もっと見る</a>
    <div>
    @foreach($myWantToBookdatas as $myWantToBookdata)
    {{$myWantToBookdata['book']}}
    <br>
    @endforeach
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
    &emsp;&emsp; <a href="">もっと見る</a>
    <div>
    @foreach($myFinishedBookdatas as $myFinishedBookdata)
    {{$myFinishedBookdata['book']}}
    <br>
    @endforeach
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
