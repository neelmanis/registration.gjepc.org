$(document).ready(function(){

  $("#loginForm").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);

    var postLink = 'login/loginAction';
    postForm(formdata,postLink);
  });
  $("#registrationForm").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);

    var postLink = 'login/registrationAction';
    postForm(formdata,postLink);
  });
  
  $("#forgetForm").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);

    var postLink = 'login/forgetPasswordAction';
    postForm(formdata,postLink);
  });
  $("#otp_box").hide();


  $("#r_email").on("blur",function(e){
    e.preventDefault();
    let email = $(this).val();

    if (validateEmail(email)) {
        $.ajax({
            type: 'POST',
            data: { email: email },
            url: CI_ROOT + 'login/sendEmailOtp',
            dataType: "json",
            beforeSend:function(){
              showLoader();
            },
            success: function (result) {
              hideLoader();
              swal({
                  title: result.title,
                  icon: result.icon,
                  text: result.message,
                  timer:3000
              }).then(function(){
                $("#otp_box").slideDown();
                $("#r_otp").focus();
              });
            }
        });
        $('label[for="r_email"]').hide().text("");
    } else {
        $(".verified").removeClass("fa fa-check");
        $(this).focus();
        $('label[for="r_email"]').show().text("Please enter valid e-mail address");
    }
   
  });
});

$("#otpVerify").on("click",function(e){
   e.preventDefault();
   let otp = $("#r_otp").val();
   let email = $("#r_email").val();
   if(otp !==""){
      $.ajax({
            type: 'POST',
            data: { email: email,otp:otp },
            url: CI_ROOT + 'login/verifyEmailOtp',
            dataType: "json",
            beforeSend:function(){
              showLoader();
            },
            success: function (result) {
               hideLoader();
              if(result.status=="success"){
                swal({
                  title: result.title,
                  icon: result.icon,
                  text: result.message,
                  timer:3000
                }).then(function(){
                  $("#otp_box").slideUp();
                  $(".verified").addClass("fa fa-check");
                });
              }else{
                swal({
                  title: result.title,
                  icon: result.icon,
                  text: result.message,
                  timer:3000
                }).then(function(){
                  $("#otp_box").slideDown();
                });
              }
              
            }
        });
    }else{
      $('label[for="r_otp"]').show().text("Please enter OTP");
    }

});
function hidePopup () {
  $("#LoginModal").modal('hide');

}
function hideRegistrationPopup () {
  $("#RegisterModal").modal('hide');

}
function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

