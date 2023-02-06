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
?>

<?php
$action=$_REQUEST['action'];
if($action=='ADD')
{
$EXHIBITOR_CODE=mysql_real_escape_string($_REQUEST['EXHIBITOR_CODE']);
$applicant_name=mysql_real_escape_string($_REQUEST['applicant_name']);
$applicant_company_name=mysql_real_escape_string($_REQUEST['applicant_company_name']);
$applicant_email_id=mysql_real_escape_string($_REQUEST['applicant_email_id']);
$applicant_mobile_no=mysql_real_escape_string($_REQUEST['applicant_mobile_no']);
$applicant_country=mysql_real_escape_string($_REQUEST['applicant_country']);
$applicant_state=mysql_real_escape_string($_REQUEST['applicant_state']);
$hotel_id=mysql_real_escape_string($_REQUEST['hotel_id']);
$hotel_details_id=mysql_real_escape_string($_REQUEST['hotel_details_id']);
$no_of_room=mysql_real_escape_string($_REQUEST['no_of_room']);
$guest_name=mysql_real_escape_string($_REQUEST['guest_name']);
$guest_company_name=mysql_real_escape_string($_REQUEST['guest_company_name']);
$guest_email_id=mysql_real_escape_string($_REQUEST['guest_email_id']);
$guest_mobile_no=mysql_real_escape_string($_REQUEST['guest_mobile_no']);
$guest_city=mysql_real_escape_string($_REQUEST['guest_city']);
$guest_country=mysql_real_escape_string($_REQUEST['guest_country']);
$sharer_name=mysql_real_escape_string($_REQUEST['sharer_name']);
$arrival_flight_no=mysql_real_escape_string($_REQUEST['arrival_flight_no']);
$arrival_from=mysql_real_escape_string($_REQUEST['arrival_from']);
$arrival_date=$_REQUEST['arrival_dd']."-".$_REQUEST['arrival_mm']."-".$_REQUEST['arrival_yyyy'];
$arrival_time=$_REQUEST['arrival_hh'].":".$_REQUEST['arrival_ss']." ".$_REQUEST['arrival_am'];
$departure_flight_no=mysql_real_escape_string($_REQUEST['departure_flight_no']);
$departure_from=mysql_real_escape_string($_REQUEST['departure_from']);
$departure_date=$_REQUEST['departure_dd']."-".$_REQUEST['departure_mm']."-".$_REQUEST['departure_yyyy'];
$departure_time=$_REQUEST['departure_hh'].":".$_REQUEST['departure_ss']." ".$_REQUEST['departure_am'];
$check_in_date=$_REQUEST['ck_in_dd']."-".$_REQUEST['ck_in_mm']."-".$_REQUEST['ck_in_yyyy'];
$check_in_time=$_REQUEST['ck_in_hh'].":".$_REQUEST['ck_in_ss']." ".$_REQUEST['ck_in_am'];
$check_out_date=$_REQUEST['ck_out_dd']."-".$_REQUEST['ck_out_mm']."-".$_REQUEST['ck_out_yyyy'];
$check_out_time=$_REQUEST['ck_out_hh'].":".$_REQUEST['ck_out_ss']." ".$_REQUEST['ck_out_am'];
$total_payable=mysql_real_escape_string($_REQUEST['total_payable']);
$credit_card_type=mysql_real_escape_string($_REQUEST['credit_card_type']);
$any_other=mysql_real_escape_string($_REQUEST['any_other']);
$credit_card_no=mysql_real_escape_string($_REQUEST['credit_card_no']);
$exp_mm=mysql_real_escape_string($_REQUEST['exp_mm']);
$exp_yyyy=mysql_real_escape_string($_REQUEST['exp_yyyy']);
$ip_address=$_SERVER['REMOTE_ADDR'];
$Create_Date=date("Y-m-d");
$Modify_Date=date("Y-m-d");
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

if($Info_Approved=='Y')
{
	$Application_Complete='Y';
}else if($Info_Approved=='P')
{
	$Application_Complete='P';
}else
{
	$Application_Complete='N';
}	

$hotel_data="select * from hotel_registration_details where Exhibitor_Code='$exhibitor_code'";
$result_hotel=mysql_query($hotel_data);
$num_rows=mysql_num_rows($result_hotel);


	if($num_rows==0)
	{
	$sqlhotel="INSERT INTO  `hotel_registration_details` (`EXHIBITOR_CODE`,`applicant_name` ,`applicant_company_name` ,`applicant_email_id` ,`applicant_mobile_no` ,`applicant_country` ,`applicant_state`,`hotel_id` ,`hotel_details_id` ,`no_of_room` ,`guest_name` ,`guest_company_name` ,`guest_email_id` ,`guest_mobile_no` ,`guest_city` ,`guest_country` ,`sharer_name` ,`arrival_flight_no` ,`arrival_from` ,`arrival_date` ,`arrival_time` ,`departure_flight_no` ,`departure_from` ,`departure_date` ,`departure_time` ,`check_in_date` ,`check_in_time` ,`check_out_date` ,`check_out_time` ,`total_payable` ,`credit_card_type` ,`any_other` ,`credit_card_no` ,`exp_mm` ,`exp_yyyy` ,`ip_address` ,`Info_Recieved`,Info_Approved,Info_Reason,Application_Complete,Create_Date,Modify_Date)VALUES ('$EXHIBITOR_CODE','$applicant_name' ,  '$applicant_company_name',  '$applicant_email_id',  '$applicant_mobile_no','$applicant_country','$applicant_state','$hotel_id',  '$hotel_details_id',  '$no_of_room',  '$guest_name',  '$guest_company_name',  '$guest_email_id',  '$guest_mobile_no',  '$guest_city',  '$guest_country',  '$sharer_name',  '$arrival_flight_no',  '$arrival_from',  '$arrival_date',  '$arrival_time',  '$departure_flight_no',  '$departure_from',  '$departure_date','$departure_time',  '$check_in_date',  '$check_in_time',  '$check_out_date',  '$check_out_time',  '$total_payable',  '$credit_card_type',  '$any_other',  '$credit_card_no',  '$exp_mm',  '$exp_yyyy', '$ip_address',  '1','P','','P','$Create_Date','$Modify_Date')";
	   $resulthotel=mysql_query($sqlhotel);

	}else
	{
	$updatehotel="update `hotel_registration_details` set `applicant_name`='$applicant_name' ,`applicant_company_name`='$applicant_company_name' ,`applicant_email_id`='$applicant_email_id' ,`applicant_mobile_no`='$applicant_mobile_no' ,`applicant_country`='$applicant_country' ,`applicant_state`='$applicant_state',`hotel_id`='$hotel_id' ,`hotel_details_id`='$hotel_details_id' ,`no_of_room`='$no_of_room' ,`guest_name`='$guest_name' ,`guest_company_name`='$guest_company_name' ,`guest_email_id`='$guest_email_id' ,`guest_mobile_no`='$guest_mobile_no' ,`guest_city`='$guest_city' ,`guest_country`='$guest_country' ,`sharer_name`='$sharer_name' ,`arrival_flight_no`='$arrival_flight_no' ,`arrival_from`='$arrival_from' ,`arrival_date`='$arrival_date' ,`arrival_time`='$arrival_time' ,`departure_flight_no`='$departure_flight_no' ,`departure_from`='$departure_from' ,`departure_date`='$departure_date' ,`departure_time`='$departure_time' ,`check_in_date`='$check_in_date' ,`check_in_time`='$check_in_time' ,`check_out_date`='$check_out_date' ,`check_out_time`='$check_out_time' ,`total_payable`='$total_payable' ,`credit_card_type`='$credit_card_type' ,`any_other`='$any_other' ,`credit_card_no`='$credit_card_no' ,`exp_mm`='$exp_mm' ,`exp_yyyy`='$exp_yyyy',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete',Modify_Date='$$Modify_Date' where Exhibitor_Code='$exhibitor_code'";
	
	$resultupdate=mysql_query($updatehotel);
		if($Info_Approved!='P')
		{
				if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='N'){$Info_Approved='Disapproved';}
			
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
				<p>Your details for the Online Application for  <strong>Form No. 13. Hotel Reservation</strong> has been updated by Signature Admin.</p>
				<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
				  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
					<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >Hotel Form</td>
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
				
				
				</tr>
				
				</table>';
				
				$to =$Exhibitor_Email.',notification@gjepcindia.com';
				//$to = "rohit@kwebmaker.com";
				$subject = "".$event." Exhibitor Manual - Form No. 13. Hotel Reservation"; 
				$headers  = 'MIME-Version: 1.0' . "\r\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
				$headers .= 'From:admin@gjepc.org';			
				mail($to, $subject, $message, $headers);
				
		}


	}

	echo '<script type="text/javascript">'; 
	echo 'window.location.href = "manage_hotel_reservation.php";';
	echo '</script>';
	exit;
}

?>
<?php 
$hotel_data="select * from hotel_registration_details where Exhibitor_Code='$exhibitor_code'";
$result_hotel=mysql_query($hotel_data);
$fetch_hotel=mysql_fetch_array($result_hotel);
$num=mysql_num_rows($result_hotel);

if($num==0)
{
	$applicant_name=$fetch_visa['Exhibitor_Contact_Person'];
	$applicant_company_name=$fetch_visa['Exhibitor_Name'];
	$applicant_email_id=$fetch_visa['Exhibitor_Email'];
	$applicant_mobile_no=$fetch_visa['Exhibitor_Mobile'];
	$applicant_country=$fetch_visa['Exhibitor_Country_ID'];
	$applicant_state=$fetch_visa['Exhibitor_State'];
}else
{
$applicant_name=$fetch_hotel['applicant_name'];
$applicant_company_name=$fetch_hotel['applicant_company_name'];
$applicant_email_id=$fetch_hotel['applicant_email_id'];
$applicant_mobile_no=$fetch_hotel['applicant_mobile_no'];
$applicant_country=$fetch_hotel['applicant_country'];
$applicant_state=$fetch_hotel['applicant_state'];
$hotel_id=$fetch_hotel['hotel_id'];
$hotel_details_id=$fetch_hotel['hotel_details_id'];
$no_of_room=$fetch_hotel['no_of_room'];
$guest_name=$fetch_hotel['guest_name'];
$guest_company_name=$fetch_hotel['guest_company_name'];
$guest_email_id=$fetch_hotel['guest_email_id'];
$guest_mobile_no=$fetch_hotel['guest_mobile_no'];
$guest_city=$fetch_hotel['guest_city'];
$guest_country=$fetch_hotel['guest_country'];
$sharer_name=$fetch_hotel['sharer_name'];
$arrival_flight_no=$fetch_hotel['arrival_flight_no'];
$arrival_from=$fetch_hotel['arrival_from'];
$arrival_date=explode("-", $fetch_hotel['arrival_date']);
	$arrival_dd=$arrival_date[0];
	$arrival_mm=$arrival_date[1];
	$arrival_yyyy=$arrival_date[2];
$arrival_time=explode(":", $fetch_hotel['arrival_time']);
	$arrival_hh=$arrival_time[0];
	$arrival_ss1=explode(" ", $arrival_time[1]);
	$arrival_ss=$arrival_ss1[0];
	$arrival_am=$arrival_ss1[1];
$departure_flight_no=$fetch_hotel['departure_flight_no'];
$departure_from=$fetch_hotel['departure_from'];
$departure_date=explode("-", $fetch_hotel['departure_date']);
	$departure_dd=$departure_date[0];
	$departure_mm=$departure_date[1];
	$departure_yyyy=$departure_date[2];
$departure_time=explode(":", $fetch_hotel['departure_time']);
	$departure_hh=$departure_time[0];
	$departure_ss1=explode(" ", $departure_time[1]);
	$departure_ss=$departure_ss1[0];
	$departure_am=$departure_ss1[1];

$check_in_date=explode("-", $fetch_hotel['check_in_date']);
	$ck_in_dd=$check_in_date[0];
	$ck_in_mm=$check_in_date[1];
	$ck_in_yyyy=$check_in_date[2];
$check_in_time=explode(":", $fetch_hotel['check_in_time']);
	$ck_in_hh=$check_in_time[0];
	$ck_in_ss1=explode(" ", $check_in_time[1]);
	$ck_in_ss=$ck_in_ss1[0];
	$ck_in_am=$ck_in_ss1[1];

$check_out_date=explode("-", $fetch_hotel['check_out_date']);
	$ck_out_dd=$check_out_date[0];
	$ck_out_mm=$check_out_date[1];
	$ck_out_yyyy=$check_out_date[2];
$check_out_time=explode(":", $fetch_hotel['check_out_time']);
	$ck_out_hh=$check_out_time[0];
	$ck_out_ss1=explode(" ", $check_out_time[1]);
	$ck_out_ss=$ck_out_ss1[0];
	$ck_out_am=$ck_in_ss1[1];

$total_payable=$fetch_hotel['total_payable'];
$credit_card_type=$fetch_hotel['credit_card_type'];
$any_other=$fetch_hotel['any_other'];
$credit_card_no=$fetch_hotel['credit_card_no'];
$exp_mm=$fetch_hotel['exp_mm'];
$exp_yyyy=$fetch_hotel['exp_yyyy'];

$Info_Recieved=$fetch_hotel['Info_Recieved'];
$Info_Approved=$fetch_hotel['Info_Approved'];
$Info_Reason=$fetch_hotel['Info_Reason'];
$Application_Complete=$fetch_hotel['Application_Complete'];
$Create_Date=$fetch_hotel['Create_Date'];
$Modify_Date=$fetch_hotel['Modify_Date'];
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hotel Reservation</title>
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



<SCRIPT type="text/javascript">
$(document).ready(function() {
	$("#hotel_id").change(function(){
	hotel_id=$("#hotel_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax_hotel.php',
					data: "actiontype=getRoom&hotel_id="+hotel_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
							     $("#hotelDiv").html(data);  
							}
		});
 	});
});
</SCRIPT>

<script>
$(document).ready(function(){
 $("#hotel_details_id").live('change',function(){
	hotel_details_id=$("#hotel_details_id").val();
	$.ajax({ type: 'POST',
	url: 'ajax_hotel.php',
	data: "actiontype=getRate&hotel_details_id="+hotel_details_id,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#rateDiv").html(data);  
						//alert(data);
	}
	});
	
});
 
 	$("#hotel_details_id").live('change',function(){
	hotel_details_id=$("#hotel_details_id").val();
	if(hotel_details_id==2 || hotel_details_id==4 || hotel_details_id==6)
	{
		$('#share_div').show("");
	}else
	{
		$('#share_div').hide("");
	}
	});
	
	$("#applicant_country").live('change',function(){
	country=$("#applicant_country").val();
	
	$.ajax({ type: 'POST',
					url: 'ajax_hotel.php',
					data: "actiontype=getState&country="+country,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
							     $("#stateDiv").html(data);  
							}
		});
 	});
	
	
	
	
});
</script>

<SCRIPT type="text/javascript">
$("#ck_in_dd").live('change',function(){
	ck_in_dd=$("#ck_in_dd").val();
	$.ajax({ type: 'POST',
	url: 'ajax_hotel.php',
	data: "actiontype=getoutDate&ck_in_dd="+ck_in_dd,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){  
						$('#ck_out_dd').html(data);
		}
	});
});
</SCRIPT>


<SCRIPT type="text/javascript">
$(document).ready(function() {
	$("#cal_total_pay").click(function(){
	ck_in_dd=$("#ck_in_dd").val();
	ck_out_dd=$("#ck_out_dd").val();
	no_of_room=$("#no_of_room").val();
	hotel_details_id=$("#hotel_details_id").val();
	$.ajax({ type: 'POST',
	url: 'ajax_hotel.php',
	data: "actiontype=calculatePayment&ck_in_dd="+ck_in_dd+"&ck_out_dd="+ck_out_dd+"&hotel_details_id="+hotel_details_id+"&no_of_room="+no_of_room,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){  
						$('#total_payable').val(data);
		}
	  });
	});
});
</SCRIPT>

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
	<div class="breadcome"><a href="manage_hotel_reservation.php?action=view">Home</a> > Hotel Reservations</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Hotel Reservations</div>
     	<div class="content_details22">
        <div id="formWrapper">
<h2>Notes :</h2>
<p>We do not have any triple occupancy rooms available in any of the hotels. Please advice credit card number with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable:</p>



<ol class="numeric">
<li>Any cancellation after the 20th of Jan 2014, will attract 100% retention on the entire booking.</li>
<li>Any cancellation after the 20th of Jan 2014, will attract 100% retention on the entire booking.</li>
<li>In case of NO - Show the entire length of stay will be charged to the credit card.</li>
<li>Please note airport transfers would be arranged only on receipt of flight details.</li>
</ol>

<p>The sections marked with a <span class="red">*</span> are compulsory.</p>


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



<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()"> 
<input type="hidden" name="action" value="ADD" />
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $exhibitor_code;?>" />


<div class="title">
  <h4>Applicant Details</h4>
</div>

<div class="clear"></div>


<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Name <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_name" id="applicant_name" class="textField" value="<?php echo $applicant_name;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">Company Name <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_company_name" id="applicant_company_name" class="textField" value="<?php echo $applicant_company_name;?>"/></td>
  </tr>
  
  <tr>
    <td class="bold">Email ID <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_email_id" id="applicant_email_id" class="textField" value="<?php echo $applicant_email_id;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile No  <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_mobile_no" id="applicant_mobile_no" class="textField" value="<?php echo $applicant_mobile_no;?>" /></td>
  </tr>
  
  <tr>
    <td class="bold">Country <sup>*</sup></td>
    <td>:</td>
    <td><select name="applicant_country" id="applicant_country" class="textField">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	  $sql="SELECT * FROM  `iijs_country_master`";
	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
		  if($rows['Country_ID']==$applicant_country){
	  	  echo "<option selected='selected' value='$rows[Country_ID]'>$rows[Country_Name]</option>";
		  }else{
		  echo "<option value='$rows[Country_ID]'>$rows[Country_Name]</option>";
		  }
	  }
	  ?>
    </select></td>
    <td>&nbsp;</td>
    <td class="bold">State  <sup>*</sup></td>
    <td>:</td>
    <td id="stateDiv">
    <select name="applicant_state" id="applicant_state" class="textField">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	  $sql="SELECT * from iijs_state_master WHERE country_code = 'IND'";
	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
		  if($rows['state_code']==$applicant_state)
		  {
	  		echo "<option selected='selected' value='$rows[state_code]'>$rows[state_name]</option>";
		  }else{
		  	echo "<option value='$rows[state_code]'>$rows[state_name]</option>";
		  }
	  }
	  ?>
    </select>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

</table>
<div class="title">
<h4>Hotel Information</h4>

</div>
<div class="clear"></div>

  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    
    <tr>
      <td width="19%"  class="bold">Hotel Name <sup>*</sup></td>
      <td width="3%">:</td>
      <td width="32%"><select name="hotel_id" id="hotel_id" class="textField">
        <option value="" selected="selected">-- Select -- </option>
        <?php 
		  $sql1="SELECT * FROM  `hotel_master` where status=1";
		  $result1=mysql_query($sql1);
		  while($rows1=mysql_fetch_array($result1))
		  {
			  if($rows1['hotel_id']==$hotel_id)
		  		{
					echo "<option selected='selected' value='$rows1[hotel_id]'>$rows1[hotel_name]</option>"; 
					
				}else{
					echo "<option value='$rows1[hotel_id]'>$rows1[hotel_name]</option>"; 
				}
		  
		  }
		 ?>
      </select></td>
      <td width="15%" class="bold"><span class="bold">Rate</span></td>
      <td width="2%" class="bold">:</td>
      <td width="29%" id="rateDiv">Rs. <?php if($hotel_id=='1'){echo "7000";}else if($hotel_id=='2'){echo "6250";}else if($hotel_id=='3'){echo "6000";}else {echo "0";}?></td>
    </tr>
    
     <tr>
      <td  class="bold">Room Type <sup>*</sup></td>
      <td>:</td>
      <td id="hotelDiv"><select class="textField" name="hotel_details_id" id="hotel_details_id">
        <option value="" selected="selected">-- Select -- </option>
        <?php 
		if($hotel_details_id=='1' || $hotel_details_id=='3' || $hotel_details_id=='5')
		{
		echo "<option value='' selected='selected'>Single</option>";
		}else if($hotel_details_id=='2' || $hotel_details_id=='4' || $hotel_details_id=='6')
		{
		echo "<option value='' selected='selected'>Double</option>";
		}
		?>
      </select></td>
      <td class="bold"><span class="bold">No. of Rooms <sup>*</sup></span></td>
      <td>:</td>
      <td><input type="text" name="no_of_room" id="no_of_room" class="textField" value="<?php echo $no_of_room;?>"/></td>
     </tr>
   
  </table>

<div class="title">
  <h4>Guest Information</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Name  <sup>*</sup></td>
    <td>:</td>
    <td>
      <input type="text" name="guest_name" id="guest_name" class="textField" value="<?php echo $guest_name;?>"/>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Company Name <sup>*</sup></td>
    <td>:</td> 
    <td><input type="text" name="guest_company_name" id="guest_company_name" class="textField" value="<?php echo $guest_company_name;?>"/></td>
  </tr>
  <tr>
    <td class="bold"><p>Email ID <sup>*</sup></p></td>
    <td>:</td>
    <td><input type="text" name="guest_email_id" id="guest_email_id" class="textField" value="<?php echo $guest_email_id;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile No <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="guest_mobile_no" id="guest_mobile_no" class="textField" value="<?php echo $guest_mobile_no;?>"/></td>
  </tr>
  <tr>
    <td class="bold">City <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="guest_city" id="guest_city" class="textField" value="<?php echo $guest_city;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">Country <sup>*</sup></td>
    <td>:</td>
    <td>
    <select name="guest_country" id="guest_country" class="textField">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	  $sql="SELECT * FROM  `iijs_country_master`";
	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
		  if($rows['Country_ID']==$guest_country){
	  	  echo "<option selected='selected' value='$rows[Country_ID]'>$rows[Country_Name]</option>";
		  }else{
		  echo "<option value='$rows[Country_ID]'>$rows[Country_Name]</option>";
		  }
	  
	  }
	  ?>
    </select></td>
  </tr>
  
  <tr id="share_div" style="display:none;">
    <td class="bold">Sharer Name</td>
    <td>:</td>
    <td><input type="text" name="sharer_name" id="sharer_name" class="textField" value="<?php echo $sharer_name;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 

  
</table>



<div class="title">
<h4>Flight Schedule</h4>

</div>
<div class="clear"></div>
	<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Arrival Flight No </td>
    <td>:</td>
    <td>
      <input type="text" name="arrival_flight_no" id="arrival_flight_no" class="textField" value="<?php echo $arrival_flight_no;?>"/>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Arrival From </td>
    <td>:</td>
    <td><input type="text" name="arrival_from" id="arrival_from" class="textField" value="<?php echo $arrival_from;?>"/></td>
  </tr>
  <tr>
    <td class="bold"><p>Arrival Date </p></td>
    <td>:</td>
    <td>
    <select name="arrival_dd" id="arrival_dd" class="textField" style="width:55px;">
        <option value="" selected="selected">DD</option>
        <option value="15" <?php if($arrival_dd=='15'){echo "selected='selected'";}?>>15</option>
        <option value="16" <?php if($arrival_dd=='16'){echo "selected='selected'";}?>>16</option>
        <option value="17" <?php if($arrival_dd=='17'){echo "selected='selected'";}?>>17</option>
        <option value="18" <?php if($arrival_dd=='18'){echo "selected='selected'";}?>>18</option>
        <option value="19" <?php if($arrival_dd=='19'){echo "selected='selected'";}?>>19</option>
        <option value="20" <?php if($arrival_dd=='20'){echo "selected='selected'";}?>>20</option>
        <option value="21" <?php if($arrival_dd=='21'){echo "selected='selected'";}?>>21</option>
        <option value="22" <?php if($arrival_dd=='22'){echo "selected='selected'";}?>>22</option>
        <option value="23" <?php if($arrival_dd=='23'){echo "selected='selected'";}?>>23</option>
        <option value="24" <?php if($arrival_dd=='24'){echo "selected='selected'";}?>>24</option>
        <option value="25" <?php if($arrival_dd=='25'){echo "selected='selected'";}?>>25</option>
        <option value="26" <?php if($arrival_dd=='26'){echo "selected='selected'";}?>>26</option>
        <option value="27" <?php if($arrival_dd=='27'){echo "selected='selected'";}?>>27</option>
        <option value="28" <?php if($arrival_dd=='28'){echo "selected='selected'";}?>>28</option>
        </select>
      <select name="arrival_mm" id="arrival_mm" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($arrival_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="arrival_yyyy" id="arrival_yyyy" class="textField" style="width:65px;">
        <option value="" selected="selected">YYYY</option>
        <option value="2014" <?php if($arrival_yyyy=='2014'){echo "selected='selected'";}?>>2014</option>
      </select>
      
    </td>
    <td>&nbsp;</td>
    <td class="bold">Arrival Time </td>
    <td>:</td>
    <td><select name="arrival_hh" id="arrival_hh" class="textField" style="width:55px;">
      <option value="" selected="selected">HH</option>
      <option value="01" <?php if($arrival_hh=='01'){echo "selected='selected'";}?>>01</option>
      <option value="02" <?php if($arrival_hh=='02'){echo "selected='selected'";}?>>02</option>
      <option value="03" <?php if($arrival_hh=='03'){echo "selected='selected'";}?>>03</option>
      <option value="04" <?php if($arrival_hh=='04'){echo "selected='selected'";}?>>04</option>
      <option value="05" <?php if($arrival_hh=='05'){echo "selected='selected'";}?>>05</option>
      <option value="06" <?php if($arrival_hh=='06'){echo "selected='selected'";}?>>06</option>
      <option value="07" <?php if($arrival_hh=='07'){echo "selected='selected'";}?>>07</option>
      <option value="08" <?php if($arrival_hh=='08'){echo "selected='selected'";}?>>08</option>
      <option value="09" <?php if($arrival_hh=='09'){echo "selected='selected'";}?>>09</option>
      <option value="10" <?php if($arrival_hh=='10'){echo "selected='selected'";}?>>10</option>
      <option value="11" <?php if($arrival_hh=='11'){echo "selected='selected'";}?>>11</option>
      <option value="12" <?php if($arrival_hh=='12'){echo "selected='selected'";}?>>12</option>
    </select>
      <select name="arrival_ss" id="arrival_ss" class="textField" style="width:55px;">
      <option value="" selected="selected">MM</option>
        <option value="00" <?php if($arrival_ss=='00'){echo "selected='selected'";}?>>00</option>
        <option value="05" <?php if($arrival_ss=='05'){echo "selected='selected'";}?>>05</option>
        <option value="10" <?php if($arrival_ss=='10'){echo "selected='selected'";}?>>10</option>
        <option value="15" <?php if($arrival_ss=='15'){echo "selected='selected'";}?>>15</option>
        <option value="20" <?php if($arrival_ss=='20'){echo "selected='selected'";}?>>20</option>
        <option value="25" <?php if($arrival_ss=='25'){echo "selected='selected'";}?>>25</option>
        <option value="30" <?php if($arrival_ss=='30'){echo "selected='selected'";}?>>30</option>
        <option value="35" <?php if($arrival_ss=='35'){echo "selected='selected'";}?>>35</option>
        <option value="40" <?php if($arrival_ss=='40'){echo "selected='selected'";}?>>40</option>
        <option value="45" <?php if($arrival_ss=='45'){echo "selected='selected'";}?>>45</option>
        <option value="50" <?php if($arrival_ss=='50'){echo "selected='selected'";}?>>50</option>
        <option value="55" <?php if($arrival_ss=='55'){echo "selected='selected'";}?>>55</option>
      </select>
      <select name="arrival_am" id="arrival_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($arrival_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="bold">Departure Flight No </td>
    <td>:</td>
    <td><input type="text" name="departure_flight_no" id="departure_flight_no" value="<?php echo $departure_flight_no;?>" class="textField" /></td>
    <td>&nbsp;</td>
    <td class="bold">Departure From </td>
    <td>:</td>
    <td><input type="text" name="departure_from" id="departure_from" value="<?php echo $departure_from;?>" class="textField"/></td>
  </tr>
  <tr>
    <td class="bold"><p>Departure Date </p></td>
    <td>:</td>
    <td>
    <select name="departure_dd" id="departure_dd" class="textField" style="width:55px;">
        <option value="" selected="selected">DD</option>
        <option value="15" <?php if($departure_dd=='15'){echo "selected='selected'";}?>>15</option>
        <option value="16" <?php if($departure_dd=='16'){echo "selected='selected'";}?>>16</option>
        <option value="17" <?php if($departure_dd=='17'){echo "selected='selected'";}?>>17</option>
        <option value="18" <?php if($departure_dd=='18'){echo "selected='selected'";}?>>18</option>
        <option value="19" <?php if($departure_dd=='19'){echo "selected='selected'";}?>>19</option>
        <option value="20" <?php if($departure_dd=='20'){echo "selected='selected'";}?>>20</option>
        <option value="21" <?php if($departure_dd=='21'){echo "selected='selected'";}?>>21</option>
        <option value="22" <?php if($departure_dd=='22'){echo "selected='selected'";}?>>22</option>
        <option value="23" <?php if($departure_dd=='23'){echo "selected='selected'";}?>>23</option>
        <option value="24" <?php if($departure_dd=='24'){echo "selected='selected'";}?>>24</option>
        <option value="25" <?php if($departure_dd=='25'){echo "selected='selected'";}?>>25</option>
        <option value="26" <?php if($departure_dd=='26'){echo "selected='selected'";}?>>26</option>
        <option value="27" <?php if($departure_dd=='27'){echo "selected='selected'";}?>>27</option>
        <option value="28" <?php if($departure_dd=='28'){echo "selected='selected'";}?>>28</option>
        </select>
      <select name="departure_mm" id="departure_mm" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($departure_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>

      <select name="departure_yyyy" id="departure_yyyy" class="textField" style="width:65px;">
        <option value="" selected="selected">YYYY</option>
        <option value="2014" <?php if($departure_yyyy=='2014'){echo "selected='selected'";}?>>2014</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Departure Time </td>
    <td>:</td>
    <td>
    <select name="departure_hh" id="departure_hh" class="textField" style="width:55px;">
        <option value="" selected="selected">HH</option>
       	  <option value="01" <?php if($departure_hh=='01'){echo "selected='selected'";}?>>01</option>
          <option value="02" <?php if($departure_hh=='02'){echo "selected='selected'";}?>>02</option>
          <option value="03" <?php if($departure_hh=='03'){echo "selected='selected'";}?>>03</option>
          <option value="04" <?php if($departure_hh=='04'){echo "selected='selected'";}?>>04</option>
          <option value="05" <?php if($departure_hh=='05'){echo "selected='selected'";}?>>05</option>
          <option value="06" <?php if($departure_hh=='06'){echo "selected='selected'";}?>>06</option>
          <option value="07" <?php if($departure_hh=='07'){echo "selected='selected'";}?>>07</option>
          <option value="08" <?php if($departure_hh=='08'){echo "selected='selected'";}?>>08</option>
          <option value="09" <?php if($departure_hh=='09'){echo "selected='selected'";}?>>09</option>
          <option value="10" <?php if($departure_hh=='10'){echo "selected='selected'";}?>>10</option>
          <option value="11" <?php if($departure_hh=='11'){echo "selected='selected'";}?>>11</option>
          <option value="12" <?php if($departure_hh=='12'){echo "selected='selected'";}?>>12</option>
        </select>
      <select name="departure_ss" id="departure_ss" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        	<option value="00" <?php if($departure_ss=='00'){echo "selected='selected'";}?>>00</option>
            <option value="05" <?php if($departure_ss=='05'){echo "selected='selected'";}?>>05</option>
            <option value="10" <?php if($departure_ss=='10'){echo "selected='selected'";}?>>10</option>
            <option value="15" <?php if($departure_ss=='15'){echo "selected='selected'";}?>>15</option>
            <option value="20" <?php if($departure_ss=='20'){echo "selected='selected'";}?>>20</option>
            <option value="25" <?php if($departure_ss=='25'){echo "selected='selected'";}?>>25</option>
            <option value="30" <?php if($departure_ss=='30'){echo "selected='selected'";}?>>30</option>
            <option value="35" <?php if($departure_ss=='35'){echo "selected='selected'";}?>>35</option>
            <option value="40" <?php if($departure_ss=='40'){echo "selected='selected'";}?>>40</option>
            <option value="45" <?php if($departure_ss=='45'){echo "selected='selected'";}?>>45</option>
            <option value="50" <?php if($departure_ss=='50'){echo "selected='selected'";}?>>50</option>
            <option value="55" <?php if($departure_ss=='55'){echo "selected='selected'";}?>>55</option>
      </select>
      <select name="departure_am" id="departure_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($departure_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
  </tr>
 

  
</table>
	<div class="title">
  <h4>Check-In Check-Out Details</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Check-In Date <sup>*</sup></td>
    <td>:</td>
    <td><select name="ck_in_dd" id="ck_in_dd" class="textField" style="width:55px;">
      <option value="" selected="selected">DD</option>
      <option value="18" <?php if($ck_in_dd=='18'){echo "selected='selected'";}?>>18</option>
      <option value="19" <?php if($ck_in_dd=='19'){echo "selected='selected'";}?>>19</option>
      <option value="20" <?php if($ck_in_dd=='20'){echo "selected='selected'";}?>>20</option>
      <option value="21" <?php if($ck_in_dd=='21'){echo "selected='selected'";}?>>21</option>
      <option value="22" <?php if($ck_in_dd=='22'){echo "selected='selected'";}?>>22</option>
      <option value="23" <?php if($ck_in_dd=='23'){echo "selected='selected'";}?>>23</option>
      <option value="24" <?php if($ck_in_dd=='24'){echo "selected='selected'";}?>>24</option>
      <option value="25" <?php if($ck_in_dd=='25'){echo "selected='selected'";}?>>25</option>
      <option value="26" <?php if($ck_in_dd=='26'){echo "selected='selected'";}?>>26</option>
      <option value="27" <?php if($ck_in_dd=='27'){echo "selected='selected'";}?>>27</option>
      <option value="28" <?php if($ck_in_dd=='28'){echo "selected='selected'";}?>>28</option>
    </select>
      <select name="ck_in_mm" id="ck_in_mm" class="textField" style="width:55px;">
      <option value="" selected="selected">MM</option>
        <option value="02" <?php if($ck_in_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="ck_in_yyyy" id="ck_in_yyyy" class="textField" style="width:65px;">
        <option value="" selected="selected">YYYY</option>
        <option value="2014" <?php if($ck_in_yyyy=='2014'){echo "selected='selected'";}?>>2014</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Check-In Time <sup>*</sup></td>
    <td>:</td>
    <td>
     <select name="ck_in_hh" id="ck_in_hh" class="textField" style="width:55px;">
        <option value="" selected="selected">HH</option>
          <option value="01" <?php if($ck_in_hh=='01'){echo "selected='selected'";}?>>01</option>
          <option value="02" <?php if($ck_in_hh=='02'){echo "selected='selected'";}?>>02</option>
          <option value="03" <?php if($ck_in_hh=='03'){echo "selected='selected'";}?>>03</option>
          <option value="04" <?php if($ck_in_hh=='04'){echo "selected='selected'";}?>>04</option>
          <option value="05" <?php if($ck_in_hh=='05'){echo "selected='selected'";}?>>05</option>
          <option value="06" <?php if($ck_in_hh=='06'){echo "selected='selected'";}?>>06</option>
          <option value="07" <?php if($ck_in_hh=='07'){echo "selected='selected'";}?>>07</option>
          <option value="08" <?php if($ck_in_hh=='08'){echo "selected='selected'";}?>>08</option>
          <option value="09" <?php if($ck_in_hh=='09'){echo "selected='selected'";}?>>09</option>
          <option value="10" <?php if($ck_in_hh=='10'){echo "selected='selected'";}?>>10</option>
          <option value="11" <?php if($ck_in_hh=='11'){echo "selected='selected'";}?>>11</option>
          <option value="12" <?php if($ck_in_hh=='12'){echo "selected='selected'";}?>>12</option>
        </select>
      <select name="ck_in_ss" id="ck_in_ss" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00" <?php if($ck_in_ss=='00'){echo "selected='selected'";}?>>00</option>
        <option value="05" <?php if($ck_in_ss=='05'){echo "selected='selected'";}?>>05</option>
        <option value="10" <?php if($ck_in_ss=='10'){echo "selected='selected'";}?>>10</option>
        <option value="15" <?php if($ck_in_ss=='15'){echo "selected='selected'";}?>>15</option>
        <option value="20" <?php if($ck_in_ss=='20'){echo "selected='selected'";}?>>20</option>
        <option value="25" <?php if($ck_in_ss=='25'){echo "selected='selected'";}?>>25</option>
        <option value="30" <?php if($ck_in_ss=='30'){echo "selected='selected'";}?>>30</option>
        <option value="35" <?php if($ck_in_ss=='35'){echo "selected='selected'";}?>>35</option>
        <option value="40" <?php if($ck_in_ss=='40'){echo "selected='selected'";}?>>40</option>
        <option value="45" <?php if($ck_in_ss=='45'){echo "selected='selected'";}?>>45</option>
        <option value="50" <?php if($ck_in_ss=='50'){echo "selected='selected'";}?>>50</option>
        <option value="55" <?php if($ck_in_ss=='55'){echo "selected='selected'";}?>>55</option>
      </select>
      <select name="ck_in_am" id="ck_in_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($ck_in_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
    </tr>
  
  
  <tr>
    <td class="bold">Check-Out Date <sup>* </sup></td>
    <td>:</td>
    <td>
    <select name="ck_out_dd" id="ck_out_dd" class="textField" style="width:55px;">
        <option value="" selected="selected">DD</option>
        <?php if($ck_out_dd!="")
		{
			echo "<option selected='selected'>$ck_out_dd</option>";
		}
		?>
    </select>
      <select name="ck_out_mm" id="ck_out_mm" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($ck_out_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="ck_out_yyyy" id="ck_out_yyyy" class="textField" style="width:65px;">
        <option value="" selected="selected">YYYY</option>
        <option value="2014" <?php if($ck_out_yyyy=='2014'){echo "selected='selected'";}?>>2014</option>
      </select>
    
    </td>
    <td>&nbsp;</td>
    <td class="bold">Check-Out Time <sup>*</sup></td>
    <td>:</td>
    <td>
     <select name="ck_out_hh" id="ck_out_hh" class="textField" style="width:55px;">
        <option value="" selected="selected">HH</option>
       	  <option value="01" <?php if($ck_out_hh=='01'){echo "selected='selected'";}?>>01</option>
          <option value="02" <?php if($ck_out_hh=='02'){echo "selected='selected'";}?>>02</option>
          <option value="03" <?php if($ck_out_hh=='03'){echo "selected='selected'";}?>>03</option>
          <option value="04" <?php if($ck_out_hh=='04'){echo "selected='selected'";}?>>04</option>
          <option value="05" <?php if($ck_out_hh=='05'){echo "selected='selected'";}?>>05</option>
          <option value="06" <?php if($ck_out_hh=='06'){echo "selected='selected'";}?>>06</option>
          <option value="07" <?php if($ck_out_hh=='07'){echo "selected='selected'";}?>>07</option>
          <option value="08" <?php if($ck_out_hh=='08'){echo "selected='selected'";}?>>08</option>
          <option value="09" <?php if($ck_out_hh=='09'){echo "selected='selected'";}?>>09</option>
          <option value="10" <?php if($ck_out_hh=='10'){echo "selected='selected'";}?>>10</option>
          <option value="11" <?php if($ck_out_hh=='11'){echo "selected='selected'";}?>>11</option>
          <option value="12" <?php if($ck_out_hh=='12'){echo "selected='selected'";}?>>12</option>
        </select>
      <select name="ck_out_ss" id="ck_out_ss" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00" <?php if($ck_out_ss=='00'){echo "selected='selected'";}?>>00</option>
        <option value="05" <?php if($ck_out_ss=='05'){echo "selected='selected'";}?>>05</option>
        <option value="10" <?php if($ck_out_ss=='10'){echo "selected='selected'";}?>>10</option>
        <option value="15" <?php if($ck_out_ss=='15'){echo "selected='selected'";}?>>15</option>
        <option value="20" <?php if($ck_out_ss=='20'){echo "selected='selected'";}?>>20</option>
        <option value="25" <?php if($ck_out_ss=='25'){echo "selected='selected'";}?>>25</option>
        <option value="30" <?php if($ck_out_ss=='30'){echo "selected='selected'";}?>>30</option>
        <option value="35" <?php if($ck_out_ss=='35'){echo "selected='selected'";}?>>35</option>
        <option value="40" <?php if($ck_out_ss=='40'){echo "selected='selected'";}?>>40</option>
        <option value="45" <?php if($ck_out_ss=='45'){echo "selected='selected'";}?>>45</option>
        <option value="50" <?php if($ck_out_ss=='50'){echo "selected='selected'";}?>>50</option>
        <option value="55" <?php if($ck_out_ss=='55'){echo "selected='selected'";}?>>55</option>
      </select>
      <select name="ck_out_am" id="ck_out_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($ck_out_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
  </tr>
 
</table>



<div class="title">
<h4>Payment Details:</h4>

</div>
<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual" style="width:665px;">
  <tr>
    <td  class="bold">Total Payable</td>
    <td>:</td>
    <td><input type="text" name="total_payable" id="total_payable" class="textField" readonly="readonly" value="<?php echo $total_payable;?>"/></td>
  </tr>
  <tr>
    <td  class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td> <input name="cal_total_pay" id="cal_total_pay" type="button" class="submitButton" value="CALCULATE" /></td>
  </tr>
</table>

<div class="title">
<h4>Credit Card Details:</h4>

</div>
<div class="clear"></div>


<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:665px;">
  
  <tr>
      <td  class="bold">Credit Card Details <sup>*</sup></td>
      <td>:</td>	
      
    <td><select name="credit_card_type" id="credit_card_type" class="textField">
      <option value="" selected="selected">-- Select -- </option>
      <option value="AmEx" <?php if($credit_card_type=='AmEx'){echo "selected='seleted'";}?>>American Express</option>
      <option value="Visa" <?php if($credit_card_type=='Visa'){echo "selected='seleted'";}?>>Visa Card</option>
      <option value="MasterCard" <?php if($credit_card_type=='MasterCard'){echo "selected='seleted'";}?>>Master Card</option>
      <option value="DinersClub" <?php if($credit_card_type=='DinersClub'){echo "selected='seleted'";}?>>Dinners Card</option>
    </select></td>
    </tr>
    <tr>
      <td  class="bold">Credit Card Number <br />
        (Don't include space)</td>
      <td>:</td>
      <td><input type="text" name="credit_card_no" id="credit_card_no" class="textField" value="<?php echo "$credit_card_no";?>"/></td>
    </tr>
    
    <tr>
      <td  class="bold">Expiry Date</td>
      <td>:</td>
      <td><select name="exp_mm" id="exp_mm" class="textField" style="width:60px;">
        <option value="" selected="selected">-MM-</option>
        <option value="01" <?php if($exp_mm=='01'){echo "selected='seleted'";}?>>01</option>
        <option value="02" <?php if($exp_mm=='02'){echo "selected='seleted'";}?>>02</option>
        <option value="03" <?php if($exp_mm=='03'){echo "selected='seleted'";}?>>03</option>
        <option value="04" <?php if($exp_mm=='04'){echo "selected='seleted'";}?>>04</option>
        <option value="05" <?php if($exp_mm=='05'){echo "selected='seleted'";}?>>05</option>
        <option value="06" <?php if($exp_mm=='06'){echo "selected='seleted'";}?>>06</option>
        <option value="07" <?php if($exp_mm=='07'){echo "selected='seleted'";}?>>07</option>
        <option value="08" <?php if($exp_mm=='08'){echo "selected='seleted'";}?>>08</option>
        <option value="09" <?php if($exp_mm=='09'){echo "selected='seleted'";}?>>09</option>
        <option value="10" <?php if($exp_mm=='10'){echo "selected='seleted'";}?>>10</option>
        <option value="11" <?php if($exp_mm=='11'){echo "selected='seleted'";}?>>11</option>
        <option value="12" <?php if($exp_mm=='12'){echo "selected='seleted'";}?>>12</option>
      </select>
        <select name="exp_yyyy" id="exp_yyyy" class="textField" style="width:90px;">
        <option value="" selected="selected">-YYYY-</option>
        <option value="2015" <?php if($exp_yyyy=='2015'){echo "selected='seleted'";}?>>2015</option>
        <option value="2016" <?php if($exp_yyyy=='2016'){echo "selected='seleted'";}?>>2016</option>
        <option value="2017" <?php if($exp_yyyy=='2017'){echo "selected='seleted'";}?>>2017</option>
        <option value="2018" <?php if($exp_yyyy=='2018'){echo "selected='seleted'";}?>>2018</option>
        <option value="2019" <?php if($exp_yyyy=='2019'){echo "selected='seleted'";}?>>2019</option>
        <option value="2020" <?php if($exp_yyyy=='2020'){echo "selected='seleted'";}?>>2020</option>
        <option value="2020" <?php if($exp_yyyy=='2021'){echo "selected='seleted'";}?>>2021</option>
        <option value="2020" <?php if($exp_yyyy=='2022'){echo "selected='seleted'";}?>>2022</option>
        <option value="2020" <?php if($exp_yyyy=='2023'){echo "selected='seleted'";}?>>2023</option>
        <option value="2020" <?php if($exp_yyyy=='2024'){echo "selected='seleted'";}?>>2024</option>
      </select>
      </td>
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
 
    
   <div class="leftStatus"><span><input name="Info_Approved" id="Info_Approved" type="radio" value="Y" <?php if($Info_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Info_Approved" id="Info_Approved" type="radio" value="N" <?php if($Info_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo "$Info_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>


    <div align="center">
       <input type="submit" value="Submit" class="maroon_btn" />
    <a href="manage_hotel_reservation.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
    </div>
    
    
</form>
</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
