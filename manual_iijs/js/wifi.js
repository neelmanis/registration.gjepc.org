$("#Item_ID").live('change',function(){
	Item_ID=$("#Item_ID").val();
	$.ajax({ type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=getItemDetails&Item_ID="+Item_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								 var data=data.split("#");
								 $('#rate').html(data[0]);
							}
		});
 });


$("#add_item").live('click',function(){
	Item_Data=$("#item_selection").serialize(); 
	if($("#Item_ID").val()=="")
	{
		alert("Please select an Item");
		$("#Item_ID").focus();
		return false;
	}
	if($("#Item_Quantity").val()=="" || $("#Item_Quantity").val()=="0")
	{
		alert("Please enter the quantity");
		$("#Item_Quantity").focus();
		return false;
	}
	$.ajax({ type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=saveItemDetails&Item_Data="+Item_Data,
					dataType:'html',
					beforeSend: function(){
						$('#progress').show();
							},
					success: function(data){
						$('#progress').hide();
						
							$('#item_selection')[0].reset();
							$('#rate').html("0");
							var data=data.split("#");
							$('#Applied_Items').html(data[0]);
							$('#paymentDiv').html(data[1]);
							window.location.href = "wireless_internet_connection.php?action=ADD";
							}
		});
 });

$(".deleteItem").live('click',function(){
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	id=claasArray[1];
	exhibitor_code=claasArray[2];
		if(confirm("Are you sure you want to remove item ?"))  
		{
			$.ajax({ 
					type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=deleteItemDetails&id="+id+"&exhibitor_code="+exhibitor_code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
							     //$("#Applied_Items").html(data);
							     var data=data.split("#");
								 $('#Applied_Items').html(data[0]);
								 $('#paymentDiv').html(data[1]); 
							}
		});
		} 
        else  
        {  
            return false;  
        } 
});