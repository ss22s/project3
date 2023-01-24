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
        //渡すメッセージ
        $message = "";

        $reportDatasGet = $request->only('bookID', 'finishedDate', 'evaluation',  'comment', 'open');
        $bookID = $reportDatasGet['bookID'];
        //selectedComment
        $selectedCommentGet = $request->input('selectedComment');
        $selectedComment = implode(',', $selectedCommentGet);

        $open = $request->input('Open');
        if ($open != 0) {
            $open = null;
        }
        //created_atの日付
        $today = date("Y-m-d H:i:s");
        //user情報
        $userData = Auth::user();

        //登録：新着感想
        //reviewは自動加算.userはログイン情報sessionからもらう

        DB::table('bookReports')->where('reviewID',$reviewID)->update([
            'id' => $userData['id'],
            'bookID' => $bookID,
            'evaluation' => $reportDatasGet['evaluation'],
            "selectedComment" =>  $selectedComment,
            "comment" => $reportDatasGet['comment'],
            "Open" => $open,
            "created_at" => $today
        ]);


        $reviewIDget = bookReport::where('id', $userData['id'])->where('bookID', $bookID)->value('reviewID');

        if (!(DB::table('finishedBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            //登録：読んだ本
            DB::table('finishedBooks')->insert([
                'id' => $userData['id'],
                'bookID' => $bookID,
                'date' => $reportDatasGet['finishedDate'],
                'reviewID' => $reviewIDget,
            ]);
        }
        if ((DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->exists())) {
            DB::table('wantToBooks')->where('id', $userData['id'])->where('bookID', $bookID)->update([
                'finished' => 1,
            ]);
        }
        //bookテーブルにまだ登録されていなければ登録する
        if (!(DB::table('books')->where('bookID', $bookID)->exists())) {
            $bookDataGet = $this->booksearchId($bookID);
            //dd($bookDataGet);
            $setISBN = $this->setISBN($bookDataGet);
            if ($setISBN == "不明") {
                $setISBN = "0";
            }

            DB::table('books')->insert([
                'bookID' => $bookID,
                'book' => $bookDataGet->volumeInfo->title,
                'author' => $this->setAuthor($bookDataGet),
                'ISBN' => $setISBN,
                'categories' => $this->setCategories($bookDataGet),
            ]);
        }

        //入った場所に返す
        //eturn redirect('home')->with('result', '感想の登録の成功しました！');
        return view('/hello');
    }
}
