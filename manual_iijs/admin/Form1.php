<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data=$result->fetch_assoc();

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

$catalog_data="select * from iijs_catalog where Exhibitor_Code='$exhibitor_code'";
$result_catalog=$conn ->query($catalog_data);
$fetch_catalog=$result_catalog->fetch_assoc();
$brand_names=$fetch_catalog['brand_names'];
if($brand_names!="")
{
	$brand_names=explode(",",$brand_names);
	if(isset($brand_names[0])){
		$brand_name1=$brand_names[0];
	}	else {
		$brand_name1 ='';
	}
	if(isset($brand_names[1])){
		$brand_name2=$brand_names[1];
	} else{
		$brand_name2='';
	}
	if(isset($brand_names[2])){
		$brand_name3=$brand_names[2];
	} else{
		$brand_name3='';
	}
	if(isset($brand_names[3])){
		$brand_name4=$brand_names[3];
	} else {
		$brand_name4= '';
	}
	if(isset($brand_names[4])){
		$brand_name5=$brand_names[4];
	} else {
		$brand_name5='';
	}

	// $brand_name1=$brand_names[0];
	// $brand_name2=$brand_names[1];
	// $brand_name3=$brand_names[2];
	// $brand_name4=$brand_names[3];
	// $brand_name5=$brand_names[4];
}
else
{
	$brand_name1="";
	$brand_name2="";
	$brand_name3="";
	$brand_name4="";
	$brand_name5="";
}
$num = $result_catalog->num_rows;
if($num>0)
{
	$Exibitor_Name=$fetch_catalog['Exibitor_Name'];
	$Catalog_Phone=$fetch_catalog['Catalog_Phone'];
	$Catalog_ContactPerson=$fetch_catalog['Catalog_ContactPerson'];
	$Catalog_Fax=$fetch_catalog['Catalog_Fax'];
	$Catalog_Designation=$fetch_catalog['Catalog_Designation'];
	$Catelog_mobile=$fetch_catalog['Catelog_mobile'];
	$Catalog_Address1=$fetch_catalog['Catalog_Address1'];
	$Catalog_Email=$fetch_catalog['Catalog_Email'];
	$Catalog_City=$fetch_catalog['Catalog_City'];
	$Catalog_Email1=$fetch_catalog['Catalog_Email'];
	$Catalog_Pincode=$fetch_catalog['Catalog_Pincode'];
	$Catalog_Website=$fetch_catalog['Catalog_Website'];
	$Catalog_CountryId=$fetch_catalog['Catalog_CountryId'];
	$Catalog_StallNo=$fetch_catalog['Catalog_StallNo'];
	$Catalog_State=$fetch_catalog['Catalog_State'];
	$Create_Date=$fetch_catalog['Create_Date'];
	$wa_jewellery=$fetch_catalog['wa_jewellery'];
	$wa_jewellery_other=$fetch_catalog['wa_jewellery_other'];
	$pd_jewellery=$fetch_catalog['pd_jewellery'];
	$pd_jewellery_other=$fetch_catalog['pd_jewellery_other'];
	$item_display=$fetch_catalog['item_display'];
	$item_display_other=$fetch_catalog['item_display_other'];
	$Catalog_Brief=$fetch_catalog['Catalog_Brief'];
	$Catalog_CompanyLogo=$fetch_catalog['Catalog_CompanyLogo'];
	$CompanyLogo_Approved=$fetch_catalog['CompanyLogo_Approved'];
	$CompanyLogo_Reason=$fetch_catalog['CompanyLogo_Reason'];
	$Catalog_ProductLogo=$fetch_catalog['Catalog_ProductLogo'];
	$ProductLogo_Reason=$fetch_catalog['ProductLogo_Reason'];
	$ProductLogo_Approved=$fetch_catalog['ProductLogo_Approved'];
	
	$Info_Reason=$fetch_catalog['Info_Reason'];
	$Info_Approved=$fetch_catalog['Info_Approved'];
	$Application_Complete=$fetch_catalog['Application_Complete'];
    	
}
else
{
	$Catalog_ContactPerson=$Exhibitor_Contact_Person;
	$Catalog_Designation=$Exhibitor_Designation;
	$Catelog_mobile=$Exhibitor_Mobile;
	$Catalog_Phone=$Exhibitor_Phone;
	$Catalog_Fax=$Exhibitor_Fax;
	$Catalog_StallNo=$stall_no;
		
	$Catalog_Address1=$Exhibitor_Address1;
	$Catalog_Address2=$Exhibitor_Address2;
	$Catalog_Address3=$Exhibitor_Address3;
	
	$Catalog_Email=$Exhibitor_Email;
	$Catalog_Email1=$Exhibitor_Email1;
	$Catalog_Pincode=$Exhibitor_Pincode;
	$Catalog_State=$Exhibitor_State;
	$Catalog_CountryId=$Exhibitor_Country_ID;
	$Catalog_City=$Exhibitor_City;
	$Catalog_Website=$Exhibitor_Website;
}

if($_REQUEST['action']=="ADD")
{

		if(isset($_FILES['Catalog_ProductLogo']) && $_FILES['Catalog_ProductLogo']['name']!="")
		{
		//Unlink the previuos image
		$qpreviousimg=$conn ->query("select Catalog_ProductLogo from iijs_catalog where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg=$qpreviousimg->fetch_assoc();
		$filename="../images/catalog/$exhibitor_code/".$rpreviousimg['Catalog_ProductLogo'];
		unlink($filename);

			$file_name=$_FILES['Catalog_ProductLogo']['name'];
			$file_temp=$_FILES['Catalog_ProductLogo']['tmp_name'];
			$file_type=$_FILES['Catalog_ProductLogo']['type'];
			$file_size=$_FILES['Catalog_ProductLogo']['size'];
			$attach="P";
			if($_FILES['Catalog_ProductLogo']['name']!="")
			{
				$Catalog_ProductLogo=uploadImageAdmin($file_name,$file_temp,$file_type,$file_size,$attach,"catalog",$exhibitor_code);
			}
		$update_plogo="update iijs_catalog set Catalog_ProductLogo='$Catalog_ProductLogo',ProductLogo_Approved='P',ProductLogo_Reason='',Application_Complete='P' where Exhibitor_Code='$exhibitor_code'";
		$update_plogoresult = $conn ->query($update_plogo);
		}
		
		if(isset($_FILES['Catalog_CompanyLogo']) && $_FILES['Catalog_CompanyLogo']['name']!="")
		{
		//Unlink the previuos image
		$qpreviousimg=$conn ->query("select Catalog_CompanyLogo from iijs_catalog where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg=$qpreviousimg->fetch_assoc();
		$filename="../images/catalog/$exhibitor_code/".$rpreviousimg['Catalog_CompanyLogo'];
		unlink($filename);
		
			$file_name=$_FILES['Catalog_CompanyLogo']['name'];
			$file_temp=$_FILES['Catalog_CompanyLogo']['tmp_name'];
			$file_type=$_FILES['Catalog_CompanyLogo']['type'];
			$file_size=$_FILES['Catalog_CompanyLogo']['size'];
			$attach="C";
			if($_FILES['Catalog_CompanyLogo']['name']!="")
			{
				$Catalog_CompanyLogo=uploadImageAdmin($file_name,$file_temp,$file_type,$file_size,$attach,"catalog",$exhibitor_code);
			}
		$update_clogo="update iijs_catalog set Catalog_CompanyLogo='$Catalog_CompanyLogo',CompanyLogo_Approved='P',CompanyLogo_Reason='',Application_Complete='P' where Exhibitor_Code='$exhibitor_code'";
		
		$update_clogoresult = $conn ->query($update_clogo);
		}

if(isset($_POST['submit']))
{
		$Exibitor_Name=$_POST['Exibitor_Name'];
		$Catalog_Phone=$_POST['Catalog_Phone'];
		$Catalog_ContactPerson=$_POST['Catalog_ContactPerson'];
		$Catalog_Fax=$_POST['Catalog_Fax'];
		$Catalog_Designation=$_POST['Catalog_Designation'];
		$Catelog_mobile=$_POST['Catelog_mobile'];
		$Catalog_Address1=$_POST['Catalog_Address1'];
		$Catalog_Email=$_POST['Catalog_Email'];
		$Catalog_City=$_POST['Catalog_City'];
		$Catalog_Email1=$_POST['Catalog_Email'];
		$Catalog_Pincode=$_POST['Catalog_Pincode'];
		$Catalog_Website=$_POST['Catalog_Website'];
		$Catalog_CountryId=$_POST['Catalog_CountryId'];		
		$Catalog_CountryId=getCountryName($Catalog_CountryId,$conn);	
		$Catalog_StallNo=$_POST['Catalog_StallNo'];
		$Catalog_State=$_POST['Catalog_State'];
		$brand_names=implode(",",$_POST['brand_names']);
		//echo $Catalog_Brief = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['Catalog_Brief']);
		$Catalog_Brief = replace_comma(str_replace("'","",$_POST['Catalog_Brief']));
		if(isset($_REQUEST['Info_Approved'])){
			$Info_Approved=$_REQUEST['Info_Approved'];
		} else {
			$Info_Approved='P';
		}
		
		if($Info_Approved=='Y')
		{
		$Info_Reason="";	
		}else
		{
		$Info_Reason=$_REQUEST['Info_Reason'];
		}
		if($Info_Approved=='')
		{
			$Info_Approved='P';
			$Info_Reason="";	
		}
		if(isset($_REQUEST['ProductLogo_Approved'])){
			$ProductLogo_Approved=$_REQUEST['ProductLogo_Approved'];
		} else {
			$ProductLogo_Approved='P';
		}
		//$ProductLogo_Approved=$_REQUEST['ProductLogo_Approved'];
		if($ProductLogo_Approved=='Y')
		{
		$ProductLogo_Reason="";	
		}else
		{
		$ProductLogo_Reason=$_REQUEST['ProductLogo_Reason'];
		}
		if($ProductLogo_Approved=='')
		{
			$ProductLogo_Approved='P';
			$ProductLogo_Reason="";	
		}
		if(isset($_REQUEST['CompanyLogo_Approved'])){
			$CompanyLogo_Approved=$_REQUEST['CompanyLogo_Approved'];
		} else {
			$CompanyLogo_Approved='P';
		}
		$CompanyLogo_Approved=$_REQUEST['CompanyLogo_Approved'];
		if($CompanyLogo_Approved=='Y')
		{
		$CompanyLogo_Reason="";	
		}else
		{
		$CompanyLogo_Reason=$_REQUEST['CompanyLogo_Reason'];
		}
		
		if($CompanyLogo_Approved=='')
		{
			$CompanyLogo_Approved='P';
			$CompanyLogo_Reason="";	
		}
		
		if($Info_Approved=='Y' && $ProductLogo_Approved=='Y' && $CompanyLogo_Approved=='Y')
		{
			$Application_Complete='Y';
		}else if($Info_Approved=='P' || $ProductLogo_Approved=='P' || $CompanyLogo_Approved=='P')
		{
			$Application_Complete='P';
		}else
		{
			$Application_Complete='N';
		}
		   
		 
		if($num>0)
		{
		$sql_update="update iijs_catalog set Exibitor_Name='$Exibitor_Name',Catalog_Phone='$Catalog_Phone',Catalog_ContactPerson='$Catalog_ContactPerson',Catalog_Fax='$Catalog_Fax',Catalog_Designation='$Catalog_Designation',Catelog_mobile='$Catelog_mobile',Catalog_Address1='$Catalog_Address1',Catalog_Email='$Catalog_Email',Catalog_City='$Catalog_City',Catalog_Pincode='$Catalog_Pincode',Catalog_Website='$Catalog_Website',Catalog_CountryId='$Catalog_CountryId',Catalog_StallNo='$Catalog_StallNo',Catalog_State='$Catalog_State',Catalog_Brief='$Catalog_Brief',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',ProductLogo_Approved='$ProductLogo_Approved',ProductLogo_Reason='$ProductLogo_Reason',CompanyLogo_Approved='$CompanyLogo_Approved',CompanyLogo_Reason='$CompanyLogo_Reason',brand_names='$brand_names',Application_Complete='$Application_Complete',Modify_Date=NOW() where Exhibitor_Code='$exhibitor_code'";
		
		$execute=$conn ->query($sql_update);
		if(!$execute) die ($conn->error);
	
if($Info_Approved!='P' && $ProductLogo_Approved!='P' && $CompanyLogo_Approved!='P')
{   
		if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='N'){$Info_Approved='Disapproved';}
		if($ProductLogo_Approved=='Y'){$ProductLogo_Approved='Approved';}else if($ProductLogo_Approved=='N'){$ProductLogo_Approved='Disapproved';}
		if($CompanyLogo_Approved=='Y'){$CompanyLogo_Approved='Approved';}else if($CompanyLogo_Approved=='N'){$CompanyLogo_Approved='Disapproved';}
	
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
		<p>Company Name: <strong>'.$Exibitor_Name.'</strong> </p>
		<p>Your details for the Online Application for <strong>Form No. 1. COMPULSORY CATALOGUE ENTRY</strong> has been updated by Signature Admin.</p>
		<p>Kindly login at our website - <a href="gjepc.org/iijs-premiere/">gjepc.org/iijs-premiere/</a> to verify the same.</p>
		
		<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
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
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Product Logo</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$ProductLogo_Approved.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$ProductLogo_Reason.'</td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Company Logo</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$CompanyLogo_Approved.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$CompanyLogo_Reason.'</td>
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
		
		//$to =$Exhibitor_Email.',notification@gjepcindia.com';
		$to = 'santosh@kwebmaker.com';
		$subject = "".$event." Exhibitor Manual - Form No. 1. COMPULSORY CATALOGUE ENTRY"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From:admin@gjepc.org';			
		mail($to, $subject, $message, $headers);}			
		}
		else
		{
			$sql_insert="insert into iijs_catalog set Exhibitor_Code='$exhibitor_code',Exibitor_Name='$Exibitor_Name',Catalog_Phone='$Catalog_Phone',Catalog_ContactPerson='$Catalog_ContactPerson',Catalog_Fax='$Catalog_Fax',Catalog_Designation='$Catalog_Designation',Catelog_mobile='$Catelog_mobile',Catalog_Address1='$Catalog_Address1',Catalog_Email='$Catalog_Email',Catalog_City='$Catalog_City',Catalog_Pincode='$Catalog_Pincode',Catalog_Website='$Catalog_Website',Catalog_CountryId='$Catalog_CountryId',Catalog_StallNo='$Catalog_StallNo',Catalog_State='$Catalog_State',	Catalog_Brief='$Catalog_Brief',Catalog_ProductLogo='$Catalog_ProductLogo',Catalog_CompanyLogo='$Catalog_CompanyLogo',Info_Recieved='1',Application_Complete='P',Create_Date=NOW()";
			$execute=$conn ->query($sql_insert);
			if (!$execute) die ($conn->error);
		}
		
}
		echo '<script type="text/javascript">'; 
		echo 'window.location.href = "manage_compulsory_catalogue.php";';
		echo '</script>';	
}
		
if($Catalog_CompanyLogo!="")
{
	$sql_comp_logo="update iijs_catalog set CompanyLogo_Recieved='1' where Exhibitor_Code='$exhibitor_code'";
	$comp_logo_result=$conn ->query($sql_comp_logo);
}

if($Catalog_ProductLogo!="")
{
	$sql_prod_logo="update iijs_catalog set ProductLogo_Recieved='1' where Exhibitor_Code='$exhibitor_code'";
	$prod_logo_result=$conn ->query($sql_prod_logo);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compulsory Catalogue Entry Form</title>

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
	if($('input[name=\'Info_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Info Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}

	if($('input[name=\'ProductLogo_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('ProductLogo_Reason').value=="")
		{
			alert("Please Enter Product Logo Disapprove Reason");
			document.getElementById('ProductLogo_Reason').focus();
			return false;
		}
	}

	if($('input[name=\'CompanyLogo_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('CompanyLogo_Reason').value=="")
		{
			alert("Please Enter Company Logo Disapprove Reason");
			document.getElementById('CompanyLogo_Reason').focus();
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
	<div class="breadcome"><a href="manage_compulsory_catalogue.php?action=view">Home</a> > Compulsory Catalogue Entry Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Compulsory Catalogue Entry Form</div>
 
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

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><input type="text" name="EN" id="EN" class="textField" value="<?php echo $Exhibitor_Name;?>" disabled="disabled"/>
      <input type="hidden" name="Exibitor_Name" id="Exibitor_Name" class="textField" value="<?php echo $Exhibitor_Name;?>"/>
      <br />
      <span id="name_error" class="error_msg"></span>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Telephone <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Phone" id="Catalog_Phone" class="textField" value="<?php echo $Catalog_Phone;?>" /></td>
  </tr>
  <tr>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td>
    
    <input type="text" name="Catalog_ContactPerson" id="Catalog_ContactPerson" class="textField" value="<?php echo $Catalog_ContactPerson;?>" />
    </td>
    <td>&nbsp;</td>
    <td class="bold">Fax</td>
    <td>:</td>
    <td><input type="text" name="Catalog_Fax" id="Catalog_Fax" class="textField" value="<?php echo $Catalog_Fax;?>" /></td>
  </tr>
  <tr>
    <td class="bold">Designation <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Designation" id="Catalog_Designation" class="textField" value="<?php echo $Catalog_Designation;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile</td>
    <td>:</td>
    <td><input type="text" name="Catelog_mobile" id="Catelog_mobile" class="textField" value="<?php echo $Catelog_mobile;?>" /></td>
  </tr>
  <tr>
    <td class="bold">Address <sup>* </sup></td>
    <td>:</td>
    <td><textarea name="Catalog_Address1" id="Catalog_Address1" cols="45" rows="5" class="textArea" ><?php echo $Catalog_Address1;?></textarea></td>
    <td>&nbsp;</td>
    <td class="bold">E-Mail <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Email" id="Catalog_Email" class="textField" value="<?php echo $Catalog_Email;?>" /></td>
  </tr>
  <tr>
    <td class="bold">City <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_City" id="Catalog_City" class="textField" value="<?php echo $Catalog_City; ?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">Pin Code <sup>* </sup></td>
    <td>:</td>
    <td><input type="text" name="Catalog_Pincode" id="Catalog_Pincode" class="textField" value="<?php echo $Catalog_Pincode; ?>" /></td>
  </tr>
  <tr>
    <td class="bold">Website</td>
    <td>:</td>
    <td><input type="text" name="Catalog_Website" id="Catalog_Website" class="textField" value="<?php echo $Catalog_Website; ?>" /></td>
	<td>&nbsp;</td>
	<td class="bold">Stall No.</td>
    <td>:</td>
    <td>
    <input type="text" name="CSN" id="CSN" class="textField" value="<?php echo $Catalog_StallNo; ?>"  disabled="disabled"/>
    <input type="hidden" name="Catalog_StallNo" id="Catalog_StallNo" class="textField" value="<?php echo $Catalog_StallNo; ?>" readonly="readonly"/></td>
  </tr>
  <tr>
    <td class="bold">Country</td>
    <td>:</td>
    <td><input type="text" name="Catalog_CountryId" id="Catalog_CountryId" class="textField" value="<?php echo getCountryName($Catalog_CountryId,$conn); ?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">State</td>
    <td>:</td>
    <td><input type="text" name="Catalog_State" id="Catalog_State" class="textField" value="<?php echo $Catalog_State; ?>" /></td>
  </tr>

</table>

<div class="clear"></div>

<div class="title"><h4>A brief write-up of the company is not more than 1000 characters</h4></div>

<div class="clear"></div>

<p>The write-up should give information on present exports, number of years the company has been operating, offices around the world if any, special product features, special customer services, certifications received etc</p>
<p><textarea  name="Catalog_Brief" class="Catalog_Brief" cols="100" rows="3" id="Catalog_Brief"><?php echo stripslashes($Catalog_Brief);?></textarea></p>

<div class="clear"></div>


<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   <div class="leftStatus"><span><input name="Info_Approved" id="Info_Approved2" type="radio" value="Y" <?php if($Info_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Info_Approved" id="Info_Approved" type="radio" value="N" <?php if($Info_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo "$Info_Reason"; ?></textarea></td>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>

<div class="title">Brand Names</div>

<div class="clear"></div>
<div class="borderBottom"></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>

    <td width="146">Brand Name 1</td>
    <td width="36">:</td>
    <td width="253"><input type="text" name="brand_names[]" id="textfield18" class="textField" value="<?php echo $brand_name1?>" <?php //if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td width="163">Brand Name 4</td>
    <td width="30">:</td>
    <td width="262"><input type="text" name="brand_names[]" id="textfield19" class="textField" value="<?php echo $brand_name4; ?>" <?php //if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td>Brand Name 2</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name2; ?>" <?php //if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>Brand Name 5</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name5; ?>" <?php //if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td>Brand Name 3</td>
    <td>:</td>
    <td><input type="text" name="brand_names[]" id="textfield20" class="textField" value="<?php echo $brand_name3; ?>" <?php //if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    
</table>

<div class="clear"></div>

<div class="title"><h4>Product Picture</h4> </div>

<div class="clear"></div>

<p>Please upload colored picture of your choice representing a product or advertising campaign of your company. Please ensure there is no integration of additional text to the picture or mention of prices. The size of the photo should not exceed 2 MB, minimum resolution required is 300 dpi (Accepted Format JPEG)</p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="37%"><div class="bottomSpace">
	<?php if($Catalog_ProductLogo==""){ ?>
	<img src="images/logo.png" alt="" width="100" height="100" />
	<?php }else{ ?>
    	<img src="../images/catalog/<?php echo $exhibitor_code;?>/<?php echo $Catalog_ProductLogo; ?>" width="189" height="177" alt="" />
        <?php }?>
    </div>
    </td>
    <td width="57%"> 
       <div class="bottomSpace"><strong class="maroonColor">Photo Approval</strong></div>
        
<div class="bottomSpace">
	   <div class="leftStatus">
       <span><input name="ProductLogo_Approved" id="ProductLogo_Approved" type="radio" value="Y" <?php if($ProductLogo_Approved=='Y'){ echo "checked='checked'";}?> /></span> Approved</div>
       
       <div class="leftStatus">
       <span><input name="ProductLogo_Approved" id="ProductLogo_Approved" type="radio" value="N" <?php if($ProductLogo_Approved=='N'){ echo "checked='checked'"; }?> /></span> Disapproved</div>

       <div class="clear"></div>
       <textarea name="ProductLogo_Reason" id="ProductLogo_Reason" class="newTextArea"><?php echo $ProductLogo_Reason;?></textarea>
</div>
        </td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <div class="chooseButton" style="float:left;">
      <input type="file" name="Catalog_ProductLogo" id="Catalog_ProductLogo" class="chooseFile" />
      </div> 
    <div class="clear"></div>
          </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="title"><h4>Company Logo / Trademark</h4></div>

<div class="clear"></div>

<p>Please upload a logo of your company and ensure that the size of the logo should not exceed 2MB, minimum resolution required is 300 dpi (Accepted Format JPEG, GIF)</p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="37%"><div class="bottomSpace">
    <?php if($Catalog_CompanyLogo==""){ ?>
    	<img src="images/logo.png"  alt="" width="150" height="100"/>
    <?php }else{ ?>
    <img src="../images/catalog/<?php echo $exhibitor_code;?>/<?php echo $Catalog_CompanyLogo; ?>" width="189" height="177" alt="" />
    <?php }?>
    </div></td>
    <td width="57%">    <div class="bottomSpace">
        <strong>Product Approval</strong>
        </div>
     <div class="bottomSpace">
	   <div class="leftStatus">
       <span><input name="CompanyLogo_Approved" id="CompanyLogo_Approved" type="radio" value="Y" <?php if($CompanyLogo_Approved=='Y'){ echo "checked='checked'";}?> /></span> Approved</div>
       
       <div class="leftStatus">
       <span><input name="CompanyLogo_Approved" id="CompanyLogo_Approved" type="radio" value="N" <?php if($CompanyLogo_Approved=='N'){ echo "checked='checked'"; }?> /></span> Disapproved</div>

       <div class="clear"></div>
       <textarea name="CompanyLogo_Reason" id="CompanyLogo_Reason" class="newTextArea"><?php echo $CompanyLogo_Reason;?></textarea>
	</div>
        
 </td>
    <td width="3%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <div class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;"><span class="chooseButton" style="float:left;">
      <input type="file" name="Catalog_CompanyLogo" id="Catalog_CompanyLogo" class="chooseFile" />
    </span></span></span></div> 
		<div class="clear"></div>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<div align="center">
<input type="submit" name="submit" value="Submit" class="maroon_btn" />
<a href="manage_compulsory_catalogue.php?action=view"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>
</form>
</div>

</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>