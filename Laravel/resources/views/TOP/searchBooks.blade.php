<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link href="css/searchBooks.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <title>本の検索</title>
</head>

<body>
    <h3>感想を書く本を選択します</h3>
    <!--TODO:ボタン押したら開く感じにしてもいいね 上か左でどの手段か選択　それが開いてる感じ-->
    <!--TODO:詳細検索をつけてもいい　クリックすると開くかModal-->
    <div class="nav">
        <div>
            <h4>検索</h4>
            <h5>検索できる項目:書籍のタイトル、著者名、ISBN10 /ISBN13 など</h5>
            <h5>複数のワードで検索する際はワードの間にスペースを入れて下さい</h5>
            <form action="/searchBooks" method="post">
                @csrf
                <input type="text" name="searchWord" placeholder="例:となりのトトロ" required>
                <input type="hidden" name="count" value="{{$count}}">
                <button type="submit" name="search">検索</button>
            </form>

            @if(session('page'))
            <h1>あああああああああ</h1>
            @endif
        </div>
        <div>
            <h4>読みたい本リストから選択</h4>
        </div>
        <div>
            <h4>読んだ本リストから選択</h4>
        </div>
    </div> 
</body>

</html>