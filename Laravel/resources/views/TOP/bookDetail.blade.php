<h3>本の詳細ページ</h3>

<div>
タイトル：{{$bookData['book']}} <br>
著者：{{$bookData['auther']}} <br>
ジャンル：{{$bookData['genre']}}
</div>
<hr>
<div>
<h4>みんなのひとこと感想TOP3</h4> 
@foreach($selectedCommentsTop as $selectedCommentTop)
@if($selectedCommentTop['number'] != 0)
{{$selectedCommentTop['comment']}}  {{$selectedCommentTop['number']}}人<br>
@endif
@endforeach
</div>