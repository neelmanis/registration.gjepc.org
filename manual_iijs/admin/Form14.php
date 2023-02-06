<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>


<?php
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_visa=mysql_fetch_array($result);

$Exhibitor_Name=$fetch_visa['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_visa['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_visa['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_visa['Exhibitor_Fax'];
$Exhibitor_StallNo[]="";
for($i=0;$i<8;$i++){
	if($fetch_visa["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_visa["Exhibitor_StallNo".($i+1)];
}
$stall_no=implode(", ",$Exhibitor_StallNo);
$Exhibitor_HallNo=$fetch_visa['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_visa['Exhibitor_Region'];
$Exhibitor_Section=$fetch_visa['Exhibitor_Section'];
$Exhibitor_Area=$fetch_visa['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_visa['Exhibitor_DivisionNo'];

$visa_data="select * from iijs_visa_application where Exhibitor_Code='$exhibitor_code'";
$result_visa=mysql_query($visa_data);
$fetch_visa=mysql_fetch_array($result_visa);
$num=mysql_num_rows($result_visa);

$Exhibitor_Code=$exhibitor_code;
$Visa_Application_Name=$fetch_visa['Visa_Application_Name'];
$Visa_Application_Gender=$fetch_visa['Visa_Application_Gender'];
$Visa_Application_Nationality=$fetch_visa['Visa_Application_Nationality'];
$Visa_Application_DOB=date('d-m-Y',strtotime($fetch_visa['Visa_Application_DOB']));
$Visa_Application_Designation=$fetch_visa['Visa_Application_Designation'];
$Visa_Application_PassportNo=$fetch_visa['Visa_Application_PassportNo'];
$Visa_Application_Date_of_Issue=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date_of_Issue']));
$Visa_Application_Date_of_Expiry=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date_of_Expiry']));
$Visa_Application_Place_of_Issue=$fetch_visa['Visa_Application_Place_of_Issue'];
$Visa_Application_Location=$fetch_visa['Visa_Application_Location'];
$Visa_Application_Indian_Embassy=$fetch_visa['Visa_Application_Indian_Embassy'];
$Visa_Application_Address1=$fetch_visa['Visa_Application_Address1'];
$Visa_Application_City=$fetch_visa['Visa_Application_City'];
$Visa_Application_Country_ID=$fetch_visa['Visa_Application_Country_ID'];
$Visa_Application_Pincode=$fetch_visa['Visa_Application_Pincode'];
$Visa_Application_Telephone=$fetch_visa['Visa_Application_Telephone'];
$Visa_Application_Fax=$fetch_visa['Visa_Application_Fax'];
$Visa_Application_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Date']));
$Visa_Application_Arrival_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Arrival_Date']));
$Visa_Application_Arrival_FlightNo=$fetch_visa['Visa_Application_Arrival_FlightNo'];
$Visa_Application_Arrival_Entry_Port=$fetch_visa['Visa_Application_Arrival_Entry_Port'];
$Visa_Application_Departure_Date=date('d-m-Y',strtotime($fetch_visa['Visa_Application_Departure_Date']));
$Visa_Application_Departure_FlightNo=$fetch_visa['Visa_Application_Departure_FlightNo'];
$Visa_Application_Departure_Port=$fetch_visa['Visa_Application_Departure_Port'];
$Info_Recieved=$fetch_visa['Info_Recieved'];
$Info_Reason=$fetch_visa['Info_Reason'];
$Info_Approved=$fetch_visa['Info_Approved'];
$Application_Complete=$fetch_visa['Application_Complete'];
$passport_pic=$fetch_visa['passport_pic'];
$passport_pic_approved=$fetch_visa['passport_pic_approved'];
$passport_pic_reason=$fetch_visa['passport_pic_reason'];
$Create_Date=$fetch_visa['Create_Date'];


if($_REQUEST['action']=="ADD")
{
		   
	if(isset($_FILES['passport_pic']) && $_FILES['passport_pic']['name']!="")
	{
		//Unlink the previuos image
		$qpreviousimg=mysql_query("select passport_pic from iijs_visa_application where Exhibitor_Code='$exhibitor_code'");
		$rpreviousimg=mysql_fetch_array($qpreviousimg);
		$filename="../images/visa/".$exhibitor_code."/".$rpreviousimg['passport_pic'];
		unlink($filename);
	
		$file_name=$_FILES['passport_pic']['name'];
		$file_temp=$_FILES['passport_pic']['tmp_name'];
		$file_type=$_FILES['passport_pic']['type'];
		$file_size=$_FILES['passport_pic']['size'];
		$attach="P";
		if($_FILES['passport_pic']['name']!="")
		{
			$passport_pic=uploadImageAdmin($file_name,$file_temp,$file_type,$file_size,$attach,"visa",$exhibitor_code);
		}
		
		$sql_passport_pic="update iijs_visa_application set Modify_Date=NOW(),passport_pic='$passport_pic' where Exhibitor_Code='$exhibitor_code'";
		if(!mysql_query($sql_passport_pic)){
			echo "error ".mysql_error();
		}
	}
	
	if(isset($_POST['Visa_Application_Name']))
	{
		
	$Visa_Application_Name=mysql_real_escape_string($_POST['Visa_Application_Name']);
	$Visa_Application_Gender=$_POST['Visa_Application_Gender'];
	$Visa_Application_Nationality=mysql_real_escape_string($_POST['Visa_Application_Nationality']);
	$Visa_Application_DOB=date("Y-m-d",strtotime($_POST['Visa_Application_DOB']));
	$Visa_Application_Designation=mysql_real_escape_string($_POST['Visa_Application_Designation']);
	$Visa_Application_PassportNo=mysql_real_escape_string($_POST['Visa_Application_PassportNo']);
	$Visa_Application_Date_of_Issue=date("Y-m-d",strtotime($_POST['Visa_Application_Date_of_Issue']));
	$Visa_Application_Date_of_Expiry=date("Y-m-d",strtotime($_POST['Visa_Application_Date_of_Expiry']));
	$Visa_Application_Place_of_Issue=mysql_real_escape_string($_POST['Visa_Application_Place_of_Issue']);
	$Visa_Application_Location=mysql_real_escape_string($_POST['Visa_Application_Location']);
	$Visa_Application_Indian_Embassy=mysql_real_escape_string($_POST['Visa_Application_Indian_Embassy']);
	$Visa_Application_Address1=mysql_real_escape_string($_POST['Visa_Application_Address1']);
	$Visa_Application_City=mysql_real_escape_string($_POST['Visa_Application_City']);
	$Visa_Application_Country_ID=mysql_real_escape_string($_POST['Visa_Application_Country_ID']);
	$Visa_Application_Pincode=mysql_real_escape_string($_POST['Visa_Application_Pincode']);
	$Visa_Application_Telephone=mysql_real_escape_string($_POST['Visa_Application_Telephone']);
	$Visa_Application_Fax=mysql_real_escape_string($_POST['Visa_Application_Fax']);
	$Visa_Application_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Date']));
	$Visa_Application_Arrival_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Arrival_Date']));
	$Visa_Application_Arrival_FlightNo=mysql_real_escape_string($_POST['Visa_Application_Arrival_FlightNo']);
	$Visa_Application_Arrival_Entry_Port=mysql_real_escape_string($_POST['Visa_Application_Arrival_Entry_Port']);
	$Visa_Application_Departure_Date=date("Y-m-d",strtotime($_POST['Visa_Application_Departure_Date']));
	$Visa_Application_Departure_FlightNo=mysql_real_escape_string($_POST['Visa_Application_Departure_FlightNo']);
	$Visa_Application_Departure_Port=mysql_real_escape_string($_POST['Visa_Application_Departure_Port']);

$passport_pic_approved=mysql_real_escape_string($_REQUEST['passport_pic_approved']);
if($passport_pic_approved=='Y')
{
$passport_pic_reason="";	
}else
{
$passport_pic_reason=mysql_real_escape_string($_REQUEST['passport_pic_reason']);
}
if($passport_pic_approved=='')
{
	$passport_pic_approved='P';
	$passport_pic_reason="";	
}


$Info_Approved=mysql_real_escape_string($_REQUEST['Info_Approved']);
if($Info_Approved=='Y')
{
$Info_Reason="";	
}else
{
$Info_Reason=mysql_real_escape_string($_REQUEST['Info_Reason']);
}
if($Info_Approved=='')
{
	$Info_Approved='P';
	$Info_Reason="";	
}



if($Info_Approved=='Y' && $passport_pic_approved=='Y')
{
	$Application_Complete='Y';
}else if($Info_Approved=='P' && $passport_pic_approved=='P')
{
	$Application_Complete='P';
}else
{
	$Application_Complete='N';
}	

	
$sql_update="update iijs_visa_application set Visa_Application_Name='$Visa_Application_Name',
									Visa_Application_Gender='$Visa_Application_Gender',
									Visa_Application_Nationality='$Visa_Application_Nationality',
									Visa_Application_DOB='$Visa_Application_DOB',
									Visa_Application_Designation='$Visa_Application_Designation',
									Visa_Application_PassportNo='$Visa_Application_PassportNo',
									Visa_Application_Date_of_Issue='$Visa_Application_Date_of_Issue',
									Visa_Application_Date_of_Expiry='$Visa_Application_Date_of_Expiry',
									Visa_Application_Place_of_Issue='$Visa_Application_Place_of_Issue',
									Visa_Application_Location='$Visa_Application_Location',
									Visa_Application_Indian_Embassy='$Visa_Application_Indian_Embassy',
									Visa_Application_Address1='$Visa_Application_Address1',
									Visa_Application_City='$Visa_Application_City',
									Visa_Application_Country_ID='$Visa_Application_Country_ID',
									Visa_Application_Pincode='$Visa_Application_Pincode',
									Visa_Application_Telephone='$Visa_Application_Telephone',
									Visa_Application_Fax='$Visa_Application_Fax',
									Visa_Application_Date='$Visa_Application_Date',
									Visa_Application_Arrival_Date='$Visa_Application_Arrival_Date',
									Visa_Application_Arrival_FlightNo='$Visa_Application_Arrival_FlightNo',
									Visa_Application_Arrival_Entry_Port='$Visa_Application_Arrival_Entry_Port',
									Visa_Application_Departure_Date='$Visa_Application_Departure_Date',
									Visa_Application_Departure_FlightNo='$Visa_Application_Departure_FlightNo',
									passport_pic_approved='$passport_pic_approved',
									passport_pic_reason='$passport_pic_reason',
									Info_Approved='$Info_Approved',
									Info_Reason='$Info_Reason',
									Application_Complete='$Application_Complete',
									Modify_Date=NOW(),
									Visa_Application_Departure_Port='$Visa_Application_Departure_Port' where Exhibitor_Code='$exhibitor_code'";
									
$sql_insert="insert into iijs_visa_application set Exhibitor_Code='$exhibitor_code',	
									Visa_Application_Name='$Visa_Application_Name',
									Visa_Application_Gender='$Visa_Application_Gender',
									Visa_Application_Nationality='$Visa_Application_Nationality',
									Visa_Application_DOB='$Visa_Application_DOB',
									Visa_Application_Designation='$Visa_Application_Designation',
									Visa_Application_PassportNo='$Visa_Application_PassportNo',
									Visa_Application_Date_of_Issue='$Visa_Application_Date_of_Issue',
									passport_pic='$passport_pic',
									Visa_Application_Date_of_Expiry='$Visa_Application_Date_of_Expiry',
									Visa_Application_Place_of_Issue='$Visa_Application_Place_of_Issue',
									Visa_Application_Location='$Visa_Application_Location',
									Visa_Application_Indian_Embassy='$Visa_Application_Indian_Embassy',
									Visa_Application_Address1='$Visa_Application_Address1',
									Visa_Application_City='$Visa_Application_City',
									Visa_Application_Country_ID='$Visa_Application_Country_ID',
									Visa_Application_Pincode='$Visa_Application_Pincode',
									Visa_Application_Telephone='$Visa_Application_Telephone',
									Visa_Application_Fax='$Visa_Application_Fax',
									Visa_Application_Date='$Visa_Application_Date',
									Visa_Application_Arrival_Date='$Visa_Application_Arrival_Date',
									Visa_Application_Arrival_FlightNo='$Visa_Application_Arrival_FlightNo',
									Visa_Application_Arrival_Entry_Port='$Visa_Application_Arrival_Entry_Port',
									Visa_Application_Departure_Date='$Visa_Application_Departure_Date',
									Visa_Application_Departure_FlightNo='$Visa_Application_Departure_FlightNo',
									Info_Recieved='Y',
									Application_Complete='P',
									Create_Date=NOW(),
									Visa_Application_Departure_Port='$Visa_Application_Departure_Port'";

				
	
				if($num>0)
				{
					if(!mysql_query($sql_update))
						echo "error ".mysql_error();
				if($Info_Approved!='P' && $passport_pic_approved!='P')
				{
				if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='N'){$Info_Approved='Disapproved';}
				if($passport_pic_approved=='Y'){$passport_pic_approved='Approved';}else if($passport_pic_approved=='N'){$passport_pic_approved='Disapproved';}
				
			
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
				<p>Your details for the Online Application for  <strong>Form No. 14. VISA APPLICATION ASSISTANCE</strong> has been updated by Signature Admin.</p>
				<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
				
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
					<td style="border:1px solid  #cccccc; padding:5px;" >Passport Copy</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$passport_pic_approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$passport_pic_reason.' </td>
				  </tr>
				  
		</table>
		
				<p>Kind regards, <br />
				<strong>Signature Web Team,</strong>
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
				//$to="rohit@kwebmaker.com";
				$subject = "".$event." Manual - Form No. 14. VISA APPLICATION ASSISTANCE"; 
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
	}
	echo '<script type="text/javascript">'; 
	//echo 'alert("You have successfully submitted your application.");'; 
	echo 'window.location.href = "manage_visa_application_assistance.php";';
	echo '</script>';
}





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Visa Application Assistance</title>
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

<!-- calendar starts-->
<link rel="stylesheet" href="../../calendar/css/jquery-ui.css" />
  <script src="../../calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
  </script>
<!-- calendar ends-->

<script type="text/javascript">
function validation()
{
	
	

	if($('input[name=\'Info_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}
	
	if($('input[name=\'passport_pic_approved\']:checked').val() == "N")
	{
		if(document.getElementById('passport_pic_reason').value=="")
		{
			alert("Please Enter Disapprove Reason");
			document.getElementById('passport_pic_reason').focus();
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
	<div class="breadcome"><a href="manage_visa_application_assistance.php?action=view">Home</a> > Visa Application Assistance</div>
</div>

<div id="main">
  <div class="content">
   	<div class="content_head">Visa Application Assistance</div>
    <div class="content_details22">
      <div id="formWrapper">
        <h2>Terms & Conditions</h2>
        <ol class="numeric">
          <li>I shall enter India for the purpose of visiting in the SIGNATURE 2014 and shall not engage in any other activities not related to this event during my stay.</li>
          <li>I shall act as per attached itinerary (Daily schedule) during my stay in India and leave India as scheduled. If there is any change in my itinerary, I shall intimate the Gem & Jewellery Export Promotion Council. India, immediately.</li>
          <li>I shall observe the Indian law during my stay in India.</li>
          <li>I shall bear by myself all the expenses incurred in my visit to and in India, including airfare from and to my country, expenses for accommodation, and all other costs for my stay, and confirm that The Gem &amp; Jewellery Export Promotion Council has no responsibility for such expenses.</li>
          <li>Upon return to my country, I shall fax to GJEPC immediately the pages in my passport that shows my Indian entry visa and the departure stamp when leaving India.</li>
        </ol>
        <p>The sections marked with an <span class="red">*</span> are compulsory.</p>
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
        <div class="title">
          <h4>Instructions On Form Submission Personal Details</h4>
        </div>
        <div class="clear"></div>
        <form name="catalogue_entry" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
          <input type="hidden" name="action" value="ADD" />
          <table border="0" cellspacing="0" cellpadding="0" class="formManual">
            <tr>
              <td width="25%" class="bold">Name <sup>*</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Name" id="Visa_Application_Name" class="textField" value="<?php echo $Visa_Application_Name; ?>" /></td>
              <td >&nbsp;</td>
              <td class="bold">Gender <sup>* </sup></td>
              <td >:</td>
              <td ><input type="radio" id="Visa_Application_Gender" name="Visa_Application_Gender" value="Male" <?php if(preg_match('/Male/',$Visa_Application_Gender)){ echo ' checked="checked"'; } ?> />
                Male
                <input type="radio" name="Visa_Application_Gender" value="Female" <?php if(preg_match('/Female/',$Visa_Application_Gender)){ echo ' checked="checked"'; } ?>  />
                Famale</td>
            </tr>
            <tr>
              <td class="bold">Nationality <sup>* </sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Nationality" id="Visa_Application_Nationality" class="textField" value="<?php echo $Visa_Application_Nationality; ?>" /></td>
              <td>&nbsp;</td>
              <td class="bold">DOB <sup>* </sup></td>
              <td>:</td>
              <td><input name="Visa_Application_DOB" id="Visa_Application_DOB" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_DOB!="01-01-1970"){echo $Visa_Application_DOB; }?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Designation <sup>* </sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Designation" id="Visa_Application_Designation" class="textField" value="<?php echo $Visa_Application_Designation; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Passport No.<sup> *</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_PassportNo" id="Visa_Application_PassportNo" class="textField" value="<?php echo $Visa_Application_PassportNo; ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Date of Issue <sup>*</sup></td>
              <td>:</td>
              <td><input name="Visa_Application_Date_of_Issue" id="Visa_Application_Date_of_Issue" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_Date_of_Issue!="01-01-1970"){echo $Visa_Application_Date_of_Issue;} ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Date of Expiry <sup>* </sup></td>
              <td>:</td>
              <td><input name="Visa_Application_Date_of_Expiry" id="Visa_Application_Date_of_Expiry" type="text"  class="calendar datepicker" value="<?php if($Visa_Application_Date_of_Expiry!="01-01-1970"){echo $Visa_Application_Date_of_Expiry;} ?>" /></td>
            </tr>
            <tr>
              <td class="bold">Place of Issue <sup>* </sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Place_of_Issue" id="Visa_Application_Place_of_Issue" class="textField" value="<?php echo $Visa_Application_Place_of_Issue; ?>" /></td>
              <td>&nbsp;</td>
              <td class="bold">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="bold">Passport Copy <sup>* </sup></td>
              <td>:</td>
              <td><input type="file" name="passport_pic" id="passport_pic" /></td>
              <td colspan="4"><?php if($passport_pic==""){ ?>
                <img src="../images/user_pic.jpg" width="189" height="177" alt="" />
                <?php }else{ ?>
                <img src="../images/visa/<?php echo $exhibitor_code;?>/<?php echo $passport_pic; ?>" width="189" height="177" alt="" />
                <?php }?></td>
            </tr>
            <tr>
              <td colspan="4"><table border="0" cellspacing="0" cellpadding="0" class="formManual">
                <tr>
                  <td width="150" class="bold"><strong>Passport Copy Approval Status</strong></td>
                  <td>:</td>
                  <td><div class="leftStatus"><span>
                    <input name="passport_pic_approved" id="passport_pic_approved" type="radio" value="Y" <?php if($passport_pic_approved=='Y'){ echo "checked='checked'";}?> />
                  </span>Approval </div>
                    <div class="leftStatus"> <span>
                      <input name="passport_pic_approved" id="passport_pic_approved" type="radio" value="N" <?php if($passport_pic_approved=='N'){ echo "checked='checked'";}?> />
                    </span> Disapprove</div>
                    <div class="clear"></div>
                    <textarea name="passport_pic_reason" id="passport_pic_reason" class="textArea"><?php echo "$passport_pic_reason"; ?></textarea></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="5" >Where do you want to submit your visa application ?</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Location" id="Visa_Application_Location" class="textField" value="<?php echo $Visa_Application_Location; ?>"  /></td>
            </tr>
            <tr>
              <td colspan="5" >Name  Of Indian Embassy/ Consulate</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Indian_Embassy" id="Visa_Application_Indian_Embassy" class="textField" value="<?php echo $Visa_Application_Indian_Embassy; ?>" /></td>
            </tr>
            <tr>
              <td class="bold">Address <sup>*</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Address1" id="Visa_Application_Address1" class="textarea" value="<?php echo $Visa_Application_Address1; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Telephone <sup>*</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Telephone" id="Visa_Application_Telephone" class="textField" value="<?php echo $Visa_Application_Telephone; ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Pincode <sup>*</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Pincode" id="Visa_Application_Pincode" class="textField" value="<?php echo $Visa_Application_Pincode; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Fax</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Fax" id="Visa_Application_Fax" class="textField" value="<?php echo $Visa_Application_Fax; ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">City <sup>*</sup></td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_City" id="Visa_Application_City" class="textField" value="<?php echo $Visa_Application_City; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Date of Visa App.<sup>*</sup></td>
              <td>:</td>
              <td><input name="Visa_Application_Date" type="text"  class="calendar datepicker" id="Visa_Application_Date" value="<?php if($Visa_Application_Date!="01-01-1970"){echo $Visa_Application_Date;} ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Country <sup>*</sup></td>
              <td>:</td>
              <td><select name="Visa_Application_Country_ID" id="Visa_Application_Country_ID" style="width:150px;"  >
                <option value="" >-- Select -- </option>
                <?php 
			$country_sql = "SELECT * FROM  iijs_country_master";
			$getCountry = mysql_query($country_sql);		
		
			while($showCountry=mysql_fetch_array($getCountry))
			{	
				$countryId=$showCountry['Country_ID'];
				$countryName=$showCountry['Country_Name'];
				if($countryId==$Visa_Application_Country_ID)
					echo "<option value=$countryId selected='selected'>$countryName</option>";		
				else
					echo "<option value=$countryId >$countryName</option>";		
			}
		?>
              </select></td>
              <td>&nbsp;</td>
              <td class="bold">&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
          </table>
          <div class="title">
            <h4>Flight Schedule</h4>
          </div>
          <div class="clear"></div>
          <table border="0" cellspacing="0" cellpadding="0" class="formManual">
            <tr>
              <td class="bold">Arrival / Entry Date</td>
              <td>:</td>
              <td><input name="Visa_Application_Arrival_Date" type="text"  class="calendar datepicker" id="Visa_Application_Arrival_Date" value="<?php if($Visa_Application_Arrival_Date!="01-01-1970"){echo $Visa_Application_Arrival_Date;} ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Departure Date</td>
              <td>:</td>
              <td><input name="Visa_Application_Departure_Date" type="text"  class="calendar datepicker" id="Visa_Application_Departure_Date" value="<?php if($Visa_Application_Departure_Date!="01-01-1970"){echo $Visa_Application_Departure_Date;} ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Arrival Flight No.</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Arrival_FlightNo" id="Visa_Application_Arrival_FlightNo" class="textField" value="<?php echo $Visa_Application_Arrival_FlightNo; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Departure Flight No.</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Departure_FlightNo" id="Visa_Application_Departure_FlightNo" class="textField"  value="<?php echo $Visa_Application_Departure_FlightNo; ?>"  /></td>
            </tr>
            <tr>
              <td class="bold">Entry Port</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Arrival_Entry_Port" id="Visa_Application_Arrival_Entry_Port" class="textField" value="<?php echo $Visa_Application_Arrival_Entry_Port; ?>"  /></td>
              <td>&nbsp;</td>
              <td class="bold">Departing Port</td>
              <td>:</td>
              <td><input type="text" name="Visa_Application_Departure_Port" id="Visa_Application_Departure_Port" class="textField" value="<?php echo $Visa_Application_Departure_Port; ?>"  /></td>
            </tr>
          </table>
          <div class="clear"></div>
          <div class="title">
            <h4>Information Approval</h4>
          </div>
          <div class="clear"></div>
          <table border="0" cellspacing="0" cellpadding="0" class="formManual">
            <tr>
              <td width="150" class="bold"><strong>Status</strong></td>
              <td>:</td>
              <td><div class="leftStatus"><span>
                <input name="Info_Approved" id="Info_Approved" type="radio" value="Y" <?php if($Info_Approved=='Y'){ echo "checked='checked'";}?> />
              </span>Approval </div>
                <div class="leftStatus"> <span>
                  <input name="Info_Approved" id="Info_Approved" type="radio" value="N" <?php if($Info_Approved=='N'){ echo "checked='checked'";}?> />
                </span> Disapprove</div>
                <div class="clear"></div>
                <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo "$Info_Reason"; ?></textarea></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <div class="clear"></div>
          <p><sup>*</sup>
            <input name="iagree" type="checkbox" checked="checked"  />
            I hereby agree to vow to abide the given mentioned terms and conditions.</p>
          <div align="center">
            <input type="submit" value="Submit" class="maroon_btn" />
            <a href="manage_visa_application_assistance.php">
              <input name="input2" type="button" value="Cancel" class="maroon_btn" />
            </a></div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
