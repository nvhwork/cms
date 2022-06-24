// ===============================================================//
// ===============================================================//
// Lấy thông tin địa chỉ ip và mac
    function checkIpEdge(edge_id, ip_address){
      if(edge_id == ""){
        var Interval = setInterval(function(){ 
          $.ajax({
            url: "get-ip-edge/"+edge_id,
            success: function(res) {
              console.log(res[0])
              if(res[0] != null){
                $("#ip-address").html(res[0]);
                $("#mac-address").html(res[1]);
                pingEdge(res[0]);
                clearInterval(Interval);
              }
            }
          }); 
        }, 2000);
      }
      else{
        pingEdge(ip_address);
      }
    }

    function setEdgeStatus(sts){
      if(sts == "online"){
        $("#status-edge").addClass("active-on");
        $("#status-edge").html('<i class="fa fa-check-circle" aria-hidden="true"></i> Online');
      }
      else if (sts == 'offline'){
        $("#status-edge").removeClass("active-on");
        $("#status-edge").html('Offline');
      }else{
        $("#status-edge").removeClass("active-on");
        $("#status-edge").html('Loading...');
      }
    }
    
    // Ping đến Edge cập nhật trạng thái onl/off 
    function pingEdge(ip){
      try{
        $.ajax({
            url: "ping/"+ip,
            success: function(res) {
              if(res == "true"){
                $("#status-edge").addClass("active-on");
                $("#status-edge").html('<i class="fa fa-check-circle" aria-hidden="true"></i> Online');
              }
              else{
                $("#status-edge").removeClass("active-on");
                $("#status-edge").html('Offline');
              }
            }
        }); 
        setInterval(function(){ 
          $.ajax({
            url: "ping/"+ip,
            success: function(res) {
              if(res == "true"){
                $("#status-edge").addClass("active-on");
                $("#status-edge").html('<i class="fa fa-check-circle" aria-hidden="true"></i> Online');
              }
              else{
                $("#status-edge").removeClass("active-on");
                $("#status-edge").html('Offline');
              }
            }
          }); 
        }, 2000);
      }
      catch(err) {
        console.log(err.message);
      }
    }






// ===============================================================//
// ===============================================================//
    // Lấy thông tin các file config của EdgeAI và hiển thị bên dưới khi chọn các profile khác nhau
    function getConfigProfile(edge_id){
      var profile_id = $("#profile-id").val();
      if(profile_id == "new_profile"){
        createProfile();
        return;
      }
      $.ajax({
        url: 'update-profile/'+edge_id+'/'+profile_id,
        success: function(res) {
          console.log(res);
        }
      });
      $("#current-profile").val(profile_id);
      $("#profile-selected").html($("#profile-id option:selected").text());
      $.ajax({
        url: 'get-config-profile/'+edge_id+'/'+profile_id,
        success: function(res) {
          var nameConfigRender = "";
          var contentConfigRender = "";
          (async () => {
            for(var i=0; i<res.length; i++){
              nameConfigRender = nameConfigRender+'<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#'+res[i].type+'" role="tab" aria-controls="v-pills-settings" aria-selected="false">'+res[i].type+'</a>';
              await jQuery.get('config/edges_ai/edge_'+edge_id+'/'+res[i].path, function(content) {
                contentConfigRender = contentConfigRender+'<div class="tab-pane fade" id="'+res[i].type+'" role="tabpanel" aria-labelledby="v-pills-settings"><div class="card"><div class="card-body"><textarea disabled class="content-config-file">'+JSON.stringify(content, undefined, 3)+'</textarea><div class="option-file-config"><a href="edit-config-file/'+res[i].id+'" class="parent-item"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a><a link="/delete-config-file/'+res[i].id+'/'+res[i].path+'" class="config-delete parent-item"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></div></div></div></div>';
              });
            }
            document.getElementById('v-pills-tab').innerHTML = nameConfigRender;
            document.getElementById('v-pills-tabContent').innerHTML = contentConfigRender;
            $(".config-delete").click(function() {
              link = $(this).attr("link");
              JSconfirm(" Are you sure to delete the file config? ", link);
            });
          })();
        }
      });
    }

    // Tạo profile mới
    function createProfile(){
      $('#new-profile').modal('show');
    }





// ===============================================================//
// ===============================================================//
    // Đóng modal "Tạo file config mới"
    function close_form(){
      document.getElementsByClassName('notification')[0].innerHTML ='';
      document.getElementsByClassName('notification')[0].classList.remove('notification-color');
    }

    // Đóng modal "Tạo profile mới"
    function close_form_profile(){
      document.getElementsByClassName('notification')[0].innerHTML ='';
      document.getElementsByClassName('notification')[0].classList.remove('notification-color');
      $("#profile-id").val($("#current-profile").val());
    }

    // Hiện thị lỗi khi file config mới không hợp lệ
    function showError(){
      $("#new-config").addClass("shake-model");
        setTimeout(function() {
          $("#new-config").removeClass("shake-model");
        }, 1000);
        document.getElementsByClassName('notification')[0].innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> An error has occurred during processing. ";
        document.getElementsByClassName('notification')[0].classList.add('notification-color');
    }

    // Tạo file config mới (Chọn 1 trong các teamplate có sẵn)
    function createConfigByTempalte(edge_id){
      config_name = $("#config_name_add").val();
      teamplate = $("#tempalte").val();
      if(config_name == ""){
        showError();
        return;
      }
      arrays = [config_name,teamplate];
      try{
        var profile_id = $("#profile-id").val();
        $.ajax({
          type: "POST",
          data : {"_token": $('meta[name="csrf-token"]').attr('content'),arrays},
          url : "new-config-file/"+edge_id+"/"+profile_id,
          success: function(msg){
            //close_loading()
            if(msg != "false"){
              $('#new-config').modal('hide');
              close_form();
              notifiSuccess("Add new config successful.");
              $("#v-pills-tab").append('<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#'+config_name+'" role="tab" aria-controls="v-pills-settings" aria-selected="false">'+config_name+'</a>');
              $("#v-pills-tabContent").append('<div class="tab-pane fade" id="'+config_name+'" role="tabpanel" aria-labelledby="v-pills-settings"><div class="card"><div class="card-body"><textarea disabled class="content-config-file">'+msg.content+'</textarea><div class="option-file-config"><a href="edit-config-file/'+msg.edge_profile_id+'" class="parent-item"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a><a link="/delete-config-file/'+msg.edge_profile_id+'/'+msg.path+'" class="config-delete parent-item"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></div></div></div></div>');
              $(".config-delete").click(function() {
                link = $(this).attr("link");
                JSconfirm(" Are you sure to delete the file config? ", link);
              });
            }
            else{
              //close_loading()
              showError()
            }
          }
        })
      }
      catch(err) {
        // close_loading()
        showError()
        console.log(err.message);
      }
    }





// ===============================================================//
// ===============================================================//
// Hiện thị thông báo thành công/ lỗi
    $(document).ready(function() {
      if($("#notice_success").val() == 1){
        notifiSuccess($("#notice_success").attr("notifi"));
      }
      if($("#notice_warning").val() == 1){
        notifiWarning($("#notice_warning").attr("notifi"));
      }
    });

    // Xác nhận reboot EdgeAI
    function confirmRebootEdge() {
      var edgeReboot = document.getElementById('edge-reboot');
      var link = document.getElementById('edge-reboot').getAttribute("link");
      edgeReboot.addEventListener('click', function (e) {
        JSconfirm(" Are you sure to restart the Edge AI device? ", link);
      });
      }
      confirmRebootEdge();

    // Xác nhận xóa Edge AI
    function confirmDeleteEdge() {
      var edgeDelete = document.getElementById('edge-delete');
      var link = document.getElementById('edge-delete').getAttribute("link");
      edgeDelete.addEventListener('click', function (e) {
        JSconfirm(" Are you sure to delete the Edge AI device? ", link);
      });
    }
    confirmDeleteEdge();


    // Xác nhận xóa file config
    $(".config-delete").click(function() {
      link = $(this).attr("link");
      JSconfirm(" Are you sure to delete the file config? ", link);
    });

    //Xác nhận xóa profile
    function deleteProfile(edge_id){
      profile_id = $("#profile-id").val();
      link = "delete-profile/"+edge_id+"/"+profile_id;
      console.log(link);
      JSconfirm(" Are you sure to delete the profile? ", link);
    }




// ===============================================================//
// ===============================================================//
// <!-- xac nhan gui file cau hinh -->
function sendConfig(edge_id){
  swal({ 
    title: "",   
    text: " Please confirm to update the Edge AI? ",   
    type: "info",   
    showCancelButton: true,     
    confirmButtonText: "Yes",   
    cancelButtonText: "No",   
    closeOnConfirm: false,   
    closeOnCancel: false,
    reverseButtons: true }, 
    function(isConfirm){   
    if (isConfirm)
    {
      var sendObj = {edge_id: edge_id};
      socket.emit('new-config', JSON.stringify(sendObj))
      loading_nomal(); 
      swal.close(); 
    } 
    else {     
      swal.close();  
    } 
  });
}

    


// ===============================================================//
// ===============================================================//
 // <!-- xac nhan gui chay cac ung dung AI -->
  var link = document.getElementById('update-app').getAttribute("link");
  document.getElementById('update-app').addEventListener('click', function(e){
    swal({ 
      title: "",   
      text: " Please confirm to run ai applications? ",   
      type: "info",   
      showCancelButton: true,     
      confirmButtonText: "Yes",   
      cancelButtonText: "No",   
      closeOnConfirm: false,   
      closeOnCancel: false,
      reverseButtons: true }, 
      function(isConfirm){   
      if (isConfirm) 
      {   
        loading_nomal();
        $.ajax({
          url: link,
          success: function(res) {
            if(res == "true"){
              close_loading();
              notifiSuccess(" Ai applications has been running. ");
              $('.status-cam').html('<span title="The configuration has been updated"><i class="fa fa-check-circle-o text-success" aria-hidden="true"></i></span>')
            }   
            else{
              close_loading();
              notifiWarning(" Configuration file update failed. ");
            }
          }
        }); 
        swal.close(); 
      } 
      else {     
        swal.close();  
      } 
    });
  });





// ===============================================================//
// ===============================================================//
 // <!-- Bieu do CPU -->

 var updateInterval = 1000;
// initial value
var yValue1 = 0; 
var dataPoints1 = [];
var time1 = new Date;


var chartRAM = new CanvasJS.Chart("RAM", {
  backgroundColor: "transparent",
    zoomEnabled: true,
    axisX: {
        labelFontColor: "transparent",
        valueFormatString:"0"
    },
    axisY:{
        prefix: "",
        includeZero: false,
        labelFontColor: "#ffffff",
        minimum: 0,
        maximum: 100
    }, 
    toolTip: {
        shared: true
    },
    legend: {
        cursor:"pointer",
        verticalAlign: "top",
        fontSize: 15,
        fontColor: "#ffffff",
        itemclick : toggleDataSeries
    },
    data: [{ 
        type: "area",
        lineColor:"#517753",
        color: "#51775387",
        xValueType: "dateTime",
        yValueFormatString: "00.00'%'",
        xValueFormatString: "hh:mm:ss TT",
        showInLegend: true,
        indexLabelFontColor: "ff7504",
        name: "CPU usage",
        dataPoints: dataPoints1,
        }]
});

function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chartRAM.render();
}


async function updateChartRAM(array) {
      if(array[0] == "create"){
        count = array[1] || 1;
        for (var i = 0; i < count; i++) {
            time1.setTime(time1.getTime()+ updateInterval);
                  dataPoints1.push({
                      x: time1.getTime(),
                      y: 0
                  });
                  // updating legend text with  updated with y Value 
                  chartRAM.options.data[0].legendText = " CPU Usage " + yValue1 + " %";
                  chartRAM.render();
              }
        } 
}

// generates first set of dataPoints 
updateChartRAM(["create",70]);   


function appendValueRAM(value){
  time1.setTime(time1.getTime()+ updateInterval);
  yValue1 = value;

  // pushing the new values
  dataPoints1.push({
    x: time1.getTime(),
    y: yValue1
  });

  dataPoints1.shift()
  // updating legend text with  updated with y Value 
  chartRAM.options.data[0].legendText = " CPU Usage " + yValue1 + " %";
  chartRAM.render();
}





// ===============================================================//
// ===============================================================//
 // <!-- Bieu do RAM -->

 var time2 = new Date;
var yValue2 = 0; 

var dataPoints2 = [];

var chartCPU = new CanvasJS.Chart("CPU", {
  backgroundColor: "transparent",
    zoomEnabled: true,
    axisX: {
        labelFontColor: "transparent",
        valueFormatString:"0"
    },
    axisY:{
        prefix: "",
        includeZero: false,
        labelFontColor: "#ffffff",
        minimum: 0,
        maximum: 100
    }, 
    toolTip: {
        shared: true
    },
    legend: {
        cursor:"pointer",
        verticalAlign: "top",
        fontSize: 15,
        fontColor: "#ffffff",
        itemclick : toggleDataSeries2
    },
    data: [{ 
        type: "area",
        lineColor:"#517753",
        color: "#51775387",
        xValueType: "dateTime",
        yValueFormatString: "00.00'%'",
        xValueFormatString: "hh:mm:ss TT",
        showInLegend: true,
        indexLabelFontColor: "ff7504",
        name: "RAM usage",
        dataPoints: dataPoints2,
        }]
});

function toggleDataSeries2(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chartCPU.render();
}

async function updateChartCPU(array) {
      if(array[0] == "create"){
        count = array[1] || 1;
        for (var i = 0; i < count; i++) {
            time2.setTime(time2.getTime()+ updateInterval);
                  dataPoints2.push({
                      x: time2.getTime(),
                      y: 0
                  });
                  // updating legend text with  updated with y Value 
                  chartCPU.options.data[0].legendText = " RAM Usage " + yValue2 + " %";
                  chartCPU.render();
              }
        } 
}

// generates first set of dataPoints 
updateChartCPU(["create",70]);   


function appendValueCPU(value){
  time2.setTime(time2.getTime()+ updateInterval);
  yValue2 = value;

  // pushing the new values
  dataPoints2.push({
    x: time2.getTime(),
    y: yValue2
  });

  dataPoints2.shift()
  // updating legend text with  updated with y Value 
  chartCPU.options.data[0].legendText = " RAM Usage " + yValue2 + " %";
  chartCPU.render();
}





// ===============================================================//
// ===============================================================//
 // <!-- Biểu đồ TEMP -->


 var time3 = new Date;

var yValue3 = 0; 

var dataPoints3 = [];

var chartTEMP = new CanvasJS.Chart("TEMP", {
  backgroundColor: "transparent",
    zoomEnabled: true,
    axisX: {
        labelFontColor: "transparent",
        valueFormatString:"0"
    },
    axisY:{
        prefix: "",
        includeZero: false,
        labelFontColor: "#ffffff",
        minimum: 0,
        maximum: 100
    }, 
    toolTip: {
        shared: true
    },
    legend: {
        cursor:"pointer",
        verticalAlign: "top",
        fontSize: 15,
        fontColor: "#ffffff",
        itemclick : toggleDataSeries3
    },
    data: [{ 
        type: "area",
        lineColor:"#ff7504",
        color: "#f5760e5e",
        xValueType: "dateTime",
        yValueFormatString: "00.00'%'",
        xValueFormatString: "hh:mm:ss TT",
        showInLegend: true,
        indexLabelFontColor: "ff7504",
        name: "CPU usage",
        dataPoints: dataPoints3,
        }]
});

function toggleDataSeries3(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chartTEMP.render();
}

async function updateChartTEMP(array) {
      if(array[0] == "create"){
        count = array[1] || 1;
        for (var i = 0; i < count; i++) {
            time3.setTime(time3.getTime()+ updateInterval);
                  dataPoints3.push({
                      x: time3.getTime(),
                      y: 0
                  });
                  // updating legend text with  updated with y Value 
                  chartTEMP.options.data[0].legendText = " CPU Usage " + yValue3 + " °C";
                  chartTEMP.render();
              }
        } 
}

// generates first set of dataPoints 
updateChartTEMP(["create",70]);   


function appendValueTEMP(value){
  time3.setTime(time3.getTime()+ updateInterval);
  yValue3 = value;

  // pushing the new values
  dataPoints3.push({
    x: time3.getTime(),
    y: yValue3
  });

  dataPoints3.shift()
  // updating legend text with  updated with y Value 
  chartTEMP.options.data[0].legendText = " TEMP " + yValue3 + " °C";
  chartTEMP.render();
}




// ===============================================================//
// ===============================================================//
 // <!-- Biểu đồ DISK -->


 var time4 = new Date;

var yValue4 = 0; 

var dataPoints4 = [];

var chartDISK = new CanvasJS.Chart("DISK", {
  backgroundColor: "transparent",
    zoomEnabled: true,
    axisX: {
        labelFontColor: "transparent",
        valueFormatString:"0"
    },
    axisY:{
        prefix: "",
        includeZero: false,
        labelFontColor: "#ffffff",
        minimum: 0,
        maximum: 100
    }, 
    toolTip: {
        shared: true
    },
    legend: {
        cursor:"pointer",
        verticalAlign: "top",
        fontSize: 15,
        fontColor: "#ffffff",
        itemclick : toggleDataSeries4
    },
    data: [{ 
        type: "area",
        lineColor:"#ff7504",
        color: "#f5760e5e",
        xValueType: "dateTime",
        yValueFormatString: "00.00'%'",
        xValueFormatString: "hh:mm:ss TT",
        showInLegend: true,
        indexLabelFontColor: "red",
        name: "CPU usage",
        dataPoints: dataPoints4,
        }]
});

function toggleDataSeries4(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chartDISK.render();
}

async function updateDiskUssage(array) {
      if(array[0] == "create"){
        count = array[1] || 1;
        for (var i = 0; i < count; i++) {
            time4.setTime(time4.getTime()+ updateInterval);
                  dataPoints4.push({
                      x: time4.getTime(),
                      y: 0
                  });
                  // updating legend text with  updated with y Value 
                  chartDISK.options.data[0].legendText = " Disk Usage " + yValue4 + " %";
                  chartDISK.render();
              }
        } 
}

// generates first set of dataPoints 
updateDiskUssage(["create",70]);   


function appendDiskUssage(value){
  time4.setTime(time4.getTime()+ updateInterval);
  yValue4 = value;

  // pushing the new values
  dataPoints4.push({
    x: time4.getTime(),
    y: yValue4
  });

  dataPoints4.shift()
  // updating legend text with  updated with y Value 
  chartDISK.options.data[0].legendText = " Disk Usage " + yValue4 + " %";
  chartDISK.render();
}







// ===============================================================//
// ===============================================================//
 // <!-- lắng nghe message từ socket -->

setEdgeStatus('loading');
var token = '';
var socket = undefined;
var isConnected = false;

const f = function(s){
  if (!isConnected || s !== socket){
    return;
  }
  var obj = {edge_id:edge_id};
  var sendStr = JSON.stringify(obj);
  socket.emit('get-device-status', sendStr);
}

const scanOnvif = function(){
  if (!isConnected || socket === undefined){
    return;
  }
  var obj = {edge_id:edge_id};
  var sendStr = JSON.stringify(obj);
  socket.emit('scan-onvif', sendStr);
}

const getInfoOnvif = function(ip, port, username, password){
  if (!isConnected || socket === undefined){
    return;
  }
  var obj = {edge_id:edge_id, ip:ip, port:port, username: username, password: password};
  var sendStr = JSON.stringify(obj);
  socket.emit('get-info-onvif', sendStr);
}

function setupSocket(socket, f){
  socket.on('analy_mess', function(data){
    // data = JSON.parse(data);
    // if (data.type === 'current'){
    //   $("#current").html(data.value);
    // }else{
    //   $("#count").html(data.value);
    // }
  });
  socket.on('scan-onvif-res', function(data){
    console.log(data);
  });
  socket.on('get-info-onvif-res', function(data){
    console.log("info");
    console.log(data);
  });

  socket.on('get-device-status-res',function(dataSeries){
    console.log(socket.id);
    console.log('Get sts settimeout');
    setTimeout(f, 3000, socket);
    setEdgeStatus("online");
      try{
        var data = JSON.parse(dataSeries);
        var status = data["status"]
        var cpuPercent =  status['cpu']['total_percentage'];
        var ramPercent = status['ram']['percentage'];
        var temperature = status['temp']['current'];
        var diskPercent = status['disk'][0]['percentage'];
        var ifaces = status.interface;
        for(var i=0; i<ifaces.length; i++){
          if (ifaces[i].ipv4 != '127.0.0.1'){
            console.log(ifaces[i].ipv4);
            $("#ip-address").html(ifaces[i].ipv4);
            $("#mac-address").html(ifaces[i].mac)

            break;
          }
        }
        appendValueCPU(cpuPercent);
        appendValueRAM(ramPercent);
        appendValueTEMP(temperature);
        appendDiskUssage(diskPercent);
        var deepSts = status['deep_app']['is_run'];
        if (deepSts){
          deepSts = "ON";
        }else{
          deepSts = "OFF";
        }
        updateSateDeepstream(deepSts);
      }
      catch(err) {
        console.error(err.message);
      }
      //   genInfo(data);
      //   updateSateDeepstream(data["deepstream"]);
      // }
  });

  socket.on('new-config-res', function(data){
    console.log(data);
    close_loading();
    notifiSuccess('Configuration applied to Edge devices');
  })

  socket.on('connect_failed', function(){
    // console.error();
    setEdgeStatus('loading');
    console.error("conn-failed")
  });

  socket.on('reconnect_failed', function(){
    // console.error();sss
    setEdgeStatus('loading');
    console.error("reconn-failed")
  });

  socket.on('error', function(data){
    console.error(data);
    try{
     err = JSON.parse(data);
     if (err.code === 403){
      getTokenAndReconnect();
     }else if (err.code == 404){
      console.log(data);
      setEdgeStatus('offline');
      setTimeout(f, 3000, socket);
     }else {
      console.log('Loginsuccess settimeout');
      setTimeout(f, 3000, socket);
     }
    }catch(err){
      console.log('Err settimeout');
      setTimeout(f, 3000, socket);
      console.error(err);
    }
  });

  socket.on('connect_error', function(){
    setEdgeStatus('loading');
    console.error("conn-err");
  });

  socket.on('connect_failed', function(){
    setEdgeStatus('loading');
    console.error("conn-failed")
  });

  socket.on('disconnect', function(){
    console.error("disconnect");
  });

  socket.on('connect', function(){
    console.log("Connected");
    console.log(socket);
    isConnected = true;
    console.log('Connect settimeout');
    setTimeout(f, 3000, socket);
  });

  socket.on('reconnect', function(){
    setEdgeStatus('loading');
    console.log("reconnected");
  });
}


const getTokenAndReconnect = function(){
  console.log("Try to connect");
  $.ajax({
    url: "/get-user-token",
    success: function(res) {
      console.log(res);
      try{
        token = res['token'];
        if (socket !== undefined){
          delete socket;
        }
        socket = io(socket_python, {
          // secure: false,
          transportOptions: {
            polling: {
              extraHeaders: {
                jwt_token:token
              }
            }
          }
        });
        setupSocket(socket, f);
      }catch(err){
        console.error(err);
        console.log("Response not valid")
        setTimeout(getTokenAndReconnect, 3000);
      }
    },
    error: function(err){
      console.error(err)
      setTimeout(getTokenAndReconnect, 10000)
    }
  });
}
setTimeout(getTokenAndReconnect, 1000);




// ===============================================================//
// ===============================================================//
 // <!-- Hiển thị, ẩn hiện thông tin chi tiết của EDGE -->

 // Gửi file config tới server iva để khởi chạy ứng dụng AI cho camera
function sendConfigToAnalysis(){
  $.ajax({
    url: "server-analysis/update-application/"+edge_id,
    success: function(res) {
      console.log(res)
      if(res == "Da tao ung dung thanh cong"){
        close_loading();
        notifiSuccess(" Configuration file updated successfully. ");
      }   
      else{
        close_loading();
        notifiWarning("Configuration file update failed");
      }
    }
  }); 
}



    // Cập nhật trạng thái start/ stop deepstrem trên giao diện
    function updateSateDeepstream(state){
      console.log(state);
      if(state == "ON"){
        $("#deepstream").attr("value","1");
        $("#deepstream").html('<i class="fa fa-stop" aria-hidden="true"></i>&nbsp; Stop');
      }
      else{
        $("#deepstream").attr("value","0");
        $("#deepstream").html('<i class="fa fa-play" aria-hidden="true"></i>&nbsp; Start');
      }
    }

    // Hiển thị thông tin lấy được từ Edge thông qua kafka lên giao diện
    function genInfo(data){
      var html1 = '';
      var html2 = '';
      var html3 = '';
      var i = 0;
        Object.keys(data).forEach(key => {
          if(i<9){
            if(data[key] == "ON"){
              html1 = html1 + '<tr><td>'+key+'</td><td style="color:#48ea48">'+data[key]+'</td></tr>';
            }
            else if(data[key] == "OFF"){
              html1 = html1 + '<tr><td>'+key+'</td><td style="color:#ff4343">'+data[key]+'</td></tr>';
            }
            else{
              html1 = html1 + '<tr><td>'+key+'</td><td>'+data[key]+'</td></tr>';
            }
          }
          else if(i>= 9 && i<18){
            if(data[key] == "ON"){
              html2 = html2 + '<tr><td>'+key+'</td><td style="color:#48ea48">'+data[key]+'</td></tr>';
            }
            else if(data[key] == "OFF"){
              html2 = html2 + '<tr><td>'+key+'</td><td style="color:#ff4343">'+data[key]+'</td></tr>';
            }
            else{
              html2 = html2 + '<tr><td>'+key+'</td><td>'+data[key]+'</td></tr>';
            }
          }
          else{
            if(data[key] == "ON"){
              html3 = html3 + '<tr><td>'+key+'</td><td style="color:#48ea48">'+data[key]+'</td></tr>';
            }
            else if(data[key] == "OFF"){
              html3 = html3 + '<tr><td>'+key+'</td><td style="color:#ff4343">'+data[key]+'</td></tr>';
            }
            else{
              html3 = html3 + '<tr><td>'+key+'</td><td>'+data[key]+'</td></tr>';
            }
          }
          i = i + 1;
        });
        document.getElementById("info-edge1").innerHTML = html1;
        document.getElementById("info-edge2").innerHTML = html2;
        document.getElementById("info-edge3").innerHTML = html3;
    } 


    // Ẩn/hiện thông tin không quan trọng
    $("#info-detail").hide();
    function showInfo(){
      if($("#state-info").attr("value") == 0){
        $("#info-detail").show();
        $("#state-info").html("Hide");
        $("#state-info").attr("value","1");
      }
      else{
        $("#info-detail").hide();
        $("#state-info").html("Show");
        $("#state-info").attr("value","0");
      }
    }


    // Hiển thị thông tin các file config trong profile khi click vào profile
    function showInfoProfile(){
      if($("#state-info-profile").attr("value") == 0){
        $("#info-profile-detail").show();
        $("#state-info-profile").attr("value","1");
      }
      else{
        $("#info-profile-detail").hide();
        $("#state-info-profile").attr("value","0");
      }
    }


    // Yêu cầu bật/ tắt deepstream khi click vào button
    $("#deepstream").click(function() {
      if($("#deepstream").attr("value") == 0){
        JSconfirmChangeStateDeepstream(" Are you sure to start the RZM Application? ", "start-deepstream/"+edge_id);
      }
      else if($("#deepstream").attr("value") == 1){
        JSconfirmChangeStateDeepstream(" Are you sure to stop the RZM Application? ", "stop-deepstream/"+edge_id);
      }
    });

    // Xác nhận bật tắt deepstream
    function JSconfirmChangeStateDeepstream(text, link){
    swal({ 
       title: "",   
       text: text,   
       type: "info",   
       showCancelButton: true,     
       confirmButtonText: "Yes",   
       cancelButtonText: "No",   
       closeOnConfirm: false,   
       closeOnCancel: false,
       reverseButtons: true }, 
       function(isConfirm){   
       if (isConfirm) 
       {   
         loading_nomal();
         try{
               $.ajax({
                  url: link,
                  success: function(res) {
                     if(res == "true"){
                        notifiSuccess("The request has been sent successfully.");
                     }    
                     else{
                        notifiWarning(" Request failed. ");
                     }
                     close_loading();
                     swal.close(); 
                  }
               });
            }
            catch(err) {
               swal.close();
               close_loading();
               console.log(err.message);
               $("#recording"+cam_id).val($("#recording"+cam_id).attr("value"));
            } 
       } 
       else {   
        close_loading();
        swal.close();   
       }
     });
     $(".btn-primary").css('border', 'none');
     $(".showSweetAlert").attr('style', 'display: block;');
     $(".text-muted").attr('style', 'color: #fff !important');
   }






// ===============================================================//
// ===============================================================//
 // <!-- Code lap lich ghi -->

 // Cập nhật trạng thái đang ghi/ không ghi của cameras
  function getRecordState(cams){
    $.ajax({
        type: "POST",
        data : {"_token": $('meta[name="csrf-token"]').attr('content'),cams},
        url : "cam-record-state/"+edge_id+"/edge_id",
        success: function(msg){
          for (const [key, value] of Object.entries(msg)) {
            $("#record-state-"+key).attr('class', value)
          }
        }
      }) 
  }
  getRecordState(cams)
  setInterval(function(){ 
    getRecordState(cams)
  }, 5000);



  // Xác nhận xóa cameras ra khỏi Edge
  // function confirm_remove() {
  //   var remove = document.getElementById('device-remove');
  //   remove.addEventListener('click', function(e){
  //       $("#form-camera").attr("action","remove-camera");
  //       swal({
  //           title: "",
  //           text: " Are you sure to stop recording these cameras? ",
  //           type: "info",
  //           showCancelButton: true,
  //           confirmButtonText: "Yes",
  //           cancelButtonText: "No",
  //           closeOnConfirm: false,
  //           closeOnCancel: false,
  //           reverseButtons: true },
  //           function(isConfirm){
  //           if (isConfirm)
  //           {
  //             loading_nomal()
  //             document.getElementById("submit-action").click();
  //             swal.close();
  //           }
  //           else {
  //             swal.close();
  //           }
  //         });
  //     });
  // }
  // confirm_remove();

// Code lập lịch ghi cho camera
var selectedCameras = [];
   var calendar = null;
   
   $("input[class='check-box']").click(function () {
       var selectedElement = this.parentElement.parentElement;
       if ($(this).is(":checked")) {
           selectedCameras.push(selectedElement);
       } else {
           selectedCameras = selectedCameras.filter(function (value) {
               return value != selectedElement
           });
       }
   });
   

   // Chọn nhiều camera
   function checkAll() {
       if ($('#select-all').is(':checked')) {
           $('.check-box').each(function (index, element) {
               if (!element.checked) {
                   element.click();
               }
           });
       } else {
           $('.check-box').each(function (index, element) {
               if (element.checked) {
                   element.click();
               }
           });
       }
   }
   
   
   // Thay đổi trạng thái ghi cho nhiều camera một lúc
   function handleBulkChangeRecording() {
      if(selectedCameras.length == 0){
         $("#recording").val(-1);
         return;
      }
       switch ($("#recording").val()) {
         case '2':
            $('#calendar-modal-multi').modal('show');
            break;
         default:
            try{
               record_mode = $("#recording").val();
               var cameras = [];
               for(var i=0; i<selectedCameras.length; i++ ){
                  cameras.push(selectedCameras[i].getAttribute("key"));
               }
               JSconfirmChangeModeMulti("Please confirm to update the record mode", "change-mode-record-all/"+record_mode, cameras);
            }
            catch(err) {
               location.reload();
            }
            break;    
      }
   }
   
   
   
   // Hiện thị Modal calender nếu chọn ghi theo lịch, hoặc hiện thị modal xác nhận chuyển chế độ ghi
   function showModes(cam_id){
      switch ($("#recording"+cam_id).val()) {
         case '2':
            renderCalendar(cam_id);
            break;
         default:
            JSconfirmChangeModeNotScheduler("Please confirm to update the record mode", cam_id);
            break;    
      }
   }
   
   // Lấy thông tin lịch ghi của camera và hiển thị
   function renderCalendar(cam_id) {
      $('#calendar-modal').modal('show');
      $('#calendar-modal').attr("cam-id",cam_id);
      var record_mode = $("#recording"+cam_id).attr("value");
      if(record_mode == 2){
         $.ajax({
            url: "get-scheduler/"+cam_id+"/"+edge_id+"/edge_id",
            success: function(res) {
               $('#scheduler').scheduler('val', res);
               $('#scheduler').scheduler('disable');
            }
         });
      } 
   }
   
   // Cập nhật lịch ghi (theo lịch) của camera
   function updateScheduler(){
      cam_id = $('#calendar-modal').attr("cam-id");
      scheduleres = $('#scheduler').scheduler('val');
      JSconfirmUpdateScheduler("Please confirm to update the scheduler", cam_id, scheduleres);
   }


   // Cập nhật lịch ghi (theo lịch) của nhiều camera 1 lúc
   function updateSchedulerMulti(){
      var cameras = [];
      for(var i=0; i<selectedCameras.length; i++ ){
         cameras.push(selectedCameras[i].getAttribute("key"));
      }
      scheduleres = $('#scheduler-multi').scheduler('val');
      var data = [cameras, scheduleres];
      JSconfirmChangeModeSchedulerMulti("Please confirm to update the scheduler", data);
   }


   // làm mới lịch ghi của camera (xóa trắng lịch ghi và chọn lại)
   function resetScheduler(){
      cam_id = $('#calendar-modal').attr("cam-id");
      $("#recording"+cam_id).val($("#recording"+cam_id).attr("value"));
      $('#scheduler').scheduler('val', {});
      $('#scheduler').scheduler('enable');
   }

   // làm mới lịch ghi của nhiều camera (xóa trắng lịch ghi và chọn lại)
   function resetSchedulerMulti(){
      cam_id = $('#calendar-modal-multi').attr("cam-id");
      $("#recording").val(-1);
      $('#scheduler-multi').scheduler('val', {});
      $('#scheduler-multi').scheduler('enable');
   }

   // Xác nhận thay đổi trạng thái ghi không phải ghi theo lịch
   function JSconfirmChangeModeNotScheduler(text, cam_id){
    swal({ 
       title: "",   
       text: text,   
       type: "info",   
       showCancelButton: true,     
       confirmButtonText: "Yes",   
       cancelButtonText: "No",   
       closeOnConfirm: false,   
       closeOnCancel: false,
       reverseButtons: true }, 
       function(isConfirm){   
       if (isConfirm) 
       {   
         loading_nomal();
         try{
               record_mode = $("#recording"+cam_id).val();
               $.ajax({
                  url: "change-mode-record/"+cam_id+"/"+record_mode+"/"+edge_id+"/edge_id",
                  success: function(res) {
                     if(res == "true"){
                        $("#recording"+cam_id).attr("value",record_mode);
                        $("#info-scheduler-"+cam_id).html("");
                        notifiSuccess("Update successful.");
                        $('#status-cam-'+cam_id).html('<span title="configuration is out of date"><i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i></span>')
                     }    
                     else{
                        $("#recording"+cam_id).val($("#recording"+cam_id).attr("value"));
                     }
                     close_loading();
                     swal.close(); 
                  }
               });
            }
            catch(err) {
               swal.close();
               close_loading();
               console.log(err.message);
               $("#recording"+cam_id).val($("#recording"+cam_id).attr("value"));
            } 
       } 
       else {   
        close_loading();
        $("#recording"+cam_id).val($("#recording"+cam_id).attr("value"));
        swal.close();  
       } 
     });
     $(".btn-primary").css('border', 'none');
     $(".showSweetAlert").attr('style', 'display: block;');
     $(".text-muted").attr('style', 'color: #fff !important');
   }


   // Xác nhận thay đổi khung giờ ghi theo lịch của nhiều cameras
   function JSconfirmChangeModeSchedulerMulti(text, data){
    swal({ 
       title: "",   
       text: text,   
       type: "info",   
       showCancelButton: true,     
       confirmButtonText: "Yes",   
       cancelButtonText: "No",   
       closeOnConfirm: false,   
       closeOnCancel: false,
       reverseButtons: true }, 
       function(isConfirm){   
       if (isConfirm) 
       {   
         loading_nomal();
         try{
         $.ajax({
            type: "POST",
            data : {"_token": $('meta[name="csrf-token"]').attr('content'),data},
            url : "update-scheduler-all/"+edge_id+"/edge_id",
            success: function(msg){
               if(msg == "true"){
                  window.location.href = 'change-scheduler-multi-success';
               }
               else if(msg = "mode:0"){
                  window.location.href = 'change-scheduler-multi-success';
               }
            }
         })
          }
          catch(err) {
             $('#scheduler-multi').scheduler('disable');
             $('#calendar-modal-multi').modal('hide');
             resetScheduler();
             console.log(err.message);
             close_loading()
          }  
       } 
       else {   
        swal.close();  
        close_loading()
       } 
     });
     $(".btn-primary").css('border', 'none');
     $(".showSweetAlert").attr('style', 'display: block;');
     $(".text-muted").attr('style', 'color: #fff !important');
   }


   // Xác nhận thay đổi khung giờ ghi theo lịch của cameras
   function JSconfirmUpdateScheduler(text, cam_id, scheduleres){
    swal({ 
       title: "",   
       text: text,   
       type: "info",   
       showCancelButton: true,     
       confirmButtonText: "Yes",   
       cancelButtonText: "No",   
       closeOnConfirm: false,   
       closeOnCancel: false,
       reverseButtons: true }, 
       function(isConfirm){   
       if (isConfirm) 
       {   
         loading_nomal();
         try{
            $.ajax({
               type: "POST",
               data : {"_token": $('meta[name="csrf-token"]').attr('content'),scheduleres},
               url : "update-scheduler/"+cam_id+"/"+edge_id+"/edge_id",
               success: function(msg){
                  close_loading()
                  if(msg == "true"){
                    $('#calendar-modal').modal('hide');
                    $("#recording"+cam_id).attr("value","2");
                    $("#info-scheduler-"+cam_id).html('&nbsp;<span title="detail" class="icon-storage-detail" onclick="showModes('+cam_id+');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>');
                    notifiSuccess("Update successful.");
                    resetScheduler();
                    $('#status-cam-'+cam_id).html('<span title="configuration is out of date"><i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i></span>')
                  }
                  else if(msg = "mode:0"){
                    close_loading()
                    $("#recording"+cam_id).val(0);
                    $("#recording"+cam_id).attr("value","0");
                    $("#info-scheduler-"+cam_id).html("");
                    $('#calendar-modal').modal('hide');
                    notifiSuccess("Update successful.");
                    resetScheduler();
                    $('#status-cam-'+cam_id).html('<span title="configuration is out of date"><i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i></span>')
                  }
                  swal.close();
               }
            })
         }
         catch(err) {
            $('#scheduler').scheduler('disable');
            $('#calendar-modal').modal('hide');
            resetScheduler();
            console.log(err.message);
            swal.close();
         } 
       } 
       else {   
        swal.close();  
       } 
     });
     $(".btn-primary").css('border', 'none');
     $(".showSweetAlert").attr('style', 'display: block;');
     $(".text-muted").attr('style', 'color: #fff !important');
   }


   // Xác nhận thay đổi trạng thái ghi của nhiều camera
   function JSconfirmChangeModeMulti(text, link, cameras){
     swal({ 
       title: "",   
       text: text,   
       type: "info",   
       showCancelButton: true,     
       confirmButtonText: "Yes",   
       cancelButtonText: "No",   
       closeOnConfirm: false,   
       closeOnCancel: false,
       reverseButtons: true }, 
       function(isConfirm){   
       if (isConfirm) 
       {   
         loading_nomal();
         var csrf = $('meta[name="csrf-token"]').attr('content');
         var form = $('<form action="' + link +'/'+ edge_id + '/edge_id" method="post">' +
           '<input type="hidden" name="_token" value="'+csrf+'">' +
           '<input type="text" name="cameras" value="' + cameras + '" />' +
           '</form>');
         $('body').append(form);
         form.submit();
         swal.close();  
       } 
       else {  
        $("#recording").val(-1);   
        swal.close();  
       } 
     });
     $(".btn-primary").css('border', 'none');
     $(".showSweetAlert").attr('style', 'display: block;');
     $(".text-muted").attr('style', 'color: #fff !important');
   }