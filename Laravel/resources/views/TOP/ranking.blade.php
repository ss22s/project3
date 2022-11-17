<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TOP-ランキング</title>
</head>

<body>
    <div>
        <h1>ランキング</h1>
    </div>
    <div>
        @csrf
        @php
        $rank = 1;
        @endphp
        @foreach($rankingDatas as $bookData)
        <!-- 書影(※書影にもリンクつける) -->
        <h4>{{$rank}}位：<a href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
        <p>作者：{{$bookData['author']}}</p>
        <p>ジャンル：{{$bookData['genre']}}</p>
        @php
        $rank ++;
        @endphp
        @endforeach
    </div>
</body>

</html>