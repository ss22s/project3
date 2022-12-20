検索結果表示画面

<!--TODO27:感想のあるものとないものに分けてもいい-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
</head>
<body>
<form action="/bookReportsList" method="post">
        @csrf
        <select name="searchType">
            <option value="title" >本を検索（タイトル）</option>
            <option value="author">本を検索（著者）</option>
        </select>
        <input type="text" name="searchWords" value="{{$searchWords}}">
        <button>検索</button>
    </form>
    現在：{{$searchWords}}
    @if($searchType == "title")
    でタイトル検索
    @elseif($searchType == "author")
    で著者検索
    @else
    @endif
    <div>
        @foreach($bookDatas as $bookData)
        <div>
            <img src="{{$bookData['thumbnail']}}" alt="書影"  width="90" height="120">
            本のタイトル：{{$bookData['title']}}<br>
            著者：{{$bookData['author']}}<br>
            本のタイトル：{{$bookData['title']}}<br>
            <a href="{{ route('book.wantBookAdd', $bookData['bookid'] )}}">読みたい本リストに追加する</a>
            <a href="">感想を書く</a>
            <a href="">他の人の感想を見る</a>
        </div>
        @endforeach
    </div>
</body>
</html>