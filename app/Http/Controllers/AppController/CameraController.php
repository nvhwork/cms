<?php

namespace App\Http\Controllers\AppController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\NvrController;
use App\Camera;
use App\NvrCamera;
use App\Nvr;

class CameraController extends Controller
{
    public function cameraList(){
    $cameras = Camera::whereNull('cam_delete ')->get();
    foreach($cameras as $camera){
      if(NvrCamera::where('cam_id',$camera->id)->first()){
        $camera->nvr_id = NvrCamera::where('cam_id',$camera->id)->first()->nvr_id;
      }
      else{
        $camera->nvr_id = null;
      }
    }
    $nvrs = Nvr::all();
    return response()->json(['cameras'=>$cameras,'nvrs'=>$nvrs]);
  }


  public function removeCamera($serial_number, Request $req){
      foreach($req["cams_id"] as $input){
        // $camera = Camera::where('id', $input)->first();
        // $camera->cam_delete = 1;
        // $camera->save();
        NvrCamera::where('cam_id', $input)->delete();
        Camera::where('id', $input)->delete();
      }
      return "true";
  }
}
