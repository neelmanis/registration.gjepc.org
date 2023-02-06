
$('#addbadge').live('click', function(){ 
	if($('#Badge_Addres').val()=="")
	{
		alert("Please enter address");
		$("#Badge_Addres").focus();
		return false;
	}	
	if($('#Badge_Country').val()=="")
	{
		alert("Please enter country");
		$("#Badge_Country").focus();
		return false;
	}	
	if($('#Badge_City').val()=="")
	{
		alert("Please enter city");
		$("#Badge_City").focus();
		return false;
	}	
	if($('#Badge_Pincode').val()=="")
	{
		alert("Please enter pincode");
		$("#Badge_Pincode").focus();
		return false;
	}	
	if($('#Badge_State').val()=="")
	{
		alert("Please enter state");
		$("#Badge_State").focus();
		return false;
	}	
	if($('#Badge_Mobile').val()=="")
	{
		alert("Please enter mobile");
		$("#Badge_Mobile").focus();
		return false;
	}								  								  
	if ($('#Badge_Type').is(':checked') || $('#Badge_Type1').is(':checked') || $('#Badge_Type2').is(':checked')) 
	{
	}	  
	else
	{
			alert("Please choose a badge type");
			$("#Badge_Type").focus();
			return false;
	}
	if($("#Badge_Name").val()=="")
	{
			alert("Please enter Badge Name");
			$("#Badge_Name").focus();
			return false;
	}
	if($("#Badge_Designation").val()=="")
	{
			alert("Please enter Designation Name");
			$("#Badge_Designation").focus();
			return false;
	}
	if($("#Badge_Mobile_No").val()=="")
	{
			alert("Please enter Mobile No.");
			$("#Badge_Mobile_No").focus();
			return false;
	}
	if(isNaN($("#Badge_Mobile_No").val()))
	{
			alert("Please enter No. Only");
			$("#Badge_Mobile_No").focus();
			return false;
	}
	Exhibitor_Code=$("#Exhibitor_Code").val();
	if($("#photoimg").val()=="")
	{
			alert("Please upload image");
			$("#photoimg").focus();
			return false;
	}
	
	var fup = document.getElementById('photoimg');
	//var fsize=document.getElementById('photoimg').size;
	/*alert(fsize/1024);*/
	var file = fup.files[0];
    if (file.size > 2097152) {
         //Now Here I need to update <span> 

       alert('Filesize must 2mb or below'); // don't want alert message
	   return false;
    }
	//return false;
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1); 
	if(ext =="GIF" || ext=="gif" || ext=="jpg" || ext=="JPG" || ext=="png" || ext=="PNG" || ext=="jpeg")
    {
    }
    else
    {
        alert("Upload Jpg,Gif,Png files only");
        return false;
    }
	

	Badge_Type=$("input[type='radio'][name='Badge_Type']:checked").val();
	if(Badge_Type=="S")
	{
		if($("#check_services").val()==1)
		{
			alert("Sorry You can add more Maintenance badges");
			location.href = "exhibitors_badges.php";
			return false;
		}
	}
	if(Badge_Type=="E")
	{
		if($("#check_exhibitor").val()==1)
		{
				alert("Sorry You can add more Exhibitor badges");
				location.href = "exhibitors_badges.php";
				return false;
		}
	}
	if(Badge_Type=="M")
	{
		if($("#check_management").val()==1)
		{
				alert("Sorry You can add more Management badges");
				location.href = "exhibitors_badges.php";
				return false;
		}
	}
	$("#badgeForm").ajaxForm({
				success : function (data) {
					//alert(data);
					if(data=="update")
					{
						location.href = "exhibitors_badges.php?badges=update";
					}
					else
					{
						location.href = "exhibitors_tmp_badges.php";
					}
					
				}
}).submit();
});

$('#badge_final').live('click', function(){
check_Payment_Mode=$('#check_Payment_Mode').val();
if(check_Payment_Mode>0){
Payment_Mode_ID=$("input[type='radio'][name='Payment_Mode_ID']:checked").val();
if (typeof Payment_Mode_ID === 'undefined') {
   alert("Please choose payment mode");
   return false;
}
}
Exhibitor_Code=$('#Exhibitor_Code').val();
Collection_Mode=$('#Collection_Mode').val();


$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=addBadges&Payment_Mode_ID="+Payment_Mode_ID+"&Exhibitor_Code="+Exhibitor_Code+"&Collection_Mode="+Collection_Mode,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							/*var data=data.split("#");
							$('#Charges').val(data[0]);
							$('#paymentDiv').html(data[1]);*/
							location.href = "exhibitors_badges.php"
							
							}
		});
});

$('#update_address').live('click', function(){
Badge_Addres=$('#Badge_Addres').val();
if(Badge_Addres==""){alert("Enter badges address");	$('#Badge_Addres').focus();return false;}

Badge_Country=$('#Badge_Country').val();
if(Badge_Country==""){alert("Enter badges country");$('#Badge_Country').focus();return false;}

Badge_City=$('#Badge_City').val();
if(Badge_City==""){alert("Enter badges city");$('#Badge_City').focus();return false;}

Badge_Pincode=$('#Badge_Pincode').val();
if(Badge_Pincode==""){alert("Enter badges pincode");$('#Badge_Pincode').focus();return false;}

Badge_State=$('#Badge_State').val();
if(Badge_State==""){alert("Enter badges state");$('#Badge_State').focus();return false;}

Badge_Mobile=$('#Badge_Mobile').val();
if(Badge_Mobile==""){alert("Enter badges mobile");$('#Badge_Mobile').focus();return false;}

Exhibitor_Code=$('#Exhibitor_Code').val();

$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=updateBadges&Badge_Addres="+Badge_Addres+"&Exhibitor_Code="+Exhibitor_Code+"&Badge_Country="+Badge_Country+"&Badge_City="+Badge_City+"&Badge_Pincode="+Badge_Pincode+"&Badge_State="+Badge_State+"&Badge_Mobile="+Badge_Mobile,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							//alert(data);
							location.href = "exhibitors_badges.php"
						}
		});
});

