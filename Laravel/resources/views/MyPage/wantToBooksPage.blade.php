<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/wantToBooksPage.css">
    <title>読みたい本リスト</title>
</head>

<body class="top">
    <div class="menuBar">
        @include('MenuBar')
    </div>
    <div class="page">読みたい本リスト</div>
    <div class="main">
        @csrf
        @foreach($wantBooks as $wantBook)
        <div class="box">
            <a class="title" href="{{ route('book.detail', $wantBook['bookID'] )}}">
                <p class="booklink">{{$wantBook['book']}}</p>
            </a>
            <span class="image">
                <img src="{{$wantBook['thumbnail']}}" alt="書影" width="180" height="220">
            </span>
            <p class="p3">登録日:{{$wantBook['registerDate']}}</p>
        </div>
        @endforeach
    </div>
    <div>
        <a class="toppagelink" href="/">TOPへ</a>
    </div>
    <br>
</body>

</html>