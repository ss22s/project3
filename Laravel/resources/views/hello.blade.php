<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/hello.css">
    <title>Shererary</title>
</head>
<body class="main">

    <div>
        <div class="mypage">
            <a class="mypagelink" href="/myPage">マイページ</a>
        </div>
        <div class="login">
            @guest
            <a class="loginlink" href="/login">ログイン</a><br>
            <a class="loginlink" href="/register">新規登録</a>
            @endguest
            @auth
        </div>
        <div class="logout">
            <p class="message">
                ログイン済み<br>
                <!--ここのログアウト-->
                ようこそ、{{Auth::user()->name}}<br>
            </p>
            <a class="logoutlink" href={{ route('logout') }} onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
                @csrf
            @endauth
        </div>

        <div class="logo">
            <img src="{{ asset('img/logo2.png')}}" alt="logo">
        </div>

        <div class="toppage">
            <hr class="line">
            <a class="toppagelink" href="/">Top</a><br>
            <a class="toppagelink" href="/ranking">ランキング</a><br>
            <a class="toppagelink" href="/newBookReport">新着感想</a><br>  
            <a class="toppagelink" href="/contactUs">お問い合わせ</a>
        </div>

        <hr class="line">
        <div>
            <a class="toppagelink" href="/selectBooks">
                感想を書く
            </a>
        
            </div>
    </div>
</body>
</html>
