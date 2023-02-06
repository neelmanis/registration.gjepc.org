$(document).ready(function(){
  
  $('[data-toggle="tooltip"]').tooltip()

  $("#admin_login").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");
    
    var formdata = new FormData(this);
    var postLink = 'admin/loginAction';
    
    postForm(formdata,postLink);
  });
  
});