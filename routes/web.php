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

// DEMO //
Route::get('/', 'DemoController@displayHome');
Route::get('/demo-hls', 'DemoController@demoHls');
Route::get('/cameras', 'DemoController@listCam');
Route::get('/cameras/add', 'DemoController@addCam');
Route::get('/streams', 'DemoController@listStream');
Route::get('/streams/add', 'DemoController@addStream');
Route::get('/login', 'DemoController@login');
Route::get('/register', 'DemoController@register');
Route::get('/change-password', 'DemoController@changePwd');
Route::get('/accounts', 'DemoController@listAcc');
