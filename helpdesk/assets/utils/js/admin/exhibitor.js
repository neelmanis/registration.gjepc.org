$(document).ready(function(){
  


  $("#exhibitor_login").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");
    
    var formdata = new FormData(this);
    var postLink = 'exhibitor/loginAction';
    postForm(formdata,postLink);
  });
  
});