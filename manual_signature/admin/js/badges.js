$('#addbadge').live('click', function(){ 
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
	if($('#Badge_Mobile').val()=="")
	{
		alert("Please enter mobile");
		$("#Badge_Mobile").focus();
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
			alert("Sorry You can not add more Maintenance badges");
			return false;
		}
		maintenance_badge_count=$('#maintenance_badge_count').val();
		Service_Badges_avail=$('#Service_Badges_avail').val();
	
		if(parseInt(maintenance_badge_count)>parseInt(Service_Badges_avail))
		{
		alert("Sorry no more maintenance badges is available");
		return false;
		}
	}
	if(Badge_Type=="E")
	{
		if($("#check_exhibitor").val()==1)
		{
				//alert("Sorry You can not add more Exhibitor badges");
				alert("Sorry You can add more Exhibitor badges");
				return false;
		}
		/*Exhibitor_badge_count=$('#Exhibitor_badge_count').val();
		Exhibitor_Badges_avail=$('#Exhibitor_Badges_avail').val();
		if(parseInt(Exhibitor_badge_count)>parseInt(Exhibitor_Badges_avail))
		{
		alert("Sorry no more Exhibitor badges is available");
		return false;
		}*/
		
	}
	if(Badge_Type=="M")
	{
		if($("#check_management").val()==1)
		{
				alert("Sorry You can add more Management badges");
				location.href = "exhibitors_badges.php";
				return false;
		}
		Management_badge_count=$('#Management_badge_count').val();
		Management_Badges_avail=$('#Management_Badges_avail').val();
		if(parseInt(Management_badge_count)>parseInt(Management_Badges_avail))
		{
		alert("Sorry no more Management badges is available");
		return false;
		}
		
	}
	$("#badgeForm").ajaxForm({
				success : function (data){
					//alert(data);
					var arr = data.split('#');
					Badge_ID=arr[0];
					Exhibitor_Code=arr[1];
					location.href = "Form4.php?Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code;
					}
}).submit();
});

$(".badges_delete").live('click',function(){
	con=confirm("Sure You want to delete the badge");
	if(con==true){									  
	classvar=$(this).attr('class');
	Badge_ID=$("#Badge_ID").val();
	Exhibitor_Code=$("#Exhibitor_Code").val();
	var classchunk = classvar.split(" ");
	Badge_Item_ID=classchunk[1];
	Badge_Type=classchunk[2];
		$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=deleteBadges&Badge_Item_ID="+Badge_Item_ID+"&Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code+"&Badge_Type="+Badge_Type,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								var arr = data.split('#');
								Badge_ID=arr[0];
								Exhibitor_Code=arr[1];
								location.href = "Form4.php?Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code;
							}
		});
	}
});

$("#update_badge").live('click',function(){
	$("#update_badge").attr("disabled", true);;
	var Badge_ID=$("#Badge_ID").val();
	//alert(Badge_ID);
	var order_id=$("#order_id").val();
	Exhibitor_Code=$("#Exhibitor_Code").val();
	CarPass1=$("#CarPass1").val();
	CarPass2=$("#CarPass2").val();
	var Badge_Addres=$('#Badge_Addres').val();
	var Badge_Country=$('#Badge_Country').val();
	var Badge_City=$('#Badge_City').val();
	var Badge_Pincode=$('#Badge_Pincode').val();
	var Badge_State=$('#Badge_State').val();
	var Badge_Mobile=$('#Badge_Mobile').val();
	var badges_count=$("#Badges_count").val();
	//alert(badges_count);
	var badge_details=new Array();
	
	for (var i = 1; i<=badges_count; i++)
           {				
			var badge_a=$('input[name=Badge_Approved'+i+']:checked').val();
			if(badge_a=='')
			{
				badge_a='P';	
			}
			var badge_reason=$('#Badge_Reason'+i).val();
			var badge_item_id=$('#Badge_Item_ID'+i).val();
			var Badge_Type=$('#Badge_T'+i).val();
			
			if(badge_a=='N')
			{
				if(badge_reason=='')
			{
					alert("Please Enter Badge Disapproved Reason");
					$('#Badge_Reason'+i).focus();
					return false;
			}
			}	
			//alert(badge_item_id);
			badge_det=badge_a+'-'+badge_reason+'-'+badge_item_id+'-'+Badge_Type;
			//alert(badge_det);
			
			badge_details.push(badge_det);
			}
			
	var Info_Approved = $("input[type='radio'][name='Info_Approved']:checked");
	if (Info_Approved.length > 0) 
	{
    	Info_Approved = Info_Approved.val();
		if(Info_Approved=="N")
		{
			Info_Reason=$("#Info_Reason").val();
			if(Info_Reason=='')
			{
					alert("Please Enter Info Disapproved Reason");
					$("#Info_Reason").focus();
					return false;
			}
		}
		else
		{
			Info_Reason="";	
		}
	}
	else
	{
		Info_Approved = "P";
		Info_Reason="";		
	}
	
	var selected = $("input[type='radio'][name='Payment_Master_Approved']:checked");
	if (selected.length > 0) 
	{
    	Payment_Master_Approved = selected.val();
		if(Payment_Master_Approved=="N")
		{
			Payment_Master_Reason=$("#Payment_Master_Reason").val();
			if(Payment_Master_Reason=='')
			{
					alert("Please Enter Payment Disapproved Reason");
					$("#Payment_Master_Reason").focus();
					return false;
			}
		}
		else
		{
			Payment_Master_Reason="";	
		}
	}
	else
	{
		Payment_Master_Approved = $('#Payment_Master_Approved').val();
		Payment_Master_Reason="";		
	}
	//alert(Payment_Master_Approved);
	
	var WaveOff = $("input[type='radio'][name='WaveOff']:checked");
	if (WaveOff.length > 0) 
	{
    	WaveOff = WaveOff.val();
		if(WaveOff=="Y")
		{
			WaveOff_Reason=$("#WaveOff_Reason").val();
		}
		else
		{
			WaveOff_Reason="";	
		}
	}
	else
	{
		WaveOff = "P";
		WaveOff_Reason="";
		
	}
	
	if(WaveOff=="Y")
		{
			if($("#WaveOff_Reason").val()=="")
			{
				alert("Please enter the waveoff reason.");
				$("#WaveOff_Reason").focus();
				return false;
			}
		}
	
	$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					/*data: "actiontype=updateBadges&Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code+"&CarPass1="+CarPass1+"&CarPass2="+CarPass2+"&Info_Approved="+Info_Approved+"&Info_Reason="+Info_Reason+"&Payment_Master_Approved="+Payment_Master_Approved+"&Payment_Master_Reason="+Payment_Master_Reason+"&WaveOff="+WaveOff+"&WaveOff_Reason="+WaveOff_Reason,*/
					data: "actiontype=updateBadges&Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code+"&CarPass1="+CarPass1+"&CarPass2="+CarPass2+"&Info_Approved="+Info_Approved+"&Info_Reason="+Info_Reason+"&Payment_Master_Approved="+Payment_Master_Approved+"&Payment_Master_Reason="+Payment_Master_Reason+"&WaveOff="+WaveOff+"&WaveOff_Reason="+WaveOff_Reason+"&badge_details="+badge_details+"&&Badge_Addres="+Badge_Addres+"&&Badge_Country="+Badge_Country+"&&Badge_City="+Badge_City+"&&Badge_Pincode="+Badge_Pincode+"&&Badge_State="+Badge_State+"&&Badge_Mobile="+Badge_Mobile+"&order_id="+order_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						
								//console.log(data);return false;
								//return false;
								/*var arr = data.split('#');
								Badge_ID=arr[0];
								Exhibitor_Code=arr[1];
								location.href = "Form4.php?Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code;*/
								location.href ="manage_badges.php?action=view";
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

address_mobile=$('#address_mobile').val();
if(address_mobile==""){alert("Enter badges mobile");$('#address_mobile').focus();return false;}

Exhibitor_Code=$('#Exhibitor_Code').val();
Badge_ID=$("#Badge_ID").val();

$.ajax({ type: 'POST',
					url: 'badges_ajax.php',
					data: "actiontype=updateAddress&Badge_Addres="+Badge_Addres+"&Exhibitor_Code="+Exhibitor_Code+"&Badge_Country="+Badge_Country+"&Badge_City="+Badge_City+"&Badge_Pincode="+Badge_Pincode+"&Badge_State="+Badge_State+"&address_mobile="+address_mobile+"&Badge_ID="+Badge_ID,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							console.log(data);
							var arr = data.split('#');
							Badge_ID=arr[0];
							Exhibitor_Code=arr[1];
							location.href = "Form4.php?Badge_ID="+Badge_ID+"&Exhibitor_Code="+Exhibitor_Code;
							//location.href = "manage_badges.php?action=view"
						}
		});
});
