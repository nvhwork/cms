var token = '';
var socket = undefined;
var isConnected = false;

var f_cb = undefined;

const f = function(s){
  if (!isConnected || s !== socket){
    return;
  }
  var obj = {edge_id:edge_id};
  var sendStr = JSON.stringify(obj);
  socket.emit('get-device-status', sendStr);
}

function setupSocket(socket, f){
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
  });

  socket.on('new-config-res', function(data){
    console.log(data);
    close_loading();
    notifiSuccess('Configuration applied to Edge devices');
  })

  socket.on('connect_failed', function(){
    setEdgeStatus('loading');
    console.error("conn-failed")
  });

  socket.on('reconnect_failed', function(){
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
