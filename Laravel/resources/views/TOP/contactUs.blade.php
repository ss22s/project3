<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ</title>
</head>
<body>
    <div><a href="/faq"><h1>よくあるご質問</h1></a></div>
    <div>
        <h1>ご意見 / お問い合わせ</h1>
        <div>
            <form action="/confirm" method="post" name="form" onsubmit="return validate()">
            @csrf    

                <div>
                    <div>
                        <label>お名前</label>
                        <input type="text" name="name" placeholder="例）田中太郎" value="">
                    </div>
                    <div>
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email" placeholder="例）guest@example.com" value="">
                    </div>
                    <div>
                        <label>お問い合わせの種類</label>
                        <select name="item">
                            <option value="お問い合わせ">お問い合わせ</option>
                            <option value="ご意見">ご意見</option>
                            <option value="その他">その他</option>
                        </select>
                    </div>
                    <div>
                        <label>内容</label>
                        <textarea name="content" rows="5" placeholder="お問合せ内容を入力"></textarea>
                    </div>
                </div>
                <button type="submit">送信</button>
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