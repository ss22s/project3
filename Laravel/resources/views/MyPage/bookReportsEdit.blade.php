<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bookReportsEdit.css')  }}">
    <title>感想-編集ページ</title>
</head>

<body>
    <div class="main">
        <div class="menuBar">
            @include('MenuBar')
        </div>

        <!-- 分岐 -->
        <div>
            <div class="page">感想を編集する</div><br>
            <div>
                <form action="/reportRegister" method="post">
                    @csrf
                    <div>
                        <label class="content">本のタイトル</label><br>
                        <!-- <input type="text" name="book" placeholder="例：となりのトトロ"> -->
                        <b>「　　　」</b>
                        <p>{{$reviewData['book']}}</p>
                    </div>
                    <br>
                    <div>
                        <label class="content">読み終わった日</label><br>
                        <input type="date" name="finishedDate">
                    </div>
                    <br>
                    <div>
                        <label class="content">評価：</label>
                        <select name="evaluation">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label class="content">ひとこと感想（複数選択可）</label>
                        <br>
                        <div class="check">
                            <input type="checkbox" name="selectedComment[]" value="0">感動した
                            <input type="checkbox" name="selectedComment[]" value="1">笑った
                            <input type="checkbox" name="selectedComment[]" value="2">面白かった
                            <input type="checkbox" name="selectedComment[]" value="3">怖かった
                            <input type="checkbox" name="selectedComment[]" value="4">ぞくぞくした
                        </div>
                        <div class="check">
                            <input type="checkbox" name="selectedComment[]" value="5">文章が好き
                            <input type="checkbox" name="selectedComment[]" value="6">描写が綺麗
                            <input type="checkbox" name="selectedComment[]" value="7">泣いた
                            <input type="checkbox" name="selectedComment[]" value="8">オススメしたい
                            <input type="checkbox" name="selectedComment[]" value="9">つまらなかった
                        </div>
                    </div>
                    <br>
                    <div>
                        <label class="content">感想</label><br>
                        <input type="text" name="comment" value="{{$reviewData['comment']}}" maxlength="10000" style="width: 50%;  line-height: 1.5; height: 6em;">
                    </div>
                    <br>
                    <div>
                        <label>公開状態：</label>
                        <input type="radio" name="open" value="0">公開
                        <input type="radio" name="open" value="1" checked>非公開
                    </div>
                    <br>
                    <div>
                        <button class="change" type="submit">編集</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
<!-- ↓読んだ本リスト→読んだ本リスト編集ページ繋ぐときにで使ってください。foreach回す方の変数の名前は変更可能
    このページには多分必要ない　
    {{--@foreach($finihsedBooks as $finishedBook)
    <a href="{{ route('bookReport.edit', $finishedBook['reviewID'] )}}">{{$finishedBook['book']}}</a>
    @endforeach --}} -->