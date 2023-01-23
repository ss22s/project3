<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/searchBox.css')  }}" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>

<body>
    本の検索
    <form action="/bookReportsList" method="post">
        @csrf
        <select name="searchType">
            <option value="title">タイトルで検索（タイトル）</option>
            @isset($searchType)
            @if($searchType == 'author')
            <option value="author" selected>著者で検索（著者）</option>
            @else
            <option value="author">著者で検索（著者）</option>
            @endif
            @else
            <option value="author">著者で検索（著者）</option>
            @endisset
        </select>
        <input type="text" name="searchWords" value="{{$searchWords}}">
        <button>検索</button>
    </form>
    @isset($bookDatas)
    @if($bookDatas != 0)
    <b>{{$searchWords}}</b>
    @if($searchType == "title")
    で<b>タイトル検索</b>
    @elseif($searchType == "author")
    で<b>著者検索</b>
    @else
    @endif
    をして、<b>{{$bookTotal}}</b>件がヒットしました
    @endif


    <div>
        @if($bookDatas == 0)
        <b>何も見つかりませんでした。検索ワードを変えて検索してみてください</b>
        @endif

        <div>
            @foreach($bookDatas as $bookData)

            <div class="main">
                <div class="box">
                    <p class="bookTitle"><b>{{$bookData['title']}}</b></p>
                    <div class="LinkTab">
                    <form action="/write" method="post">
                        @csrf
                        <input type="hidden" name="bookID" value="{{$bookData['bookID']}}">
                        <button class="buttonLink">感想を書く</button>
                    </form>
                        @if($bookData['exsists'])
                        <a class="bookLink" href="{{route('book.detail',['bookID'=>$bookData['bookID']])}}">
                            感想を見る</a>
                        @else

                        @endif
</div>
                    <div class="flex">
                        <p class="bookPhoto">
                            <img class="thumbnail" src="{{$bookData['thumbnail']}}" alt="書影" width="120" height="160">
                        </p>
                        <p class="booktext">

                            <b>著者：</b>{{$bookData['author']}}<br>
                            <b>カテゴリ：</b>{{$bookData['categories']}}<br>
                            <b>ISBN：</b>{{$bookData['isbn13']}}<br>
                            <!-- <b>説明：</b>{{$bookData['description']}}<br> -->
                            <b>説明：</b>{{ Str::limit($bookData['description'], 100) }}
                        </p>
                    </div>
                </div>
            </div>

            @endforeach
            <div class="pagebutton">
                <form method="post" class="form-inline">
                    @csrf
                    <input type="hidden" name="searchType" value="{{$searchType}}">
                    <input type="hidden" name="searchWords" value="{{$searchWords}}">
                    <input type="hidden" name="count" value="{{$count}}">
                    <input type="hidden" name="pageCount" value="{{$pageCount}}">
                    @if($pageCount == 1)
                    <input type="submit" class="buttoncss pagecount" name="before" formaction="/before" value="前へ" disabled>
                    @else
                    <input type="submit" class="buttoncss pagecount" name="before" formaction="/before" value="前へ">
                    @endif
                    <!-- <input type="hidden" name="count" value="{{$count}}"> -->
                    <b class="pagecount">{{$pageCount}}</b>
                    <input type="submit" class="buttoncss" name="next" formaction="/next" value="次へ">
                </form>
            </div>
        </div>
    </div>
    @endisset
</body>

</html>