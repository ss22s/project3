<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/ranking.css">
</head>
<title>TOP-ランキング</title>
</head>

<body>
    <div class="main">
    <div class="menuBar">
        @include('MenuBar')
    </div>
        <div class="page">ランキング</div>
        @csrf
        @php
        $rank = 1;
        @endphp
        @foreach($rankingDatas as $bookData)

        @if($rank == 1)
        <div class="box1">
            <h4 class="ranking">
                <div class="rank1">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a>
            </h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">
                <img src="{{$bookData['thumbnail']}}" alt="書影" width="120" height="160">
            </span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @elseif($rank == 2)
        <div class="box1">
            <h4 class="ranking">
                <div class="rank2">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a>
            </h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">
            <img src="{{$bookData['thumbnail']}}" alt="書影" width="120" height="160">
            </span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @elseif($rank == 3)
        <div class="box1">
            <h4 class="ranking">
                <div class="rank3">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a>
            </h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">
            <img src="{{$bookData['thumbnail']}}" alt="書影" width="120" height="160">
            </span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @else
        <div class="box2">
            <h4 class="ranking">
                <div>{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a>
            </h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">
            <img src="{{$bookData['thumbnail']}}" alt="書影" width="120" height="160">
            </span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @endif
        @endforeach
        <div>
            <a class="toppagelink" href="/">TOPへ</a>
        </div>
        <br>
    </div>

</body>

</html>