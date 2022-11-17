<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="css/finishedBooksPage.css">
    <title>読んだ本リスト</title>
</head>

<body class="top">
    {{-- TODO:読んだ本リストのページ --}}
    {{-- finishedBooksにデータ入っるのでforeachなどで回すと取り出せる！ 
        感想はまだ書いてないけど、読んだ本リストに追加したものはfor回している中でif(reviewID != null) で判断できる--}}
    <h3>読んだ本リスト</h3>

    <div>
        @csrf
        @foreach($finishedBooks as $finishedBook)
        <!-- 書影(※書影にもリンクつける) -->
        <div>
            <label class="open" for="pop-up">{{$finishedBook['book']}}</label>
            <input type="checkbox" id="pop-up">
            <div class="overlay">
                <div class="window">
                    <label class="close" for="pop-up">×</label>
                    <!-- 書影(※書影にもリンクつける) -->
                    <!-- ひとこと感想 -->
                    <!-- コメント感想 -->
                    <!-- 読んだ日 -->
                    <!-- 編集ボタン→編集ページに移動 -->
                    <!-- 削除ボタン -->
                    <a class="text" href="{{ route('book.detail', $finishedBook['bookID'] )}}">{{$finishedBook['book']}}</a>
                    <p class="text">{{$finishedBook['author']}}</p>
                    <p class="text">{{$finishedBook['genre']}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>