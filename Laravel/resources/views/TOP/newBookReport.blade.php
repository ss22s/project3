<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/newBookReport.css">
    <title>新着感想</title>
</head>

<body class="top">
    <div>
        @include('MenuBar')
    </div>
    @csrf
    @php
    $data = 0;
    @endphp
    <div class="page">新着感想</div>
    @foreach($newBookReportDatas as $bookData)
    @if($data == 6)
    @break
    @else
    <div class="main">
        <div class="box">
            <a class="title" href="{{route('book.detail',['bookID'=>$bookData['bookID']])}}">
                <p class="booklink">{{$bookData['book']}}</p>
            </a>
            <span class="image">書影</span>
            <!-- <img src = "書籍画像"> -->
            <p class="p1">
                <hr><text style="font-size:20px;">【感想】</text><br>{!! nl2br(e(Str::limit($bookData['comment'], 200))) !!}
            </p>
            <p class="p2">{{$bookData['userName']}}</p>
            <p class="p3">更新日:{{$bookData['created_at']}}</p>
        </div>
    </div>
    @php
    $data++;
    @endphp
    @endif
    @endforeach
    <div>
        <a class="toppagelink" href="/">TOPへ</a>
    </div>
    <br>
</body>

</html>