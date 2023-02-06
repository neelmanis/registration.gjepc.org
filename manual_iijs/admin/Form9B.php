<?php session_start(); ?>
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
$sql="select * from iijs_strongroom where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
$num_rows=mysql_num_rows($result);
$StrongRoom_ID=$rows['StrongRoom_ID'];
$StrongRoom_Taken=$rows['StrongRoom_Taken'];
$keyperson1=$rows['keyperson1'];
$keyperson2=$rows['keyperson2'];
$Items_Approved=$rows['Items_Approved'];
$Items_Reason=$rows['Items_Reason'];
$Application_Complete=$rows['Application_Complete'];
$Create_Date=$rows['Create_Date'];

$Badge_ID=getBadgeID($exhibitor_code);
?>

<?php 
$action=$_REQUEST['action'];
if($action=='ADD')
{
	
	if($num_rows==0)
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$StrongRoom_Taken=$_REQUEST['StrongRoom_Taken'][0];
		$keyperson1=$_REQUEST['keyperson1'];
		$keyperson2=$_REQUEST['keyperson2'];
		
		if($StrongRoom_Taken=='N')
		{
			$keyperson1="";
			$keyperson2="";
		}
		$sql_insert="insert into iijs_strongroom set Exhibitor_Code='$exhibitor_code',StrongRoom_Taken='$StrongRoom_Taken',Badge_ID='$Badge_ID',keyperson1='$keyperson1',keyperson2='$keyperson2',Items_Recieved='1',Items_Approved='P',Items_Reason='',Create_Date=NOW(),Modify_Date=NOW(),Application_Complete='P'";
		$execute=mysql_query($sql_insert);
		
		$sql3="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson1'";
		$result3=mysql_query($sql3);
		
		$sql4="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson2'";
		$result4=mysql_query($sql4);
		
		if(!$execute)
		echo "Error : ".mysql_error();
		
	}else
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$StrongRoom_Taken=$_REQUEST['StrongRoom_Taken'][0];
		$keyperson1=$_REQUEST['keyperson1'];
		$keyperson2=$_REQUEST['keyperson2'];
		
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
		
		if($StrongRoom_Taken=='N')
		{
			$keyperson1="";
			$keyperson2="";
		}
		
		$sql_insert="update iijs_strongroom set StrongRoom_Taken='$StrongRoom_Taken',keyperson1='$keyperson1',keyperson2='$keyperson2',Items_Approved='$Items_Approved',Items_Reason='$Items_Reason',Application_Complete='$Application_Complete',Modify_Date=NOW() where Exhibitor_Code='$exhibitor_code'";
		$execute=mysql_query($sql_insert);
		
		$sql3="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson1'";
		$result3=mysql_query($sql3);
		
		$sql4="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson2'";
		$result4=mysql_query($sql4);
		
		if(!$execute)
		echo "Error : ".mysql_error();
		
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
					<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_iijs/images/logo.png" border="0"/></td>
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
				<p>Your details for the Online Application for <strong>Form No. 5. STRONG ROOM FACILITY</strong> has been updated by Signature Admin.</p>
				<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
				  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
					<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >Strong Room</td>
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
				
				
				
				</tr>
				
				</table>';
				
				$to =$Exhibitor_Email.',notification@gjepcindia.com';
				//$to ='rohit@kwebmaker.com';
				$subject = "".$event." Exhibitor Manual - Form No. 5. STRONG ROOM FACILITY"; 
				$headers  = 'MIME-Version: 1.0' . "\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
				$headers .= 'From:admin@gjepc.org';			
				mail($to, $subject, $message, $headers);
				
		}
				
	}
	
	echo '<script type="text/javascript">'; 
	//echo 'alert("You have successfully submitted your application..");'; 
	echo 'window.location.href = "manage_storng_room.php?action=view";';
	echo '</script>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Strong Room Facility</title>

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
	<div class="breadcome"><a href="manage_storng_room.php?action=view">Home</a> > Strong Room Facility</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Strong Room Facility</div>
     	<div class="content_details22">
        <div id="formWrapper">
<p align="right"><a href="../images/pdf/Disclaimer_cum_handling_instructions_for_strong_room_Signature_2017.pdf" target="_blank" style="color:#F00;"><strong>Strong Room Disclaimer</strong></a></p>

<div class="title"><h4>Exhibitor Information</h4></div>
<div class="clear"></div>

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
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $exhibitor_code;?>" />

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold" width="350px">Would you like to avail of strong room facilities at the show? <sup>*</sup></td>
    <td><input type="radio" name="StrongRoom_Taken[]" id="StrongRoom_Taken" value="Y" onchange="check_disable()" <?php if($StrongRoom_Taken=="Y"){echo "checked='checked'";}?> /> Yes</td>
    <td><input type="radio" name="StrongRoom_Taken[]" id="StrongRoom_Taken" value="N" onchange="check_disable()" <?php if($StrongRoom_Taken=="N"){echo "checked='checked'";}?> /> No</td>
  </tr>
</table>


<div class="title"><h4>Key Person</h4></div>
<div class="clear"></div>
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <td class="bold">Key Person 1</td>
      <td>:</td>
      <td><?php echo getKeyName($keyperson1);?></td>
      <td>&nbsp;</td>
      <td class="bold">Key Person 2</td>
      <td>:</td>
      <td><?php echo getKeyName($keyperson2);?></td>
    </tr>
    <tr>
      <td width="14%" class="bold">Designation</td>
      <td width="3%">:</td>
      <td width="29%"><?php echo getKeyDesignation($keyperson1);?></td>
      <td width="3%">&nbsp;</td>
      <td width="14%" class="bold">Designation</td>
      <td width="5%">:</td>
      <td width="32%"><?php echo getKeyDesignation($keyperson2);?></td>
    </tr>
    <tr>
      <td class="bold">Photo</td>
      <td>:</td>
      <td><img src="../images/badges/<?php echo $exhibitor_code;?>/<?php echo getKeyPhoto($keyperson1);?>" width='150px' height='120' /></td>
      <td>&nbsp;</td>
      <td class="bold">Photo</td>
      <td>:</td>
      <td><img src="../images/badges/<?php echo $exhibitor_code;?>/<?php echo getKeyPhoto($keyperson2);?>" width='150px' height='120' /></td>
    </tr>   
    </table>

<div class="clear"></div>
<div id="keyperson">
<div class="title"><h4>Key Person</h4></div>
<div class="clear">
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
    <td colspan="8" class="bold">Select safe key holder ( Recommended : Exhibitors ) <sup>*</sup></td>
    </tr>
    <tr>
      <td width="14%" class="bold">Key Person 1<sup>*</sup></td>
      <td width="3%">:</td>
      <td width="29%">
      <select name="keyperson1" id="keyperson1" class="textField">
        <option selected="selected" value="">--Select--</option>
        <?php $sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND  (`Badge_Type`='E' || `Badge_Type`='M')";
		$result=mysql_query($sql);
		while($rows=mysql_fetch_array($result))
		{
			if($rows['Badge_Item_ID']==$keyperson1)
			{
			echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";	
			}else
			{
			echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}
		}
		?>
      </select></td>
      <td width="3%">&nbsp;</td>
      <td width="14%" class="bold">Key Person 2 <sup>*</sup></td>
      <td width="5%">:</td>
      <td width="32%">
      <select name="keyperson2" id="keyperson2" class="textField">
        <option selected="selected" value="">--Select--</option>
        <?php $sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M')";
		$result=mysql_query($sql);
		while($rows=mysql_fetch_array($result))
		{
			if($rows['Badge_Item_ID']==$keyperson2)
			{
			echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";	
			}else
			{
			echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}	
		}
		?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td colspan="3" class="bold"><div id="keydesc1"></div></td>
      <td>&nbsp;</td>
      <td colspan="3" class="bold"><div id="keydesc2"></div></td>
      </tr>
    
    </table>
</div>
</div>
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
<p>&nbsp;</p>
<div class="clear"></div>
<div align="center">
  <input name="input2" type="submit" value="Submit" class="maroon_btn" />
<a href="manage_storng_room.php?action=view"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
<a href="print_acknowledge/strong_room_print.php?&exhibitor_code=<?php echo $exhibitor_code;?>&StrongRoom_ID=<?php echo $StrongRoom_ID;?>" target="_blank" class="button5">Print AcknowledgeMent</a>

</div>
</form>
</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
