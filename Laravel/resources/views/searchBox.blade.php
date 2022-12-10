<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bookDetail.css" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>

<body>
    <form>
        <select name="searchType">
            <option value="user">ユーザーを検索</option>
            <option value="title">本を検索（タイトル）</option>
            <option value="author">本を検索（著者）</option>
            <option value="report">感想を書かれている本を検索（タイトル）</option>
        </select>
        <input type="text">
        <button>検索</button>
    </form>
    <div id="content">
        <div id="main">
        
            <h3>本の詳細ページ</h3>

            <div>
               
            </div>

            <div>
               
            </div>

            <hr>
            <div>
                <h4>みんなのひとこと感想TOP3</h4>
                
            </div>
            <hr>
            <p>
            <h4>感想</h4>
            </p>
            <h4><a href="/">TOPへ</a> </h4>
        </div>
        <nav>
        <div class="menuBar">
                @include('MenuBar')
            </div>
        </nav>
    </div>
</body>

</html>