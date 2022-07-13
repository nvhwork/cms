@extends('../layouts/index')
@section('content')
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role'])) {
            header("refresh: 0, url=/login");
            exit;
        }
    ?>
  <link rel="stylesheet" href="/js-css/css/checkbox_custom.css">
      <div class="content-camera" style="display: flex;">
        <div class="tree-area">
          <div class="sidenav-area">
            <div style="width: 230px;">
              <div class="area-header">
                <h6 style="float: left;">Areas Management</h6>
              </div>
              <!-- <div class="dropdown more-option">
                <button class="btn-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                <div class="dropdown-menu" aria-labelledby="">
                  <a class="dropdown-item new-area" data-toggle="modal" data-target="#new-camera" area-id="">New Camera</a>
                  <a class="dropdown-item" href="/scan-onvif-device">Scan Onvif</a>
                  <a class="dropdown-item edit-area" href="#" data-toggle="modal" data-target="#edit-area" area-id="" area-name="" description="">Rename</a>
                  <a class="dropdown-item area-remove" area-id="" area-name="">Delete</a>
                </div>
              </div>
              <button class="dropdown-btn item-menu active dropdown-area"><i class="fa fa-sitemap" aria-hidden="true"></i> &nbsp; <span class="option-text">Hành lang 405</span></button>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-DE1</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-DE2</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-DE3</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-DE4</span></a>
              </div>
              <div class="dropdown more-option">
                <button class="btn-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                <div class="dropdown-menu" aria-labelledby="">
                  <a class="dropdown-item new-area" data-toggle="modal" data-target="#new-camera" area-id="">New Camera</a>
                  <a class="dropdown-item" href="/scan-onvif-device">Scan Onvif</a>
                  <a class="dropdown-item edit-area" href="#" data-toggle="modal" data-target="#edit-area" area-id="" area-name="" description="">Rename</a>
                  <a class="dropdown-item area-remove" area-id="" area-name="">Delete</a>
                </div>
              </div>
              <button class="dropdown-btn item-menu active dropdown-area"><i class="fa fa-sitemap" aria-hidden="true"></i> &nbsp; <span class="option-text">Hành lang 405</span></button>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-IC1</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2DE4225W-IC2</span></a>
              </div>

              <div class="dropdown more-option">
                <button class="btn-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                <div class="dropdown-menu" aria-labelledby="">
                  <a class="dropdown-item new-area" data-toggle="modal" data-target="#new-camera" area-id="">New Camera</a>
                  <a class="dropdown-item" href="/scan-onvif-device">Scan Onvif</a>
                  <a class="dropdown-item edit-area" href="#" data-toggle="modal" data-target="#edit-area" area-id="" area-name="" description="">Rename</a>
                  <a class="dropdown-item area-remove" area-id="" area-name="">Delete</a>
                </div>
              </div>
              <button class="dropdown-btn item-menu active dropdown-area"><i class="fa fa-sitemap" aria-hidden="true"></i> &nbsp; <span class="option-text">Hành lang 405</span></button>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2CD2121G0-I0</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2CD2121G0-I1</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2CD2121G0-I2</span></a>
              </div>
              <div class="dropdown-container" style="display: block;">
                <div class="dropdown camera-more-option">
                  <button hidden="" class="btn-more camera-opt-more" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                  <div class="dropdown-menu" aria-labelledby="">
                    <a class="dropdown-item" href="">Alerts</a>
                    <a class="dropdown-item cam-remove" cam-id="" cam-model=''>Delete</a>
                    <a class="dropdown-item" href="">Setting</a>
                  </div>
                </div>
                <a class="item-menu item-chil camera-item" cam-id=""><i id="" class="fa fa-circle active-on cam-status-tree" aria-hidden="true"></i><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="option-text">DS-2CD2121G0-I3</span></a>
              </div> -->
              <div style="padding:10px">
                <!-- <input placeholder="Camera ID" type="text" id="cam-id" class="input-edit modol-text"> -->
                <select id="cam-id" class="form-control white-color">
                  <option disabled selected value> -- Select a camera -- </option>
                    <?php
                      $conn = mysqli_connect("localhost", "hoangnv", "bkcs2022", "transcoding");
                      if (!$conn) {
                          die("Connection failed: " . mysqli_connect_error());
                      }
                      $result = mysqli_query($conn, "SELECT stream_input_camera FROM streams GROUP BY stream_input_camera");
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo '<option class="white-color">'. $row["stream_input_camera"] .'</option>';
                      }
                      mysqli_close($conn);
                    ?>
                </select>
                <button type="button" class="btn btn-model apply" onclick="addLive($('#cam-id').val())">Apply</button>
              </div>
            </div>
          </div>
        </div>
        <div class="camera-viewer">
          <div class="header-content">
              <div class="header-content-left desktop">
                  <!-- <h6>Camera Management</h6> -->
              </div>
              <div class="header-content-right">
                  <a href="/"><h6 class="display-inline link-active"><i class="fa fa-home"></i> Home </h6></a>
                  <!-- /
                  <h6 class="display-inline">Camera Management</h6> -->
              </div>
          </div>
          <div class="session">
              @if(Session::has('notification'))
                <input hidden="" notifi="{{Session::get('notification')}}" value="1" id="notice_success">
              @endif
              @if(Session::has('warning'))
                <input hidden="" notifi="{{Session::get('warning')}}" value="1" id="notice_warning">
              @endif
          </div>
          <div class="row row-content">
            <div class="list-frame-liveview">
              <script src="js-css/js/hls.js"></script>
              <div class="cam-liveview">

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="overlay-dark"></div>
      <img class="img-overlay">
      <div id="snackbar">
        <i class="fa fa-check" style="font-size: 1.5em;"></i>&nbsp;
        <h6 class="display-inline"> notifition</h6>
      </div>
      <div id="snackbar-warning">
        <i class="fa fa-exclamation-triangle" style="font-size: 1.5em;"></i>&nbsp;
        <h6 class="display-inline"> Warning</h6>
      </div>

  <style type="text/css">
    .cam-model {
      color: white;
      position: absolute;
      margin-left: 10px;
      z-index: 1;
      padding: 5px;
    }

    .cam-list {
      width: 200px; 
      margin-right: 25px;
      border-right: 1px solid gray;
    }

    .cam {
      padding: 5px;
      margin: 10px;
      cursor: pointer;
    }

    .cam:hover {
      background-color: rgba(0,0,0,0.08);
    }

    .cam-option {
      width: 320px;
      height: 180px;
      background: rgba(0,0,0,.7);
      color: white;
      position: absolute;
      z-index: 1;
      display: none;
    }

    .option-preview {
      text-align: center;
      width: 30px; 
      height: 30px;
      float: right;
      color: #f5252c;
      cursor: pointer;
      font-size: 20px;
    }

    .option-preview:hover {
      background: rgba(255,255,255,0.2);
    }

    .head-liveview {
      background: #ffffff1c;
      width: 320px;
      height: 30px;
    }

    video::-webkit-media-controls {
      display:none !important;
    }


    .header-content {
      margin-bottom: 0px;
    }

    .camera-more-option .dropdown-menu{
      transform: translate3d(-130px, 0px, 0px)!important;
    }

    /*#device-id,*/ #cam-id {
      margin: 10px 0px;
      background: #1c2023;
    }

    .apply {
      margin: 5px 68px;
    }

    .sidenav:hover {
      width: 50px;
    }


    .sidenav:hover .option-text{
      display: none;
    }
  </style>


  <script>
    function snakeModel(cam_id){
      $("#live"+cam_id).css("border","2px solid rgba(234,186,66,0.7)");
      $("#video"+cam_id).css("width","316px");
      $("#video"+cam_id).css("height","176px");
      setTimeout(function() { 
        $("#live"+cam_id).css("border","0px");
        $("#video"+cam_id).css("width","320px");
        $("#video"+cam_id).css("height","180px");
      }, 2000);
    }
  </script>


  <script type="text/javascript"> -->
    var hlsList = {};

    async function retrieveStreams() {
      const response = await fetch('/api/get-stream-list');

      var data = await response.json();
      return data;
    }

    function closeLiveView(frame_id){
      $("#"+frame_id).remove();
      hlsList[frame_id].destroy();
      delete hlsList[frame_id];
    }

    function fullScreen(frame_id){
      var elem = document.getElementById('video'+frame_id);
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { 
        elem.msRequestFullscreen();
      }
    }

    function refreshScreen(frame_id, cam_id){
      console.log(this);
      var video = document.getElementById('video'+frame_id);
      // var videoSrc = 'get-file-hls/' + cam_id + '/index.m3u8';
      var videoSrc = '/hls/' + cam_id + '/master.m3u8';
      if (Hls.isSupported() && video !== undefined && hlsList[frame_id] !== undefined) {
        console.log(cam_id + ": Start loading");
        // console.log(cam_id + ': ' + video.videoWidth + 'x' + videoHeight);
        hlsList[frame_id].attachMedia(video);
      } else {
        console.log(cam_id + ": Not loading");
      }
    }

    async function addLive(cam_id){
      var data = await retrieveStreams();
      if (!data.includes(cam_id)) {
        alert('ID not available!');
        return;
      }

      var frame_id = Math.random().toString(36).substring(7);
      // if(document.getElementById('live'+cam_id) != null){
      //   snakeModel(cam_id);
      //   notifiWarning("This camera is already displayed");
      // } 
      // else{
        var videoSrc = '/hls/' + cam_id + '/master.m3u8';
        // var videoSrc = '/api/get-file-hls/'+cam_id+'_720/index.m3u8';
        // var videoSrc = '/hls/' + cam_id + '/1024x576/index.m3u8';
        var html =  '<div class="live-view" id="'+frame_id+'">'+
                      '<img class="loading-icon" src="js-css/img/loading2.gif">'+
                      '<div class="cam-option">'+
                        '<div class="bg-frame">'+
                          '<div class="head-liveview">'+
                            '<div class="cam-model" id="cam-'+cam_id+'">'+cam_id+'</div>'+
                            '<div class="option-preview" onclick={closeLiveView("'+frame_id+'")} camid="'+cam_id+'"><i class="fa fa-times" aria-hidden="true"></i></div>'+
                            '<div class="option-preview" onclick={fullScreen("'+frame_id+'")} camid="'+cam_id+'"><i class="fa fa-square-o" aria-hidden="true"></i></div>'+
                          '</div>'+
                        '</div>'+
                      '</div>'+
                      '<video muted autoplay playsinline id="video'+frame_id+'" class="frame-video"></video>'+
                    '</div>';

        await $(".cam-liveview").append(html);
        var video = document.getElementById('video'+frame_id);


        if (Hls.isSupported()) {
          console.log("Browser support HLS");
          var hls = hlsList[frame_id] = new Hls();
          // hls.loadSource(videoSrc);

          hls.on(Hls.Events.MEDIA_ATTACHED, function () {
            console.log(cam_id + ": Video and hls.js are now bound together !");
            hls.loadSource(videoSrc);
            // hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {
            //   console.log("manifest loaded, found " + data.levels.length + " quality level");
            // });
          });


          hls.attachMedia(video);
          hls.on(Hls.Events.MANIFEST_PARSED, function() {
            console.log(cam_id + ": On manifest parsed, play")
            video.play();
          });

          hls.on(Hls.Events.BUFFER_EOS, function(event, data){
            console.log(data);
            console.log(cam_id + ": EOS in live, agent in error, wait about 10 sec to reconnect");
            video.pause();
            setTimeout(function(){
              refreshScreen(frame_id, cam_id)
            }, 10000);
          });

          hls.on(Hls.Events.ERROR, function (event, data) {
            console.log(data);
            console.log(cam_id + ": Network error or media error, wait about 1 sec to reload");
            video.pause();
            setTimeout(function(){
              refreshScreen(frame_id, cam_id)
            }, 1000);

            // if (data.fatal) {

            //   switch(data.type) {
            //     case Hls.ErrorTypes.NETWORK_ERROR:
            //     // try to recover network error
            //       console.log("fatal network error encountered, try to recover");
            //       refreshScreen(cam_id)
            //       // hls.startLoad();
            //       break;
            //     case Hls.ErrorTypes.MEDIA_ERROR:
            //       console.log("fatal media error encountered, try to recover");
            //       hls.recoverMediaError();
            //       break;
            //     default:
            //     // cannot recover
            //       hls.destroy();
            //       break;
            //   }
            // }
          });

          video.onplaying = function () {
            var width = video.videoWidth;
            var height = video.videoHeight;
            console.log(cam_id + ": " + width + "x" + height);
            // document.getElementById("cam-" + cam_id).innerHTML = cam_id + ": " + width + 'x' + height;
          }
        }
        // video.src = videoSrc;
        // video.play();
      // }
    }

    async function viewAllStreams() {
      var data = await retrieveStreams();
      console.log(data);

      for (var i = 0; i < data.length; i++) {
        console.log(data[i]);
        addLive(data[i]);
      }
    }

    <?php
      if (strcmp($_SESSION['role'], "Administrator") == 0) {
        echo 'viewAllStreams();';
      }
    ?>

  </script>
@endsection
