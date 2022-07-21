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
        //数加算
        $selectedCommentsCount = array_fill(0, 10, 0);
        
        //TODO:本データを外部から取る場合、書き換え
        $bookData = Book::where('bookID', $bookID)->first();
        //TODO:ひとこと感想TOP3.やり方が綺麗でない
        $selectedCommentsGet = bookReport::selectraw('selectedComment')->where('bookID', $bookID)->get();
        foreach ($selectedCommentsGet as $selectedCommentGet) {
            $selectedCommentsExplode = explode(',', $selectedCommentGet['selectedComment']);
            
            foreach ($selectedCommentsExplode as $commentNum) {            
                $selectedCommentsCount[$commentNum]++;
            }
            arsort($selectedCommentsCount);
        }
        $selectedCommentsTOP = array_slice($selectedCommentsCount,0,3);
        $this->commentAdd($selectedCommentsTOP);
        
        return view('TOP/bookDetail',compact('bookData','selectedCommentsTOP'));


    }

    //
    public function write()
    {
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
}