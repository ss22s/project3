<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//use App\Models\

class TopController extends Controller
{
    //
    public function ranking(Request $request){
        //rankingの本
        
        return view('TOP/ranking');
    }

    public function newBookReport(Request $request){
        return view('TOP/newBookReport');
    }

    public function chatRoom(Request $request){
        return view('TOP/chatRoom');
    }

    public function contactUs(Request $request){
        return view('TOP/contactUS');
    }

    
}
