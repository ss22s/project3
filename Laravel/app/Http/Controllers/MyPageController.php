<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\myPage;
use App\Models\member;
use App\Models\book;
use App\Models\followList;
use App\Models\wantToBook;
use App\Models\finishedBook;

class MyPageController extends Controller
{
    //
    public function myPage(Request $request){

        $myPageDataGet = myPage::where('UserID',1)->first();
        $userDataGet = member::where('UserID',1)->first();

        //userデータ
        $myData['userID'] = $myPageDataGet['UserID'];
        $myData['userName'] = $userDataGet['name'];
        $myData['userEmail'] = $userDataGet['email'];
        //マイページ関連
        $myData['favoriteBook'] = $myPageDataGet['favoriteBook'];
        $myData['favoriteAuther'] = $myPageDataGet['favoriteAuthor'];
        $myData['freeText'] = $myPageDataGet['freeText'];
        
        //フォロー関連
        $followListsGet = followList::where('UserID',1)->get();
        $x = 0;
        foreach($followListsGet as $followListGet){
            $myFollowList[$x]['followUserID'] = $followListGet['followerID'];
            $myFollowList[$x]['name'] = member::where('userID',$followListGet['followerID'])->value('name');
            $x++;
        }

        //読みたい本
        $wantToBooksGet = wantToBook::where('userID',1)->where('finished',null)->get();
        
        $x = 0;
        foreach($wantToBooksGet as $wantToBookGet){
            $myWantToBooks[$x]['bookID'] = $wantToBookGet['bookID'];
            $myWantToBooks[$x]['book'] = book::where('bookID',$wantToBookGet['bookID'])->value('book');
            $x++;
        }
        
        //読んだ本

        $finishedBookGet = finishedBook::where('userID',1)->get();
        $x = 0;
        foreach ($finishedBookGet as $finishedBook) {
            $myFinishedBooks[$x]['bookID'] = $finishedBook['bookID'];
            $myFinishedBooks[$x]['book'] = book::where('bookID',$finishedBook['bookID'])->value('book');
            $myFinishedBooks[$x]['reviewID'] = $finishedBook['reviewID'];
        }
        
        return view('MyPage/myPage',compact('myData'));
    }
}
