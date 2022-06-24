<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use DB;
use App\KmsClient;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\NvrController;
use App\CameraPermission;
use App\Proxy;
use App\Camera;
use App\EdgePermission;
use App\NvrPermission;
use App\Account;
use App\Nvr;
use App\NvrCamera;
use App\Edge;
use \Cache;
use \Response;
use File;
Use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CameraController extends Controller
{
  public function getFileHls($cam_id, $file_name){
    $file_content = Cache::store('redis')->get('hls_camera_'.$cam_id.'_'.$file_name,function() {
        abort(404);
        // return null;
    });
    // return Response::make($file_content)->header('Content-Type', 'm3u8/mp4');
    if (str_contains($file_name, '.ts')) {
      return Response::make($file_content)->header('Content-Type', 'video/MP2T');
    } else {
      return Response::make($file_content)->header('Content-Type', 'application/x-mpegURL');
    }
  }


  public function liveView(){
    $cameras = EdgePermission::cameras()->get();
    foreach($cameras as $camera){
      if(NvrCamera::where('cam_id',$camera->id)->first()){
        $camera->nvr_id = NvrCamera::where('cam_id',$camera->id)->first()->nvr_id;
      }
      else{
        $camera->nvr_id = null;
      }
    }
    $nvrs = NvrPermission::nvrs();
    $edges = EdgePermission::edges();
    $agent = new Agent();
    if($agent->isMobile()){
      $title = 'Live View';
      return view('device.m_live_view', compact('cameras','nvrs','edges','title'));
    }
    return view('device.live_view', compact('cameras','nvrs','edges'));
  }

  public function getStreamList() {
    $server = "localhost";
    $username = "hoangnv";
    $password = "bkcs2022";
    $database = "transcoding";

    $conn = mysqli_connect($server, $username, $password, $database);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connection successfully";

    $sql = "SELECT stream_input_camera FROM streams GROUP BY stream_input_camera";
    $result = mysqli_query($conn, $sql);

    $stream_list = array();
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($stream_list, $row["stream_input_camera"]);
      }
    } else {
      echo "0 results";
    }

    mysqli_close($conn);
    return $stream_list;
  }
}