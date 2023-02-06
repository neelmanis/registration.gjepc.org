var filterOptions = function(data){};

var columns =  [{"targets": [0],"orderable":false}, {"targets": [1,2,3,4,5],"orderable":true},{"targets":[0],"width":50},{"targets":[1],"width":80},{"targets":[2],"width":200},{"targets":[3],"width":200},{"targets":[4],"width":150},{"targets":[5],"width":80}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("userTable",true,true,false,true,true,"user/page",filterOptions,columns,25);

   $("#update_users").on("submit", function(e) {
        e.preventDefault();
        $(".error").html("");
        $(".error").css("display", "none");

        var formdata = new FormData(this);
        postForm(formdata, "user/updateAction");
    });
   
});