
$("#required_car_passes").live('change',function(){
	required_car_passes=$(this).val();
	//alert(required_car_passes);
		$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=getCarFields&required_car_passes="+required_car_passes,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								 $('#carno_div').html(data);
							}
		});
});

$("#Badge_Mobile_No").live('blur',function(){
	console.log("error");
	mobile_no=$(this).val();
	//alert(mobile_no);
	 //var n = mobile_no.length;
		$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=checkMobileno&mobile_no="+mobile_no,
					dataType:'html',
					beforeSend: function(){
							$(".loader").show();
							},
					success: function(data){
								//alert(data);
								console.log(data);
								$(".loader").hide();
								if(data==0){
									alert("Mobile no already taken..!!");
									$('#addbadge').attr("disabled", 'disabled');
								}else{
									$('#addbadge').removeAttr("disabled");
								}
							}
		});
});


$('#addbadge').live('click', function(){ 	  								  
	var option=document.getElementsByName('Badge_Type');
	var Badge_Type = $("input[name='Badge_Type']:checked"). val();
	//alert(Badge_Type);
	if (!(Badge_Type=="M" || Badge_Type=="E" || Badge_Type=="R" || Badge_Type=="S")) {
		alert("Please choose a badge type");
		$("#Badge_Type").focus();
		return false;
	}
		
	if(Badge_Type=="R"){
		if($("#RBadge_Item_ID").val()==""){
			alert("Select badge to be replace");
			$("#RBadge_Item_ID").focus();
			return false;	
		}
	}
	//alert($("#Badge_Name").val());
	if($("#Badge_Name").val()=="")
	{
			alert("Please enter Badge Name");
			$("#Badge_Name").focus();
			return false;
	}
	if($("#Badge_Designation").val()=="")
	{
			alert("Please select Designation");
			$("#Badge_Designation").focus();
			return false;
	}
	if($("#Badge_Mobile_No").val()=="")
	{
			alert("Please enter Mobile No.");
			$("#Badge_Mobile_No").focus();
			return false;
	}
	if ($("#Badge_Mobile_No").val().length < 10 || $("#Badge_Mobile_No").val().length > 10) {
		alert("Mobile No. is not valid, Please Enter 10 Digit Mobile No.");
		return false;
	}
	Exhibitor_Code=$("#Exhibitor_Code").val();
	if($("#photoimg").val()=="")
	{
			alert("Please upload badge image");
			$("#photoimg").focus();
			return false;
	}
	
	if($("#document").val()=="")
	{
			alert("Please upload badge docuemnt proof");
			$("#document").focus();
			return false;
	}
	
	var fup = document.getElementById('photoimg');
	var file = fup.files[0];
    if (file.size > 2097152) {
       alert('Filesize must 2mb or below'); // don't want alert message
	   return false;
    }
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1); 
	if(ext=="jpg" || ext=="JPG" || ext=="png" || ext=="PNG" || ext=="jpeg")
    {
    }
    else
    {
        alert("Upload jpg,png files only");
        return false;
    }
	
	var fup = document.getElementById('document');
	var file = fup.files[0];
    if (file.size > 2097152) {
       alert('Filesize must 2mb or below'); // don't want alert message
	   return false;
    }
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1); 
	if(ext=="jpg" || ext=="JPG" || ext=="png" || ext=="PNG" || ext=="jpeg")
    {
    }
    else
    {
        alert("Upload jpg,png files only");
        return false;
    }
	
	if(Badge_Type=="E")
	{
		if($("#check_exhibitor").val()==1)
		{
				alert("Sorry You can not add more Exhibitor badges");
				return false;
		}
	}
	if(Badge_Type=="S")
	{
		if($("#check_service").val()==1)
		{
				alert("Sorry You can not add more Temporary badges");
				return false;
		}
	}
	if(Badge_Type=="M")
	{
		if($("#check_exhibitor").val()==0){
			alert("Kindly Avail Exhibitor Badge to apply Additional Badge");
			return false;	
		}
		else if($("#check_management").val()==1)
		{
				alert("Sorry You can not add more Additional badges");
				//location.href = "exhibitors_tmp_badges.php";
				return false;
		}
	}
	if(Badge_Type=="R")
	{
		if($("#check_replacement").val()==1)
		{
				alert("Sorry You can not add more Replacement badges");
				return false;
		}
	}	
	document.getElementById('addbadge').disabled=true;
	document.getElementById('addbadge').value='Submitting, please wait...';
	$("#badgeForm").ajaxForm({
				success : function (data) {
					console.log(data);
						location.href = "exhibitors_tmp_badges.php";
				}
}).submit();
});

$('#badge_final').live('click', function(){
CarPass1=$('#CarPass1').val();
CarPass2=$('#CarPass2').val();

if(CarPass1=="")
{
	alert("Please enter carpass");
	$('#CarPass1').focus();
	return false;
}
Exhibitor_Code=$('#Exhibitor_Code').val();
Collection_Mode=$('#Collection_Mode').val();


$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=addExhBadges&Payment_Mode_ID="+Payment_Mode_ID+"&Exhibitor_Code="+Exhibitor_Code+"&Collection_Mode="+Collection_Mode+"&CarPass1="+CarPass1+"&CarPass2="+CarPass2,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							console.log(data);
							/*var data=data.split("#");
							$('#Charges').val(data[0]);
							$('#paymentDiv').html(data[1]);*/
							location.href = "exhibitors_badges.php"							
							}
		});
});

$('#update_address').live('click', function(){
	
Exhibitor_Code=$('#Exhibitor_Code').val();
Badge_Addres=$('#Badge_Addres').val();
if(Badge_Addres==""){alert("Enter Badges Address");	$('#Badge_Addres').focus();return false;}

Badge_Country=$('#Badge_Country').val();
if(Badge_Country==""){alert("Enter Badges Country");$('#Badge_Country').focus();return false;}

Badge_City=$('#Badge_City').val();
if(Badge_City==""){alert("Enter Badges City");$('#Badge_City').focus();return false;}

Badge_Pincode=$('#Badge_Pincode').val();
if(Badge_Pincode==""){alert("Enter badges pincode");$('#Badge_Pincode').focus();return false;}

Badge_State=$('#Badge_State').val();
if(Badge_State==""){alert("Enter Badges State");$('#Badge_State').focus();return false;}

Badge_Mobile=$('#Badge_Mobile').val();
if(Badge_Mobile==""){alert("Enter Badges Mobile");$('#Badge_Mobile').focus();return false;}

Exhibitor_Code=$('#Exhibitor_Code').val();

$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=updateBadges&Exhibitor_Code="+Exhibitor_Code+"&Badge_Addres="+Badge_Addres+"&Exhibitor_Code="+Exhibitor_Code+"&Badge_Country="+Badge_Country+"&Badge_City="+Badge_City+"&Badge_Pincode="+Badge_Pincode+"&Badge_State="+Badge_State+"&Badge_Mobile="+Badge_Mobile,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							console.log(data);
							location.href = "exhibitors_badges.php"
						}
		});
});
