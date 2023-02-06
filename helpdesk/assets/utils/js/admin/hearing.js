var filterOptions = function(data){};

var columns =  [{"targets": [0,3,5],"orderable":false}, {"targets": [1,2,4,6],"orderable":true},{"targets":[0],"width":50},{"targets":[1,2],"width":80},{"targets":[3],"width":200},{"targets":[4,5,6],"width":80}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("hearingTable",true,true,false,true,true,"hearing/page",filterOptions,columns,25);

  $(".host").hide();
  $(".reason").hide();

  //disable previous date
  var dtToday = new Date(); 
  var month = dtToday.getMonth() + 1;
  var day = dtToday.getDate();
  var year = dtToday.getFullYear();
  if(month < 10)
      month = '0' + month.toString();
  if(day < 10)
      day = '0' + day.toString();
  
  var maxDate = year + '-' + month + '-' + day;
  $('#date').attr('min', maxDate);
  ///end

  $('#time').timepicker();

  $(".host").hide();
  $(".reason").hide();
  $("#hearingModal").click(function(event){ 
    event.preventDefault();
    $("#meetingRequest").modal();
  });

   $("#meetingRequestForm").on("submit",function(e){
    e.preventDefault();        
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);
    var postLink = 'hearing/create';
    postForm(formdata,postLink);
  });
   
  $("#action").on("change",function(){
    let status = $("#action").val();

    if( status == "rejected" ){
      $(".host").hide();
      $(".reason").show();
      $("#reason").val("");
      $("#reason").focus();
    }else if( status == "accepted" ){
      $("#reason").val("");
      $(".reason").hide();
      $(".host").show();
    }else{
      $("#reason").val("");
      $(".reason").hide();
      $(".host").hide();
    }
  });

  $("#meetingDetails").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);
    postForm(formdata,"hearing/upadteAction");
  });
});