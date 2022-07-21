<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\myPage;
use App\Models\member;
use App\Models\finishedBook;
use App\Models\wantBook;
use App\Models\book;
use App\Models\followList;

class MyPageController extends Controller
{
    //
    public function myPage(Request $request){
        //ログイン済みデータ取得
        $user = Auth::user();
        if(Auth::user() == null){
            return view('MyPage/myPage');
        }

        $myPageDataGet = myPage::where('id',$user['id'])->first();
        $userDataGet = member::where('id',$user['id'])->first();

        //userデータ
        $myData['userID'] = $myPageDataGet['id'];
        $myData['userName'] = $userDataGet['name'];
        $myData['userEmail'] = $userDataGet['email'];
        //マイページ関連
        $myData['favoriteBook'] = $myPageDataGet['favoriteBook'];
        $myData['favoriteAuther'] = $myPageDataGet['favoriteAuthor'];
        $myData['freeText'] = $myPageDataGet['freeText'];

        //本関連
        $finishedBookDatasGet = finishedBook::where('id',$user['id'])->get();
        $x = 0;
        foreach($finishedBookDatasGet as $finishedBookDataGet){
            $myFinishedBookdatas[$x]['bookID'] = $finishedBookDataGet['bookID'];
            $myFinishedBookdatas[$x]['book'] = book::where('bookID',$finishedBookDataGet['bookID'])->value('book');
            //日付関連
            $finishDateGet = explode(" ",$finishedBookDataGet['date']);
            $finishDate = explode("-",$finishDateGet[0]);
            
            $myFinishedBookdatas[$x]['finishDate'] = $finishDate[0]. "年" .  $finishDate[1] . "月" .  $finishDate[2] . "日";
            $myFinishedBookdatas[$x]['reviewID'] = $finishedBookDataGet['reviewID'];

            $x++;
        }
        
        $wantToBookDatasGet = wantBook::where('id',$user['id'])->where('finished',null)->get();
        $x = $this->setZero($x);
        foreach($wantToBookDatasGet as $wantToBookDataGet){
            $myWantToBookdatas[$x]['bookID'] = $wantToBookDataGet['bookID'];
            $myWantToBookdatas[$x]['book'] = book::where('bookID',$wantToBookDataGet['bookID'])->value('book');
            
            //日付関連
            $registerDateGet = explode(" ",$wantToBookDataGet['registered_at']);
            $registerDate = explode("-",$registerDateGet[0]);            
            $myWantToBookdatas[$x]['registerDate'] = $registerDate[0]. "年" .  $registerDate[1] . "月" .  $registerDate[2] . "日";

            $x++;
        }
        //followList
        $followListGet = followList::where('id',$user['id'])->get();
        $x = $this->setZero($x);
        foreach ($followListGet as $followListSet) {
            $followLists[$x]['followerID'] = $followListSet['followerID'];
            $followLists[$x]['followerName'] = member::where('id',$followLists[$x]['followerID'])->value('name');

            $x++;
        }

        return view('MyPage/myPage',compact('myData','myFinishedBookdatas','myWantToBookdatas','followLists'));
    }

    public function setZero($x){
        return $x = 0;
    }
}