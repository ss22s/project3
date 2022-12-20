<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bookDetail.css')  }}">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <div class="menuBar">
            @include('MenuBar')
        </div>
            <div class="page">本の詳細ページ</div><br>
                <img src="{{$bookThumbnail}}" alt="書影" width="150" height="200">
                    <div class="data">    
                        タイトル：{{$bookData['book']}} <br>
                        著者：{{$bookData['author']}} <br>
                        カテゴリ：{{$bookData['categories']}}
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
            </div>
            <a class="toppagelink"  href="/">TOPへ</a>
    </div>
</body>
</html>