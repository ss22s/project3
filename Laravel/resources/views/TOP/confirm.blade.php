<?php
//セッション開始
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //フォームの確認ボタンが押されたら、POSTされたデータを各変数に格納する
    $name = $_POST["name"];
    $email = $_POST["email"];
    $item = $_POST["item"];
    $content = $_POST["content"];

    //トークンの生成
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;

    //HTML出力前のエスケープ処理
    function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
} else {
    //フォームの確認ボタン以外からこのページにアクセスした場合
    header(("location: alert.php"));
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>確認画面</title>
    <link rel="stylesheet" type="text/css" href="css/confirm.css">
</head>
<body>
    <div class="page">確認画面</div>
    <div class="p">下記の内容でメッセージを送信します。よろしければ「送信」ボタンを押してください。</div>

    <form action="/complete" method="POST">
    @csrf
        <input type="hidden" name="token" value="<?php echo escape($token); ?>">
        <div class="content">
            <label class="label" for="name">お名前</label>
            <input type="hidden" id="name" name="name" value="{{$name}}">
            <p class="input">{{$name}}</p>
        </div>
        <div class="content">
            <label class="label" for="email">メールアドレス</label>
            <input type="hidden" id="email" name="email" value="{{$email}}">
            <p class="input">{{$email}}</p>
        </div>
        <div class="content">
            <label class="label" for="item">お問い合わせの種類</label>
            <input type="hidden" id="item" name="item" value="{{$item}}">
            <p class="input">{{$item}}</p>
        </div>
        <div class="content">
            <label class="label" for="content">内容</label>
            <input type="hidden" id="content" name="content" value="{{$content}}">
            <p class="input naiyou">{{$content}}</p>
        </div>
        <div class="btnset">
            <input class="btn" type="button" value="修正" onclick="history.back(-1)">
            <input class="btn" type="submit" value="送信" name="submit"></input>
        </div>
    </form>
</body>
</html>