var filterOptions = function(data){};

var columns =  [{"targets":[0],"orderable": false}, {"targets":[1,2],"orderable":true},{"targets":[0],"width":60},{"targets":[1],"width":180},{"targets":[2],"width":250}];

$(document).ready(function(){
  //dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,no_of_records)
  table = dataTables("seoTable",true,true,false,true,true,"seo/page",filterOptions,columns,50);

  $("#update_seo").on("submit",function(e){
    e.preventDefault();  
    $(".error").html("");
    $(".error").css("display","none"); 
    
    var formdata = new FormData(this);
    postForm(formdata,"seo/updateAction");
  });
});
