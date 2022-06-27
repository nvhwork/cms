<?php

use Illuminate\Http\Request;
use Iman\Streamer\VideoStreamer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('upload-to-cache', 'ApiEdgeController@uploadToCache');

Route::post('add-camera', 'ApiEdgeController@addCamera');

Route::get('/delete-camera/{cam_name}', 'ApiEdgeController@deleteCamera');

Route::get('/notify-camera/{msg}', 'ApiEdgeController@notifyCamera');

Route::post('add-stream', 'ApiEdgeController@addStream');

Route::get('/delete-stream/{stream_id}', 'ApiEdgeController@deleteStream');

Route::get('/notify-stream/{msg}', 'ApiEdgeController@notifyStream');

Route::post('login', 'ApiEdgeController@login');

Route::post('register', 'ApiEdgeController@registerAccount');

Route::get('/get-file-hls/{cam_id}/{file_name}', 'CameraController@getFileHls');

Route::get('get-stream-list', 'CameraController@getStreamList');
