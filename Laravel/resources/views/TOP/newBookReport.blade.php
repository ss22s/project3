<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新着感想</title>
</head>
<body>
    @csrf
    @foreach($newBookReportData as $bookData)
    <div style="display:inline-block; border:2px solid; border-radius:30px; margin:10px; padding:10px;">
        <h2 style="text-align:center">{{$newBookReportData['book']}}</h2>
        <span style="display:inline-block; border:1px solid; font-size:50px; margin:20px; padding:40px;">書影</span>
        <!-- <img src = "書籍画像"> -->
        <span style="border:1px solid; font-size:20px; border-radius:50px; margin:10px; padding:20px;">icon</span> 
        <p style="display:inline-block; padding:5px;">【感想】<br>{{$newBookReportData['comment']}}<!--mb_sbstrで字数制限--></p>
        <p style="text-align:right">{{$newBookReportData['userName']}}</p>
        <p style="text-align:right">更新日:{{$newBookReportData['created_at']}}</p>
        <br>
    </div>
    @endforeach
</body>
</html>
