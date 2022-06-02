<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('hello');
});

//top関連
Route::get('chatRoom',function(){
    return view('TOP/chatRoom');
});
Route::get('contactUs',function(){
    return view('TOP/contactUs');
});
Route::get('newBookReport',function(){
    return view('TOP/newBookReport');
});
Route::get('ranking',function(){
    return view('TOP/ranking');
});
Route::get('topMain',function(){
    return view('TOP/topMain');
});
