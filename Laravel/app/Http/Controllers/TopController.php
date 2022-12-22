<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

use App\Models\bookReport;
use App\Models\member;
use App\Models\book;

use App\Models\Mypage;
use App\Models\wantBook;
use App\Models\finishedBook;
use App\Models\followList;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactUsMail;

use app;

class TopController extends Controller
{
    //


    public function ranking(Request $request)
    {
        $x = 0;
        //rankingの本
        //DBの感想created_atが二週間以内のものを検索(whereBetween)
        $bookDatasGet = BookReport::selectRaw('bookID')->GroupBy('bookID')->limit(7)->get();
        //bookIDをカウントcoD,多い順に並び替え(配列)
        //take,limitで上から決まった件数(7)のみviewへ
        $this->setZero($x);
        foreach ($bookDatasGet as $bookDatas) {
            $rankingDataSet['bookID'] = $bookDatas['bookID'];
            $bookDataSet = book::where('bookID', $bookDatas['bookID'])->first();
            $rankingDataSet['book'] = $bookDataSet['book'];
            $rankingDataSet['author'] = $bookDataSet['author'];
            $rankingDataSet['categories'] = $bookDataSet['categories'];
            $rankingDataSet['thumbnail'] = $this->setThumbnail($bookDatas['bookID']);
            $rankingDataSet['count'] = bookReport::where('bookID', $bookDatas['bookID'])->count();

            $rankingDatas[$x] = $rankingDataSet;
            $x++;
        }


        return view('TOP/ranking', compact('rankingDatas'));
    }

    public function newBookReport(Request $request)
    {
        //openが公開(null)になっている、日付が新しいもの(latest,or,idの大きい順)を検索
        $bookReportDatas = bookReport::where('Open', null)->latest()->take(6)->get();
        $x = 0;

        foreach ($bookReportDatas as $bookReportData) {
            $newBookReportData['reviewID'] = $bookReportData['reviewID'];
            //user関連
            $newBookReportData['userID'] = $bookReportData['id'];
            $newBookReportData["userName"] = member::where('id', $bookReportData['id'])->value('name');
            //book関連
            $newBookReportData['bookID'] = $bookReportData['bookID'];
            $newBookReportData["book"] = book::where('bookID', $newBookReportData['bookID'])->value('book');
            $newBookReportData['thumbnail'] = $this->setThumbnail($bookReportData['bookID']);
            //感想関連
            $newBookReportData["evaluation"] = $bookReportData["evaluation"];
            $newBookReportData["selectedComment"] = $bookReportData["selectedComment"];
            $newBookReportData["comment"] = $bookReportData["comment"];
            $day = explode(" ", $bookReportData['created_at']);
            $newBookReportData["created_at"] = $day[0];

            $newBookReportDatas[$x] = $newBookReportData;
            $x++;
        }

        return view('TOP/newBookReport', compact('newBookReportDatas'));
    }

    public function chatRoom()
    {

        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request)
    {
        return view('TOP/contactUS');
    }

    public function faq(Request $request)
    {
        return view('TOP/faq/faq');
    }

    public function confirm(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $item = $request->input('item');
        $content = $request->input('content');

        return view('TOP/confirm', compact('name', 'email', 'item', 'content'));
    }

    public function complete(Request $request)
    {
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
        Mail::to($to)->send(new SendContactUsMail($name, $email, $item, $content));



        return view('TOP/complete', compact('name', 'email', 'item', 'content'));
    }
    //st002023@m01.kyoto-kcg.ac.jp


    public function bookReportsList(Request $request)
    {
        $searchType = $request->input('searchType');
        $searchWords = $request->input('searchWords');

        if ($searchType == "title") {
            $bookDatasGet = book::where('book', 'LIKE', '%' . $searchWords . '%')->get();
        } else if ($searchType == "author") {
            $bookDatasGet = book::where('author', 'LIKE', '%' . $searchWords . '%')->get();
        }
        $x = 0;
        foreach ($bookDatasGet as $bookDataSet) {
            //本の情報
            $bookData['bookid'] = $bookDataSet['bookID'];
            $bookData['title'] = $bookDataSet['book'];
            $bookData['author'] = $bookDataSet['author'];
            $bookData['thumbnail'] = $this->setThumbnail($bookDataSet['bookID']);

            //感想
            $bookReportDataGet = bookReport::where('bookID', $bookDataSet['bookID'])->where('Open', null)->first();
            $y = 0;
            //dd($bookReportDataGet);
            // foreach($bookReportDataGet as $bookReportDataSet){

            $bookData['userid'] = member::where('id', $bookReportDataGet['id'])->value('name');
            $day = explode(' ', $bookReportDataGet['created_at']);
            $bookData['created_at'] = $day[0];
            $bookData['evaluation'] = $bookReportDataGet['evaluation'];

            $selectedCommentsExplode = explode(',', $bookReportDataGet['selectedComment']);
            $commentVar = 0;
            foreach ($selectedCommentsExplode as $selectedComment) {
                $bookData['selectedComment'][$commentVar] = BookController::commentAdd($selectedComment);
                $commentVar++;
            }
            $y++;
            // }
            $bookDatas[$x] = $bookData;
            $x++;
        }
        //dd($bookDatas);

        return view('/TOP/searchResult', compact('bookDatas', 'searchType', 'searchWords'));
    }


    public function userPage($userID)
    {

        $myData = Auth::user();

        if ($myData == null || $myData['id'] != $userID) {
            //userのページ表示
            $userData = Mypage::where('id', $userID)->first();
            $userData['name'] = member::where('id', $userID)->value('name');
            $userData['id'] = $userID;

            //読みたい本リスト
            if (DB::table('MyPages')->where('id', $userID)->where('showWantToBook', null)->exists()) {
                if (DB::table('wantToBooks')->where('id', $userID)->where('finished', null)->exists()) {
                    $wantToBookDatasGet = wantBook::where('id', $userID)->where('finished', null)->orderBy('registered_at', 'desc')->take(3)->get();
                    $x = 0;
                    foreach ($wantToBookDatasGet as $wantToBookDataGet) {
                        $userWantToBookdatas[$x]['bookID'] = $wantToBookDataGet['bookID'];
                        $userWantToBookdatas[$x]['book'] = book::where('bookID', $wantToBookDataGet['bookID'])->value('book');
                        $x++;
                    }
                } else {
                    $userWantToBookdatas = "";
                }
            } else if (DB::table('MyPages')->where('id', $userID)->where('showWantToBook', null)->exists()) {
                $userWantToBookdatas = "非公開";
            } else {
                $userWantToBookdatas = "";
            }

            //読んだ本リスト
            if (DB::table('MyPages')->where('id', $userID)->where('showFinishedBook', null)->exists()) {
                if (DB::table('finishedBooks')->where('id', $userID)->exists()) {
                    $finishedBookDatasGet = finishedBook::where('id', $userID)->orderBy('date', 'desc')->take(3)->get();
                    $x = 0;
                    foreach ($finishedBookDatasGet as $finishedBookDataGet) {
                        $userFinishedBookdata['bookID'] = $finishedBookDataGet['bookID'];
                        $userFinishedBookdata['book'] = book::where('bookID', $finishedBookDataGet['bookID'])->value('book');
                        //日付関連
                        $finishDateGet = explode(" ", $finishedBookDataGet['date']);
                        $finishDate = explode("-", $finishDateGet[0]);

                        $userFinishedBookdata['finishDate'] = $finishDate[0] . "年" .  $finishDate[1] . "月" .  $finishDate[2] . "日";
                        $userFinishedBookdata['reviewID'] = $finishedBookDataGet['reviewID'];

                        $userFinishedBookdatas[$x] = $userFinishedBookdata;
                        $x++;
                    }
                } else {
                    $userFinishedBookdatas = "";
                }
            } else if (DB::table('MyPages')->where('id', $userID)->where('showFinishedBook', null)->exists()) {
                $userFinishedBookdatas = "非公開";
            } else {
                $userWantToBookdatas = "";
            }

            //フォローリスト
            if (DB::table('MyPages')->where('id', $userID)->where('showFollowList', null)->exists()) {
                if (DB::table('followLists')->where('id', $userID)->exists()) {
                    $followListGet = followList::where('id', $userID)->get();
                    $x = 0;
                    foreach ($followListGet as $followListSet) {
                        $userFollowListSet['followerID'] = $followListSet['followerID'];
                        $userFollowListSet['followerName'] = member::where('id', $userFollowListSet['followerID'])->value('name');

                        $userFollowLists[$x] = $userFollowListSet;
                        $x++;
                    }
                } else {
                    $userFollowLists = "";
                }
            } else {
                $userFollowLists = "非公開";
            
            }
            //書いた感想
            if (DB::table('bookReports')->where('id', $userID)->where('Open', null)->exists()) {
                $bookReportGet = DB::table('bookReports')->where('id', $userID)->where('Open', null)->latest()->take(5)->get();
                $x = 0;
                foreach ($bookReportGet as $bookReportset) {
                    $userBookReportdata['reviewID'] = $bookReportset->reviewID;

                    //book関連
                    $userBookReportdata['bookID'] = $bookReportset->bookID;
                    $userBookReportdata["book"] = book::where('bookID', $userBookReportdata['bookID'])->value('book');
                    $userBookReportdata['thumbnail'] = $this->setThumbnail($bookReportset->bookID);
                    //感想関連
                    $userBookReportdata["evaluation"] = $bookReportset->evaluation;
                    $userBookReportdata["selectedComment"] = $bookReportset->selectedComment;
                    $userBookReportdata["comment"] = $bookReportset->comment;
                    $day = explode(" ", $bookReportset->created_at);
                    $userBookReportdata["created_at"] = $day[0];

                    $userBookReportdatas[$x] = $userBookReportdata;

                    $x++;
                }
            } else {
                $userBookReportdatas = "";
            }

            return view('userPage', compact('userData', 'userWantToBookdatas', 'userFinishedBookdatas', 'userFollowLists', 'userBookReportdatas'));
        } else if ($myData['id'] == $userID) {

            return redirect()->action([MyPageController::class, 'myPage']);
        }
    }

    public function userFollow($userID)
    {
        $flashMessage = "まだ";
        $myData = Auth::user();

        if ((DB::table('followLists')->where('id', $myData['id'])->where('followerID', $userID)->exists())) {
            $flashMessage = "失敗";
        } else {
            DB::table('followLists')->insert([
                [
                    'id' => $myData['id'],
                    'followerID' => $userID
                ],
            ]);
            $flashMessage = "成功";
        }

        return back()->with('FollowMessage', $flashMessage);
    }


    public function setZero($x)
    {
        return $x = 0;
    }

    public function setThumbnail($bookID)
    {
        $frontUrl = 'http://books.google.com/books/content?id=';
        $backUrl =  '&printsec=frontcover&img=1&zoom=1&source=gbs_api';
        $thumbnailUrl = $frontUrl . $bookID . $backUrl;
        return $thumbnailUrl;
    }

    public function setThumbnailSmall($bookID)
    {
        $frontUrl = 'http://books.google.com/books/content?id=';
        $backUrl =  '&printsec=frontcover&img=1&zoom=5&source=gbs_api';
        $thumbnailUrl = $frontUrl . $bookID . $backUrl;
        return $thumbnailUrl;
    }
}
