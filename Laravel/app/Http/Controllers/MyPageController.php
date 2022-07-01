<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\myPage;
use App\Models\member;

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

        return view('MyPage/myPage',compact('myData'));
    }
}