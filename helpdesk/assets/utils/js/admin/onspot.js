var table;
$(document).ready(function(){
		
	$("#onspot-form").on("submit", function(e){
    e.preventDefault();
    $(".error").html("");
    $(".error").css("display", "none");

    var t = new FormData(this);
    $.ajax({
      type: "POST",
      data: t,
      url: CI_ROOT + "onspot/addOnspotAction",
      mimeType: "multipart/form-data",
      contentType: !1,
      processData: !1,
      dataType: "json",
      beforeSend: function(){
        $(".preloader").fadeIn()
      },
      success: function(result) {
        $(".preloader").fadeOut();
        if(result.status == "success"){
          window.location.href = CI_ROOT + "team/lists";
        }else{
          $.each(result, function(e, t) {
            $("label[for='" + e + "']").html(t)
          });
          var t = Object.keys(result);
          $(".error").css("display", "block");
          $('input[name="' + t[0] + '"]').focus();
        }
      }
    })
  });
  
  
  $("#update_team").on("submit", function(e){
    e.preventDefault();
    $(".error").html("");
    $(".error").css("display", "none");

    var t = new FormData(this);
    $.ajax({
      type: "POST",
      data: t,
      url: CI_ROOT + "team/updateTeamAction",
      mimeType: "multipart/form-data",
      contentType: !1,
      processData: !1,
      dataType: "json",
      beforeSend: function(){
        $(".preloader").fadeIn()
      },
      success: function(result) {
        $(".preloader").fadeOut();
        if(result.status == "success"){
          window.location.href = CI_ROOT + "team/lists";
        }else{
          $.each(result, function(e, t) {
            $("label[for='" + e + "']").html(t)
          });
          var t = Object.keys(result);
          $(".error").css("display", "block");
          $('input[name="' + t[0] + '"]').focus();
        }
      }
    })
  });
  
});
