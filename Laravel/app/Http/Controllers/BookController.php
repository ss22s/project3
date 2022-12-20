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
            $selectedCommentsCount['value'] = $x;
            $selectedCommentsCount['comment'] = $this->commentAdd($x);
            $selectedCommentsCount['number'] = "0";

            $selectedCommentsCount[$x] = $selectedCommentsCount;
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

        return view('TOP/bookDetail', compact('bookData', 'bookThumbnail', 'selectedCommentsTop'));
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
        if ($request->input('next') != null) {
            //echo "NEXT";
            $pageCount++;
            $count = ($count + 10);
        }
        if ($request->input('before') != null) {
            // echo "BEFORE";
            $pageCount--;
            $count = ($count - 10);
            if ($count < 0) {
                $count = 0;
            }
        }

        // $searchWordGet = $request->input('searchWord');
        $searchTitleGet = $request->input('searchTitle');
        $searchAuthorGet = $request->input('searchAuthor');
        $searchISBNGet = $request->input('searchISBN');

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
        //dd($param);

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
        if (!($request->input('before') != null)) {
            //?
        }
        //$count++;
        foreach ($bookDatasGet as $bookDataSet) {

            $bookData['id'] = $bookDataSet->id;

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


        // /dd($bookDatas);

        // session(['searchWord' => $searchWordGet]);
        session(['searchTitle' => $searchTitleGet]);
        session(['searchAuthor' => $searchAuthorGet]);
        session(['searchISBN' => $searchISBNGet]);
        session(['page' => 'true']);
        session(['select' => 'search']);

        return view('TOP/searchBooks', compact('count', 'bookDatas', 'pageCount'));
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

                $bookDataGet = book::where('bookID', $bookID)->first();
                // dd($bookDataGet);

                $wantBook['bookID'] = $bookID;
                $wantBook['book'] = $bookDataGet['book'];

                //作者
                $wantBook['author'] = $bookDataGet['author'];

                $wantBook['thumbnail'] = $this->setThumbnail($bookID);

                $wantBooks[$x] = $wantBook;

                // $wantBooks[$x]['genre'] = $bookDataSet['genre'];

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

                // $finishedBooks[$x]['genre'] = $bookDataget['genre'];
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

        DB::table('bookReports')->insert([
            'id' => $userData['id'],
            'bookID' => $bookID,
            'evaluation' => $reportDatasGet['evaluation'],
            "selectedComment" =>  $selectedComment,
            "comment" => $reportDatasGet['comment'],
            "Open" => $open,
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
        //bookテーブルにまだ登録されていなければ登録する
        if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
            $bookDataGet = $this->booksearchId($bookID);
            //dd($bookDataGet);

            DB::table('books')->insert([
                'bookID' => $bookID,
                'book' => $bookDataGet->volumeInfo->title,
                'author' => $this->setAuthor($bookDataGet),
                'ISBN' => $this->setISBN($bookDataGet),
                'categories' => $this->setCategories($bookDataGet),
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
                    'bookiD' => $bookID,
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

    public function booksearchId($bookID)
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

    public function setAuthor($bookData)
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

    public function setCategories($bookData)
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

    public function setISBN($bookData)
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

    public function setDescription($bookData)
    {
        if (!(property_exists($bookData->volumeInfo, 'description'))) {
            $description = "";
        } else {
            $description = $bookData->volumeInfo->description;
        }
        return $description;
    }

    public function setThumbnail($bookID)
    {
        $frontUrl = 'http://books.google.com/books/content?id=';
        $backUrl =  '&printsec=frontcover&img=1&zoom=1&source=gbs_api';
        $thumbnailUrl = $frontUrl . $bookID . $backUrl;
        return $thumbnailUrl;
    }
}
