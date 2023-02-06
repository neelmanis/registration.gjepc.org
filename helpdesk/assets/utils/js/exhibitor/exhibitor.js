var filterOptions = function(data){
    data.unique_code = $('#unique_code').val();
    data.subject = $('#subject').val();
   
  };
  
  var columns =  [{"targets": [5],"orderable":false}, {"targets": [0,1,2,3,4],"orderable":true},{"targets":[0,1],"width":120},{"targets":[2],"width":80},{"targets":[3],"width":50},{"targets":[4],"width":50},{"targets":[5],"width":80}];
  
  $(document).ready(function(){
    //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
    table = dataTables("allRIcketsTable",true,true,false,true,true,"exhibitor/getAllTicketRecords",filterOptions,columns,25);
    
  
  
    
    
  });
  
  
  $(document).ready(function(){
          
    $("#ticket-form").on("submit", function(e){
      e.preventDefault();
      $(".error").html("");
      $(".error").css("display", "none");
      var t = new FormData(this);
      $.ajax({
        type: "POST",
        data: t,
        url: CI_ROOT + "exhibitor/addTicketction",
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
            swal({
              title: "Success",
              icon: "success",
              text: result.message
            }).then((value) => {
              window.location.href = CI_ROOT + result.redirect;
            });
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
    
    
    $("#update-ticket-form").on("submit", function(e){
      e.preventDefault();
  
      $(".error").html("");
      $(".error").css("display", "none");
      
      var t = new FormData(this);
      $.ajax({
        type: "POST",
        data: t,
        url: CI_ROOT + "exhibitor/updateTicket",
        mimeType: "multipart/form-data",
        contentType: !1,
        processData: !1,
        dataType: "json",
        beforeSend: function(){
         showLoader();
        },
        success: function(result) {
          hideLoader();
          if(result.status == "success"){
            swal({
              title: "Success",
              icon: "success",
              text: result.message
            }).then((value) => {
              window.location.href = CI_ROOT + result.redirect;
            });
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
  
    $("#category").change(function(){
      var ov = $("#category").val();
      if(ov == "OV"){
        $(".nri_ov_div").show();
        $(".pan-div").hide();
        $(".mobile-div").hide();
      } else {
        $(".nri_ov_div").hide();
        $(".pan-div").show();
        $(".mobile-div").show();
      }
    });
    
    
  });
  
    