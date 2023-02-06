var filterOptions = function(data){
  data.exhibitor_name = $('#exhibitor_name').val();
  data.unique_code = $('#unique_code').val();
  data.statuses = $('#statuses').val();
};

var columns =  [{"targets": [5],"orderable":false}, {"targets": [0,1,2,3,4],"orderable":true},{"targets":[0,1],"width":120},{"targets":[2],"width":80},{"targets":[3],"width":50},{"targets":[4],"width":50},{"targets":[5],"width":80}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("allVisitorsTable",true,true,false,true,true,"tickets/getAllVisitorsRecords",filterOptions,columns,25);  
});


$(document).ready(function(){
	
	$("#onspot-form").on("submit", function(e){
    e.preventDefault();
    $(".error").html("");
    $(".error").css("display", "none");
    
    var t = new FormData(this);
    $.ajax({
      type: "POST",
      data: t,
      url: CI_ROOT + "tickets/addOnspotAction",
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
          window.location.href = CI_ROOT + "tickets/all_tickets";
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
  
  
  
  $("#update_tickets").on("submit", function(e){
    e.preventDefault();

    $(".error").html("");
    $(".error").css("display", "none");
    
    var t = new FormData(this);
    $.ajax({
      type: "POST",
      data: t,
      url: CI_ROOT + "tickets/updateTicketAction",
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
          window.location.href = CI_ROOT + "tickets/all_tickets";
        } else {
          swal({
              title: "Invalid Request!",
              icon: "error",
              text: "Something went wrong."
            });
        }
      }
    })
  });

});
