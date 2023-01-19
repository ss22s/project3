<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>よくあるご質問</title>
    <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
    <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/9-2-2/css/9-2-2.css">
    <link rel="stylesheet" type="text/css" href="css/faq.css">
</head>
<body>
    <div class="MenuBar">
        @include('MenuBar')
    </div>
    <div class="linkbutton"><a class="toppagelink" href="/">TOPへ</a></div>
    <h1>よくあるご質問</h1>
    <div class="page">よくあるご質問</div>
    <ul class="accordion-area">
        <li>
            <div class="faq">
            <!-- <section> -->
                <h3 class="title">読んだ本はどこから登録できますか？</h3>
                <div class="box">
                    <p>
                        トップページの「感想を書く」ボタンをクリックすると読んだ本やその感想を登録することができるページに飛びます。<br>
                        <a class="reportWriteLink" href="/selectBooks">こちら</a>から登録ページに飛ぶことができます。
                    </p>
                </div>
            <!-- </section> -->
            </div>
        </li>
        <li>
            <div class="faq">
            <!-- <section> -->
                <h3 class="title">自分の読んだ本はどこから確認できますか？</h3>
                <div class="box">
                    <p>
                        トップページの「マイページ」ボタンをクリックした先のマイページの「読んだ本リスト」から確認することができます。<br>
                        <a class="myPageLink" href="/myPage">こちら</a>からマイページに飛ぶことができます。
                    </p>
                </div>
            <!-- </section> -->
            </div>
        </li>
        <li>
            <div class="faq">
            <!-- <section> -->
                <h3 class="title">ユーザー情報の変更はどこからできますか？</h3>
                <div class="box">
                    <p>
                        トップページの「マイページ」ボタンをクリックした先のマイページでユーザー情報を編集することができます。<br>
                        <a class="myPageLink" href="/myPage">こちら</a>からマイページに飛ぶことができます。
                    </p>
                </div>
            <!-- </section> -->
            </div>
        </li>
        <li>
            <div class="faq">
            <!-- <section> -->
                <h3 class="title">他のユーザーの感想はどこから見られますか？</h3>
                <div class="box">
                    <p>
                        トップページの「新着感想」ボタンをクリックすると他のユーザーの感想を見ることができます。<br>
                        <a class="newBookReportLink" href="/newBookReport">こちら</a>から新着感想ページに飛ぶことができます。
                    </p>
                </div>
            <!-- </section> -->
            </div>
        </li>
        <li>
            <div class="faq">
            <!-- <section> -->
                <h3 class="title">感想が書かれている本の詳細はどこから確認できますか？</h3>
                <div class="box">
                    <p>
                        新着感想ページで感想が書かれている本のタイトルをクリックすると、本の詳細を確認することができます。<br>
                        <a class="newBookReportLink" href="/newBookReport">こちら</a>から新着感想ページに飛ぶことができます。
                    </p>
                </div>
            <!-- </section> -->
            </div>
        </li>
    </ul>
    <div class="linkbutton"><a class="toppagelink" href="/">TOPへ</a></div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        //アコーディオンをクリックした時の動作
        $('.title').on('click', function() {//タイトル要素をクリックしたら
        var findElm = $(this).next(".box");//直後のアコーディオンを行うエリアを取得し
        $(findElm).slideToggle();//アコーディオンの上下動作
            
        if($(this).hasClass('close')){//タイトル要素にクラス名closeがあれば
            $(this).removeClass('close');//クラス名を除去し
        }else{//それ以外は
            $(this).addClass('close');//クラス名closeを付与
        }
        });

        //ページが読み込まれた際にopenクラスをつけ、openがついていたら開く動作
        $(window).on('load', function(){
        $('.accordion-area li:first-of-type section').addClass("open"); //accordion-areaのはじめのliにあるsectionにopenクラスを追加
        $(".open").each(function(index, element){ //openクラスを取得
            var Title =$(element).children('.title'); //openクラスの子要素のtitleクラスを取得
            $(Title).addClass('close');       //タイトルにクラス名closeを付与し
            var Box =$(element).children('.box'); //openクラスの子要素boxクラスを取得
            $(Box).slideDown(500);          //アコーディオンを開く
        });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="css/faq.css">
</body>
</html>