<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\bookReport;
use App\Models\member;
use App\Models\book;


class TopController extends Controller
{
    //
    public function ranking(Request $request){
        //rankingの本
        //DBの感想created_atが二週間以内のものを検索(whereBetween)
        //bookIDをカウントcount,多い順に並び替え(配列)
        //take,limitで上から決まった件数(7)のみviewへ

        $bookDatas = book::all();
        $x = 0;

        foreach($bookDatas as $bookData){
            $rankingDatas[$x]['bookID'] = $bookData['bookID'];
            $rankingDatas[$x]['book'] = $bookData['book'];
            $rankingDatas[$x]['auther'] = $bookData['auther'];
            $rankingDatas[$x]['genre'] = $bookData['genre'];
            $x++;
        }
        
        
        return view('TOP/ranking',compact('rankingDatas'));
    }

    public function newBookReport(Request $request){
        //openが公開になっている、日付が新しいもの(latest,or,idの大きい順)を検索
        $bookReportDatas = bookReport::where('Open',1)->latest()->get();

        $x = 0;
        foreach ($bookReportDatas as $bookReportData) {
            $newBookReportData[$x]['reviewID'] = $bookReportData['reviewID'];
            //user関連
            $newBookReportData[$x]['userID'] = $bookReportData['userID'];
            $newBookReportData[$x]["userName"] = member::where('UserID',$bookReportData['UserID'])->value('name');
            //book関連
            $newBookReportData[$x]['bookID'] = $bookReportData['bookID'];
            $newBookReportData[$x]["book"] = book::where('bookID',$newBookReportData[$x]['bookID'])->value('book');
            //感想関連
            $newBookReportData[$x]["evaluation"] = $bookReportData["evaluation"];
            $newBookReportData[$x]["selectedComment"] = $bookReportData["selectedComment"];
            $newBookReportData[$x]["comment"] = $bookReportData["comment"];
            $day = explode(" ", $bookReportData['created_at']);
            $newBookReportData[$x]["created_at"] = $day[0];

            $x++;
        }
        dd($newBookReportData);
 
        return view('TOP/newBookReport',compact('newBookReportData'));
    }

    public function chatRoom(Request $request){
        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request){
        return view('TOP/contactUS');
    }

    public function confirm(Request $request){
        //名前
        $name = $request->input('name');
        //メールアドレス
        $email = $request->input('email');
        //種類
        $item = $request->input('item');
        //内容
        $content = $request->input('content');

        return view('TOP/confirm',compact('name','email','item','content'));
    }

    
}
