<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Book;

class BookController extends Controller
{
    //
    public function write(){
        return view('bookReportWrite');
    }
    //'reviewID' => 7以降,'UserID'、'bookID'、'evaluation'、'selectedComment'、'comment'、'Open'、'created_at'
    public function register(Request $request){
        $reportDatasGet = $request->only('book','author','finishedDay','evaluation','selectedComment','comment','open');
        
        $bookID = Book::where('book',$reportDatasGet['book'])->value('bookID');

        //登録
        //reviewは自動加算？userはログイン情報sessionからもらう
        DB::table('bookReports')->insert([
            'reviewID' => "",
            'userID' => "",
            'bookID' => $bookID,
            'evaluation' => $reportDatasGet['evaluation'],
            "selectedComment" => $reportDatasGet['selectedComment'],
            "comment" => $reportDatasGet['comment'],
            "Open" => $reportDatasGet['open'],
            'created_at' =>"",
        ]);

        //入った場所に返す
        //eturn redirect('home')->with('result', '感想の登録の成功しました！');
        return back();
    }
}
