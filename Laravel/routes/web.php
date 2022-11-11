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


//Login
Route::get('/login',function(){
    return view('login');
});
Route::get('/register',function(){
    return view('register');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//top関連

Route::get('/chatRoom','App\Http\Controllers\TopController@chatroom');

Route::get('/contactUs','App\Http\Controllers\TopController@contactUS');

ROute::get('/newBookReport','App\Http\Controllers\TopController@newBookReport');

Route::get('/ranking','App\Http\Controllers\TopController@ranking');

Route::get('/topMain','App\Http\Controllers\TopController@topMain');



//お問い合わせ
Route::get('/contactUs','App\Http\Controllers\TopController@contactUS');
Route::post('/confirm','App\Http\Controllers\TopController@confirm');
Route::post('/complete','App\Http\Controllers\TopController@complete');

//よくあるご質問
Route::get('/faq','App\Http\Controllers\TopController@faq');

//マイページ関連
Route::get('/myPage','App\Http\Controllers\MyPageController@myPage')->middleware('auth');
//ユーザ情報変更
Route::get('/userInfo','App\Http\Controllers\MypageController@userInfoChange')->middleware('auth');
//読みたい本リストページ
Route::get('/wantToBooks','App\Http\Controllers\MypageController@wantToBooks')->middleware('auth');
//読んだ本リストページ
Route::get('/finishedBooks','App\Http\Controllers\MyPageController@finishedBooks')->middleware('auth');

//listページ関連
Route::get('/listDelete/{bookID}','App\Http\COntrollers\ListController@delete')
    ->name('list.delete');

//book関連
    //感想を書く
    Route::get('/reportWrite','App\Http\Controllers\BookController@searchPageGet')->middleware('auth');
    Route::post('searchBooks','App\Http\Controllers\BookController@search');
    Route::post('/reportRegister','App\Http\Controllers\BookController@register');

    //読みたい本リストに追加
    Route::get('/wantBook/{bookID}','App\Http\COntrollers\BookController@WantBookAdd')
        ->name('book.wantBookAdd');

//本の詳細ページ
Route::get('/detail/{bookID}','App\Http\Controllers\BookController@detail')
    ->name('book.detail');
