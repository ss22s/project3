<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新着感想</title>
</head>
<body>
    @csrf
    @php
        $data = 0;
    @endphp

    @foreach($newBookReportDatas as $bookData)
        @if($data == 6)
            @break
        @else
        <div style="text-align:center;">
            <div style="display:inline-block; border:2px solid; border-radius:30px; text-align:center; margin:20px; padding:10px; width:450px;">
                    <a href="{{route('book.detail',['bookID'=>$bookData['bookID']])}}"><h2 style="text-align:center">{{$bookData['book']}}</h2></a>
                    <span style="display:inline-block; border:1px solid; font-size:50px; margin:20px; padding:40px;">書影</span>
                    <!-- <img src = "書籍画像"> -->
                    <p style="display:inline-block; padding:5px;"><hr><text style="font-size:20px;">【感想】</text><br>{!! nl2br(e(Str::limit($bookData['comment'], 200))) !!}</p>
                    <p style="text-align:right; font-size:18px;">[icon]　{{$bookData['userName']}}</p>
                    <p style="text-align:right">更新日:{{$bookData['created_at']}}</p>
            </div>
        </div>
            @php
                $data++;
            @endphp
        @endif
    @endforeach
</body>
</html>
