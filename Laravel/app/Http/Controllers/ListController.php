<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{
    //
    public function delete($bookID){

        $urlGet = url()->previous();
        $DBdecide = explode("/",$urlGet);
        
        if(end($DBdecide) == "wantToBooks"){
            //読みたい本リストのDBを書き換える
        }

    }
}
