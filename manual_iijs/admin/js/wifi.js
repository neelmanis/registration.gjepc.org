$("#Item_ID").live('change',function(){
	Item_ID=$("#Item_ID").val(); 
	
	$.ajax({ type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=getItemDetails&Item_ID="+Item_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
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
							},						
						success: function(data){
						$('#progress').hide();
						
							$('#item_selection')[0].reset();
							$('#rate').html("0");
							var data=data.split("#");
							$('#Applied_Items').html(data[0]);
							$('#paymentDiv').html(data[1]);
							}
		});
 });

$(".deleteItem").live('click',function(){ 
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	WirelessInternet_Items_ID=claasArray[1];
	WireLessInternet_ID=claasArray[2];
	Payment_Master_ID=claasArray[3];
	WirelessInternet_Items_Master_Id=claasArray[4];
	$.ajax({ type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=deleteItemDetails&WirelessInternet_Items_ID="+WirelessInternet_Items_ID+"&WireLessInternet_ID="+WireLessInternet_ID+"&Payment_Master_ID="+Payment_Master_ID+"&WirelessInternet_Items_Master_Id="+WirelessInternet_Items_Master_Id,
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
	WireLessInternet_ID=claasArray[2];
	Exhibitor_Code=claasArray[3];
	con=confirm("Are you sure to delete");
	if(con==true){
	$.ajax({ type: 'POST',
					url: 'wifi_ajax.php',
					data: "actiontype=deleteOrder&Payment_Master_ID="+Payment_Master_ID+"&WireLessInternet_ID="+WireLessInternet_ID+"&Exhibitor_Code="+Exhibitor_Code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     location.href='Form7.php?Exhibitor_Code='+$.trim(data);
							}
		});
	}
});