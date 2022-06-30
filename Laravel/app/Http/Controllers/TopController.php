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

        //今はデータを直接入れている
        $rankingDatas[0]['bookID'] = 1001;
        $rankingDatas[0]['book'] ="となりのトトロ";
        $rankingDatas[0]['auther'] ="スタジオジブリ";
        $rankingDatas[0]['genre'] ="児童書";

        $rankingDatas[1]['bookID'] = 1002;
        $rankingDatas[1]['book'] ="カラフル";
        $rankingDatas[1]['auther'] ="森絵都";
        $rankingDatas[1]['genre'] ="児童書";

        $rankingDatas[2]['bookID'] = 1003;
        $rankingDatas[2]['book'] ="ハリーポッターと賢者の石";
        $rankingDatas[2]['auther'] ="J・K・ローリング";
        $rankingDatas[2]['genre'] ="児童書";

        $rankingDatas[3]['bookID'] = 1004;
        $rankingDatas[3]['book'] ="基本情報技術者過去問題集";
        $rankingDatas[3]['auther'] ="技術評論社";
        $rankingDatas[3]['genre'] ="問題集";

        $rankingDatas[4]['bookID'] = 1005;
        $rankingDatas[4]['book'] ="Myojo";
        $rankingDatas[4]['auther'] ="集英社";
        $rankingDatas[4]['genre'] ="雑誌";

        $rankingDatas[5]['bookID'] = 1006;
        $rankingDatas[5]['book'] ="カードキャプターさくら";
        $rankingDatas[5]['auther'] ="CLAMP";
        $rankingDatas[5]['genre'] ="少女漫画";

        $rankingDatas[6]['bookID'] = 1007;
        $rankingDatas[6]['book'] ="わたしの美しい庭";
        $rankingDatas[6]['auther'] ="凪良ゆう";
        $rankingDatas[6]['genre'] ="小説・文芸";

        
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
            $newBookReportData[$x]["book"] = book::where('bookID', $newBookReportData[$x]['bookID'])->value('book');
            //感想関連
            $newBookReportData[$x]["evaluation"] = $bookReportData["evaluation"];
            $newBookReportData[$x]["selectedComment"] = $bookReportData["selectedComment"];
            $newBookReportData[$x]["comment"] = $bookReportData["comment"];
            $day = explode(" ", $bookReportData['created_at']);
            $newBookReportData[$x]["created_at"] = $day[0];

            $x++;
        }
 
        return view('TOP/newBookReport',compact('newBookReportData'));
    }

    public function chatRoom(Request $request){
        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request){
        return view('TOP/contactUS');
    }

    public function confirm(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $item = $request->input('item');
        $content = $request->input('content');

        return view('TOP/confirm',compact('name','email','item','content'));
    }
    
}
