<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Center Management System</title>
        <link rel="icon" type="image/ico" href="js-css/img/title_logo.png" />
        <base href="{{asset('')}}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="js-css/css/bootstrap.min.css">
        <script src="js-css/js/jquery.min.js"></script>
        <script src="js-css/js/popper.min.js"></script>
        <script src="js-css/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="js-css/font/font-awesome.min.css">
        @if(Auth()->user()->display == 1)
            <link rel="stylesheet" href="js-css/css/css.css">
        @else
            <link rel="stylesheet" href="js-css/css/css2.css">
        @endif
        <script src="js-css/js/jquery.dataTables.min.js"></script>
        <script src="js-css/js/sweetalert.js"></script>
        <link rel="stylesheet" href="js-css/css/sweetalert.css">

        @yield('header')
    </head>
    <body>
        <div class="lds-roller-div">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <a id="loading-nomal" class="loading-nomal">
        <img id="gif_load" src="js-css/img/loading2.gif" width="50" height="50">
        </a>
        <div class="body-content">
            <div class="header-camera dropdown1">
                <div class="dropdown">
                    <div class="back">
                        <a href="/">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="text-title">
                        <span>{{$title}}</span>
                    </div>
                    <input hidden="" id="close-menu" value="0">
                    <div class="close-menu user1" onclick="menu_close();">
                        <i class="fa fa-outdent" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="sidenav">
                <div style="width: 230px;">
                    <button class="dropdown-btn item-menu"><i class="fa fa-video-camera" aria-hidden="true"></i> &nbsp; <span class="option-text">Device Management <i class="fa fa-caret-down"></i></span></button>
                    <div class="dropdown-container">
                        <a href="/camera-list" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Cameras</span></a>
                        <a href="/edge-list" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">DASCAM Edges AI</span></a>
                        <!-- <a href="/proxylist" class="item-menu item-chil"><i class="fa fa-circle-o"></i> DASCAM Protect</a> -->
                        <a href="/nvrlist" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">DASCAM Edge Storage</span></a>
                        <!-- <a href="/kafka-broker" class="item-menu item-chil"><i class="fa fa-circle-o"></i> DASCAM Kafka Broker</a> -->
                    </div>
                    <a href="accountlist" id="account-management" class="item-menu"><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <span class="option-text">User Management</span></a>
                    <a href="/firmwareversion" class="item-menu"><i class="fa fa-info-circle text-red"></i> &nbsp; <span class="option-text">Firmware version</span></a>
                    <a href="/changepassword" class="item-menu"><i class="fa fa-unlock-alt white-color"></i> &nbsp; <span class="option-text">Change the password</span></a>
                    <a href="/logoutkms" class="item-menu"><i class="fa fa-sign-out white-color"></i> &nbsp; <span class="option-text">Logout</span></a>
                </div>
            </div>
            <div id="content">
                @yield('content')
            </div>
        </div>
        <div class="setting">
            
        </div>
        <div id="background-black"></div>
        <script>
            $(".event-class").click(function() {
              $(".exists-noti").attr("hidden",true);
              eventWatched();
              if($("#events").attr("status") == '1'){

                $.ajax({
                  url: 'getevents/'+{!! Auth()->user()->id !!},
                  success: function(data) {
                    for(var i=0; i<data.length; i++){
                        var a = document.createElement("a");
                        a.classList.add('white-color');
                        a.setAttribute("href", "#");
                        a.innerHTML = 
                            '<div class="user-setting">'+
                                '<small><i class="fa fa-exclamation-triangle text-danger"></i> &nbsp;'+ data[i].event +'</small>'+ 
                                '<small style="display:block;"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;'+ data[i].created_at +'</small>'       
                            '</div>';
                        document.getElementById("dropdown-event").appendChild(a);
                    }            
                  }
                });

                $("#events").attr("status", "0");
                $(".dropdown-content-event").css('display','block');
              }
              else{
                $("#events").attr("status", "1");
                $(".dropdown-content-event").css('display','none');
                $("#dropdown-event").html('');
              }
            });
        </script>

        <!-- <script type="text/javascript" src="js-css/js/socket.io.js"></script>
        <script>
        var socket = io('localhost:6001')
        socket.on('kafka',function(data){
          console.log(data);
        })
        </script> -->


        <script>
            function eventWatched(){
                $.ajax({
                url: 'eventwatched',
                success: function(data) {
                        
                }
            });
            }
        </script>
        <script src="js-css/js/script.js"></script>
        <script src="js-css/js/config.js"></script>
    </body>
</html>

<style type="text/css">
    @media (max-width: 760px){
        .text-title {
            text-shadow: none;
            float: none;
            font-size: 1.3rem;
            margin-top: 3px;
            color: #c0c0c0;
        }

        .row-content {
            margin: 0px 0px!important;
        }

        .list-frame-liveview {
            margin-top: 0px;
            margin-bottom: 100px;
        }

        .camera-button {
            display: grid;
            font-size: 1.6rem;
            margin: 5px;
        }

        .content-camera {
            margin-bottom: 60px!important;

        }
    }

    .content-camera, .content-camera:before, .main-footer-camera, .main-footer-camera:before {
        overflow: auto;
        margin-top: 50px;
    }

    .header-camera{
        text-align: center;
        height: 50px;
    }

    .close-menu {
        position: absolute;
        display: inline;
        padding-top: 0px;
        font-size: 1.6rem;
        right: 0px;
        left: unset;
        top: -5px;
        color: #b0b0b0;
        margin-right: 15px;
    }

    .sidenav {
        margin-top: 50px;
        padding-top: 0px;
        right: 0;
        left: auto;
    }

    .sidenav a {
        border-top: 1px solid #444444;
        border-bottom: 1px solid #444444;
    }

    .sidenav a.item-chil {
        border-top: 0px;
    }

    .row-title-proxy {
        position: fixed;
        right: 0px;
        left: 0px;
        bottom: 0px;
        z-index: 2;
        background: #1f1f1f;
        margin-bottom: 0px;
        padding: 5px;
        display: flex;
    } 

    .proxy-add {
        font-size: 1.6rem;
        float: none;
        margin: 5px;
    }

    .option-bottom {
        display: flex;
        margin: 0px auto;
    }

    .back {
        position: absolute;
        display: inline;
        padding-top: 0px;
        font-size: 1.6rem;
        left: 0px;
        top: -12px;
        color: #b0b0b0;
        margin: 10px;
        margin-left: 15px;
    }

    .form-camera {
        width: 100%;
    }

    #zone .modal-dialog {
       top: 0px;
    }

    .modal-dialog {
        height: 100vh;
        width: 100vw;
        margin: 0px;
    }

    .modal-content {
        width: 100%;
        height: 100%;
    }

    .select-profile{
        font-size: 1rem;
    }

</style>