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

Route::get('/contactUs','App\Http\Controllers\TopController@contactUS');

ROute::get('/newBookReport','App\Http\Controllers\TopController@newBookReport');

Route::get('/ranking','App\Http\Controllers\TopController@ranking');

Route::get('/topMain','App\Http\Controllers\TopController@topMain');
