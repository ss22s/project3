<div>
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
@auth
    ようこそ、{{Auth::user()->name}}<br>
@endauth
<a href="/login">ログイン</a><br>
<a href="/register">新規登録</a><br>
<a href={{ route('logout') }} onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    ログアウト
</a>
<form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
    @csrf
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
