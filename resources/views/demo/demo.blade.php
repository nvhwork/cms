@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="js-css/css/jquery-ui.css">
<link href="js-css/css/timeslider.css" rel="stylesheet" type="text/css"/>
<div class="content-camera">
   <div class="header-content">
      <div class="header-content-left desktop">
         <h6>Notification Management</h6>
      </div>
      <div class="header-content-right">
         <a href="/">
            <h6 class="display-inline link-active"><i class="fa fa-home"></i> Home </h6>
         </a>
         /
         <h6 class="display-inline">Restricted areas</h6>
      </div>
   </div>
   <div class="row row-content">
   	  <div class="col-sm-7">
	      <div class="row-title-proxy">
	        <div>
	         <div class="title-list-proxy desktop"><i class="fa fa-list" aria-hidden="true"></i> &nbsp;List of Devices</div>
	         <div class="proxy-add desktop" title="Cameras">Cameras &nbsp;
             <select class="browser-default custom-select select-profile cameraids" name="model-device">
                <option value="0">- All -</option>
                <option value="80">DS-2CD2420F-IW</option>
                <script type="text/javascript">
                  $(".cameraids").val('{!!$cam_id!!}');
                </script>
             </select>
           </div>
	         <div class="form-option-right" style="float: right;">
	            <div class="proxy-add" title="options">
	               <input class="select-profile input-time-range" type="date" id="date" name="date" value="{{$date}}" min="2017-01" onchange="filterDay(event);">
                 <a href="/monitor_video/{{$cam_id}}/{{$date}}"><button type="button" class="btn btn-model btn-apply">Video</button></a>
	            </div>
	         </div>
	       </div>
	         <div class="tab-content1">
	            <div class="timeline">
	               <!-- Modal -->
	               <div class="modal fade" id="video-playback" role="dialog" style="top:15%;">
	                  <div class="modal-dialog" style="width: 60%;">
	                     <!-- Modal content-->
	                     <div class="modal-content" style="background: transparent;">
	                        <div class="header-video">
	                           <a data-dismiss="modal" class="close-model"><button class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></button></a>
	                        </div>
	                        <div class="modal-body" style="padding: 0px;">
	                           <video width="100%" height="auto" controls playsinline="true" src="" id="myvideo">
	                              Your browser does not support the video tag.
	                           </video>
	                        </div>
	                     </div>
	                  </div>
	               </div>
	            </div>
	         </div>
	         <div class="tab-content1">
	            <div class="active-view" id="menu1">
	               <form action="removeadmin" method="POST">
	                  <input type="hidden" name="_token" value="{{csrf_token()}}">
	                  <table id="example" class="nvr-table">
	                     <thead>
	                        <tr class="thead"> 
	                           <th>Time Occurred</th>
                             <th>Location</th>
	                           <th>Type</th>
                             <th>Cam ID</th>
	                        </tr>
	                     </thead>
	                     <tbody class="tbody">
	                        @foreach($images as $img)
	                        <tr class="color-add" onclick='eventDetail("{!! $img->path !!}")'>
	                           <td>{{$img->occurr_time}}</td>
                             <td>Hanh Lang 405</td>
	                           <td>{{$img->type}}</td>
                             <td>{{$img->cam_id}}</td>
	                        </tr>
	                        @endforeach
	                     </tbody>
	                  </table>
                    {{ $images->links() }}
	                  <!-- /.table -->
	               </form>
	            </div>
	         </div>
	      </div>
	  </div>
	  <div class="col-sm-5 right-info">
	  	<div class="row">
            <div class="image-event">
              <div class="frame-preview">
                @if(count($images) > 0)
                <img class="cam-snapshot-info" id="snapshot" src="{{$images[0]->path}}">
                @else
                <img class="cam-snapshot-info" id="snapshot">
                @endif
              </div>
            </div>
        </div>
        <div class="row">
            @if(count($images) > 0)
              <table class="table-edit table-model table-info">
                <thead>
                  <tr>
                    <th class="cam-properties">Detail</th>
                    <th>_____</th>
                  </tr>
                </thead>
                <tbody class="table-edit table-manual-add">
                    <tr>
                        <td class="cam-properties">Location:</td>
                        <td class="location"> Hanh lang 405</td>
                    </tr>
                    <tr>
                        <td class="cam-properties">Event Type:</td>
                        <td class="event-type"> Video</td>
                    </tr>
                  </tbody>
                  <thead>
                    <tr>
                      <th class="cam-properties">Camera information</th>
                      <th>_____</th>
                    </tr>
                  </thead>
                  <tbody class="table-edit table-manual-add">
                    <tr>
                        <td class="cam-properties">Device Name:</td>
                        <td class="model">  DS-2DE4225W-DE3</td>
                    </tr>
                    <tr>
                        <td class="cam-properties">Manufacturer:</td>
                        <td class="manufacturer"> HIKVISION</td>
                    </tr>
                    <tr>
                        <td class="cam-properties">Serial Number:</td>
                        <td class="serial-number">  DS-2DE4225W-DE320180206C</td>
                    </tr>
                    <tr>
                        <td class="cam-properties">Firmware Version:</td>
                        <td class="firmware-version"> V5.5.3 build 171214</td>
                    </tr>
                    <tr>
                        <td class="cam-properties">IP Address:</td>
                        <td class="ipaddress"> 192.168.1.20</td>
                    </tr>
                  </tbody>
              </table>
            @else
              <table class="table-edit table-model table-info">
              <thead>
                <tr>
                  <th class="cam-properties">Detail</th>
                  <th>_____</th>
                </tr>
              </thead>
              <tbody class="table-edit table-manual-add">
                  <tr>
                      <td class="cam-properties">Location:</td>
                      <td class="location"> ______________________________</td>
                  </tr>
                  <tr>
                      <td class="cam-properties">Event Type:</td>
                      <td class="event-type"> ______________________________</td>
                  </tr>
                </tbody>
                <thead>
                  <tr>
                    <th class="cam-properties">Camera information</th>
                    <th>_____</th>
                  </tr>
                </thead>
                <tbody class="table-edit table-manual-add">
                  <tr>
                      <td class="cam-properties">Device Name:</td>
                      <td class="model"> ______________________________</td>
                  </tr>
                  <tr>
                      <td class="cam-properties">Manufacturer:</td>
                      <td class="manufacturer"> ______________________________</td>
                  </tr>
                  <tr>
                      <td class="cam-properties">Serial Number:</td>
                      <td class="serial-number"> ______________________________</td>
                  </tr>
                  <tr>
                      <td class="cam-properties">Firmware Version:</td>
                      <td class="firmware-version"> ______________________________</td>
                  </tr>
                  <tr>
                      <td class="cam-properties">IP Address:</td>
                      <td class="ipaddress"> ______________________________</td>
                  </tr>
                </tbody>
            </table>
            @endif
        </div>
	  </div>
   </div>
</div>
<!-- end model --->
</div>


<!-- end model --->


<div id="snackbar"><i class="fa fa-check" style="font-size: 1.5em;"></i>&nbsp;<h6 class="display-inline"> Update successful !</h6>
</div>
<div id="snackbar-warning"><i class="fa fa-exclamation-triangle" style="font-size: 1.5em;"></i>&nbsp;<h6 class="display-inline"> Warning !</h6>
</div>

<script>
  $(document).ready(function() {
      if($("#notice_warning").val() == 1){
        notifiWarning($("#notice_warning").attr("notifi"));
      }
      if($("#notice_success").val() == 1){
        notifiSuccess($("#notice_success").attr("notifi"));
      }

      $('#example').DataTable({
        "paging":   false,
        "info":     false,
        "searching": false,
        "aaSorting": [ [0,'desc'] ]
      });

      $('#example tbody tr').click(function() {
        $(this).addClass('bg-success').siblings().removeClass('bg-success');
      });
    });
</script>

<style type="text/css">
   .time-slider .ruler .bg {
   background-color: #24272b;
   border: none;
   }
   .ui-widget-content{
   background: #24272b;
   border: none;
   }
   .silder-zoom {
   margin-top: 30px; 
   }
   @media (max-width: 760px) {
   .silder-zoom {
   margin-top: -10px;
   margin-left: 10px;
   margin-bottom: 20px; 
   }
   }
   .silder-zoom input {
   border-radius: 5px;
   }
   .slider {
   -webkit-appearance: none;
   background: #24272b;
   outline: none;
   }
   .slider::-webkit-slider-thumb {
   -webkit-appearance: none;
   appearance: none;
   width: 15px;
   height: 15px;
   background: #b0b0b0;
   cursor: pointer;
   }
   .zoom-icon {
   font-size: 0.8rem;
   position: absolute;
   margin-top: 5px;
   margin-left: 5px;
   color: #b0b0b0;
   }
   .header-video {
   background: #36393e;
   text-align: right;
   }
   .btn-close {
   background: #f5252c;
   color: #fff;
   padding: 2px 5px 5px 5px;
   border: 0px;
   width: 30px;
   height: 30px;
   }

   .unsubscribe {
    display: none;
    cursor: pointer;
   }

   .modal-backdrop{
    z-index: 1039;
   }

   .modal{
    z-index: 1040;
   }

   @media (min-width: 767px){
    .sweet-alert {
       margin-left: -239px
    }
  }

  .row-content {
  	margin: 10px;
  }

  .cam-snapshot-info {
  	max-width: 100%;
  }

  .right-info {
  	border-left: 2px solid #c0c0c0;
  }

  .color-add {
    cursor: pointer;
  }

  .select-profile {
    font-size: 0.85em;
  }
</style>
<script type="text/javascript">
   function filterDay(e){
     location.replace("/monitor/"+$(".cameraids").val()+"/"+e.target.value)
   }

   $(".cameraids").change(function() {
    location.replace("/monitor/"+$('.cameraids').val()+"/"+$('#date').val())
  });

   function eventDetail(path){
    $(".location").html("Hanh Lang 405")
    $(".event-type").html(" Image")
    $(".model").html("  DS-2DE4225W-DE3")
    $(".ipaddress").html(" 192.168.1.20")
    $(".manufacturer").html(" HIKVISION")
    $(".serial-number").html(" DS-2DE4225W-DE320180206C")
    $(".firmware-version").html("   V5.5.3 build 171214")
    var timestamp = new Date().getTime();
    $("#snapshot").attr("src", path+'?time'+ timestamp);
   }
</script>

<script type="text/javascript">
  $(".occurr-time").click(function() {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
      time = Date.parse(this.textContent.replace(" ", "T")) - 25200000
    }
    else{
      time = Date.parse(this.textContent.replace(" ", "T"))
    }
    getFtpFile(time);
  });

</script>
@endsection