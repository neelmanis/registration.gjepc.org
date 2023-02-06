<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$exhibitor_code=$_REQUEST['Exhibitor_Code'];
$event = getEventDescription($conn);
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data=$result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Designation=$fetch_data['Exhibitor_Designation'];
$Exhibitor_Mobile=$fetch_data['Exhibitor_Mobile'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];
$Exibitor_Name=$fetch_data['Exibitor_Name'];

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

$catalog_data	=	"select approval,disapprove_reason from jewellery_fineness where Exhibitor_Code='$exhibitor_code'";
$result_catalog	=	$conn ->query($catalog_data);
$fetch_catalog	=	$result_catalog->fetch_assoc();
$approval	=	$fetch_catalog['approval'];
$disapprove_reason	=	$fetch_catalog['disapprove_reason'];


if($_REQUEST['action']=="ADD")
{

if(isset($_POST['submit']))
{		
		$Info_Approved = $_REQUEST['Info_Approved'];
		if($Info_Approved=='Y')
		{
		$Info_Reason="";	
		}else
		{
		$Info_Reason=$_REQUEST['Info_Reason'];
		}
		
		if($Info_Approved=='N')
		{
		$Info_Reason = $_REQUEST['Info_Reason'];
		}else
		{
		$Info_Reason="";	
		}
		
		
		if($Info_Approved=='')
		{
			$Info_Approved='P';
			$Info_Reason="";	
		}
		   
		$sql_update="update jewellery_fineness set approval='$Info_Approved',disapprove_reason='$Info_Reason',Modify_Date=NOW() where Exhibitor_Code='$exhibitor_code'";		
		$execute=$conn ->query($sql_update);
		if(!$execute) die ($conn->error);
	
		if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='D'){$Info_Approved='Disapproved';}
	
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
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
		<p>Company Name: <strong>'.$Exibitor_Name.'</strong> </p>
		<p>Your details for the Online Application for <strong>UNDERTAKING OF JEWELLERY FINENESS</strong> has been updated by IIJS Admin.</p>
		
		<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
		  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
			<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Information</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Approved.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Reason.' </td>
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
		
		<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="https://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
		<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="https://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
		
		</tr>
		
		</table>';
		
		$to = $Exhibitor_Email.',notification@gjepcindia.com';
		//$to = 'neelmani@kwebmaker.com';
		$subject = "".$event." UNDERTAKING OF JEWELLERY FINENESS"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: "'.$event.'" <admin@gjepc.org>';			
		mail($to, $subject, $message, $headers);
	
		
}
		echo '<script type="text/javascript">'; 
		echo 'window.location.href = "manage_fineness.php";';
		echo '</script>';	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fineness Form</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
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
function validation()
{
	if($('input[name=\'Info_Approved\']:checked').val() == "D")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Info Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}
}
</script>
<style>
.Catalog_Brief { width: 100%; height: 110px; }
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="manage_fineness.php?action=view">Home</a> > Compulsory Catalogue Entry Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Fineness Approval Form</div>
 
<div class="content_details22">
<div id="formWrapper">
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

<form name="catalogue_entry" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD" />

<div class="clear"></div>

<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   <div class="leftStatus"><span><input name="Info_Approved" id="Info_Approved2" type="radio" value="Y" <?php if($approval=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Info_Approved" id="Info_Approved" type="radio" value="D" <?php if($approval=='D'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo $disapprove_reason; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>

<div class="clear"></div>

<div align="center">
<input type="submit" name="submit" value="Submit" class="maroon_btn" />
<a href="manage_fineness.php?action=view"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>
</form>
</div>

</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>