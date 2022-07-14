<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="UTF-8">
</head>

<body>
<br>
    {{$name}} 様<br>
    <div>
        メッセージありがとうございます。
        以下の内容でメッセージを承りました。
    </div>
    <br>
    <div>
        <hr>
        <br>
        < お名前><br>
        {{$name}}<br>
        <br>
        < メールアドレス><br>
        {{$email}}<br>
        <br>
        < お問い合わせの種類><br>
        {{$item}}<br>
        <br>
        < 内容><br>
        {{$content}}<br>
        <br>
        <hr>
    </div>
    <br>
    ※当メールは送信専用となっております。
    ご返信頂いても、お答えしかねますのでご了承ください。
</body>
</html>