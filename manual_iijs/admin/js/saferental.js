$("#Safe_ID").live('change',function(){
	Safe_ID=$("#Safe_ID").val();
	Exhibitor_Country_ID=$("#Exhibitor_Country_ID").val();
	$.ajax({ type: 'POST',
					url: 'saferental_ajax.php',
					data: "actiontype=getItemDetails&Safe_ID="+Safe_ID+"&Exhibitor_Country_ID="+Exhibitor_Country_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
								 var data=data.split("#");
								 $('#deadline_1').html(data[0]);
								 $('#deadline_2').html(data[1]);
								 $('#deadline_3').html(data[2]);
								 $('#avail_qty').html(data[3]);
							}
		});
 });


$("#add_item").live('click',function(){
	Safe_Data=$("#item_selection").serialize();
	if($("#Safe_ID").val()=="")
	{
		alert("Please select an Item");
		$("#Safe_ID").focus();
		return false;
	}
	if($("#Item_Quantity").val()=="" || $("#Item_Quantity").val()=="0")
	{
		alert("Please enter the quantity");
		$("#Item_Quantity").focus();
		return false;
	}
	$.ajax({ type: 'POST',
					url: 'saferental_ajax.php',
					data: "actiontype=saveItemDetails&Safe_Data="+Safe_Data,
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
							$('#deadline_1').html("0");
							$('#deadline_2').html("0");
							$('#deadline_3').html("0");
							$("#Applied_Items").html(data);
						}
					}
		});
 });

$(".deleteItem").live('click',function(){
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	Safe_Rental_Items_ID=claasArray[1];
	exhibitor_code=claasArray[2];
	Payment_Master_ID=claasArray[3];
	Safe_ID=claasArray[4];
	Safe_Rental_ID=claasArray[5];
	$.ajax({ type: 'POST',
					url: 'saferental_ajax.php',
					data: "actiontype=deleteItemDetails&Safe_Rental_Items_ID="+Safe_Rental_Items_ID+"&exhibitor_code="+exhibitor_code+"&Payment_Master_ID="+Payment_Master_ID+"&Safe_ID="+Safe_ID+"&Safe_Rental_ID="+Safe_Rental_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								//alert(data);
								 $('#Applied_Items').html(data);
							}
		});
});
	
$("#keyperson1").live('change',function(){
	Badge_Item_ID=$("#keyperson1").val();
	Exhibitor_Code=$("#Exhibitor_Code").val();
	$.ajax({ type: 'POST',
	url: 'saferental_ajax.php',
	data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID+"&Exhibitor_Code="+Exhibitor_Code,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#keydesc1").html(data);  
						//alert(data);
			}
	});
});
						   
$("#keyperson2").live('change',function(){
Badge_Item_ID=$("#keyperson2").val();
Exhibitor_Code=$("#Exhibitor_Code").val();
$.ajax({ type: 'POST',
url: 'saferental_ajax.php',
data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID+"&Exhibitor_Code="+Exhibitor_Code,
dataType:'html',
beforeSend: function(){
		   },
success: function(data){
				$("#keydesc2").html(data);  
				//alert(data);
}
});
});

$(".deleteOrder").live('click',function(){
	var currentClass = $(this).attr('class');
	var claasArray = currentClass.split(" ");
	Payment_Master_ID=claasArray[1];
	Safe_Rental_ID=claasArray[2];
	Exhibitor_Code=claasArray[3];
	con=confirm("Are you sure to delete");
	if(con==true){
	$.ajax({ type: 'POST',
					url: 'saferental_ajax.php',
					data: "actiontype=deleteOrder&Payment_Master_ID="+Payment_Master_ID+"&Safe_Rental_ID="+Safe_Rental_ID+"&Exhibitor_Code="+Exhibitor_Code,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
							    location.href='Form9A.php?Exhibitor_Code='+$.trim(data);
							}
		});
	}
});