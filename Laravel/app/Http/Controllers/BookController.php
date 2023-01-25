<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyPageController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Book;
use App\Models\bookReport;
use App\Models\finishedBook;
use App\Models\wantBook;
use App\Models\User;

class BookController extends Controller
{
    public function detail($bookID)
    {
        $x = 0;

        $selectedCommentsCountSet = array_fill(0, 10, 0);
        foreach ($selectedCommentsCountSet as $commentAdd) {
            $selectedCommentCount['value'] = $x;
            $selectedCommentCount['comment'] = $this->commentAdd($x);
            $selectedCommentCount['number'] = "0";

            $selectedCommentsCount[$x] = $selectedCommentCount;
            $x++;
        }
        //TODO27:本データを外部から取る場合、書き換え
        $bookData = Book::where('bookID', $bookID)->first();
        $bookThumbnail = $this->setThumbnail($bookID);

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

        //感想取得
        $reportDatasGet = bookReport::where('bookID', $bookID)->where('Open', null)->get();

        $x = 0;

        if (isset($reportDatasGet)) {
            foreach ($reportDatasGet as $reportDataGet) {

                $reportDataSet['name'] = User::where('id', $reportDataGet['id'])->value('name');
                $reportDataSet['id'] = $reportDataGet['id'];
                $reportDataSet['evaluation'] = $reportDataGet['evaluation'];

                $selectedComments = explode(',', $reportDataGet['selectedComment']);
                foreach ($selectedComments as $selectedComment) {
                    $reportDataSet['selectedComment'] = $this->commentAdd($selectedComment);
                    if ($selectedComment !== end($selectedComments)) {
                        $reportDataSet['selectedComment'] .= ",";
                    }
                }
                $reportDataSet['comment'] = $reportDataGet['comment'];

                $reportDatas[$x] = $reportDataSet;
                $x++;
            }
        } else {
            $reportDatas = null;
        }
        $Message = "";

        return view('TOP/bookDetail', compact('Message', 'bookData', 'bookThumbnail', 'selectedCommentsTop', 'reportDatas'));
    }

    public function searchPageGet(Request $request)
    {
        $count = 0;
        $request->session()->forget('page');
        $searchTitle = null;
        $searchAuthor = null;
        $searchISBN = null;
        session(['select' => 'search']);
        return view('TOP/searchBooks', compact('searchTitle', 'searchAuthor', 'searchISBN', 'count'));
    }

    public function search(Request $request)
    {
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');

        if (!(isset($_POST['next'])) && !(isset($_POST['before']))) {
            $pageCount = 1;
            $count = 0;
        }

        $searchTitleGet = $request->input('searchTitle');

        $searchAuthorGet = $request->input('searchAuthor');
        $searchISBNGet = $request->input('searchISBN');

        list($bookDatas, $bookTotal) = $this->searchBooksAndSetbookDatas($searchTitleGet, $searchAuthorGet, $searchISBNGet, $count);


        $searchTitle = $searchTitleGet;
        $searchAuthor = $searchAuthorGet;
        $searchISBN = $searchISBNGet;

        session(['page' => 'true']);
        session(['select' => 'search']);

        return view('TOP/searchBooks', compact('searchTitle', 'searchAuthor', 'searchISBN', 'count', 'bookDatas', 'pageCount', 'bookTotal'));
    }

    public function beforeBookSearch(Request $request)
    {
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');
        $searchTitle = $request->input('searchTitle');
        $searchAuthor = $request->input('searchAuthor');
        $searchISBN = $request->input('searchISBN');

        $pageCount--;
        $count = ($count - 20);
        if ($count < 0) {
            $count = 0;
        }

        list($bookDatas, $bookTotal) = $this->searchBooksAndSetbookDatas($searchTitle, $searchAuthor, $searchISBN, $count);

        return view('TOP/searchBooks', compact('searchTitle', 'searchAuthor', 'searchISBN', 'count', 'bookDatas', 'pageCount', 'bookTotal'));
    }
    public function nextBookSearch(Request $request)
    {
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');
        $searchTitle = $request->input('searchTitle');
        $searchAuthor = $request->input('searchAuthor');
        $searchISBN = $request->input('searchISBN');

        $pageCount++;
        $count = ($count + 20);

        list($bookDatas, $bookTotal) = $this->searchBooksAndSetbookDatas($searchTitle, $searchAuthor, $searchISBN, $count);

        return view('TOP/searchBooks', compact('searchTitle', 'searchAuthor', 'searchISBN', 'count', 'bookDatas', 'pageCount', 'bookTotal'));
    }

    public function searchBooksAndSetBookDatas($searchTitleGet, $searchAuthorGet, $searchISBNGet, $count)
    {
        $params  = array();
        if ($searchTitleGet != null) {
            $params += array('intitle' => $searchTitleGet);
        }
        if ($searchAuthorGet != null) {
            $params += array('inauthor' => $searchAuthorGet);
        }
        if ($searchISBNGet != null) {
            $params += array('isbn' => $searchISBNGet);
        }

        $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q=';
        $foreachCount = 0;
        $searchURL = "";
        foreach ($params as $key => $value) {
            if ($foreachCount == 0) {
                $searchURL = $baseURL . $key . ':' . $value;
            } else {
                $searchURL .= '+' . $key . ':' . $value;
            }
            $foreachCount++;
        }

        $url = $searchURL . '&maxResults=20' . '&startIndex=' . $count;
        $searchGet = file_get_contents($url);
        // echo $url;
        $searchDatas = json_decode($searchGet);
        if ($searchDatas->totalItems != 0) {
            $bookDatasGet = $searchDatas->items;
            $bookTotal = $searchDatas->totalItems;



            $x = 0;
            $bookDatas = array();
            foreach ($bookDatasGet as $bookDataSet) {

                $bookData['bookID'] = $bookDataSet->id;

                $bookData['thumbnail'] = $this->setThumbnail($bookDataSet->id);

                $bookData['isbn13'] = $this->setISBN($bookDataSet);

                $bookData['title'] = $bookDataSet->volumeInfo->title;

                //作者名がなければ不明で登録
                $bookData['author'] = $this->setAuthor($bookDataSet);

                //カテゴリ
                $bookData['categories'] = $this->setCategories($bookDataSet);

                //詳細
                $bookData['description'] = $this->setDescription($bookDataSet);

                $bookDatas[$x] = $bookData;
                $x++;
            }
        } else {
            $bookDatas = 0;
        }
        return array($bookDatas, $bookTotal);
    }

    public function selectFromsearch(Request $request)
    {
        $count = 0;
        $searchTitle = null;
        $searchAuthor = null;
        $searchISBN = null;
        $request->session()->forget('page');
        session(['select' => 'search']);
        return view('TOP/searchBooks', compact('searchTitle', 'searchAuthor', 'searchISBN', 'count'));
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

                $bookDataGet = book::where('bookID', $bookID)->first();
                // dd($bookDataGet);

                $wantBook['bookID'] = $bookID;
                $wantBook['book'] = $bookDataGet['book'];

                //作者
                $wantBook['author'] = $bookDataGet['author'];

                $wantBook['categories'] = $bookDataGet['categories'];

                $wantBook['ISBN'] = $bookDataGet['ISBN'];

                $wantBook['thumbnail'] = $this->setThumbnail($bookID);

                $wantBooks[$x] = $wantBook;

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
                $bookID = $finishedBookDataGet['bookID'];
                $finishedBooks[$x]['bookID'] = $bookID;

                $bookDataGet = book::where('bookID', $finishedBookDataGet['bookID'])->first();
                // $bookDataGet = $this->booksearchId($bookID);

                $finishedBooks[$x]['book'] = $bookDataGet['book'];

                $finishedBooks[$x]['author'] = $bookDataGet['author'];
                $finishedBooks[$x]['ISBN'] = $bookDataGet['ISBN'];
                $finishedBooks[$x]['categories'] = $bookDataGet['categories'];

                $finishedBooks[$x]['thumbnail'] = $this->setThumbnail($bookID);
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
        $bookID = request()->input('bookID');
        $bookDatasGet = $this->booksearchId($bookID);

        $book = $bookDatasGet->volumeInfo->title;

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

        $open = $request->input('Open');
        if ($open != 0) {
            $open = null;
        }
        //created_atの日付
        $today = date("Y-m-d H:i:s");
        //user情報
        $userData = Auth::user();

        //登録：新着感想
        //reviewは自動加算.userはログイン情報sessionからもらう
        if(!(DB::table('bookReports')->where('id',$userData['id'])->where('bookID',$bookID)->exists())){
            DB::table('bookReports')->insert([
                'id' => $userData['id'],
                'bookID' => $bookID,
                'evaluation' => $reportDatasGet['evaluation'],
                "selectedComment" =>  $selectedComment,
                "comment" => $reportDatasGet['comment'],
                "Open" => $open,
                "created_at" => $today
            ]);
        } else {
            DB::table('bookReports')->where('id',$userData['id'])->where('bookID',$bookID)->update([
                'evaluation' => $reportDatasGet['evaluation'],
                "selectedComment" =>  $selectedComment,
                "comment" => $reportDatasGet['comment'],
                "Open" => $open,
                "created_at" => $today
            ]);
        }
        


        $reviewIDget = bookReport::where('id', $userData['id'])->where('bookID', $bookID)->value('reviewID');

        if (!(DB::table('finishedBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            //登録：読んだ本
            DB::table('finishedBooks')->insert([
                'id' => $userData['id'],
                'bookID' => $bookID,
                'date' => $reportDatasGet['finishedDate'],
                'reviewID' => $reviewIDget,
            ]);
        } else if((DB::table('finishedBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())){
            DB::table('finishedBooks')->where('id', $userData['id'])->where('bookID', $bookID)->update([
                'reviewID' => $reviewIDget,
            ]);
        }
        if ((DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->update([
                'finished' => 1,
            ]);
        }
        //bookテーブルにまだ登録されていなければ登録する
        if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
            $bookDataGet = $this->booksearchId($bookID);
            //dd($bookDataGet);
            $setISBN = $this->setISBN($bookDataGet);
            if ($setISBN == "不明") {
                $setISBN = "0";
            }

            DB::table('books')->insert([
                'bookID' => $bookID,
                'book' => $bookDataGet->volumeInfo->title,
                'author' => $this->setAuthor($bookDataGet),
                'ISBN' => $setISBN,
                'categories' => $this->setCategories($bookDataGet),
            ]);
        }

        //入った場所に返す
        session(['message' => " 感想の登録に成功しました！"]);
        //入った場所に返す
        return redirect()->action([MyPageController::class, 'myPage']);
    }


    public static function commentAdd($comment)
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

    public static function wantBookAdd($bookID)
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
                    'bookiD' => $bookID,
                    'registered_at' => $today,
                    'finished' => null
                ],
            ]);
            if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
                $bookDataGet = BookController::booksearchId($bookID);
                //dd($bookDataGet);
                $setISBN = BookController::setISBN($bookDataGet);
                if ($setISBN == "不明") {
                    $setISBN = "0";
                }

                DB::table('books')->insert([
                    'bookID' => $bookID,
                    'book' => $bookDataGet->volumeInfo->title,
                    'author' => BookController::setAuthor($bookDataGet),
                    'ISBN' => $setISBN,
                    'categories' => BookController::setCategories($bookDataGet),
                ]);
            }
            $flashMessage = "リストに追加しました！";
        } else if ((DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->where('finished', '1')->exists()) && (!(DB::table('finishedBooks')->where('id', $user['id'])->where('bookID', $bookID)->exists()))) {
            DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->where('finished', 1)->update(['finished' => null]);
            $flashMessage = "リストに追加しました！";
        } else {
            $flashMessage = "この本は既に読みたい本リストに追加されています";
        }
        //TODO:成功を失敗でCSS分ける場合はMessageをMessageKeyで区別できるように変更する

        return back()->with('Message', $flashMessage);
        //return view('/');
    }


    public static function wantBookAddTo(Request $request)
    {
        $bookID = $request->input('bookID');
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');
        $searchType = $request->input('searchType');
        $searchWords = $request->input('searchWords');

        $user = Auth::user();
        //registered_atの日付


        $today = date("Y-m-d H:i:s");

        if (!(DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->exists())) {
            DB::table('wantToBooks')->insert([
                [
                    'id' => $user['id'],
                    'bookiD' => $bookID,
                    'registered_at' => $today,
                    'finished' => null
                ],
            ]);
            if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
                $bookDataGet = BookController::booksearchId($bookID);
                //dd($bookDataGet);
                $setISBN = BookController::setISBN($bookDataGet);
                if ($setISBN == "不明") {
                    $setISBN = "0";
                }

                DB::table('books')->insert([
                    'bookID' => $bookID,
                    'book' => $bookDataGet->volumeInfo->title,
                    'author' => BookController::setAuthor($bookDataGet),
                    'ISBN' => $setISBN,
                    'categories' => BookController::setCategories($bookDataGet),
                ]);
            }

            $flashMessage = "リストに追加しました！";
        } else if ((DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->where('finished', '1')->exists()) && (!(DB::table('finishedBooks')->where('id', $user['id'])->where('bookID', $bookID)->exists()))) {
            DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->where('finished', 1)->update(['finished' => null]);
            $flashMessage = "リストに追加しました！";
        } else {
            $flashMessage = "この本は既に読みたい本リストに追加されています";
        }
        //ここからBookrepostsと同じ
        $params  = array();
        if ($searchType == "title") {
            $params += array('intitle' => $searchWords);
        } else if ($searchType == "author") {
            $params += array('inauthor' => $searchWords);
        }
        $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q=';
        $foreachCount = 0;
        $searchURL = "";
        foreach ($params as $key => $value) {
            if ($foreachCount == 0) {
                $searchURL = $baseURL . $key . ':' . $value;
            } else {
                $searchURL .= '+' . $key . ':' . $value;
            }
            $foreachCount++;
        }
        // dd($searchURL);
        $url = $searchURL . '&maxResults=20' . '&startIndex=' . $count;
        $searchGet = file_get_contents($url);
        // echo $url;
        $searchDatas = json_decode($searchGet);
        if ($searchDatas->totalItems != 0) {
            $bookDatasGet = $searchDatas->items;
            $bookTotal = $searchDatas->totalItems;

            $x = 0;
            $bookDatas = array();
            $bookcount = 0;
            
            //$count++;
            foreach ($bookDatasGet as $bookDataSet) {

                $bookData['bookID'] = $bookDataSet->id;

                $bookData['thumbnail'] = BookController::setThumbnail($bookDataSet->id);

                $bookData['isbn13'] = BookController::setISBN($bookDataSet);

                $bookData['title'] = $bookDataSet->volumeInfo->title;

                //作者名がなければ不明で登録
                $bookData['author'] = BookController::setAuthor($bookDataSet);

                //カテゴリ
                $bookData['categories'] = BookController::setCategories($bookDataSet);

                //詳細
                $bookData['description'] = BookController::setDescription($bookDataSet);

                //感想があるか検索
                    $bookReportsExsists = bookReport::where('bookID', $bookData['bookID'])->exists();
                    $bookData['exsists'] = $bookReportsExsists;

                    $bookDatas[$x] = $bookData;
                    $x++;
            }
        }
        return view('searchBox', compact('count', 'pageCount', 'bookDatas', 'searchType', 'searchWords', 'bookTotal', 'flashMessage'));
        //return view('/hello');
    }

    public static function finishedBookAddTo(Request $request){

        $bookID = $request->input('bookID');
        $count = $request->input('count');
        $pageCount = $request->input('pageCount');
        $searchType = $request->input('searchType');
        $searchWords = $request->input('searchWords');

        $user = Auth::user();
        //registered_atの日付


        $today = date("Y-m-d H:i:s");

        if (!(DB::table('finishedBooks')->where('id', $user['id'])->where('bookID', $bookID)->exists()) && (!(DB::table('bookReports')->where('id', $user['id'])->where('bookID', $bookID)->exists()))) {
            DB::table('finishedBooks')->insert([
                [
                    'id' => $user['id'],
                    'bookiD' => $bookID,
                    'date' => $today,
                    'reviewID' => null,
                    'delete' => null
                    
                ],
            ]);
            if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
                $bookDataGet = BookController::booksearchId($bookID);
                //dd($bookDataGet);
                $setISBN = BookController::setISBN($bookDataGet);
                if ($setISBN == "不明") {
                    $setISBN = "0";
                }

                DB::table('books')->insert([
                    'bookID' => $bookID,
                    'book' => $bookDataGet->volumeInfo->title,
                    'author' => BookController::setAuthor($bookDataGet),
                    'ISBN' => $setISBN,
                    'categories' => BookController::setCategories($bookDataGet),
                ]);
            }

            $flashMessage = "リストに追加しました！";
        } else {
            $flashMessage = "この本は既に読んだ本リストに追加されています";
        }
        //ここからBookrepostsと同じ
        $params  = array();
        if ($searchType == "title") {
            $params += array('intitle' => $searchWords);
        } else if ($searchType == "author") {
            $params += array('inauthor' => $searchWords);
        }

        $baseURL = 'https://www.googleapis.com/books/v1/volumes?&q=';
        $foreachCount = 0;
        $searchURL = "";

        foreach ($params as $key => $value) {
            if ($foreachCount == 0) {
                $searchURL = $baseURL . $key . ':' . $value;
            } else {
                $searchURL .= '+' . $key . ':' . $value;
            }
            $foreachCount++;
        }
        // dd($searchURL);
        $url = $searchURL . '&maxResults=20' . '&startIndex=' . $count;
        $searchGet = file_get_contents($url);
        // echo $url;
        $searchDatas = json_decode($searchGet);
        if ($searchDatas->totalItems != 0) {
            $bookDatasGet = $searchDatas->items;
            $bookTotal = $searchDatas->totalItems;

            $x = 0;
            $bookDatas = array();
            $bookcount = 0;
            
            //$count++;
            foreach ($bookDatasGet as $bookDataSet) {

                $bookData['bookID'] = $bookDataSet->id;

                $bookData['thumbnail'] = BookController::setThumbnail($bookDataSet->id);

                $bookData['isbn13'] = BookController::setISBN($bookDataSet);

                $bookData['title'] = $bookDataSet->volumeInfo->title;

                //作者名がなければ不明で登録
                $bookData['author'] = BookController::setAuthor($bookDataSet);

                //カテゴリ
                $bookData['categories'] = BookController::setCategories($bookDataSet);

                //詳細
                $bookData['description'] = BookController::setDescription($bookDataSet);

                //感想があるか検索
                $bookReportsExsists = bookReport::where('bookID', $bookData['bookID'])->exists();
                $bookData['exsists'] = $bookReportsExsists;

                $bookDatas[$x] = $bookData;
                $x++;
            }
        }

        return view('searchBox', compact('count', 'pageCount', 'bookDatas', 'searchType', 'searchWords', 'bookTotal', 'flashMessage'));

    }


    public static function booksearchId($bookID)
    {
        $baseURL = 'https://www.googleapis.com/books/v1/volumes';

        // $searchwords = 'isbn:' . $bookID;
        $URL = urldecode("$baseURL/$bookID");
        $searchGet = file_get_contents($URL);
        // echo $URL;
        $searchDatas = json_decode($searchGet);
        return $searchDatas;
    }

    //値をセットするfunction

    public static function setAuthor($bookData)
    {
        $authors = "";
        if (!(property_exists($bookData->volumeInfo, 'authors'))) {
            $authors = "不明";
        } else {
            if (count($bookData->volumeInfo->authors) != 1) {
                $countAuthor = 0;
                foreach ($bookData->volumeInfo->authors as $author) {
                    if ($countAuthor == 0) {
                        $authors = $author;
                    } else {
                        $authors = $authors . "," . $author;
                    }
                    $countAuthor++;
                }
            } else {
                $authors = $bookData->volumeInfo->authors[0];
            }
        }
        return $authors;
    }

    public static function setCategories($bookData)
    {
        if (!(property_exists($bookData->volumeInfo, 'categories'))) {
            $categories = "不明";
        } else {
            if (count($bookData->volumeInfo->categories) != 1) {
                $countCategories = 0;
                foreach ($bookData->volumeInfo->categories as $categories) {

                    if ($countCategories == 0) {
                        $categories = $categories;
                    } else {
                        $categories .= "," . $categories;
                    }
                }
            } else {
                $categories = $bookData->volumeInfo->categories[0];
            }
        }

        return $categories;
    }

    public static function setISBN($bookData)
    {
        if (property_exists($bookData->volumeInfo, 'industryIdentifiers')) {

            if (count($bookData->volumeInfo->industryIdentifiers) == 2) {
                foreach ($bookData->volumeInfo->industryIdentifiers as $isbn) {
                    if ($isbn->type == "ISBN_13") {
                        $ISBN = $isbn->identifier;
                    }
                }
            } else {
                $ISBN = "不明";
            }
        } else {
            $ISBN = "不明";
        }
        return $ISBN;
    }

    public static function setDescription($bookData)
    {
        if (!(property_exists($bookData->volumeInfo, 'description'))) {
            $description = "不明";
        } else {
            $description = $bookData->volumeInfo->description;
        }
        return $description;
    }

    public static function setThumbnail($bookID)
    {
        $frontUrl = 'http://books.google.com/books/content?id=';
        $backUrl =  '&printsec=frontcover&img=1&zoom=1&source=gbs_api';
        $thumbnailUrl = $frontUrl . $bookID . $backUrl;
        return $thumbnailUrl;
    }
}
