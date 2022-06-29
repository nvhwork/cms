<!doctype html>
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
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
        <link rel="stylesheet" href="js-css/css/css.css">
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
                    <div class="text-logo">
                        DASCAM CMS
                    </div>
                    <input hidden="" id="close-menu" value="0">
                    <div class="close-menu" onclick="menu_close();">
                        <i class="fa fa-outdent" aria-hidden="true"></i>
                    </div>
                    <?php
                        if (isset($_SESSION['username'])) {
                            $usr = $_SESSION['username'];
                            echo '  <div class="user1" id="account" status="1">
                                        <span class="header-item account-header">
                                            ' . $usr . ' &nbsp;<i class="fa fa-user" aria-hidden="true"></i>
                                        </span>
                                    </div>  
                                    <div class="dropdown-content">
                                        <div class="user-login user-name">
                                            <span class="span-avatar"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;' . $usr . '</span>
                                        </div>
                                        <a href="change-password" class="white-color">
                                            <div class="user-setting">
                                                <small><i class="fa fa-unlock-alt white-color"></i> &nbsp;Change the password</small>
                                            </div>
                                        </a>
                                        <a href="api/logout" class="white-color">
                                            <div class="user-setting">
                                                <small><i class="fa fa-sign-out white-color"></i> &nbsp;Logout</small>
                                            </div>
                                        </a>
                                    </div>  ';
                        } else {
                            echo '  <div class="user1" status="1">
                                        <span class="header-item account-header">
                                            <a href="login" class="white-color">
                                                Sign in &nbsp;<i class="fa fa-sign-in white-color"></i>
                                            </a>
                                        </span>
                                    </div>  ';
                        }
                    ?>
                    
                    
                    <!-- <div class="dropdown-content-event">
                        <div id="dropdown-event">

                        </div>
                        <a href="/listevent/37" class="white-color">
                            <div style="text-align: center;">
                                <div class="user-setting">
                                    <small>
                                        <i class="fa fa-folder-open-o white-color"></i> &nbsp;See All
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div> -->
                </div>
            </div>
            <div class="sidenav">
                <div style="width: 230px;">
                    <a href="/" class="item-menu"><i class="fa fa-home" aria-hidden="true"></i> &nbsp; <span class="option-text">Home</span></a>
                    <button class="dropdown-btn item-menu">
                        <i class="fa fa-video-camera" aria-hidden="true"></i> &nbsp; 
                        <span class="option-text">Device Management <i class="fa fa-caret-down"></i></span>
                    </button>
                    <div class="dropdown-container">
                        <a href="/cameras" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Cameras</span></a>
                        <a href="/streams" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Streams</span></a>
                        <!-- <a href="/edge-list" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">DASCAM Edges AI</span></a>
                        <a href="/nvrlist" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">DASCAM Edge Storage</span></a> -->
                    </div>
                    <!-- <a href="accountlist" id="account-management" class="item-menu"><i class="fa fa-user" aria-hidden="true"></i> &nbsp; <span class="option-text">User Management</span></a>
                    <a href="/firmwareversion" class="item-menu"><i class="fa fa-info-circle text-red"></i> &nbsp; <span class="option-text">Firmware version</span></a>
                    <button class="dropdown-btn item-menu"><i class="fa fa-bell" aria-hidden="true"></i> &nbsp; <span class="option-text">Notifications <i class="fa fa-caret-down"></i></span></button>
                    <div class="dropdown-container">
                        <a href="/event-detect-zone/0/<?php echo date("Y-m-d"); ?>/<?php echo date("Y-m-d",strtotime("+1 day")) ?>" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Restricted zones</span></a>
                        <a href="/face-recognition/0/<?php echo date("Y-m-d"); ?>/<?php echo date("Y-m-d",strtotime("+1 day")) ?>" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Face Recognition</span></a>
                        <a href="/event-burning-smoke" class="item-menu item-chil"><i class="fa fa-circle-o"></i> <span class="option-text">Burning smoke</span></a>
                    </div> -->
                    <a href="/demo-hls" class="item-menu"><i class="fa fa-desktop" aria-hidden="true"></i> &nbsp; <span class="option-text">Monitor</span></a>
                    <a href="/accounts" class="item-menu"><i class="fa fa-group" aria-hidden="true"></i> &nbsp; <span class="option-text">User Management</span></a>
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
                  url: 'getevents/1',
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