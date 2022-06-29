<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class DemoController extends Controller
{	
  public function demoHls() {
    return view('demo.demo_hls');
  }

  public function displayHome() {
    return view('home_kms');
  }

  public function listCam() {
    return view('camera.camera_list');
  }

  public function addCam() {
    return view('camera.camera_add');
  }

  public function listStream() {
    return view('stream.stream_list');
  }

  public function addStream() {
    return view('stream.stream_add');
  }

  public function login() {
    return view('account.login');
  }

  public function register() {
    return view('account.register');
  }

  public function changePwd() {
    return view('account.change_pwd');
  }

  public function listAcc() {
    return view('account.account_list');
  }
}