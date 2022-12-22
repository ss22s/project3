<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーページ</title>
    <link rel="stylesheet" type="text/css" href="css/userDetail.css">
</head>
<body>
<div class="MenuBar">
    @include('MenuBar')
    </div>
    <h4>{{$userData['name']}}さんのページ</h4>
    <p>
        <b>イチオシの一冊：</b>{{$userData['favoriteBook']}}<br>
        <b>好きな著者：</b>{{$userData['favoriteAuthor']}}<br>
        <b>自由記述欄：</b>{{$userData['text']}}
    </p>
    <div>
    <a href="{{ route('user.follow', $userData['id'] )}}">{{$userData['name']}}さんをフォローする</a>
    <div>
    @if(session('FollowMessage') == "成功")
    フォローしました！
    @elseif(session('FollowMessage') == "失敗")
    既に{{$userData['name']}}さんをフォローしています
    @endif
    </div>
    </div>

    <p>
        <h5>最近の感想</h5>
    </p>

    <p>
        <h5>読みたい本リスト</h5>
    </p>

    <p>
        <h5>読んだ本リスト</h5>
    </p>

    <div>
        <h4>フォロー</h4>
    </div>
</body>
</html>