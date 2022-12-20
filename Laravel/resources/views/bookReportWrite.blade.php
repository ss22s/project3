<!--
・form：
    form actionは"/reportRegister"
    formのinputのname指定
        本のタイトル：book
        本の著者（後で自動化）:author
        読んだ日：finishedDate
        評価：evaluation
        ひとこと感想:selectで"selectedComment"
             itemのvalueを0~の数字に
            例：<option value="0">感動した</option>
        コメント：comment
        公開・非公開：ラジオボタンのnameはopen、
                    非公開はvalueが0、公開は1。デフォルトは非公開に
        
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>感想を書く</title>
</head>

<body>
    <div class="main">
        <div class="menuBar">
            @include('MenuBar')
        </div>
        <div class="page">本の感想を書く</div>
        <div>
            <form action="/reportRegister" method="post">
                @csrf
                <div>
                    <label>本のタイトル：</label>
                    <input type="hidden" name="bookID" value="{{$bookID}}">
                    <!-- <input type="text" name="book" placeholder="例：となりのトトロ"> -->
                    <b>{{$book}}</b>
                    <button method="get" formaction="/selectBooks">変更する</button>
                </div>
                <br>
                <div>
                    <label>読み終わった日：</label>
                    <input type="date" name="finishedDate">
                </div>
                <br>
                <div>
                    <label>評価：</label>
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
                    <label>ひとこと感想（複数選択可）：</label>
                    <br>
                    <input type="checkbox" name="selectedComment[]" value="0">感動した
                    <input type="checkbox" name="selectedComment[]" value="1">笑った<br>
                    <input type="checkbox" name="selectedComment[]" value="2">面白かった
                    <input type="checkbox" name="selectedComment[]" value="3">怖かった <br>
                    <input type="checkbox" name="selectedComment[]" value="4">ぞくぞくした
                    <input type="checkbox" name="selectedComment[]" value="5">文章が好き <br>
                    <input type="checkbox" name="selectedComment[]" value="6">描写が綺麗
                    <input type="checkbox" name="selectedComment[]" value="7">泣いた <br>
                    <input type="checkbox" name="selectedComment[]" value="8">オススメしたい
                    <input type="checkbox" name="selectedComment[]" value="9">つまらなかった <br>
                </div>
                <br>
                <div>
                    <label>感想：</label>
                    <input type="text" name="comment" maxlength="10000" style="width: 50%;  line-height: 1.5; height: 6em;">
                </div>
                <br>
                <div>
                    <label>公開：</label>
                    <input type="radio" name="open" value="0">公開
                    <input type="radio" name="open" value="1" checked>非公開
                </div>
                <br>
                <div>
                    <button type="submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>