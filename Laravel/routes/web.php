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

Route::get('/chatRoom','App\Http\Controllers\TopController@chatroom');

ROute::get('/newBookReport','App\Http\Controllers\TopController@newBookReport');

Route::get('/ranking','App\Http\Controllers\TopController@ranking');

Route::get('/topMain','App\Http\Controllers\TopController@topMain');

<<<<<<< HEAD
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
=======
//お問い合わせ
Route::get('/contactUs','App\Http\Controllers\TopController@contactUS');
Route::post('/confirm','App\Http\COntrollers\TopController@confirm');

//マイページ関連
Route::get('/myPage','App\Http\Controllers\MyPageController@myPage');
>>>>>>> 2fe359d7f16b671a9c27b53dfa72886cfd0463e4
