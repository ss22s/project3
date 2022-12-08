<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーページ</title>
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
    @if($userWantToBookdatas == "")
    読みたい本リストに登録された本がありません。
    @elseif($userWantToBookdatas == "非公開")
    読みたい本リストは非公開です。
    @else
    <div>
        <p class="data">
            @foreach($userWantToBookdatas as $userWantToBookdata)
            <a class="title" href="{{ route('book.detail', $userWantToBookdata['bookID'] )}}">{{$userWantToBookdata['book']}}</a>
            <br>
            @endforeach
            ︙
        </p>
    </div>
    @endif
    </p>

    <p>
    <h5>読んだ本リスト</h5>
    @if($userFinishedBookdatas == "")
    読んだ本リストに登録された本がありません。
    @elseif($userFinishedBookdatas == "非公開")
    読んだ本リストは非公開です。
    @else
    <div>
        <p class="data">
            @foreach($userFinishedBookdatas as $userFinishedBookdata)
            <a class="title" href="{{ route('book.detail', $userFinishedBookdata['bookID'] )}}">{{$userFinishedBookdata['book']}}</a>
            <br>
            @endforeach
            ︙
        </p>
    </div>
    @endif
    </p>

    <div>
        <h5>フォロー</h5>
        @if($userFollowLists == "")
    読んだ本リストに登録された本がありません。
    @elseif($userFollowLists == "非公開")
    読んだ本リストは非公開です。
    @else
    <div>
        <p class="data">
            @foreach($userFollowLists as $userfollowList)
            <a href="{{route('user',['userID' => $userfollowList['followerID']])}}"> {{$userfollowList['followerName']}}</a>
            <br>
            @endforeach
            ︙
        </p>
    </div>
    @endif
    </div>
</body>

</html>