<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    *{
        background-color: #faf9f8;
    }
    div{
        background-color: #FFFFFF	;
        margin: 30px;
    }
    </style>
    <title>Document</title>
</head>
<body>

<div>
    <h4> sharerary </h4>
    sharerary
    <br>
    sharerary<br>
    sharerary<br>
</div>


<div class="box">
TOP:) <br>
<a href="/">Top</a><br>
<a href="/ranking">ランキング</a><br>
<a href="/newBookReport">新着感想</a><br>  
<a href="/chatRoom">掲示板</a><br>
<a href="/contactUs">お問い合わせ</a>

</div>
<hr>

<div>
ログイン:(
<br>

@guest
<a href="/login">ログイン</a><br>
<a href="/register">新規登録</a>
@endguest
@auth
ログイン済み<br>
<!--ここのログアウト-->
ようこそ、{{Auth::user()->name}}<br>
<a href={{ route('logout') }} onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    ログアウト
</a>
<form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
    @csrf
@endauth
</div>
<hr>
<div>
マイページ<br>
<a href="/myPage">マイページ</a><br>
</div>
<hr>
<div>
    <a href="/reportWrite">感想を書く</a>
</div>
</body>
</html>
