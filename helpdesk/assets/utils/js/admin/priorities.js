var table;
$(document).ready(function(){
  //datatable
  table = $('#PriorityTable').DataTable({
    "paging":   true,
    "scrollX": true,
    // "scrollY": 250,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
      "url": CI_ROOT+'priorities/getPLists',
      "type": "POST",
	  "data": function ( data ) {
        data.status = $('#status').val();
      }
    },
    "columnDefs": [
      { 
        "targets": "_all",
        "orderable": false,
      },
      { "targets": [0], "width":20},
      { "targets": [2], "width":50},
    ],
    dom: 'Bfrtip',
    buttons: []
  });
	
	  $('#btn-filter').click(function(e){ //button filter event click
      e.preventDefault();
      table.ajax.reload();  //just reload table
	  });

	  $('#btn-reset').click(function(e){ //button reset event click
		e.preventDefault();
		$('#form-filter')[0].reset();
		table.ajax.reload();  //just reload table
	  });
	
	jQuery('#title').on('keyup',function(event){
		//var value = String.fromCharCode(event.keyCode).toLowerCase();
		var $this = jQuery(this);

		var text = $this.val();
		text = text.replace(/[&\/\\#, +()$~%.'":;*?<>{}]/g,'-').toLowerCase();
		jQuery('input[name=slug]').val(text);
	});
  
});