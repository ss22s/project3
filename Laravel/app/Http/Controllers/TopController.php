<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\bookReport;
use App\Models\member;


class TopController extends Controller
{
    //
    public function ranking(Request $request){
        //rankingの本
        //DBの感想created_atが二週間以内のものを検索(whereBetween)
        //bookIDをカウントcount,多い順に並び替え(配列)
        //take,limitで上から決まった件数(7)のみviewへ

        //今はデータを直接入れている
        $rankingDatas[0]['book'] ="となりのトトロ";
        $rankingDatas[0]['auther'] ="スタジオジブリ";
        $rankingDatas[0]['genre'] ="児童書";

        $rankingDatas[1]['book'] ="カラフル";
        $rankingDatas[1]['auther'] ="森絵都";
        $rankingDatas[1]['genre'] ="児童書";

        $rankingDatas[2]['book'] ="ハリーポッターと賢者の石";
        $rankingDatas[2]['auther'] ="J・K・ローリング";
        $rankingDatas[2]['genre'] ="児童書";
        
        return view('TOP/ranking',compact('rankingDatas'));
    }

    public function newBookReport(Request $request){
        //openが公開になっている、日付が新しいもの(latest,or,idの大きい順)を検索
        $bookReportDatas = bookReport::where('Open',1)->latest()->get();

        foreach ($bookReportDatas as $bookReportData) {
            $newBookReportData['reviewID'] = $bookReportData['reviewID'];
            //user関連
            $newBookReportData['userID'] = $bookReportData['userID'];
            $newBookReportData["userName"] = member::where('UserID',$bookReportData['UserID'])->value('name');
            //book関連
            $newBookReportData['bookID'] = $bookReportData['bookID'];
            $newBookReportData["book"] = "となりのトトロ";
            //感想関連
            $newBookReportData["evaluation"] = $bookReportData["evaluation"];
            $newBookReportData["selectedComment"] = $bookReportData["selectedComment"];
            $newBookReportData["comment"] = $bookReportData["comment"];
            $day = explode(" ", $bookReportData['created_at']);
            $newBookReportData["created_at"] = $day[0];
        }
 
        return view('TOP/newBookReport',compact('newBookReportData'));
    }

    public function chatRoom(Request $request){
        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request){
        return view('TOP/contactUS');
    }

    
}
