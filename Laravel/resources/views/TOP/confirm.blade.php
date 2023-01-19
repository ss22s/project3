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
    <h2>確認画面</h2>
    <p>下記の内容でメッセージを送信します。よろしければ「送信」ボタンを押してください。</p>

    <form action="/complete" method="POST">
    @csrf
        <input type="hidden" name="token" value="<?php echo escape($token); ?>">
        <div>
            <label for="name">お名前</label>
            <input type="hidden" id="name" name="name" value="{{$name}}">
            <p>{{$name}}</p>
        </div>
        <div>
            <label for="email">メールアドレス</label>
            <input type="hidden" id="email" name="email" value="{{$email}}">
            <p>{{$email}}</p>
        </div>
        <div>
            <label for="item">お問い合わせの種類</label>
            <input type="hidden" id="item" name="item" value="{{$item}}">
            <p>{{$item}}</p>
        </div>
        <div>
            <label for="content">内容</label>
            <input type="hidden" id="content" name="content" value="{{$content}}">
            <p>{{$content}}</p>
        </div>
        <input class="btn" type="button" value="修正" onclick="history.back(-1)">
        <input class="btn" type="submit" value="送信" name="submit"></input>
    </form>
</body>
</html>