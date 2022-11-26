<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Book;
use App\Models\bookReport;
use App\Models\finishedBook;
use App\Models\wantBook;

class BookController extends Controller
{
    public function detail($bookID)
    {
        $x = 0;

        $selectedCommentsCountSet = array_fill(0, 10, 0);
        foreach ($selectedCommentsCountSet as $commentAdd) {
            $selectedCommentsCount[$x]['value'] = $x;
            $selectedCommentsCount[$x]['comment'] = $this->commentAdd($x);
            $selectedCommentsCount[$x]['number'] = "0";
            $x++;
        }
        //TODO27:本データを外部から取る場合、書き換え
        $bookData = Book::where('bookID', $bookID)->first();
        //TODO27:ひとこと感想TOP3.やり方が綺麗でない
        $selectedCommentsGet = bookReport::selectraw('selectedComment')->where('bookID', $bookID)->get();
        foreach ($selectedCommentsGet as $selectedCommentGet) {
            $selectedCommentsExplode = explode(',', $selectedCommentGet['selectedComment']);

            foreach ($selectedCommentsExplode as $commentNum) {
                $selectedCommentsCount[$commentNum]['number']++;
            }
        }
        foreach ($selectedCommentsCount as $Number) {
            $NumGet[] = $Number['number'];
        }

        array_multisort($NumGet, SORT_DESC, $selectedCommentsCount);
        $selectedCommentsTop = array_slice($selectedCommentsCount, 0, 3);

        return view('TOP/bookDetail', compact('bookData', 'selectedCommentsTop'));
    }

    public function searchPageGet(Request $request)
    {
        $count = 0;
        $request->session()->forget('page');
        $request->session()->forget('searchTitle');
        $request->session()->forget('searchAuthor');
        $request->session()->forget('searchISBN');
        session(['select' => 'search']);
        return view('TOP/searchBooks', compact('count'));
    }

    public function search(Request $request)
    {
        //TODO27:次へ、をしてページ数増えてる時に新しい検索をしたときの対処方法 if文で分岐　検索を押されるたびにcountを0にする
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');

        if (!(isset($_POST['next'])) && !(isset($_POST['before']))) {
            $pageCount = 1;
            $count = 0;
        }
        if($request->input('next') != null){
            //echo "NEXT";
            $pageCount++;
            $count = ($count+10);
            
        }
        if($request->input('before') != null){
            // echo "BEFORE";
            $pageCount--;
            $count = ($count-10);
            if($count < 0){
                $count = 0;
            }
            
        }
        //TODO27:countに対して　次へのボタン押されたとき+10,前へは-10するif文

        // $searchWordGet = $request->input('searchWord');
        $searchTitleGet = $request->input('searchTitle');
        $searchAuthorGet = $request->input('searchAuthor');
        $searchISBNGet = $request->input('searchISBN');

        $params  = array();
        if($searchTitleGet != null){
            $params += array('intitle'=>$searchTitleGet);
        }
        if($searchAuthorGet != null){
            $params += array('inauthor'=>$searchAuthorGet);
        }
        if($searchISBNGet != null){
            $params += array('isbn'=>$searchISBNGet);
        }
        //dd($param);

        $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q=';
        $foreachCount = 0;
        $searchURL ="";
        foreach ($params as $key => $value) {
            if($foreachCount == 0){
                $searchURL = $baseURL . $key . ':' . $value ; 
            }else{
                $searchURL .= '+' . $key . ':' . $value ;
            }
            $foreachCount++;
        }
        //dd($searchURL);
        // $searchwords = preg_split("( |　)", $searchWordGet);

        // $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q';

        // if (count($searchwords) == 1) {
        //     $searchURL = urldecode("$baseURL=$searchWordGet");
        // } else {
        //     $isFirst = true;
        //     $wordsSet = "";
        //     foreach ($searchwords as $searchword) {
        //         if ($isFirst) {
        //             $wordsSet =  $searchword;
        //             $isFirst = false;
        //         } else {
        //             $wordsSet .= "%2b" .   $searchword;
        //         }
        //     }
        //     //dd($wordsSet);
        //     $searchURL = urldecode("$baseURL=$wordsSet");
        // }
        //dd($searchURL);

        $url = $searchURL . '&maxResults=10' . '&startIndex=' . $count;
        $searchGet = file_get_contents($url);
        // echo $url;
        $searchDatas = json_decode($searchGet);

        $bookDatasGet = $searchDatas->items;
        //dd($searchDatas);
        //dd($bookDatasGet);

        //TODO27:backに変数持たせるのと、本が決まったらsession pageを消す 検索結果出すとこ書く

        $x = 0;
        $bookDatas = array();
        $bookcount = 0;
        if(!($request->input('before') != null)){
           //?
        }
        //$count++;
        foreach ($bookDatasGet as $bookDataSet) {
            //Dataの数が10個になったら終わる
            // if (count($bookDatas) == 10) {
            //     echo $count;
            //     break;
            // } else {
            //本かどうか確かめる　論文なら飛ばす    本ならISBNとタイトルを取る
            if(property_exists($bookDataSet->volumeInfo,'industryIdentifiers')){

            if (count($bookDataSet->volumeInfo->industryIdentifiers) == 1) {
            continue;

            } else if (count($bookDataSet->volumeInfo->industryIdentifiers) == 2) {
                // $bookcount++;
                // $bookDatas[$x]['num'] = $bookcount;
            foreach ($bookDataSet->volumeInfo->industryIdentifiers as $isbn) {
                if ($isbn->type == "ISBN_13") {
                    $bookDatas[$x]['isbn13'] = $isbn->identifier;
                }
            }
            // $bookDatas[$x]['id'] = $bookDataSet->id;
            $bookDatas[$x]['title'] = $bookDataSet->volumeInfo->title;

            //本ならISBN
            if (property_exists($bookDataSet->volumeInfo, 'industryIdentifiers')) {
                if (count($bookDataSet->volumeInfo->industryIdentifiers) == 1) {
                    $bookDatas[$x]['isbn13'] = "なし";
                } else {
                    foreach ($bookDataSet->volumeInfo->industryIdentifiers as $isbn) {
                        if ($isbn->type == "ISBN_13") {
                            $bookDatas[$x]['isbn13'] = $isbn->identifier;
                        }
                    }
                }
            }
            //dd($bookDataSet->volumeInfo->authors);
            //作者名がなければ不明で登録
            if (!(property_exists($bookDataSet->volumeInfo, 'authors'))) {
                $bookDatas[$x]['author'] = "不明";
            } else {
                if (count($bookDataSet->volumeInfo->authors) != 1) {
                    $countAuthor = 0;
                    foreach ($bookDataSet->volumeInfo->authors as $author) {
                        if ($countAuthor == 0) {
                            $bookDatas[$x]['author'] = $author;
                        } else {
                            $bookDatas[$x]['author'] = $bookDatas[$x]['author'] . "," . $author;
                        }
                        $countAuthor++;
                    }
                } else {
                    $bookDatas[$x]['author'] = $bookDataSet->volumeInfo->authors[0];
                }
            }
            //カテゴリ
            if (!(property_exists($bookDataSet->volumeInfo, 'categories'))) {
                $bookDatas[$x]['categories'] = "不明";
            } else {
                if (count($bookDataSet->volumeInfo->categories) != 1) {
                    $countCategories = 0;
                    foreach ($bookDataSet->volumeInfo->categories as $categories) {

                        if ($countCategories == 0) {
                            $bookDatas[$x]['categories'] = $categories;
                        } else {
                            $bookDatas[$x]['categories'] .= "," . $categories;
                        }
                    }
                } else {
                    $bookDatas[$x]['categories'] = $bookDataSet->volumeInfo->categories[0];
                }
            }
            //詳細
            if (!(property_exists($bookDataSet->volumeInfo, 'description'))) {
                $bookDatas[$x]['description'] = "";
            } else {
                $bookDatas[$x]['description'] = $bookDataSet->volumeInfo->description;
            }
            //サムネイル
            if (!(property_exists($bookDataSet->volumeInfo, 'imageLinks'))) {
                $bookDatas[$x]['Thumbnail'] = "";
            } else {
                $bookDatas[$x]['Thumbnail'] = $bookDataSet->volumeInfo->imageLinks->smallThumbnail;
            }
            }

            //   }
            $x++;
        }
         }

        //dd($bookDatas);

        // session(['searchWord' => $searchWordGet]);
        session(['searchTitle' => $searchTitleGet]);
        session(['searchAuthor' => $searchAuthorGet]);
        session(['searchISBN' => $searchISBNGet]);
        session(['page' => 'true']);
        session(['select' => 'search']);

        return view('TOP/searchBooks', compact('count', 'bookDatas','pageCount'));
    }

    public function selectFromsearch(Request $request)
    {
        $count = 0;
        $request->session()->forget('page');
        session(['select' => 'search']);
        return view('TOP/searchBooks', compact('count'));
    }

    public function selectFromwantToBooks(Request $request)
    {
        $count = 0;
        $request->session()->forget('page');
        session(['select' => 'wantToBooks']);

        $user = Auth::user();
        if (DB::table('wantToBooks')->where('id', $user['id'])->where('finished', null)->exists()) {
            $wantBookGet = wantBook::where('id', $user['id'])->where('finished', null)->get();

            $x = 0;
            foreach ($wantBookGet as $wantBookSet) {
                $bookID = $wantBookSet['bookID'];
                $bookDataget = book::where('bookID', $bookID)->first();
                $wantBooks[$x]['bookID'] = $bookID;

                $wantBooks[$x]['book'] = $bookDataget['book'];
                $wantBooks[$x]['author'] = $bookDataget['author'];
                $wantBooks[$x]['genre'] = $bookDataget['genre'];

                $x++;
            }
        } else {
            $wantBooks = "";
        }


        return view('TOP/searchBooks', compact('count', 'wantBooks'));
    }

    public function selectFromfinishedBooks(Request $request)
    {
        $count = 0;
        session(['select' => 'finishedBooks']);
        $user = Auth::user();

        if (DB::table('finishedBooks')->where('id', $user['id'])->where('reviewID', null)->exists()) {
            $finishedBookDatasGet = finishedBook::where('id', $user['id'])->where('reviewID', null)->get();
            $x = 0;
            foreach ($finishedBookDatasGet as $finishedBookDataGet) {

                $bookDataget = book::where('bookID', $finishedBookDataGet['bookID'])->first();
                $finishedBooks[$x]['bookID'] = $finishedBookDataGet['bookID'];
                $finishedBooks[$x]['book'] = $bookDataget['book'];
                $finishedBooks[$x]['author'] = $bookDataget['author'];
                $finishedBooks[$x]['genre'] = $bookDataget['genre'];
                //日付関連
                $finishDateGet = explode(" ", $finishedBookDataGet['date']);
                $finishDate = explode("-", $finishDateGet[0]);

                $finishedBooks[$x]['finishDate'] = $finishDate[0] . "年" .  $finishDate[1] . "月" .  $finishDate[2] . "日";

                $x++;
            }
        } else {
            $finishedBooks = "";
        }

        return view('TOP/searchBooks', compact('count', 'finishedBooks'));
    }

    //
    public function write(request $request)
    {
        $bookID = request()->input('isbn');
        $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q=';

        $searchwords = 'isbn:' . $bookID;
        $URL = urldecode("$baseURL=$searchwords");
        $searchGet = file_get_contents($URL);
        echo $URL;
        $searchDatas = json_decode($searchGet);
        //dd($searchDatas);

        $bookDatasGet = $searchDatas->items;
        //dd($bookDatasGet);
        foreach ($bookDatasGet as $bookDatasSet) {
            $book = $bookDatasSet->volumeInfo->title;
        }
        
        //$bookID = request()->input('bookID');
        
        //$book = DB::table('books')->where('bookID', $bookID)->value('book');

        // dd($bookID);
        $request->session()->forget('page');
        return view('bookReportWrite', compact('bookID', 'book'));
    }

    //'reviewID' => 7以降,'UserID'、'bookID'、'evaluation'、'selectedComment'、'comment'、'Open'、'created_at'
    public function register(Request $request)
    {
        //渡すメッセージ
        $message = "";

        $reportDatasGet = $request->only('bookID', 'finishedDate', 'evaluation',  'comment', 'open');
        $bookID = $reportDatasGet['bookID'];
        //selectedComment
        $selectedCommentGet = $request->input('selectedComment');
        $selectedComment = implode(',', $selectedCommentGet);

        $reportDatasGet = $request->only('bookID', 'finishedDate', 'evaluation', 'selectedComment', 'comment', 'open');

        //created_atの日付
        $today = date("Y-m-d H:i:s");
        //user情報
        $userData = Auth::user();

        //登録：新着感想
        //reviewは自動加算.userはログイン情報sessionからもらう

        DB::table('bookReports')->insert([
            'id' => $userData['id'],
            'bookID' => $bookID,
            'evaluation' => $reportDatasGet['evaluation'],
            "selectedComment" =>  $selectedComment,
            "comment" => $reportDatasGet['comment'],
            "Open" => $reportDatasGet['open'],
            "created_at" => $today
        ]);


        $reviewIDget = bookReport::where('id', $userData['id'])->where('bookID', $bookID)->value('reviewID');
        if (!(DB::table('finishedBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            //登録：読んだ本
            DB::table('finishedBooks')->insert([
                'id' => $userData['id'],
                'bookID' => $bookID,
                'date' => $reportDatasGet['finishedDate'],
                'reviewID' => $reviewIDget,
            ]);
        }
        if ((DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->update([
                'finished' => 1,
            ]);
        }

        //入った場所に返す
        //eturn redirect('home')->with('result', '感想の登録の成功しました！');
        return view('hello');
    }


    public function commentAdd($comment)
    {
        if ($comment == 0) {
            return "感動した";
        }
        if ($comment == 1) {
            return "笑った";
        }
        if ($comment == 2) {
            return "面白かった";
        }
        if ($comment == 3) {
            return "怖かった";
        }
        if ($comment == 4) {
            return "ぞくぞくした";
        }
        if ($comment == 5) {
            return "文章が好き";
        }
        if ($comment == 6) {
            return "描写が綺麗";
        }
        if ($comment == 7) {
            return "泣いた";
        }
        if ($comment == 8) {
            return  "オススメしたい";
        }
        if ($comment == 9) {
            return "つまらなかった";
        }
    }

    public function wantBookAdd($bookID)
    {
        //TODO:読みたい本リストに追加する
        $user = Auth::user();
        if (Auth::user() == null) {
            return view('MyPage/myPage');
        }
        //registered_atの日付
        $today = date("Y-m-d H:i:s");

        //DBに追加
        if (!(DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->exists())) {
            DB::table('wantToBooks')->insert([
                [
                    'id' => $user['id'],
                    'bookid' => $bookID,
                    'registered_at' => $today,
                    'finished' => null
                ],
            ]);
            $flashMessage = "リストに追加しました！";
        } else {
            $flashMessage = "この本は既に読みたい本リストに追加されています";
        }
        //TODO:成功を失敗でCSS分ける場合はMessageをMessageKeyで区別できるように変更する

        return back()->with('Message', $flashMessage);
    }
}
