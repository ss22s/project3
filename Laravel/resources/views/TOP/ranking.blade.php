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
        @for($i = 0; $i < 7; $i++) <div>
            <!-- 書影 -->
            <h4>{{$i+1}}位：<a href="">{{$rankingDatas[$i]['book']}}</a></h4>
            <p>作者：{{$rankingDatas[$i]['auther']}}</p>
            <p>ジャンル：{{$rankingDatas[$i]['genre']}}</p>
    </div>
    @endfor
    </div>
</body>

</html>