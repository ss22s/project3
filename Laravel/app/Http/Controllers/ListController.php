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
            //wantBook::where('id',$user['id'])->where('bookID',$bookID)->where('finished',null)->delete();
            wantBook::where('id',$user['id'])->where('bookID',$bookID)->where('finished',null)->update(['finished' => 1]);

        }else if(end($DBdecide) == "finishedBooks"){
            finishedBook::where('id',$user['id'])->where('bookID',$bookID)->update(['finished' => 1]);

        }else{

        }
        return back()->with("message",'');

    }
}
