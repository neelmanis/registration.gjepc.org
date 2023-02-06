<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Designation=$fetch_data['Exhibitor_Designation'];
$Exhibitor_Mobile=$fetch_data['Exhibitor_Mobile'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_StallNo[]="";

for($i=0;$i<8;$i++){
	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
}

$stall_no=implode(", ",$Exhibitor_StallNo);

$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
$Exhibitor_StallType=$fetch_data['Exhibitor_StallType'];

$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
?>
<?php 
$wireless_data="select * from iijs_wirelessinternet where Exhibitor_Code='$exhibitor_code'";
$result_wireless=mysql_query($wireless_data);
$fetch_wireless=mysql_fetch_array($result_wireless);

$subscription=$fetch_wireless['subscription'];
$Items_Approved=$fetch_wireless['Items_Approved'];
$Items_Reason=$fetch_wireless['Items_Reason'];
$Application_Complete=$fetch_wireless['Application_Complete'];
$Create_Date=$fetch_wireless['Create_Date'];


$num=mysql_num_rows($result_wireless);


if(isset($_POST['status']))
{
	$subscription=$_POST['subscription'];
	if($subscription=='Y')
		$subscription='Y';
	else
		$subscription='N';
	$Items_Approved=mysql_real_escape_string($_REQUEST['Items_Approved']);
	if($Items_Approved=='Y')
	{
	$Items_Reason="";	
	}else
	{
	$Items_Reason=mysql_real_escape_string($_REQUEST['Items_Reason']);
	}
	if($Items_Approved=='')
	{
		$Items_Approved='P';
		$Items_Reason="";	
	}
	
	if($Items_Approved=='Y')
	{
		$Application_Complete='Y';
	}else if($Items_Approved=='P')
	{
		$Application_Complete='P';
	}else
	{
		$Application_Complete='N';
	}	
	
	$sql_update="update iijs_wirelessinternet set subscription='$subscription',Items_Approved='$Items_Approved',Items_Reason='$Items_Reason',Application_Complete='$Application_Complete' where Exhibitor_Code='$exhibitor_code'";
	$sql_insert="insert into iijs_wirelessinternet set Exhibitor_Code='$exhibitor_code',Create_Date=NOW(),Modify_Date=NOW(),subscription='$subscription'";
	
	if($num>0)
	{
		if(!mysql_query($sql_update))
			echo "error ".mysql_error();
		if($Items_Approved!='P')
		{
				if($Items_Approved=='Y'){$Items_Approved='Approved';}else if($Items_Approved=='N'){$Items_Approved='Disapproved';}
			
				/*.......................................Send mail to users mail id...............................................*/
				$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
				
				<tr>
				<td style="padding:30px;">
				<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
				
				<tr>
					<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
					<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/SIGNATURE-LOGO-4.jpg" border="0"/></td>
				</tr>	
				
				<tr>
				<td></td>
				<td align="right"></td>
				</tr>
				
				<tr>
				<td align="right" colspan="2" height="30px"><hr /></td>
				</tr>
				
				<tr>
				<td colspan="2" style="font-size:13px; line-height:22px;">
				<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
				<p>Company Name: <strong>'.$Exhibitor_Name.'</strong> </p>
				<p>Your details for the Online Application for  <strong>Form No. 5. WIRELESS INTERNET CONNECTION</strong> has been updated by Signature Admin.</p>
				<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
				  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
					<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >WIRELESS INTERNET CONNECTION</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Items_Approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Items_Reason.' </td>
				  </tr>
				 
				  
		</table>
		
				<p>Kind regards, <br />
				<strong>IIJS Web Team,</strong>
				</p>
				</td>
				</tr>
			
				<tr>
				<td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
				</td>
				</tr>
				</table>
				</td>
				
				<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="https://gjepc.org/iijs-signature/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
				<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
				
				</tr>
				
				</table>';
				
				$to =$Exhibitor_Email.',notification@gjepcindia.com';
				//$to = 'rohit@kwebmaker.com';
				$subject = "".$event." Exhibitor Manual - Form No. 5. WIRELESS INTERNET CONNECTION"; 
				$headers  = 'MIME-Version: 1.0' . "\r\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
				$headers .= 'From:admin@gjepc.org';			
				mail($to, $subject, $message, $headers);
				
		}

	}
	else
	{
		if(!mysql_query($sql_insert))
			echo "error ".mysql_error();
	}	
	
	header("location:manage_wireless_internet_connection.php");							
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wireless Internet Connection</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />


<!-- form css -->
<link rel="stylesheet" type="text/css" href="css/adminForm.css">



<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>


<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->


<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->
<script type="text/javascript">
function check_disable(){
    if ($('input[name=\'Stall_Image_Layout_Type[]\']:checked').val() == "Custom"){
        $("#custom_lay").show();
    }
    else{
        $("#custom_lay").hide();
    }	
}
</script>


<script>
$(document).ready(function(){
	
	$("#keyperson1").change(function(){
    Badge_Item_ID=$("#keyperson1").val();
	$.ajax({ type: 'POST',
	url: 'ajax_strong_room.php',
	data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#keydesc1").html(data);  
						//alert(data);
	}
	});
  });
						   
 		
	$("#keyperson2").change(function(){
    Badge_Item_ID=$("#keyperson2").val();
	$.ajax({ type: 'POST',
	url: 'ajax_strong_room.php',
	data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#keydesc2").html(data);  
						//alert(data);
	}
	});
  });
	
	
	
});
</script>


<script type="text/javascript">
function validation()
{
	
	

	if($('input[name=\'Items_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Items_Reason').value=="")
		{
			alert("Please Enter Disapprove Reason");
			document.getElementById('Items_Reason').focus();
			return false;
		}
	}
	
	


}

</script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="manage_wireless_internet_connection.php?action=view">Home</a> > Wireless Internet Connection</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Wireless Internet Connection</div>
     	<div class="content_details22">
        <div id="formWrapper">
<form name="catalogue_entry" id="form1" action="" method="post" onsubmit="return validation()">

<p><strong>Wireless Internet (wi-fi) connections will be provided Complimentary to each exhibitor who will be applying to the council within 25th January 2014.</strong></p>

<div class="clear"></div>

<p>
  <input type="checkbox" name="subscription" id="subscription" value="Y" <?php if(preg_match('/Y/',$subscription)){ echo ' checked="checked"'; } ?> />
  <input type="hidden" name="status" value="subscribe" />
 <strong> I want to subscribe for Complimentary Wireless Connection </strong></p>


<h2>Exhibitor Information</h2>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Name;?></td>
    <td width="50">&nbsp;</td>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Contact_Person;?></td>
  </tr>
  <tr>
    <td class="bold">Stall No(s)</td>
    <td>:</td>
    <td><?php echo $stall_no;?></td>
    <td>&nbsp;</td>
    <td class="bold">Hall No</td>
    <td>:</td>
    <td><?php echo $Exhibitor_HallNo;?></td>
  </tr>
  <tr>
    <td class="bold">Zone</td>
    <td>:</td>
    <td><?php echo $Exhibitor_DivisionNo; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Region</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Region;?></td>
  </tr>
  <tr>
    <td class="bold">Section</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>
<div class="clear"></div>
<div class="title"><h4>Information Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
 
    
   <div class="leftStatus"><span><input name="Items_Approved" id="Items_Approved" type="radio" value="Y" <?php if($Items_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Items_Approved" id="Items_Approved" type="radio" value="N" <?php if($Items_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Items_Reason" id="Items_Reason" class="textArea"><?php echo "$Items_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
<div class="clear"></div>

    <div align="center">
      <input name="input2" type="submit" value="Submit" class="maroon_btn" />
    <a href="manage_wireless_internet_connection.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>
</form>
</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
