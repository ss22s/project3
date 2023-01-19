<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    感想検索
    <form action="/bookReportsList" method="post">
        @csrf
        <select name="searchType">
            <option value="title">本を検索（タイトル）</option>
            <option value="author">本を検索（著者）</option>
        </select>
        <input type="text" name="searchWords">
        <button>検索</button>
    </form>
    <div>
        
    </div>
</body>

</html>