$("#CCTV_Items_Master_ID").live('change',function(){
	CCTV_Items_Master_ID=$("#CCTV_Items_Master_ID").val();
	$.ajax({ type: 'POST',
					url: 'electronic_ajax.php',
					data: "actiontype=getItemDetails&CCTV_Items_Master_ID="+CCTV_Items_Master_ID,
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
	if($("#CCTV_Items_Master_ID").val()=="")
	{
		alert("Please select an Item");
		$("#CCTV_Items_Master_ID").focus();
		return false;
	}
	if($("#Item_Quantity").val()=="" || $("#Item_Quantity").val()=="0")
	{
		alert("Please enter the quantity");
		$("#Item_Quantity").focus();
		return false;
	}
	$.ajax({ type: 'POST',
					url: 'electronic_ajax.php',
					data: "actiontype=saveItemDetails&Item_Data="+Item_Data,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						
						//alert(data);
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
							   //$("#Applied_Items").html(data);
							   var data=$.trim(data);
							    var data=data.split("#");
								//alert(data);
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
					url: 'electronic_ajax.php',
					data: "actiontype=deleteItemDetails&id="+id+"&exhibitor_code="+exhibitor_code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
							     //$("#Applied_Items").html(data);
								 var data=$.trim(data);
							     var data=data.split("#");
								// alert(data);
								 $('#Applied_Items').html(data[0]);
								 $('#paymentDiv').html(data[1]); 
								 
							}
		});

});











