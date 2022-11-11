<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>本の検索</title>
</head>
<body>
    <h3>感想を書く本を検索します</h3>
    <h5>検索できる項目:書籍のタイトル、著者名、ISBN10 /ISBN13 など</h5>
    <form action="/searchBooks" method="post">
        <input type="text" name="searchBook" placeholder="例:となりのトトロ">
        <button>検索</button>
    </form>
</body>
</html>