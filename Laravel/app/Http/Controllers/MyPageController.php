<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\myPage;
use App\Models\member;
use App\Models\followList;
use App\Models\wantToBook;

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
        $wantTobookGet = wantToBook::where('userID',1)->where('finished',null)->get();
        dd($wantTobookGet);

        //読んだ本

        return view('MyPage/myPage',compact('myData'));
    }
}
