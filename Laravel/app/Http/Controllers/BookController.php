<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Book;
use App\Models\bookReport;
use App\Models\finishedBook;

class BookController extends Controller
{
    public function detail(Request $request, int $bookID){
        return view('bookDetail');
    }
    
    //
    public function write(){
        return view('bookReportWrite');
    }

    //'reviewID' => 7以降,'UserID'、'bookID'、'evaluation'、'selectedComment'、'comment'、'Open'、'created_at'
    public function register(Request $request){
        $reportDatasGet = $request->only('book','author','finishedDate','evaluation','selectedComment','comment','open');
        
        $bookID = Book::where('book',$reportDatasGet['book'])->value('bookID');
        

        //登録：新着感想
        //reviewは自動加算.userはログイン情報sessionからもらう
        DB::table('bookReports')->insert([
            'id' => "1",
            'bookID' => $bookID,
            'evaluation' => $reportDatasGet['evaluation'],
            "selectedComment" => $reportDatasGet['selectedComment'],
            "comment" => $reportDatasGet['comment'],
            "Open" => $reportDatasGet['open'],

        ]);

        $reviewIDget = bookReport::where('id',1)->where('bookID',$bookID)->value('reviewID');

        //登録：読んだ本
        DB::table('finishedBook')->insert([
            'id' => 1,
            'bookID' => $bookID,
            'date' => $reportDatasGet['finishedDay'],
            'reviewID' => $reviewIDget,
        ]);

        //入った場所に返す
        //eturn redirect('home')->with('result', '感想の登録の成功しました！');
        return back();
    }
}
