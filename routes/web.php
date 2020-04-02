<?php

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

Route::get('/', "TestController@index")->name("index");
Route::post('/send_uans', "TestController@send")->name("send");
Route::post('/save_rec', "TestController@saverecord")->name("save");
