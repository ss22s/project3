<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/ranking.css">
    <title>TOP-ランキング</title>
</head>

<body>
    <div class="main">
        <div class="page">ランキング</div>
        @csrf
        @php
        $rank = 1;
        @endphp
        @foreach($rankingDatas as $bookData)
        <div class="box">
            <!-- 書影(※書影にもリンクつける) -->
            <h4>{{$rank}}位：<a href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
            <p>作者：{{$bookData['auther']}}</p>
            <p>ジャンル：{{$bookData['genre']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @endforeach

        <div>
            <a class="toppagelink" href="/">TOPへ</a>
        </div>
        <br>
    </div>
</body>
</html>