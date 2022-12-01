<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="MenuBar">
    @include('MenuBar')
    </div>
    <h3>本の詳細ページ</h3>

<div>
   <img src="{{$bookThumbnail}}" alt="書影" width="150" height="200"><br>
    タイトル：{{$bookData['book']}} <br>
    著者：{{$bookData['author']}} <br>
    カテゴリ：{{$bookData['categories']}}
</div>

<div>
    <button>
        <a href="{{ route('book.wantBookAdd', $bookData['bookID'] )}}">読みたい本リストに追加する</a>
    </button>
    {{-- TODO:フラッシュメッセージらしいCSS 成功と失敗で分けてもいい alertにするのか--}}
    @if(session('Message'))
    <div>
        {{session('Message')}}
    </div>
    @endif
</div>

<hr>
<div>
    <h4>みんなのひとこと感想TOP3</h4>
    @foreach($selectedCommentsTop as $selectedCommentTop)
    @if($selectedCommentTop['number'] != 0)
    {{$selectedCommentTop['comment']}} {{$selectedCommentTop['number']}}人<br>
    @endif
    @endforeach
</div>
<hr>
<h4><a href="/">TOPへ</a> </h4>
</body>
</html>
