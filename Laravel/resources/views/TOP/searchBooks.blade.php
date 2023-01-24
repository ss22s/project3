<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <link href="css/searchBooks.css" rel="stylesheet" type="text/css">
    <title>本の検索</title>
    <script>
        $(function() {
            $('button').click(function() {
                //alert("D");
            });
            if ($('#searchTitle').val() != null || $('#searchAuthor').val() != null || $('#searchISBN').val() != null) {
                $('button[name=searchBooks]').prop("disabled", false);
            };

            // $pageCount = $count / 10; 
            $(document).on('change', '.searchwords', function(e) {
                if ($('#searchTitle').val() != null || $('#searchAuthor').val() != null || $('#searchISBN').val() != null) {

                    $('button[name=searchBooks]').prop("disabled", false);
                }

                // if()
            });
            // if($('.searchwords').)

        })
    </script>
    <!--TODO27:ここのコードきもすぎ-->
    @if(session('select') == 'search')
    <script>
        $(function() {
            if ($('.select').attr('id') != 'search') {
                $('.select').addClass('notselect');
                $('.nav *').prop('disabled', false);
                $('*').removeClass('select');
                $('#search').removeClass('notselect');

                $('#search').addClass('select');
                $('button[name=search]').prop("disabled", true);

                // $('#searchContent').show();
                //alert("A");
            }

        });
    </script>
    @elseif(session('select') == 'wantToBooks')
    <script>
        //alert("E");
        $(function() {
            if ($('.select').attr('id') != 'wantToBooks') {
                $('.select').addClass('notselect');
                $('.nav *').prop('disabled', false);

                $('*').removeClass('select');
                $('#wantToBooks').removeClass('notselect');
                $('#wantToBooks').addClass('select');
                $('button[name=wantToBooks]').prop("disabled", true);
                //alert("B");
            }
        });
    </script>
    @elseif(session('select') == 'finishedBooks')
    <script>
        $(function() {
            if ($('.select').attr('id') != 'finishedBooks') {
                $('.select').addClass('notselect');
                $('*').prop('disabled', false);

                $('*').removeClass('select');
                $('#finishedBooks').removeClass('notselect');
                $('#finishedBooks').addClass('select');
                $('button[name=finishedBooks]').prop("disabled", true);
            }
            //alert("c");
        });
    </script>
    @endif
</head>

<body>


    <!--TODO27:ボタン押したら開く感じにしてもいいね 上か左でどの手段か選択　それが開いてる感じ-->
    <!--TODO27:詳細検索をつけてもいい　クリックすると開くかModal-->
    <div id="content">
        <div id="main">
            <div class="top">

                感想を書く本を選択します
                <div class="nav">
                    <form class="form-inline" method="post">
                        @csrf
                        <div class="notselect" id="search">
                            <button class="buttoncss" type="submit" name="search" formaction="selectFromsearch" disabled> 検索</button>
                            <!-- 検索 -->
                        </div>
                        <div class="notselect" id="wantToBooks">
                            <button class="buttoncss" type="submit" name="wantToBooks" formaction="selectFromwantToBooks">読みたい本リストから選択</button>
                        </div>
                        <div class="notselect" id="finishedBooks">
                            <button class="buttoncss" type="submit" name="finishedBooks" formaction="selectFromfinishedBooks">読んだ本リストから選択</button>
                        </div>

                    </form>
                </div>
            </div>
            <main>
                @if(session('select') == 'search')
                <div id="searchContent">
                    <h3>検索する</h3>
                    
                    <h5>検索できる項目:書籍のタイトル、著者名、ISBN10 /ISBN13</h5>
                    <form action="/searchBooks" method="post">
                        @csrf
                        <b>本のタイトル</b> &nbsp;<input class="searchwords" id="searchTitle" type="text" name="searchTitle" value="{{session('searchTitle')}}" placeholder="例:こころ"><br>
                        <b>著者</b> &nbsp;<input class="searchwords" id="searchAuthor" type="text" name="searchAuthor" value="{{session('searchAuthor')}}" placeholder="例:夏目漱石"><br>
                        <b>ISBN</b> &nbsp;<input class="searchwords" id="searchISBN" type="text" name="searchISBN" value="{{session('searchISBN')}}" placeholder="例:9784903620305"><br>
                        <button type="submit" name="searchBooks" disabled>検索</button>
                    </form>
                </div>
                <!-- TODO27:検索結果表示 page-->
                @if(session('page'))
                <h2>検索結果</h2>
                @if($bookDatas == [])
                <b>何も見つかりませんでした。検索ワードを変えて検索してみてください</b>
                @else
                @foreach($bookDatas as $bookData)
                <form action="/write" method="post">
                    @csrf
                    <p class="searchbookdatas">
                        <input type="hidden" name="bookID" value="{{$bookData['id']}}">
                        <button class="buttoncss datacss">

                            <b>本のタイトル：</b>{{$bookData['title']}}<br>
                            <b>著者：</b>{{$bookData['author']}}<br>
                            <b>カテゴリ：</b>{{$bookData['categories']}}<br>
                            <b>ISBN：</b>{{$bookData['isbn13']}}<br>
                            <!-- <b>説明：</b>{{$bookData['description']}}<br> -->
                            <b>説明：</b>{{ Str::limit($bookData['description'], 200) }}
                        </button>
                    </p>
                </form>
                @endforeach
                <div class="pagebutton">
                    <form method="post" class="form-inline">
                        @csrf
                        <input type="hidden" name="searchTitle" value="{{session('searchTitle')}}">
                        <input type="hidden" name="searchAuthor" value="{{session('searchAuthor')}}">
                        <input type="hidden" name="searchISBN" value="{{session('searchISBN')}}">
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
                @endif

                @endif
                @endif
                <!--  style="display:none" -->
                @if(session('select') == 'wantToBooks')
                <div id="wantToBooksContent">
                    <h3>読みたい本リストから選択する</h3>
                    @if($wantBooks == "")
                    読みたい本リストに登録された本がありません。

                    @else
                    @foreach($wantBooks as $wantBook)
                    <div class="bookselectdata">
                        <form action="/write" method="post" class="bookselectdata">
                            @csrf
                            <p class="bookdatas">
                                <input type="hidden" name="bookID" value="{{$wantBook['bookID']}}">
                                <button class="buttoncss">
                                    <div class="bookdata">
                                        <figure class="img">
                                            <img src="{{$wantBook['thumbnail']}}" alt="書影" width="90" height="120">
                                        </figure>
                                        <div class="bookInfo">
                                            <b> 本のタイトル：</b>{{$wantBook['book']}}<br>
                                            <b>著者：</b>{{$wantBook['author']}}<br>
                                        </div>
                                    </div>
                                </button>
                            </p>
                        </form>
                    </div>
                    @endforeach

                    @endif

                </div>
                @endif
                @if(session('select') == 'finishedBooks')
                <div id="finishedBooksContent">
                    <h3>読んだ本リストから選択する</h3>
                    @if($finishedBooks == "")
                    読んだ本リストに登録された本がない、または全てに感想が書かれています。
                    感想を編集する場合は<a href="">ここ</a>から

                    @else
                    @csrf
                    @foreach($finishedBooks as $finishedBook)
                    <div class="bookselectdata">

                        <form action="/write" method="post">
                            @csrf
                            <input type="hidden" name="bookID" value="{{$finishedBook['bookID']}}">
                            <p class="bookdatas">
                                <button class="buttoncss">
                                <div class="bookdata">
                                        <figure class="img">
                                            <img src="{{$finishedBook['thumbnail']}}" alt="書影" width="90" height="120">
                                        </figure>
                                        <div class="bookInfo">
                                            <b> 本のタイトル：</b>{{$finishedBook['book']}}<br>
                                            <b>著者：</b>{{$finishedBook['author']}}<br>
                                            <b>読み終わった日：</b>{{$finishedBook['finishDate']}}
                                        </div>
                                    </div>                                    
                                </button>
                            </p>
                        </form>

                    </div>
                    @endforeach
                    @endif
                </div>
                @endif

            </main>
        </div>
        <nav id="menuBarBox">
            <div class="menuBar">
                @include('MenuBar')
            </div>
        </nav>
    </div>
    <link href="css/searchBooks.css" rel="stylesheet" type="text/css">
</body>

</html>