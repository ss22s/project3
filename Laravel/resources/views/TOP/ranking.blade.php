<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</head>
    <link rel="stylesheet" type="text/css" href="css/ranking.css">
    <title>TOP-ランキング</title>
</head>

<body>
<div class="MenuBar">
    @include('MenuBar')
    </div>
    <div class="main">
        <div class="page">ランキング</div>
        @csrf
        @php
        $rank = 1;
        @endphp
        @foreach($rankingDatas as $bookData)

        <!-- 書影(※書影にもリンクつける) -->
        <h4>{{$rank}}位：<a href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
        <p>作者：{{$bookData['author']}}</p>
        <p>ジャンル：{{$bookData['categories']}}</p>

        @if($rank == 1)
        <div class="box1">
            <h4 class="ranking"><div class="rank1">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">書影</span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @elseif($rank == 2)
        <div class="box1">
            <h4 class="ranking"><div class="rank2">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">書影</span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @elseif($rank == 3)
        <div class="box1">
            <h4 class="ranking"><div class="rank3">{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">書影</span>
            <p>作者：{{$bookData['author']}}</p>
            <p>ジャンル：{{$bookData['categories']}}</p>
        </div>
        @php
        $rank ++;
        @endphp
        @else
        <div class="box2">
            <h4 class="ranking"><div>{{$rank}}位</div><a class="title" href="{{ route('book.detail', $bookData['bookID'] )}}">{{$bookData['book']}}</a></h4>
            <!-- 書影(※書影にもリンクつける) -->
            <span class="image">書影</span>
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