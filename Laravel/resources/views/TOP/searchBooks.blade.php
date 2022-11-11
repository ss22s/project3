<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>本の検索</title>
</head>

<body>
    <h3>感想を書く本を選択します</h3>
    <!--TODO:ボタン押したら開く感じにしてもいいね 上か左でどの手段か選択　それが開いてる感じ-->
    <!--TODO:詳細検索をつけてもいい　クリックすると開くかModal-->
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
</body>

</html>