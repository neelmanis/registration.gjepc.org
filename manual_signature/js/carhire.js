
$(document).ready(function(){
$("#Hours").change(function(){
	hrs=$(this).val();

	if(hrs=="8"){kilometer=80;}
	if(hrs=="12"){kilometer=100;}
	if(hrs=="8"){$("#Kilometers").val(80);}
	else if(hrs=="12"){$("#Kilometers").val(100);}
	else{$("#Kilometers").val("");}
	Car_Type_ID=$("#Car_Type_ID").val();
	$.ajax({ type: 'POST',
					url: 'carhire_ajax.php',
					data: "actiontype=getPayment&hrs="+hrs+"&kilometers="+kilometer+"&Car_Type_ID="+Car_Type_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							var data=data.split("#");
							$('#Charges').val(data[0]);
							$('#paymentDiv').html(data[1]);
							
							}
		});	
    });

/*
$("#pickup_facility").live('click',function(){ alert("hieeeeeeeeeee");
	/*pickup_facility_amount=$(this).val();
	alert(pickup_facility_amount);
	return false;
});
*/
$(".pickup_facility").click(function(){
  pickup_facility_amount=$(this).val();
  Charges=$("#Charges").val();
  drop_facility=$("drop_facility").val();
  $.ajax({ type: 'POST',
					url: 'carhire_ajax.php',
					data: "actiontype=addpickPayment&pickup_facility_amount="+pickup_facility_amount+"&Charges="+Charges+"&drop_facility="+drop_facility,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							var data=data.split("#");
							$('#paymentDiv').html(data);
							}
		});
	});

$(".drop_facility").click(function(){
  drop_facility_amount=$(this).val();
  Charges=$("#Charges").val();
  pickup_facility=$(".pickup_facility").val();
  //alert(total_amount);
  $.ajax({ type: 'POST',
					url: 'carhire_ajax.php',
					data: "actiontype=adddropPayment&drop_facility_amount="+drop_facility_amount+"&Charges="+Charges+"&pickup_facility="+pickup_facility,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							var data=data.split("#");
							$('#paymentDiv').html(data);
							}
		});
	});

});




