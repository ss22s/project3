<?php
session_start();

//-----メールの送信処理↓------
//送信ボタンが押されたら
if(!empty($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
    //フォームのボタンが押されたら、POSTされたデータを各変数に格納
    $name = $_POST["name"];
    $email = $_POST["email"];
    $item = $_POST["item"];
    $content = $_POST["content"];

    //メールの言語設定
    mb_language("ja");
    mb_internal_encoding("UTF-8");

    //件名を変数subjectに格納
    $subject = "[自動送信]　メッセージ内容の確認";

    //メール本文を変数bodyに格納
    $body = <<< EOM
    {$name}　様

    メッセージありがとうございます。
    以下の内容でメッセージを承りました。

    =======================================================
    < お名前 >
    {$name}

    < メールアドレス >
    {$email}

    < お問い合わせの種類 >
    {$item}

    < 内容 >
    {$content}
    ========================================================

    ※当メールは送信専用となっております。
    　ご返信頂いても、お答えしかねますのでご了承ください。
    EOM;

    //送信元のメールアドレスを変数fromEmailに格納
    $fromEmail = "sharerary@sharerary.com";

    //送信元の名前を変数fromNameに格納
    $fromName = "Sharerary";

    //ヘッダ情報を変数headerに格納する
    $header = "From: " . mb_encode_mimeheader($fromName) . "<{$fromEmail}>";

    //受信用のメールアドレスを変数myEmailに格納
    $myEmail = "st022023@m01.kyoto-kcg.ac.jp";

    //フォーム入力者にメールを送信する
    mb_send_mail($email, $subject, $body, $header);
} else {
    //トークンが一致しない場合、不正アクセス画面へ移動する
    header(("location: alert.blade.php"));
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>送信完了</title>
    <link rel="stylesheet" type="text/css" href="css/confirm.css">
</head>
<body>
    <h2>送信完了</h2>
    <p>メッセージありがとうございました。入力したメールアドレス宛に確認メールを送信致しましたので、ご確認ください。</p>
    <p>なお、数十分経過してもメールが届かない場合はメッセージを送信できていない可能性がございます。お手数ですが、お問い合わせページよりもう一度メッセージの送信をお願い致します。</p>
    <a href="/">
        <button class="btn" type="button">トップページに戻る</button>
    </a>
</body>
</html>