<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">

    <title>読んだ本リスト</title>
    <style type="text/css">
        .open {
            cursor: pointer;
            /* マウスオーバーでカーソルの形状を変えることで、クリックできる要素だとわかりやすいように */
        }

        #pop-up {
            display: none;
            /* label でコントロールするので input は非表示に */
        }

        .overlay {
            display: none;
            /* input にチェックが入るまでは非表示に */
        }

        #pop-up:checked+.overlay {
            display: block;
            z-index: 9999;
            background-color: #00000070;
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
        }

        .window {
            width: 90vw;
            max-width: 380px;
            height: 240px;
            background-color: #ffffff;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .text {
            font-size: 18px;
            margin: 0;
        }

        .close {
            cursor: pointer;
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 20px;
        }
    </style>
</head>

<body>
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
                    <p class="text">{{$finishedBook['auther']}}</p>
                    <p class="text">{{$finishedBook['genre']}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>