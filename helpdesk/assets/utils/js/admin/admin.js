var filterOptions = function(data){};

var columns =  [{"targets": [0,1],"orderable":false}, {"targets": [2,3,4,5,6,7],"orderable":true},{"targets":[0],"width":10},{"targets":[1,2],"width":60},{"targets":[3,4,5],"width":150},{"targets":[6,7],"width":100}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("adminTable",true,true,false,true,true,"admin/getRecords",filterOptions,columns,25);

  $("#add_admin").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);
    postForm(formdata,"admin/addAction");
  });

  $("#update_admin").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none"); 
    
    var formdata = new FormData(this);
    postForm(formdata,"admin/updateAction");
  });

  $("input[name='selectall']").click(function(e) {
    if($(this).is(':checked')){
      $("input[name='selectedRows[]'").prop('checked', true);
    }else{
      $("input[name='selectedRows[]'").prop('checked', false);
    }
  });

  $("#delete_records").click(function(e){
    e.preventDefault();
    var count = $("input[name='selectedRows[]']:checked").length;
    var ids = [];
    if(count > 0){
      $.each($("input[name='selectedRows[]']:checked"), function(){            
        ids.push($(this).val());
      });

      var arr = ids.join(",");

      $.ajax({
        type:'POST',
        data:{values:arr},
        url:CI_ROOT+"admin/deleteAction",
        dataType: "json",
        beforeSend:function(){
          showLoader();
        },
        success:function(result){
          hideLoader();
          
          if(result.status == "success"){
            swal({
              title: "Success",
              icon: "success",
              text: "Records deleted successfully."
            });
            $("input[name='selectall']").prop('checked', false);
            table.ajax.reload();   
          }else if(result.status == "invalid"){
            swal({
              title: "Invalid Request!",
              icon: "error",
              text: "Something went wrong."
            });
          }
        }
      });
    }else{
      swal({
        title: "Error",
        icon: "error",
        text: "Select records to delete"
      });
    }
  });

});