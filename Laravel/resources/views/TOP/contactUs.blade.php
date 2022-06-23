<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ</title>
</head>
<body>
    <div><a href=""><h1>よくある質問</h1></a></div>
    <div>
        <h1>ご意見 / お問い合わせ</h1>
        <div>
            <form action="/confirm" method="post" name="form" onsubmit="return validate()">

            @csrf
                <div>

                    <div>
                        <label for="name">お名前</label>
                        <input type="text" name="name" placeholder="例）田中太郎" value="">
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="text" name="email" placeholder="例）example@example.com" value="">
                    </div>
                    <div>
                        <label for="item">お問い合わせの種類</label>
                        <select name="item">
                            <option value="contact">お問い合わせ</option>
                            <option value="opinion">ご意見</option>
                            <option value="others">その他</option>
                        </select>
                    </div>
                    <div>
                        <label for="content">内容</label>
                        <textarea name="content" rows="5" placeholder="お問合せ内容を入力"></textarea>
                    </div>
                </div>
                <button type="submit">確認</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $("#form").submit(function(){
                var error;

                var name_value = $("input[name=name]").val();

                if(name_value == ""){
                    alert("お名前を入力してください");
                    return false;
                }
            });
        });
    </script>
</body>
</html>