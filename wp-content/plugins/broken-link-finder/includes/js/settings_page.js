function nav_popup() {
  document.getElementById("notice_div").style.width = "40%";
  setTimeout(function(){ jQuery('#notice_div').fadeOut('slow'); }, 3000);
}

function error_msg(error) {
jQuery('#moblc_message').empty();
var msg = "<div id='notice_div' class='overlay_error'><div class='popup_text'>&nbsp; &nbsp; "+error+"</div></div>";
jQuery('#moblc_message').append(msg);
window.onload = nav_popup();
}

function success_msg(success) {
jQuery('#moblc_message').empty();
var msg = "<div id='notice_div' class='overlay_success'><div class='popup_text'>&nbsp; &nbsp; "+success+"</div></div>";
jQuery('#moblc_message').append(msg);
window.onload = nav_popup();
}