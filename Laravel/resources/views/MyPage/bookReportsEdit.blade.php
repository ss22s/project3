<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bookReportWrite.css')  }}">
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
                <form action="/reportEdit" method="post">
                    <input type="hidden" name="reviewID" value="{{ $reviewData['reviewID']}}">
                    @csrf
                    <div>
                        <label class="content">本のタイトル</label><br>
                        <b>「 {{ $reviewData['book']}} 」</b>
                    </div>
                    <br>
                    <div>
                        <label class="content">読み終わった日</label><br>
                        <input type="date" name="finishedDate" value="{{ $reviewData['finishedDate']}}">
                    </div>
                    <br>
                    <div>
                        <label class="content">評価：</label>
                        <select name="evaluation">
                            <option value="0" <?php if ($reviewData['evaluation'] == '0') {
                                                    echo 'selected';
                                                } ?>>0</option>
                            <option value="1" <?php if ($reviewData['evaluation'] == '1') {
                                                    echo 'selected';
                                                } ?>>1</option>
                            <option value="2" <?php if ($reviewData['evaluation'] == '2') {
                                                    echo 'selected';
                                                } ?>>2</option>
                            <option value="3" <?php if ($reviewData['evaluation'] == '3') {
                                                    echo 'selected';
                                                } ?>>3</option>
                            <option value="4" <?php if ($reviewData['evaluation'] == '4') {
                                                    echo 'selected';
                                                } ?>>4</option>
                            <option value="5" <?php if ($reviewData['evaluation'] == '5') {
                                                    echo 'selected';
                                                } ?>>5</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label class="content">ひとこと感想（複数選択可）</label>
                        <br>
                        <div class="check">
                            <input type="checkbox" name="selectedComment[]" value="0" <?php if (strpos($reviewData['selectedComment'], 0) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>感動した
                            <input type="checkbox" name="selectedComment[]" value="1" <?php if (strpos($reviewData['selectedComment'], 1) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>笑った
                            <input type="checkbox" name="selectedComment[]" value="2" <?php if (strpos($reviewData['selectedComment'], 2) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>面白かった
                            <input type="checkbox" name="selectedComment[]" value="3" <?php if (strpos($reviewData['selectedComment'], 3) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>怖かった
                            <input type="checkbox" name="selectedComment[]" value="4" <?php if (strpos($reviewData['selectedComment'], 4) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>ぞくぞくした
                        </div>
                        <div class="check">
                            <input type="checkbox" name="selectedComment[]" value="5" <?php if (strpos($reviewData['selectedComment'], 5) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>文章が好き
                            <input type="checkbox" name="selectedComment[]" value="6" <?php if (strpos($reviewData['selectedComment'], 6) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>描写が綺麗
                            <input type="checkbox" name="selectedComment[]" value="7" <?php if (strpos($reviewData['selectedComment'], 7) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>泣いた
                            <input type="checkbox" name="selectedComment[]" value="8" <?php if (strpos($reviewData['selectedComment'], 8) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>オススメしたい
                            <input type="checkbox" name="selectedComment[]" value="9" <?php if (strpos($reviewData['selectedComment'], 9) !== false) {
                                                                                            echo 'checked';
                                                                                        } ?>>つまらなかった
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
                        <input type="radio" name="open" value="0" <?php if (is_null($reviewData['Open'])) {
                                                                        echo 'checked';
                                                                    } ?>>公開
                        <input type="radio" name="open" value="1" <?php if (!is_null($reviewData['Open'])) {
                                                                        echo 'checked';
                                                                    } ?>>非公開
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