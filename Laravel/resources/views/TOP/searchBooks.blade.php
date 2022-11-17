<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link href="css/searchBooks.css" rel="stylesheet" type="text/css">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <title>本の検索</title>
    <script>
        $(function() {
            $('button').click(function() {
                //alert("D");
            });
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
    <div class="top">
        感想を書く本を選択します
        <div class="nav">
            <form class="form-inline" method="post">
                <!--TODO27：formの縦向きになるのをなんとかする　ならないなら左か右に固定に変える-->
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
            <h5>検索できる項目:書籍のタイトル、著者名、ISBN10 /ISBN13 など</h5>
            <h5>複数のワードで検索する際はワードの間にスペースを入れて下さい</h5>
            <form action="/searchBooks" method="post">
                @csrf
                <input type="text" name="searchWord" value="{{session('searchWord')}}" placeholder="例:となりのトトロ" required>
                <input type="hidden" name="count" value="{{$count}}">
                <button type="submit" name="searchbook">検索</button>
            </form>
        </div>
        <!-- TODO27:検索結果表示 page-->
        @if(session('page'))
            <h1>あああああああああ</h1>
            <form action="/searchBooks" method="post">
                <input type="hidden">
            </form>
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
                    <p class="bookdata">
                        <input type="hidden" name="bookID" value="{{$wantBook['bookID']}}">
                        <button class="buttoncss">
                            <b> 本のタイトル：</b>{{$wantBook['book']}}<br>
                            <b>著者：</b>{{$wantBook['author']}}<br>
                            <b>ジャンル：</b>{{$wantBook['genre']}}
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
            <form action="/write" method="post">
                @csrf
                @foreach($finishedBooks as $finishedBook)
                <p class="bookdata">
                    <input type="hidden" name="bookID" value="{{$finishedBook['bookID']}}">
                    <button class="buttoncss">
                        <b> 本のタイトル：</b>{{$finishedBook['book']}}<br>
                        <b>著者：</b>{{$finishedBook['author']}}<br>
                        <b>ジャンル：</b>{{$finishedBook['genre']}}<br>
                        <b>読み終わった日：</b>{{$finishedBook['finishDate']}}
                    </button>
                </p>
                @endforeach
            </form>
            @endif
        </div>
        @endif

    </main>
</body>

</html>