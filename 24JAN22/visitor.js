$("#add_visitor").live('click',function(){
	Item_Data=$("#item_selection").serialize();
	//console.log(Item_Data);return false;
	//alert(Item_Data);return false;
	if($("#visitor_id").val()=="" || $("#visitor_id").val()=="0")
	{
		alert("Please select Visitor");
		$("#visitor_id").focus();
		return false;
	}
	if($("#payment_made_for").val()=="" || $("#payment_made_for").val()=="0")
	{
		alert("Please Select Show");
		$("#payment_made_for").focus();
		return false;
	}
	if($("#check_visitor").val()==1)
	{
		alert("Sorry You can not add more Visitor");
		return false;
	}
	if($("#participation_fee").val()=="")
	{
		alert("Payment is not generated");
		return false;
	}
	
	
	$.ajax({
			type: 'POST',
			url: 'actionAjax.php',
			data: "actiontype=saveVisitorDetails&"+Item_Data,
			dataType:'json',
			beforeSend: function(){
						$('#progress').show();
						},
			success: function(data)
			{	
				$('#progress').hide();
			    $('#item_selection')[0].reset();
				if(data.status=="success"){
                  alert(data.message);
                  window.location.reload();
				}else{
                  alert(data.message);
                  return false;		
				}
			}
		});
 });

$(".deleteOrder").live('click',function(){
	var ref = $(this);
	var currentClass = $(this).attr('class');
	//alert(currentClass);
	var claasArray = currentClass.split(" ");
	v_id=claasArray[1]; //alert(id);
		if(confirm("Are you sure you want to remove this visitor?"))  
		{
			$.ajax({ type: 'POST',
							url: 'actionAjax.php',
							data: "actiontype=deleteItemDetails&v_id="+v_id,
							dataType:'html',
							beforeSend: function(){
									},
							success: function(data){
								//alert(data);
										alert("Visitor has been removed");
										ref.parent("td").parent("tr").fadeOut("slow")						  
									}
				});
		} 
        else  
        {  
            return false;  
        }  

});