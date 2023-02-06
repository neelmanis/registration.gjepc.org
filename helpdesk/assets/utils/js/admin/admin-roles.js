var filterOptions = function(data){};

var columns =  [{"targets": [0,1],"orderable":false}, {"targets": [2,3],"orderable":true},{"targets":[0,1],"width":60},{"targets":[2],"width":200},{"targets":[3],"width":100}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("adminRolesTable",true,true,false,true,true,"admin/roles/getRecords",filterOptions,columns,25);

  var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
  $('.js-switch').each(function() {
    new Switchery($(this)[0], $(this).data());
  });

  $("#add_role").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none");

    var formdata = new FormData(this);
    postForm(formdata,"admin/roles/addAction");
  });

  $("#update_role").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none"); 
    
    var formdata = new FormData(this);
    postForm(formdata,"admin/roles/updateAction");
  });

  $("input[name='selectall']").click(function(e) {
    if($(this).is(':checked')){
      $("input[name='selectedRows[]'").prop('checked', true);
    }else{
      $("input[name='selectedRows[]'").prop('checked', false);
    }
  });
  
});

function deleteRecord(roleId){
  swal({
    title: "Are you sure ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type:'POST',
        data:{id:roleId},
        url:CI_ROOT+"admin/roles/deleteAction",
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
              text: "Record deleted successfully."
            });
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
    }
  });
}