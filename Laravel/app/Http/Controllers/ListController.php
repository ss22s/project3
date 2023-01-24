<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyPageController;

use Auth;
use Illuminate\Http\Request;

use DB;

use App\Models\wantBook;
use App\Models\Book;
use App\Models\finishedBook;

class ListController extends Controller
{
    //
    public function delete($bookID)
    {
        //ユーザデータ取得
        $user = Auth::user();

        //読みたい本リストのDBから削除する
        //wantBook::where('id',$user['id'])->where('bookID',$bookID)->where('finished',null)->delete();
        DB::table('wantToBooks')->where('id', $user['id'])->where('bookID', $bookID)->where('finished', null)->update(['finished' => 1]);


        $key = "削除に成功しました！";
        
        $user = Auth::user();

        //回す分の変数
        $x = 0;

        $wantBookGet = wantBook::where('id', $user['id'])->where('finished', null)->get();

        if ($wantBookGet != null) {
        foreach ($wantBookGet as $wantBookSet) {
            $bookID = $wantBookSet['bookID'];
            $wantBooks[$x]['bookID'] = $bookID;

            $wantBooks[$x] = book::where('bookID', $bookID)->first();
            $wantBooks[$x]['thumbnail'] =  BookController::setThumbnail($bookID);
            $x++;
        }
          return view('MyPage/wantToBooksPage', compact('wantBooks', 'key'));
        } else {
            return redirect()->action([MyPageController::class, 'myPage']);
        }
        // return view('/wantToBooksPage',compact('key'));
    }
    public function reportEdit(request $request){
        //TODO:感想DB編集
        return view('/hello');
    }
}
