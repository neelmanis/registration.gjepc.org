$(document).ready(function(){
  


  $("#admin_login").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");
    
    var formdata = new FormData(this);
    var postLink = 'login/loginAction';
    postForm(formdata,postLink);
  });
  
});