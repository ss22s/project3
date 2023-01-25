<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bookDetail.css')  }}">
    <title>本の詳細</title>
    <script>
        if ('{{$Message}}' != "") {
            alert('{{$Message}}');
        }
    </script>
</head>

<body>
    <div class="main">
        <div class="menuBar">
            @include('MenuBar')
        </div>
            <div class="page">本の詳細</div><br>
                <img src="{{$bookThumbnail}}" alt="書影" width="150" height="200">
                    <div class="data">    
                        <b>タイトル：</b>{{$bookData['book']}} <br>
                        <b>著者：</b>{{$bookData['author']}} <br>
                        <b>カテゴリ：</b>{{$bookData['categories']}}
                    </div>

                <br>
                <a class="favorite" href="{{ route('book.wantBookAdd', $bookData['bookID'] )}}">読みたい本リストに追加する</a>
                {{-- TODO:フラッシュメッセージらしいCSS 成功と失敗で分けてもいい alertにするのか--}}
                @if(session('Message'))
                <div>
                    {{session('Message')}}
                </div>
                @endif

            <div class="line">
                <h4>みんなのひとこと感想TOP3</h4>
                @foreach($selectedCommentsTop as $selectedCommentTop)
                @if($selectedCommentTop['number'] != 0)
                {{$selectedCommentTop['comment']}} {{$selectedCommentTop['number']}}人<br>
                @endif
                @endforeach
            </div>
            <div class="line">
                <h4>感想</h4>
                @foreach($reportDatas as $reportData)
                <div class="comment">
                <b>名前：</b><a class="user" href="{{route('user',['userID' => $reportData['id']])}}"> {{$reportData['name']}}</a><br>
                <b>評価：</b>{{$reportData['evaluation']}}<br>
                <b>一言コメント：</b>{{$reportData['selectedComment']}}<br>
                <b>【感想】</b><br>{{$reportData['comment']}}<br>
                </div>
                @endforeach
            </div>
            <a class="toppagelink"  href="/">TOPへ</a>
    </div>
</body>
</html>