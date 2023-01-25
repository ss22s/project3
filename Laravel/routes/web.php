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
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//top関連

Route::get('/chatRoom', 'App\Http\Controllers\TopController@chatroom');

Route::get('/contactUs', 'App\Http\Controllers\TopController@contactUS');

ROute::get('/newBookReport', 'App\Http\Controllers\TopController@newBookReport');

Route::get('/ranking', 'App\Http\Controllers\TopController@ranking');

Route::get('/topMain', 'App\Http\Controllers\TopController@topMain');

Route::post('/bookReportsList', 'App\Http\Controllers\TopController@bookReportsList');





//お問い合わせ
Route::get('/contactUs', 'App\Http\Controllers\TopController@contactUS');
Route::post('/confirm', 'App\Http\Controllers\TopController@confirm');
Route::post('/complete', 'App\Http\Controllers\TopController@complete');

//よくあるご質問
Route::get('/faq', 'App\Http\Controllers\TopController@faq');

//マイページ関連
Route::get('/myPage', 'App\Http\Controllers\MyPageController@myPage')->middleware('auth');
//ユーザ情報変更
Route::get('/userInfo', 'App\Http\Controllers\MypageController@userInfoChange')->middleware('auth');
//読みたい本リストページ
Route::get('/wantToBooks', 'App\Http\Controllers\MypageController@wantToBooks')->middleware('auth');
//読んだ本リストページ
Route::get('/finishedBooks','App\Http\Controllers\MyPageController@finishedBooks')->middleware('auth');
//読んだ本リスト編集
Route::get('/bookReportEdit/{reviewID}','App\Http\Controllers\MypageController@edit')
    ->name('bookReport.edit');
//感想編集
Route::post('/reportEdit','App\Http\Controllers\ListController@reportedit');
//listページ関連
Route::get('/listDelete/{bookID}','App\Http\Controllers\ListController@delete')
    ->name('list.delete');

//user
Route::get('/user/{userID}', 'App\Http\Controllers\TopController@userPage')
    ->name('user');
Route::get('/follow/{userID}', 'App\Http\Controllers\TopController@userFollow')
    ->name('user.follow')->middleware('auth');

//book関連
//感想を書く
Route::get('/selectBooks', 'App\Http\Controllers\BookController@searchPageGet')->middleware('auth');
Route::post('/selectBooks', 'App\Http\Controllers\BookController@searchPageGet')->middleware('auth');

Route::post('searchBooks', 'App\Http\Controllers\BookController@search');

Route::post('selectFromsearch', 'App\Http\Controllers\BookController@selectFromsearch');
Route::post('selectFromwantToBooks', 'App\Http\Controllers\BookController@selectFromwantToBooks');
Route::post('selectFromfinishedBooks', 'App\Http\Controllers\BookController@selectFromfinishedBooks');

Route::post('before', 'App\Http\Controllers\BookController@beforeBookSearch');
Route::post('next', 'App\Http\Controllers\BookController@nextBookSearch');

Route::post('/write', 'App\Http\Controllers\BookController@write')->middleware('auth');;;

Route::post('/reportRegister', 'App\Http\Controllers\BookController@register');
//読みたい本リストに追加
Route::get('/wantBook/{bookID}', 'App\Http\Controllers\BookController@wantBookAdd')
    ->name('book.wantBookAdd')->middleware('auth');
Route::post('/wantBookAddTo','App\Http\Controllers\BookController@wantBookAddTo')
    ->name('/bookReportList')->middleware('auth');

//本の詳細ページ
Route::get('/detail/{bookID}', 'App\Http\Controllers\BookController@detail')
    ->name('book.detail');

//マイページ編集
Route::post('/changeName', 'App\Http\Controllers\MyPageController@changeName');

Route::get('/delete/{bookID}','App\Http\Controllers\ListController@delete')
    ->name('book.delete');

//退会処理
Route::get('/userExit', function () {
    return view('MyPage/userExit');
});


Route::post('/userExit', 'App\Http\Controllers\MyPageController@userExit');

Route::get('/searchBox', 'App\Http\Controllers\TopController@searchBox');

Route::post('beforeSearchBox', 'App\Http\Controllers\TopController@beforeSearchBox');
Route::post('nextSearchBox', 'App\Http\Controllers\TopController@nextSearchBox');

Route::get('/MenuBar', function () {
    return view('MenuBar');
});
