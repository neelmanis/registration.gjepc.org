var table;

$(document).ready(function(){
  $('#btn-filter').click(function(e){ 
    e.preventDefault();
    table.ajax.reload();  
  });

  $('#btn-reset').click(function(e){ 
    e.preventDefault();
    $('#form-filter')[0].reset();
    table.ajax.reload(); 
  });
});

function dataTables(tableName,paging,scrollX,scrollY,processing,serverside,recordURL,filterData,columns,recordsPerPage){
  
  table = $("#"+tableName).DataTable({ 
    "paging": paging,
    "scrollX": scrollX,
    "scrollY": scrollY,
    "processing": processing, 
    "serverSide": serverside,
    "pageLength": recordsPerPage,
    "order": [], 
    "ajax": {
      "url": CI_ROOT + recordURL,
      "type": "POST",
      "data": filterData
    },
    "columnDefs": columns,
    dom: 'Bfrtip',
    buttons: [],
    "language": {                
      "infoFiltered": ""
    }
  });

  return table;
}

