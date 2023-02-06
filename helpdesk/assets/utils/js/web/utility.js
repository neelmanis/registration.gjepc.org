function showLoader(){
  $("#status").fadeIn();       
  $("#preloader").fadeIn();
}

function hideLoader(){
  $("#status").fadeOut();       
  $("#preloader").fadeOut();
}


//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example

//user is "finished typing," do something



function getSearchResult () {
  $("#showSearchResults").show();
  $(".about_listing").empty().hide();
  
  let searchInput = $("#searchInput").val();

  $(".search_text").show().empty().append('Serching for '+searchInput+' ...');
  
  if( searchInput !== "" ){
    $.ajax({
      type : 'POST',
      data : { searchInput:searchInput},
      url : CI_ROOT + 'api/scheme/search',
      dataType: "json",
      success:function(result){
       if(result.status == "success"){
          $(".search_text").empty().hide();
          $(".about_listing").show().empty().append( result.response );
        }else{
          $(".search_text").empty().append("No records");
          $(".about_listing").empty().hide();
        }
      }
    });
  }else{
    $(".search_text").empty().hide();
    $(".about_listing").empty().hide();
    $("#showSearchResults").hide();
  }
}

$(document).ready(function(){
  // document.getElementById("search-form").reset();
  // $(document).on("change",".uploadType1 input[type='file']",function(){
  //   $(this).parent("div").siblings(".fakename").remove();
  //   var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
  //   $(this).parent("div").after('<div class="d-block w-100 fakename mt-3 "><small class="mr-3">'+filename+'</small> <i class=" fa fa-times resetFile" title="Remove selected file"></i></div>');
  // });
  // $(document).on("click", ".resetFile", function(){
  //   $(this).parent(".fakename").siblings('div').children("input").val("");
  //   $(this).parent(".fakename").remove();
  // });
  
  //on keyup, start the countdown
  $("#searchInput").on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(getSearchResult, doneTypingInterval);
  });

  //on keydown, clear the countdown 
  $("#searchInput").on('keydown', function () {
    clearTimeout(typingTimer);
  });

  $(".search_btn search cancel").on('click', function () {
    $(".search_text").empty().hide();
    $(".about_listing").empty().hide();
    $("#showSearchResults").hide();
  });

  $("#contactEnquiry").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");
    
    let formdata = new FormData(this);

    $.ajax({
      type : 'POST',
      data : formdata,
      url : CI_ROOT + 'api/contact/enquiry',
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend:function(){
        showLoader();
      },
      success:function(result){
        hideLoader();
  
        if(result.status == "success"){
          swal({
            title: result.title,
            icon: result.icon,
            text: result.message
          });
          $("#contactEnquiry")[0].reset();
        }else{
          $.each(result, function(i, v) {
            $("label[for='"+i+"']").html(v);
          });
                    
          var keys = Object.keys(result);
          $(".error").css("display","block");
          $('label[for="'+keys[0]+'"]').focus();
        }
      }
    });
  });

  $("#careerEnquiry").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");
    
    let formdata = new FormData(this);

    $.ajax({
      type : 'POST',
      data : formdata,
      url : CI_ROOT + 'api/career/enquiry',
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend:function(){
        showLoader();
      },
      success:function(result){
        hideLoader();
  
        if(result.status == "success"){
          swal({
            title: result.title,
            icon: result.icon,
            text: result.message
          });
          $("#careerEnquiry")[0].reset();
        }else{
          $.each(result, function(i, v) {
            $("label[for='"+i+"']").html(v);
          });
                    
          var keys = Object.keys(result);
          $(".error").css("display","block");
          $('label[for="'+keys[0]+'"]').focus();
        }
      }
    });
  });
});

function postForm(formdata,postLink){
  $.ajax({
    type:'POST',
    data:formdata,
    url: CI_ROOT + postLink,
    mimeType : 'multipart/form-data',
    contentType: false,
    processData: false,
    dataType: "json",
    beforeSend:function(){
      showLoader();
    },
    success:function(result){
      hideLoader();

      if(result.status == "success"){
        if(typeof result.redirect !="undefined"){
          swal({
            title: result.title,
            icon: result.icon,
            text: result.message,
            buttons:false,
            timer: 3000
          })
          .then((value) => {
            window.location.href = CI_ROOT + result.redirect;
          });
        }else{
          swal({
            title: result.title,
            icon: result.icon,
            text: result.message,
            buttons:false,
            timer: 3000
          });
        }
        
      }else if(result.status == "redirect"){ 
        window.location.href = CI_ROOT + result.redirect;
      }else if(result.status == "report"){  
        window.location.href = CI_ROOT +'excel/'+ result.reportUrl;
      }else if(result.status == "alert"){
        swal({
          title: result.title,
          icon: result.icon,
          text: result.message,
        
          timer: 3000
        });
      }else{
        $.each(result, function(i, v) {
          $("label[for='"+i+"']").html(v);
        });
        var keys = Object.keys(result);
        $(".error").css("display","block");
        $('input[name="'+keys[0]+'"]').focus();
      }
    }
  });
}

function confirmPostData(data,postLink,callback){
  swal({
        title: "Are you sure!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
        $.ajax({
          type:'POST',
          data:data,
          url: CI_ROOT + postLink,
          dataType: "json",
          beforeSend:function(){
            showLoader();
          },
          success:function(result){
            hideLoader();
            callback(result);
          }
        });
      }
  });
}