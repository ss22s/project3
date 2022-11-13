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
        session(['select' => 'search']);
        return view('TOP/searchBooks', compact('count'));
    }
    public function search(Request $request)
    {
        //TODO27:次へ、をしてページ数増えてる時に新しい検索をしたときの対処方法 if文で分岐　検索を押されるたびにcountを0にする
        $count = $request->input('count');

        if (isset($_POST['search'])) {
            
            $count = 0;
        }
        //TODO27:countに対して　次へのボタン押されたとき+10,前へは-10するif文

        $searchWordGet = $request->input('searchWord');
        $searchwords = preg_split("( |　)", $searchWordGet);

        $baseURL = 'https://www.googleapis.com/books/v1/volumes?projection=lite&q';

        if (count($searchwords) == 1) {
            $searchURL = urldecode("$baseURL=$searchWordGet");
        } else {
            $isFirst = true;
            $wordsSet = "";
            foreach ($searchwords as $searchword) {
                if ($isFirst) {
                    $wordsSet =  $searchword;
                    $isFirst = false;
                } else {
                    $wordsSet .= "+" .   $searchword;
                }
            }
        }
        $searchURL = urldecode("$baseURL=$searchWordGet");

        $searchGet = file_get_contents($searchURL);

        //TODO27:backに変数持たせるのと、本が決まったらsession pageを消す 検索結果出すとこ書く
       $count++;

       session(['page' => 'true']);
        //return back()->with(compact('count','ok'));
        return view('TOP/searchBooks',compact('count'));
    }
    public function selectFromwantToBooks(Request $request){
        $count = 0;
        session(['select' => 'wantToBooks']);
        return view('TOP/searchBooks',compact('count'));
    }


    //
    public function write(request $request)
    {
        $request->session()->forget('page');
        return view('bookReportWrite');
    }

    //'reviewID' => 7以降,'UserID'、'bookID'、'evaluation'、'selectedComment'、'comment'、'Open'、'created_at'
    public function register(Request $request)
    {
        //渡すメッセージ
        $message = "";

        $reportDatasGet = $request->only('book', 'finishedDate', 'evaluation',  'comment', 'open');
        $bookID = Book::where('book', $reportDatasGet['book'])->value('bookID');
        //selectedComment
        $selectedCommentGet = $request->input('selectedComment');
        $selectedComment = implode(',', $selectedCommentGet);

        $reportDatasGet = $request->only('book', 'finishedDate', 'evaluation', 'selectedComment', 'comment', 'open');
        $bookID = Book::where('book', $reportDatasGet['book'])->value('bookID');

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
