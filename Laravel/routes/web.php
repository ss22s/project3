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

//マイページ関連
Route::get('/myPage','App\Http\Controllers\MyPageController@myPage');

//book関連
    //感想を書く
    Route::get('/reportWrite','App\Http\Controllers\BookController@write');
    Route::get('/reportRegister','App\Http\Controllers\BookController@register');

