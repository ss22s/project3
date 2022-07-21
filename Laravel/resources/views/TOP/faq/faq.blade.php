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
    <h1>よくあるご質問</h1>
    <ul class="accordion-area">
        <li>
            <section>
                <h3 class="title">新規登録についての質問</h3>
                <div class="box">
                    <p>あいうえおあいうえおあいうえお</p>
                </div>
            </section>
        </li>
        <li>
            <section>
                <h3 class="title">ログインについての質問</h3>
                <div class="box">
                    <p>あいうえおあいうえおあいうえお</p>
                </div>
            </section>
        </li>
        <li>
            <section>
                <h3 class="title">マイページについての質問</h3>
                <div class="box">
                    <p>あいうえおあいうえおあいうえお</p>
                </div>
            </section>
        </li>
        <li>
            <section>
                <h3 class="title">検索機能についての質問</h3>
                <div class="box">
                    <p>あいうえおあいうえおあいうえお</p>
                </div>
            </section>
        </li>
    </ul>

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
</body>
</html>