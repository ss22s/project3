<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Models\wantBook;
use App\Models\finishedBook;

class ListController extends Controller
{
    //
    public function delete($bookID){
        //ユーザデータ取得
        $user = Auth::user();

        //どこから来たか取得
        $urlGet = url()->previous();
        $DBdecide = explode("/",$urlGet);

        //コメント用のkey
        $key = "";
        
        if(end($DBdecide) == "wantToBooks"){
            //読みたい本リストのDBから削除する
            //TODO:本当に消すか消したことを示すカラムを作ってそこにキーを持たせるか　今は消している
            wantBook::where('id',$user['id'])->where('bookID',$bookID)->where('finished',null)->delete();

        }else if(end($DBdecide) == "finishedBooks"){
            finishedBook::where('id',$user['id'])->where('bookID',$bookID)->delete();

        }else{

        }
        return back()->with("message",'');

    }
}
