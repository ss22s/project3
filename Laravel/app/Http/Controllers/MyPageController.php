<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

//使用するDB
use App\Models\User;
use App\Models\myPage;
use App\Models\member;
use App\Models\finishedBook;
use App\Models\wantBook;
use App\Models\book;
use App\Models\bookReport;
use App\Models\followList;

class MyPageController extends Controller
{

    public function setZero($x)
    {
        return $x = 0;
    }

    //マイページ表示

    public function myPage(Request $request)
    {
        //ログイン済みデータ取得
        $user = Auth::user();
        if (Auth::user() == null) {
            return view('MyPage/myPage');
        }

        $myPageDataGet = myPage::where('id', $user['id'])->first();
        $userDataGet = member::where('id', $user['id'])->first();

        //userデータ
        $myData['userID'] = $myPageDataGet['id'];
        $myData['userName'] = $userDataGet['name'];
        $myData['userEmail'] = $userDataGet['email'];
        //マイページ関連
        $myData['favoriteBook'] = $myPageDataGet['favoriteBook'];
        $myData['favoriteAuther'] = $myPageDataGet['favoriteAuthor'];
        $myData['freeText'] = $myPageDataGet['freeText'];


        //変数置く
        $x = 0;

        //本関連
        //読んだ本リスト
        if (DB::table('finishedBooks')->where('id', $user['id'])->exists()) {
            $finishedBookDatasGet = finishedBook::where('id', $user['id'])->orderBy('date', 'desc')->take(3)->get();
            $x = $this->setZero($x);
            foreach ($finishedBookDatasGet as $finishedBookDataGet) {
                $myFinishedBookdatas[$x]['bookID'] = $finishedBookDataGet['bookID'];
                $myFinishedBookdatas[$x]['book'] = book::where('bookID', $finishedBookDataGet['bookID'])->value('book');
                //日付関連
                $finishDateGet = explode(" ", $finishedBookDataGet['date']);
                $finishDate = explode("-", $finishDateGet[0]);

                $myFinishedBookdatas[$x]['finishDate'] = $finishDate[0] . "年" .  $finishDate[1] . "月" .  $finishDate[2] . "日";
                $myFinishedBookdatas[$x]['reviewID'] = $finishedBookDataGet['reviewID'];

                $x++;
            }
        } else {
            $myFinishedBookdatas = "";
        }

        //読みたい本リスト
        if (DB::table('wantToBooks')->where('id', $user['id'])->where('finished', null)->exists()) {
            $wantToBookDatasGet = wantBook::where('id', $user['id'])->where('finished', null)->orderBy('registered_at', 'desc')->take(3)->get();
            $x = $this->setZero($x);
            foreach ($wantToBookDatasGet as $wantToBookDataGet) {
                $myWantToBookdatas[$x]['bookID'] = $wantToBookDataGet['bookID'];
                $myWantToBookdatas[$x]['book'] = book::where('bookID', $wantToBookDataGet['bookID'])->value('book');

                //日付関連
                $registerDateGet = explode(" ", $wantToBookDataGet['registered_at']);
                $registerDate = explode("-", $registerDateGet[0]);
                $myWantToBookdatas[$x]['registerDate'] = $registerDate[0] . "年" .  $registerDate[1] . "月" .  $registerDate[2] . "日";

                $x++;
            }
        } else {
            $myWantToBookdatas = "";
        }

        //followList
        if (DB::table('followLists')->where('id', $user['id'])->exists()) {
            $followListGet = followList::where('id', $user['id'])->get();
            $x = $this->setZero($x);
            foreach ($followListGet as $followListSet) {
                $followLists[$x]['followerID'] = $followListSet['followerID'];
                $followLists[$x]['followerName'] = member::where('id', $followLists[$x]['followerID'])->value('name');

                $x++;
            }
        } else {
            $followLists = "";
        }

        return view('MyPage/myPage', compact('myData', 'myFinishedBookdatas', 'myWantToBookdatas', 'followLists'));
    }


    //ユーザ情報編集ページ
    public function userInfoChange(Request $request){
        
        //ログイン済みデータ取得
        $user = Auth::user();
        
        $userDataGet = User::where('id',$user['id'])->first();

        $userData['id'] = $userDataGet['id'];
        $userData['name'] = $userDataGet['name'];
        $userData['email'] = $userDataGet['email'];

        //本に関するデータ
        $userBookDataGet = MyPage::where('id',$user['id'])->first();

        $userData['favoriteBook'] = $userBookDataGet['favoriteBook'];
        $userData['favoriteAuthor'] = $userBookDataGet['favoriteAuthor'];
        $userData['freeText'] = $userBookDataGet['freeText'];
        

        return view('MyPage/userInfoPage',compact('userData'));
    }

    //読みたい本リストページ表示
    public function wantToBooks(Request $request){

        return view('MyPage/wantToBooksPage');
    }

    //読んだ本リストページ表示
    public function finishedBooks(Request $request)
    {

        //ログイン済みデータ取得
        $user = Auth::user();
        // if (Auth::user() == null) {
        //     return view('MyPage/myPage');
        // }

        //回す分の変数
        $x = 0;

        //読んだ本リスト取得
        $finishedBooksGet = finishedBook::where('id', $user['id'])->get();

        foreach ($finishedBooksGet as $finishedBooksSet) {

            
            $reviewID = $finishedBooksSet['reviewID'];
            $finishedBooks[$x]['reviewID'] = $reviewID;
            //本関連
            $finishedBooks[$x]['bookID'] = $finishedBooksSet['bookID'];
            $finishedBooks[$x]['book'] = book::where('bookID', $finishedBooksSet['bookID'])->value('book');
            $finishedBooks[$x]['auther'] = book::where('bookID', $finishedBooksSet['bookID'])->value('auther');
            $finishedBooks[$x]['genre'] = book::where('bookID', $finishedBooksSet['bookID'])->value('genre');
            //感想関連
            //TODO:感想はまだ書いてなくて読んだ本リストに追加だけした時、Keyを持たせて区別するかreviewのnullで判断するか
            if ($finishedBooksSet['reviewID'] != null) {
                //日付
                $date = explode(" ", bookReport::where('reviewID', $reviewID)->value('created_at'));
                $finishedBooks[$x]['date'] = $date[0];
                //一言コメント(多重配列)
                $commentGet = explode(",", bookReport::where('reviewID', $reviewID)->value('selectedComment'));
                $loopVar = 0;
                foreach ($commentGet as $commentSet) {
                    $finishedBooks[$x]['selectedComment'][$loopVar] = $this->commentAdd($commentSet);
                    $loopVar++;
                }
                //コメント
                $finishedBooks[$x]['comment'] = bookReport::where('reviewID',$reviewID)->value('comment');

                $x++;
            }
        }

        return view('Mypage/finishedBooksPage',compact('finishedBooks'));
    }

    //一言コメント変換
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
}
