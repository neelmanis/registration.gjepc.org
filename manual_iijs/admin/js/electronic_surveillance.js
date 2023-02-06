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
	CCTV_Items_ID=claasArray[1];
	CCTV_ID=claasArray[2];
	Payment_Master_ID=claasArray[3];
	CCTV_Items_Master_ID=claasArray[4];
	$.ajax({ type: 'POST',
					url: 'electronic_ajax.php',
					data: "actiontype=deleteItemDetails&CCTV_Items_ID="+CCTV_Items_ID+"&CCTV_ID="+CCTV_ID+"&Payment_Master_ID="+Payment_Master_ID+"&CCTV_Items_Master_ID="+CCTV_Items_Master_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								 //alert(data);
							     var data=data.split("#");
								 $('#Applied_Items').html(data[0]);
								 $('#paymentDiv').html(data[1]); 
							}
		});
});


$(".deleteOrder").live('click',function(){
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	Payment_Master_ID=claasArray[1];
	CCTV_ID=claasArray[2];
	Exhibitor_Code=claasArray[3];
	con=confirm("Are you sure to delete");
	if(con==true){
	$.ajax({ type: 'POST',
					url: 'electronic_ajax.php',
					data: "actiontype=deleteOrder&Payment_Master_ID="+Payment_Master_ID+"&CCTV_ID="+CCTV_ID+"&Exhibitor_Code="+Exhibitor_Code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     location.href='Form8.php?Exhibitor_Code='+$.trim(data);
							}
		});
	}
});
