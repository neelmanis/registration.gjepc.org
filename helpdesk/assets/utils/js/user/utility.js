function showLoader(){
  $("#status").fadeIn();       
  $("#preloader").fadeIn();
}

function hideLoader(timeout = 1000,motion='slow'){
  $("#status").fadeOut();       
  $("#preloader").delay(timeout).fadeOut(motion);
}
$(document).on("change", ".uploadType1 input[type='file']", function() {
    $(this).parent("div").siblings(".fakename").remove();
    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
    $(this).parent("div").after('<div class="d-block w-100 fakename mt-3 "><small class="mr-3">' + filename + '</small> <i class=" fa fa-times resetFile" title="Remove selected file"></i></div>');
});
$(document).on("click", ".resetFile", function() {
    $(this).parent(".fakename").siblings('div').children("input").val("");
    $(this).parent(".fakename").remove();
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
        swal({
          title: result.title,
          icon: result.icon,
          text: result.message
        })
        .then((value) => {
          window.location.href = CI_ROOT + result.redirect;
        });
      }else if(result.status == "redirect"){ 
        window.location.href = CI_ROOT + result.redirect;
      }else if(result.status == "report"){  
        window.location.href = CI_ROOT +'excel/'+ result.reportUrl;
      }else if(result.status == "alert"){
        swal({
          title: result.title,
          icon: result.icon,
          text: result.message
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

function deleteBulk(records,postLink){
  $.ajax({
    type : 'POST',
    data : { records : records },
    url : CI_ROOT + postLink,
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
        $("input[name='selectall']").prop('checked', false);
        table.ajax.reload();
      }else if(result.status == "alert"){
        swal({
          title: result.title,
          icon: result.icon,
          text: result.message
        });
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