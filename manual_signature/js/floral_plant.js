$("#Floral_Items_Master_ID").live('change',function(){
	Floral_Items_Master_ID=$("#Floral_Items_Master_ID").val();
	$.ajax({ type: 'POST',
					url: 'floral_ajax.php',
					data: "actiontype=getItemDetails&Floral_Items_Master_ID="+Floral_Items_Master_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						         //alert(data);
								 var data=data.split("#");
								 $('#avail_qty').html(data[0]);
								 $('#rate').html(data[1]);
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
					url: 'floral_ajax.php',
					data: "actiontype=saveItemDetails&Item_Data="+Item_Data,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						if(data=="not")
						{
							alert("Please enter less than available quantity");
							return false;
						}
						else
						{
							$('#item_selection')[0].reset();
							$('#avail_qty').html("0");
							$('#rate').html("0");
							var data=data.split("#");
							$('#Applied_Items').html(data[0]);
							$('#paymentDiv').html(data[1]);
						}
							   
							}
		});
 });

$(".deleteItem").live('click',function(){
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	id=claasArray[1];
	exhibitor_code=claasArray[2];
	$.ajax({ type: 'POST',
					url: 'floral_ajax.php',
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

});











