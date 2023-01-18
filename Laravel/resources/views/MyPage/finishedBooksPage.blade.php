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
    <div class="menuBar">
        @include('MenuBar')
    </div>
    <div class="page">読んだ本リスト</div>
    <div class="main">
        @csrf
        @foreach($finishedBooks as $finishedBook)
        <div class="box">
            <a class="title" href="{{ route('book.detail', $finishedBook['bookID'] )}}">
                <p class="booklink">{{$finishedBook['book']}}</p>
            </a>
            <p class="author">{{$finishedBook['author']}}</p>
            <span class="image">
                <img src="{{$finishedBook['thumbnail']}}" alt="書影" width="180" height="220">
            </span>
            <div class="info">
                カテゴリ：{{$finishedBook['categories']}}<br>
                読んだ日：{{$finishedBook['date']}}<br>
                一言感想：{{$finishedBook['selectedComment'][0]}}<br>
                感想：{{$finishedBook['comment']}}</p>
            </div>
            <div class="edit">
                <a href="#">→感想を編集する</a>
            </div>
        </div>
        @endforeach
    </div>
    <div>
        <a class="toppagelink" href="/">TOPへ</a>
    </div>
    <br>
</body>

</html>