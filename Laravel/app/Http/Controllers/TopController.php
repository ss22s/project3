<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\bookReport;
use App\Models\member;
use App\Models\book;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactUsMail;


class TopController extends Controller
{
    //

    
    public function ranking(Request $request){
        $x = 0;
        //rankingの本
        //DBの感想created_atが二週間以内のものを検索(whereBetween)
        $bookDatasGet = BookReport::selectRaw('bookID')->GroupBy('bookID')->limit(7)->get();
        //bookIDをカウントcount,多い順に並び替え(配列)
        //take,limitで上から決まった件数(7)のみviewへ
        
        $this->setZero($x);
        foreach($bookDatasGet as $bookDatas){
            $rankingDatas[$x]['bookID'] = $bookDatas['bookID'];
            $rankingDatas[$x]['book'] = book::where('bookID',$rankingDatas[$x]['bookID'])->value('book');
            $rankingDatas[$x]['auther'] = book::where('bookID',$rankingDatas[$x]['bookID'])->value('auther');
            $rankingDatas[$x]['genre'] = book::where('bookID',$rankingDatas[$x]['bookID'])->value('genre');
            $rankingDatas[$x]['count'] = bookReport::where('bookID',$rankingDatas[$x]['bookID'])->count();
            $x++;
        }

        return view('TOP/ranking',compact('rankingDatas'));
    }

    public function newBookReport(Request $request){
        //openが公開になっている、日付が新しいもの(latest,or,idの大きい順)を検索
        $bookReportDatas = bookReport::where('Open',1)->latest()->take(6)->get();

        $x = 0;
        
        foreach ($bookReportDatas as $bookReportData) {
            $newBookReportData['reviewID'] = $bookReportData['reviewID'];
            //user関連
            $newBookReportData['userID'] = $bookReportData['id'];
            $newBookReportData["userName"] = member::where('id',$bookReportData['id'])->value('name');
            //book関連
            $newBookReportData['bookID'] = $bookReportData['bookID'];
            $newBookReportData["book"] = book::where('bookID', $newBookReportData['bookID'])->value('book');
            //感想関連
            $newBookReportData["evaluation"] = $bookReportData["evaluation"];
            $newBookReportData["selectedComment"] = $bookReportData["selectedComment"];
            $newBookReportData["comment"] = $bookReportData["comment"];
            $day = explode(" ", $bookReportData['created_at']);
            $newBookReportData["created_at"] = $day[0];

            $newBookReportDatas[$x] = $newBookReportData;
            $x++;
        }
        
        return view('TOP/newBookReport',compact('newBookReportDatas'));
    }

    public function chatRoom(Request $request){
        
        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request){
        return view('TOP/contactUS');
    }

    public function faq(Request $request){
        return view('TOP/faq/faq');
    }

    public function confirm(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $item = $request->input('item');
        $content = $request->input('content');

        return view('TOP/confirm',compact('name','email','item','content'));
    }

    public function complete(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $item = $request->input('item');
        $content = $request->input('content');

        // sendMail($name,$email,$item,$content);
        $to = [
            [
                'name' => 'Manager',
                'email' => 'cinnamondonuts02@gmail.com'
            ]
            ];
        Mail::to($to)->send(new SendContactUsMail($name,$email,$item,$content));

        

        return view('TOP/complete',compact('name','email','item','content'));
    }
    //st002023@m01.kyoto-kcg.ac.jp

    public function setZero($x){
        return $x = 0;
    }
    
}
