<h3>本の詳細ページ</h3>

<div>
    タイトル：{{$bookData['book']}} <br>
    著者：{{$bookData['auther']}} <br>
    ジャンル：{{$bookData['genre']}}
</div>

<div>
    <button>
        <a href="{{ route('book.wantBookAdd', $bookData['bookID'] )}}">読みたい本リストに追加する</a>
    </button>
    {{-- TODO:フラッシュメッセージらしいCSS 成功と失敗で分けてもいい --}}
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