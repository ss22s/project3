<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function write(){
        return view('bookReportWrite');
    }

    public function register(Request $request){
        $reportDataAllGet = Request::all();
        return view('/');
    }
}
