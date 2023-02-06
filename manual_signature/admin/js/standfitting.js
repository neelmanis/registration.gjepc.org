$("#Item_ID").live('change',function(){
	Item_ID=$("#Item_ID").val();
	$.ajax({ type: 'POST',
					url: 'standfitting_ajax.php',
					data: "actiontype=getItemDetails&Item_ID="+Item_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
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
	//alert(Item_Data);
	$.ajax({ type: 'POST',
					url: 'standfitting_ajax.php',
					data: "actiontype=saveItemDetails&Item_Data="+Item_Data,
					dataType:'html',
					beforeSend: function(){
						$('#progress').show();
							},
					success: function(data){
						//alert(data);
						console.log(data);
						if(data=="not")
						{
							alert("Please enter less than available quantity");
							return false;
						}
						else
						{
							$('#progress').hide();
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
	Stand_Item_ID=claasArray[1];
	Stand_ID=claasArray[2];
	Payment_Master_ID=claasArray[3];
	Item_Master_ID=claasArray[4];
	$.ajax({ type: 'POST',
					url: 'standfitting_ajax.php',
					data: "actiontype=deleteItemDetails&Stand_Item_ID="+Stand_Item_ID+"&Stand_ID="+Stand_ID+"&Payment_Master_ID="+Payment_Master_ID+"&Item_Master_ID="+Item_Master_ID,
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
	Stand_ID=claasArray[2];
	Exhibitor_Code=claasArray[3];
	con=confirm("Are you sure to delete");
	if(con==true){
	$.ajax({ type: 'POST',
					url: 'standfitting_ajax.php',
					data: "actiontype=deleteOrder&Payment_Master_ID="+Payment_Master_ID+"&Stand_ID="+Stand_ID+"&Exhibitor_Code="+Exhibitor_Code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     location.href='Form3.php?Exhibitor_Code='+$.trim(data);
							}
		});
	}
});



function validate_reason()
{
	//alert($('input[name=\'Info_Approved\']:checked').val());
	//return false;
	if($('input[name=\'Info_Approved\']:checked').val()==undefined)
	{
			alert("Please Select Info Approve or Disapprove");
			document.getElementById('Info_Approved').focus();
			return false;
	}
	if($('input[name=\'Info_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Info Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}
	
	if($('input[name=\'Payment_Master_Approved\']:checked').val()==undefined)
	{
			alert("Please Select Payment Approve or Disapprove");
			document.getElementById('Payment_Master_Approved').focus();
			return false;
	}
	if($('input[name=\'Payment_Master_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Payment_Master_Reason').value=="")
		{
			alert("Please Enter Payment Disapprove Reason");
			document.getElementById('Payment_Master_Reason').focus();
			return false;
		}
	}
	
	//return false;
}


$("#add_item_tmp").live('click',function(){
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
					url: 'standfitting_ajax.php',
					data: "actiontype=addItemDetails&Item_Data="+Item_Data,
					dataType:'html',
					beforeSend: function(){
						$('#progress').show();
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
							var data=data.split("#");
							$('#Applied_Items').html(data[0]);
							$('#paymentDiv').html(data[1]);
						}
							   
							}
		});
 });







