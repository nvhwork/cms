/*-------------menu-js---------------*/
$( ".text-logo" ).click(function() {
  window.location.href = '/';
});

$("#content").click(function() {
  $(".dropdown-content").css("width", "0px");
  $("#account").attr("status", "1");
  $(".dropdown-content-event").css('display','none');
  $("#dropdown-event").html('');
  $("#events").attr("status", "1");
});


$(".account-header").click(function() {
  if($("#account").attr("status") == '1'){
    $("#account").attr("status", "0");
    $(".dropdown-content").css("width", "225px");
  }
  else{
    $("#account").attr("status", "1");
    $(".dropdown-content").css("width", "0px");
  }
});

var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}

/*---------------------end-menu-js---------------*/

function delete_item() {
  var deletes = document.getElementsByClassName('delete');
  for(i=0; i<deletes.length; i++){
    deletes[i].addEventListener('click', function(e){
      if (confirm("are you sure?")) {
        ip = this.getAttribute('value');
        window.location.href = "deleteDevice/"+ip;
      }
    });
  }
}
delete_item();

function loading() {
  document.getElementById("background-loading").classList.add("background-load");
  document.getElementById("gif_load").removeAttribute("hidden");
}

function menu_close(){
  var key = $("#close-menu").val();
  if(key == 1){
    $("#close-menu").val(0);
    var menu = document.getElementsByClassName('sidenav')[0];
    menu.style.width = "0px";
  }
  else{
    $("#close-menu").val(1);
    var menu = document.getElementsByClassName('sidenav')[0];
    menu.style.width = "230px";
  }
}

function notifi() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}

function notifiWarning(warning){
  var x = document.getElementById("snackbar-warning");
  x.className = "show";
  x.childNodes[2].innerHTML = warning;
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}

function notifiSuccess(success){
  var x = document.getElementById("snackbar");
  x.className = "show";
  x.childNodes[2].innerHTML = success;
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}

function delete_item() {
  var deletes = document.getElementsByClassName('delete');
  for(i=0; i<deletes.length; i++){
    deletes[i].addEventListener('click', function(e){
      if (confirm("* Are you sure you want to delete this camera? ")) {
        ip = this.getAttribute('value');
        window.location.href = "deleteDevice/"+ip;
      }
    });
  }
}
delete_item();

function loading_nomal() {
  $(".lds-roller-div").css("display", "block");
  $(".body-content").addClass("disable-body");
  $("body").css("overflow", "hidden");
  $("#background-black").addClass('show');
  $("#background-black").addClass('modal-backdrop');
}

function close_loading() {
  $(".lds-roller-div").css("display", "none");
  $(".body-content").removeClass("disable-body");
  $("body").css("overflow", "visible");
  $("#background-black").removeClass('show');
  $("#background-black").removeClass('modal-backdrop');
}

function JSconfirm(text, link){
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
      window.location = link; 
      swal.close();  
    } 
    else {     
      swal.close();  
    } 
  });
  $(".btn-primary").css('border', 'none');
  $(".showSweetAlert").attr('style', 'display: block;');
  $(".text-muted").attr('style', 'color: #fff !important');
}

function confirmConfigView(text){
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
      changeStatus();
      swal.close();  
    } 
    else {     
      swal.close();  
    } 
  });
  $(".btn-primary").css('border', 'none');
  $(".showSweetAlert").attr('style', 'display: block; background-image: url(/js-css/img/gray.jpg);');
  $(".text-muted").attr('style', 'color: #fff !important');
}



function JSalert(text){
  swal({ 
    title: "",   
    text: text,   
    type: "warning",         
    closeOnConfirm: false,   
    reverseButtons: true });
  $(".showSweetAlert").attr('style', 'display: block; background-image: url(/js-css/img/gray.jpg);');
  $(".text-muted").attr('style', 'color: #fff !important');
}
