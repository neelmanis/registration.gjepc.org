$(document).ready(function(){

  $("#my_profile").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);

    var postLink = 'admin/updateProfileAction';
    postForm(formdata,postLink);
  });

});