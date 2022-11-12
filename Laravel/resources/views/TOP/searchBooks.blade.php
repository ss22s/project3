<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link href="css/searchBooks.css" rel="stylesheet" type="text/css">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <title>本の検索</title>

    <!--TODO27:ここのコードきもすぎ-->
    @if(session('select') == 'search')
    <script>
        $(function() {
            //$('#search').removeClass('select').addClass('notselect');
            if ($('.select').attr('id') != 'search') {
                $('.select').addClass('notselect');
                $('*').removeClass('select');
                $('#search').addClass('select');
            }
            alert("A");
        });
    </script>
    @elseif(session('select') == 'wantToBooks')
    <script>
        $(function() {
            if ($('.select').attr('id') != 'wantToBooks') {
                $('.select').addClass('notselect');
                $('*').removeClass('select');
                $('#search').addClass('select');
            }
            alert("A");
        });
    </script>
    @elseif(session('select') == 'finishedBooks')
    <script>
        $(function() {
            if ($('.select').attr('id') != 'finishedBooks') {
                $('.select').addClass('notselect');
                $('*').removeClass('select');
                $('#search').addClass('select');
            }
            alert("A");
        });
    </script>
    @endif
</head>

<body>
    <!--TODO27:ボタン押したら開く感じにしてもいいね 上か左でどの手段か選択　それが開いてる感じ-->
    <!--TODO27:詳細検索をつけてもいい　クリックすると開くかModal-->
    <div class="top">
        感想を書く本を選択します
        <div class="nav">
            <div class="select" id="search">
                <button type="submit" name="search"> 検索</button>
                <!-- 検索 -->
            </div>
            <div class="notselect" id="wantToBooks">
            <button type="submit" name="wantToBooks">読みたい本リストから選択</button>
            </div>
            <div class="notselect" id="finishedBooks">
                <button type="submit" name="finishedBooks">読んだ本リストから選択</button>
            </div>

            @if(session('page'))
            <h1>あああああああああ</h1>
            @endif
        </div>
    </div>
    <main>
        <!--TODO27:mainにsession selectが何かで表示するもの変化させる-->
        @if(1==1)
        <h5>検索できる項目:書籍のタイトル、著者名、ISBN10 /ISBN13 など</h5>
        <h5>複数のワードで検索する際はワードの間にスペースを入れて下さい</h5>
        <form action="/searchBooks" method="post">
            @csrf
            <input type="text" name="searchWord" placeholder="例:となりのトトロ" required>
            <input type="hidden" name="count" value="{{$count}}">
            <button type="submit" name="search">検索</button>
        </form>
        @endif
        の度アドグローブはコーポレートサイトのデザインをリニューアルいたしました！<br>
        今回はリニューアルでデザイン面などを主に担当した プロダクトデザイン部の伊東さん、フルモトさん にリニューアル時のあれこれについて、インタビューでお話を聞いてみました。
        <br>
        <br>
        <br>
        今回のリニューアルについてコンセプトを教えてください<br>
        伊東<br>
        これまでのホームページではゲーム・エンタメ色のイメージが強かったのですが、今回はそれらに加えてソリューションやプロダクトなど、アドグローブの幅広い事業の情報を伝えられるようにしてほしいという依頼があって制作しました。<br>
        あとは法人としてアドグローブの規模が大きくなってきたこともあり、勢いや親しみやすさ、カジュアルさから、落ち着きやフォーマルといった部分を強調するデザインにシフトしました。これまでは会社のイメージカラーであったオレンジ色がデザインに多く含まれていたんですが、リニューアルではモノトーンを軸とするデザインになっています。<br>
        <br>
        フルモト<br>
        今回のリニューアルでは、アドグローブの堅実さと最新技術の積極的な取り組みをイメージして欲しいとの要望だったので、そのイメージに合うようにデザインしました。<br>
        最新技術の積極的な取り組みが、幅広い事業情報を伝えられる印象に繋がったのかなと思います。<br>
        <br>
        伊東
        モノトーンなどへのデザイン変更もですが、内容などの書き換えも今回のリニューアルのメインとなっており、中身の変更点も多かったです。<br>
        メニュー面の変更とかもありましたよね？<br>
        <br>
        フルモト<br>
        そうですね。例えば、メニュー面でABOUT、PRODUCT、BUISINESSなどの項目を新たに追加したり、アドグローブの幅広い事業内容がわかるように情報の見せ方を工夫しました。<br>
        <br>
        <br>
        <br>
        製作期間やリニューアル業務について教えてください<br>
        伊東<br>
        6月初旬くらいからスタートして9月に公開となったので、制作は約3ヶ月の期間となります。<br>
        リニューアルのチームには営業も入ってもらい、どういった情報を見せたいのかを考え、プロダクトデザイン部の部長と私で画面の設計を考えて、フルモトさんにデザインを担当してもらいました。実際の開発ではアドグローブ社内のエンジニアに協力をしてもらい、新卒社員のメンバーも開発に挑戦してもらいました。<br>
        <br>
        リニューアル業務については、先程メニュー項目追加のお話をしましたが、業務内容にUI／UXとECなどの業務を追加しました。<br>これによって、アドグローブがどのような業務に対応しているかが明確化されたかと思います。
        <br>
        <br>
        <br>
        リニューアル業務で一番大変だったことを教えてください<br>
        伊東<br>
        トップ画面のメインビジュアルが大変で、何度も再考しましたね。<br>
        <br>
        フルモト<br><br>
        はい、ここは何度も再考を重ねました（笑）<br>
        <br>
        伊東<br>
        トップ画面の画像には東京・モントリオール・ニューヨーク・台北の四都市の画像を使っています。アドグローブの海外支社がある都市の写真ですね。<br>
        最初はこれまでのイメージでもあった《渋谷の会社》として渋谷の街並みの画像などを使っていたんですが、それよりも《グローバルな会社》の印象に変えようという話になりました。<br>
        グローバルな会社のデザイン表現として、当初は世界地図を記号化したデザインなど、写真以外の手法もいろいろと試行錯誤した結果、今の形に落ち着きました。<br>
        <br>
        フルモト<br>
        トップ画面もなんですが、私は写真選びが一番大変でした。<br>
        『トーンを落としつつも、色合いを感じられるような写真を選ぶといい』とアドバイスをいただいたので、それを意識して写真選びをしていました。
        リニューアルにおいて、ほぼすべての写真画像を変更しているんですがデザインの見栄えや統一感を出すための写真選びや加工に苦労しましたし、一番時間がかかった作業だと思います。
        <br>
        <br>
        <br>
        リニューアル業務で一番力を入れた、工夫した箇所を教えてください<br>
        フルモト<br>
        私はメインビジュアルに一番力を入れました！
        サイト全体がモノクロデザインの中で写真だけは少し色を出すようにしていたんですが、メインビジュアルもそれに合わせて少し色味を出してみました。

        <br>
        メインビジュアルの写真画像<br>
        トンマナ * を考えていただいたのは伊東さんですよね？<br>
        ※トンマナ（トーン（tone）＆マナー（manner）の略称）：デザインやスタイルなどに一貫性をもたせるルール<br>
        伊東<br>
        そうですね、私が考えました。コンセプトや方向性も決まっていたので、トンマナは比較的スムーズに決まりましたね。
        <br>
        フルモト<br>
        私はトップにあるBUSINESSの項目デザインが好きですね。<br>
        伊東さんに作成いただいたんですが、カッコいいな！と思っていました。このデザインはどういう思いで作ったのか私も聞いてみたいです。


        BUSINESSの項目デザイン
        伊東
        この箇所は《三角形を使いたかった》のと、シンプルで遊びが少ないデザインに《遊びを入れたくて》工夫しました。三角を入れることで斜めの形状が入るのと、アドグローブのロゴマークの ” A ” を連想させる図形を配置でき、わずかですがシンプルなデザインの中にも引っ掛かりを作っています。
        この部分のスマホ画面への切り替わり方もちょっとこだわってますので、見てみてください。

        フルモト
        私の工夫した箇所で言うと、写真選びの時に同じデザインばかりにならないように工夫しました。
        普通に画像を選ぶと、システム開発、ゲーム開発、UI／UX開発で液晶画面を使ったデザインにしたくなるんですが……。システム開発で液晶画面の写真を使うので、ゲーム開発では液晶だけではなく手元も映るような写真を選んだり。UI／UX開発では紙ベースでデザイン設計している写真を使って、似たような写真ばかりが続かないように、意識して差を持たせるようにしました。
        そういったこだわりも感じていただけると嬉しいです。





        最後までお読みいただきありがとうございました。
        アドグローブでは、これからもコーポレートサイト内容のさらなる充実をはかり、
        皆様に有益な情報を発信してまいります！

    </main>
</body>

</html>