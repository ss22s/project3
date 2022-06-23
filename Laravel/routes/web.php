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

//お問い合わせ
Route::get('/contactUs','App\Http\Controllers\TopController@contactUS');
Route::post('/confirm','App\Http\COntrollers\TopController@confirm');