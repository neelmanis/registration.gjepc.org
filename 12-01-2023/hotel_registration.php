<?php include('header_include.php');?>

<?php 

echo '<script type="text/javascript">'; 
echo 'alert("Complimentary hotel Booking is now closed.");'; 
echo 'window.location.href = "https://gjepc.org/iijs-signature/";';
echo '</script>';	
?>

<?php
$action=$_REQUEST['action'];
$show ='signature22';
if($action=='ADD')
{
$company_pan=mysqli_real_escape_string($conn,strtoupper($_REQUEST['company_pan']));
$applicant_name=mysqli_real_escape_string($conn,strtoupper($_REQUEST['applicant_name']));
$applicant_company_name=mysqli_real_escape_string($conn,strtoupper($_REQUEST['applicant_company_name']));
$applicant_email_id=mysqli_real_escape_string($conn,$_REQUEST['applicant_email_id']);
$applicant_mobile_no=mysqli_real_escape_string($conn,$_REQUEST['applicant_mobile_no']);
$applicant_country=mysqli_real_escape_string($conn,$_REQUEST['applicant_country']);
$applicant_state=mysqli_real_escape_string($conn,$_REQUEST['applicant_state']);
$hotel_id=mysqli_real_escape_string($conn,$_REQUEST['hotel_id']);
$hotel_details_id=mysqli_real_escape_string($conn,$_REQUEST['hotel_details_id']);
$no_of_room=mysqli_real_escape_string($conn,$_REQUEST['no_of_room']);
$guest_name=mysqli_real_escape_string($conn,$_REQUEST['guest_name']);
$guest_company_name=mysqli_real_escape_string($conn,$_REQUEST['guest_company_name']);
$guest_email_id=mysqli_real_escape_string($conn,$_REQUEST['guest_email_id']);
$guest_mobile_no=mysqli_real_escape_string($conn,$_REQUEST['guest_mobile_no']);
$guest_city=mysqli_real_escape_string($conn,$_REQUEST['guest_city']);
$guest_country=mysqli_real_escape_string($conn,$_REQUEST['guest_country']);
if($guest_country=="")
  $guest_country=0;
$sharer_name=mysqli_real_escape_string($conn,$_REQUEST['sharer_name']);

$arrival_flight_no=mysqli_real_escape_string($conn,$_REQUEST['arrival_flight_no']);
$arrival_from=mysqli_real_escape_string($conn,$_REQUEST['arrival_from']);
$arrival_date=$_REQUEST['arrival_dd']."-".$_REQUEST['arrival_mm']."-".$_REQUEST['arrival_yyyy'];
$arrival_time=$_REQUEST['arrival_hh'].":".$_REQUEST['arrival_ss']." ".$_REQUEST['arrival_am'];
$departure_flight_no=mysqli_real_escape_string($conn,$_REQUEST['departure_flight_no']);
$departure_from=mysqli_real_escape_string($conn,$_REQUEST['departure_from']);
$departure_date=$_REQUEST['departure_dd']."-".$_REQUEST['departure_mm']."-".$_REQUEST['departure_yyyy'];
$departure_time=$_REQUEST['departure_hh'].":".$_REQUEST['departure_ss']." ".$_REQUEST['departure_am'];

$check_in_date= $_REQUEST['ck_in_yyyy']."-".$_REQUEST['ck_in_mm']."-".$_REQUEST['ck_in_dd'];
//$check_in_date_minus= $_REQUEST['ck_in_yyyy']."-".$_REQUEST['ck_in_mm']."-".$_REQUEST['ck_in_dd'];

$check_in_time=$_REQUEST['ck_in_hh'].":".$_REQUEST['ck_in_ss']." ".$_REQUEST['ck_in_am'];
$check_out_date = $_REQUEST['ck_out_yyyy']."-".$_REQUEST['ck_out_mm']."-".$_REQUEST['ck_out_dd'];

$check_out_time=$_REQUEST['ck_out_hh'].":".$_REQUEST['ck_out_ss']." ".$_REQUEST['ck_out_am'];
$total_payable=mysqli_real_escape_string($conn,$_REQUEST['total_payable']);
$credit_card_type=mysqli_real_escape_string($conn,$_REQUEST['credit_card_type']);
$any_other=mysqli_real_escape_string($conn,$_REQUEST['any_other']);
$credit_card_no=mysqli_real_escape_string($conn,$_REQUEST['credit_card_no']);
$exp_mm=mysqli_real_escape_string($conn,$_REQUEST['exp_mm']);
$exp_yyyy=mysqli_real_escape_string($conn,$_REQUEST['exp_yyyy']);
$ip_address=$_SERVER['REMOTE_ADDR'];
$post_date=date("Y-m-d");

$guest_1 = mysqli_real_escape_string($conn,$_REQUEST['guest_1']);
$guest_2 = mysqli_real_escape_string($conn,$_REQUEST['guest_2']);
$guest_1_name = getVisitorName($guest_1,$conn);
$guest_2_name = getVisitorName($guest_2,$conn);
$Guest1_Email = mysqli_real_escape_string($conn,$_REQUEST['Guest1_Email']);
$Guest2_Email = mysqli_real_escape_string($conn,$_REQUEST['Guest2_Email']);
$Guest1_Mobile = mysqli_real_escape_string($conn,$_REQUEST['Guest1_Mobile']);
$Guest2_Mobile = mysqli_real_escape_string($conn,$_REQUEST['Guest2_Mobile']);

if(!empty($applicant_email_id) && !empty($applicant_company_name)){
$sqlhotel="INSERT INTO  `iijs_hotel_registration_details` (`company_pan`,`applicant_name` ,`applicant_company_name` ,`applicant_email_id` ,`applicant_mobile_no` ,`applicant_country` ,`applicant_state`,`hotel_id` ,`hotel_details_id` ,`no_of_room` ,`guest_name` ,`guest_company_name` ,`guest_email_id` ,`guest_mobile_no` ,`guest_city` ,`guest_country` ,`sharer_name` ,`arrival_flight_no` ,`arrival_from` ,`arrival_date` ,`arrival_time` ,`departure_flight_no` ,`departure_from` ,`departure_date` ,`departure_time` ,`check_in_date` ,`check_in_time` ,`check_out_date` ,`check_out_time` ,`total_payable` ,`credit_card_type` ,`any_other` ,`credit_card_no` ,`exp_mm` ,`exp_yyyy` ,`status` ,`ip_address` ,`post_date`,`guest_1`,`guest_2`,`Guest1_Email`,`Guest2_Email`,`Guest1_Mobile`,`Guest2_Mobile`,`guest_1_name`,`guest_2_name`)VALUES ('$company_pan','$applicant_name' ,  '$applicant_company_name',  '$applicant_email_id',  '$applicant_mobile_no','$applicant_country','$applicant_state','$hotel_id',  '$hotel_details_id',  '$no_of_room',  '$guest_name',  '$guest_company_name',  '$guest_email_id',  '$guest_mobile_no',  '$guest_city',  '$guest_country',  '$sharer_name',  '$arrival_flight_no',  '$arrival_from',  '$arrival_date',  '$arrival_time',  '$departure_flight_no',  '$departure_from',  '$departure_date','$departure_time',  '$check_in_date',  '$check_in_time',  '$check_out_date',  '$check_out_time',  '$total_payable',  '$credit_card_type',  '$any_other',  '$credit_card_no',  '$exp_mm',  '$exp_yyyy',  '1',  '$ip_address',  '$post_date','$guest_1','$guest_2','$Guest1_Email','$Guest2_Email','$Guest1_Mobile','$Guest2_Mobile','$guest_1_name','$guest_2_name')";
$resulthotel = $conn->query($sqlhotel); 
 
// echo "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='$check_in_date'"; exit;

	if($check_in_date=="2022-02-17" && $check_out_date=="2022-02-18")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-17'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-17'";
		$minus = $conn->query($sqlx);
	}
	else if($check_in_date=="2022-02-17" && $check_out_date=="2022-02-19")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-17'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-17'";
		$minus = $conn->query($sqlx);
		
		$sql1= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-18'";
		$result1 = $conn ->query($sql1);
		$sql_qty1 = $result1->fetch_assoc();
		$tot_qty1 = $sql_qty1['qty'];
		$remain_quantity1 = $tot_qty1-1;
		$sqlx1= "update vis_hotel_details set qty='$remain_quantity1' where hotel_id='$hotel_id' AND date='2022-02-18'";
		$minus1 = $conn->query($sqlx1);
	}
	else if($check_in_date=="2022-02-18" && $check_out_date=="2022-02-19")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-18'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-18'";
		$minus = $conn->query($sqlx);
	}
	else if($check_in_date=="2022-02-18" && $check_out_date=="2022-02-20")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-18'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-18'";
		$minus = $conn->query($sqlx);
		
		$sql1= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-19'";
		$result1 = $conn ->query($sql1);
		$sql_qty1 = $result1->fetch_assoc();
		$tot_qty1 = $sql_qty1['qty'];
		$remain_quantity1 = $tot_qty1-1;
		$sqlx1= "update vis_hotel_details set qty='$remain_quantity1' where hotel_id='$hotel_id' AND date='2022-02-19'";
		$minus1 = $conn->query($sqlx1);
	}
	else if($check_in_date=="2022-02-19" && $check_out_date=="2022-02-20")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-19'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-19'";
		$minus = $conn->query($sqlx);
	}
	else if($check_in_date=="2022-02-19" && $check_out_date=="2022-02-21")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-19'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-19'";
		$minus = $conn->query($sqlx);
		
		$sql1= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-20'";
		$result1 = $conn ->query($sql1);
		$sql_qty1 = $result1->fetch_assoc();
		$tot_qty1 = $sql_qty1['qty'];
		$remain_quantity1 = $tot_qty1-1;
		$sqlx1= "update vis_hotel_details set qty='$remain_quantity1' where hotel_id='$hotel_id' AND date='2022-02-20'";
		$minus1 = $conn->query($sqlx1);
	}
	else if($check_in_date=="2022-02-20" && $check_out_date=="2022-02-21")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-20'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-20'";
		$minus = $conn->query($sqlx);
	}
	else if($check_in_date=="2022-02-20" && $check_out_date=="2022-02-22")
	{
		$sql= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-20'";
		$result = $conn ->query($sql);
		$sql_qty = $result->fetch_assoc();
		$tot_qty = $sql_qty['qty'];
		$remain_quantity = $tot_qty-1;
		$sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='2022-02-20'";
		$minus = $conn->query($sqlx);
		
		$sql1= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-21'";
		$result1 = $conn ->query($sql1);
		$sql_qty1 = $result1->fetch_assoc();
		$tot_qty1 = $sql_qty1['qty'];
		$remain_quantity1 = $tot_qty1-1;
		$sqlx1= "update vis_hotel_details set qty='$remain_quantity1' where hotel_id='$hotel_id' AND date='2022-02-21'";
		$minus1 = $conn->query($sqlx1);
	}
	else if($check_in_date=="2022-02-21" && $check_out_date=="2022-02-22")
	{		
		$sql1= "select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='2022-02-21'";
		$result1 = $conn ->query($sql1);
		$sql_qty1 = $result1->fetch_assoc();
		$tot_qty1 = $sql_qty1['qty'];
		$remain_quantity1 = $tot_qty1-1;
		$sqlx1= "update vis_hotel_details set qty='$remain_quantity1' where hotel_id='$hotel_id' AND date='2022-02-21'";
		$minus1 = $conn->query($sqlx1);
	}

/*

 $qitem_quantity = $conn ->query("select qty from vis_hotel_details where hotel_id='$hotel_id' AND date='$check_in_date'");
 $ritem_quantity = $qitem_quantity->fetch_assoc();
 $tot_quantity = $ritem_quantity['qty'];
 $remain_quantity = $tot_quantity-1;
 $sqlx= "update vis_hotel_details set qty='$remain_quantity' where hotel_id='$hotel_id' AND date='$check_in_date'";
 $minus = $conn->query($sqlx);
 */
 
 //$id=mysql_insert_id();
 if($resulthotel){
 $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
    <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
    
    <tr>
    <td align="left"> <img src="https://registration.gjepc.org/images/logo/iijs-signature-22.png"> </td>
  <td align="right" height="60px"><img src="https://registration.gjepc.org/images/logo.png" /></td>
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
    
   <p> Dear '.$applicant_name.',</p>
   
   <p>Thank you for confirming your presence at IIJS SIGNATURE 2022. We are in receipt of your reservation request and the same has been forwarded to the respective hotel for further process. A formal confirmation email will be shared with you shortly via your email address submitted in the form.</p>
   <p>Below are the reservation details provided by you:-</p>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" style="font-weight:bold">Hotel Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.getHotelName($hotel_id,$conn).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Company Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($applicant_company_name).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Name 1</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($guest_1_name).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Name 2</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($guest_2_name).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Mobile No 1</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$Guest1_Mobile.'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Mobile No 2</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$Guest2_Mobile.'</td>
  </tr>
 
</table>

<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="160" style="font-weight:bold">Arrival Flight No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$arrival_flight_no.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Departure Flight No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$departure_flight_no.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Check-In</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$check_in_date.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Check-Out</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$check_out_date.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">&nbsp;</td>
    <td width="21">&nbsp;</td>
    <td width="219" style="color:#751b53;">&nbsp;</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Credit Card No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.substr_replace($credit_card_no, str_repeat("X", 12),0, 12).'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Expiry Date </td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$exp_mm.'/'.$exp_yyyy.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Credit Card Type </td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$credit_card_type.'</td>
  </tr>
 
</table>

<p></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#751b53">
    <td style="text-align:center; color:#fff;">Copyright, IIJS SIGNATURE 2022. All Rights Reserved.</td>
  </tr>
</table>
   </td>
    </tr>
    
    <tr>
    <td align="right" colspan="2" height="30px"><hr /></td>
    </tr>
  
    <tr>
   <td align="right" colspan="2" height="30px" style="text-align:left;"><b>Please Note:</b><br><br> 
	1.	All reservations are to be guaranteed with a valid credit card.<br>
	2.	Kindly share your credit card number along with the expiration date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed .<br>
	3.	Cut of date for cancelation of room without any charge is 10th February, any cancellation post 10th February will attract 100% retention charges.</br></br>
	4.	100% retention for the entire length of stay will be applicable incase of any No-Show .<br>
	5.	The credit card shared will be considered as a guarantee for the reservation made and the same will be charged in the event of any No Show or Cancellation for the above booking .<br>
	6.	Guest will borne the charges for any additional services (incidentals) used during their stay. <br>
	7.	If the guest is covid 19 positive & unable to travel, then guest will not be charged. (Authentic Govt Covid 19 positive report needs to be submitted).<br>
	8.	Check In time at the hotel for all guests is 1400 hours (02:00 pm) IST . Guests arriving prior to this time will be allocated rooms as soon as they become available & it also depends on the hotel policies. For all early check-ins, we recommend to reserve and pay for the night before in order to guarantee early check-in.<br>
	9.	The Check Out time at the hotel for all guests is 1200 hrs (12:00 pm), late check outs will be subject to availability upon request.<br>
	10.	In case of any change in the rate of taxes mandated by the Government at any future date, the same would be applicable and charged on the final billing by the hotel (Only Applicable for guest who are extending their stays).<br>
	11. For any query or for any assistance write to us on hotels@gjepcindia.com
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
  if($hotel_id==1)
  {
    $hotel_email_id="ramika.kapoor@hyatt.com";
  }
  else if($hotel_id==2)
  {
    $hotel_email_id="rnatarajan@thelalit.com";
  }
  else if($hotel_id==3)
  {
    $hotel_email_id="Kanav.Khanna@marriotthotels.com";
  }
  else if($hotel_id==4)
  {
    //$hotel_email_id="mumresv@thelalit.com,mumgroupresv@thelalit.com";
    $hotel_email_id="richa.ahuja@hyatt.com";
  }
  else if($hotel_id==5)
  {
    $hotel_email_id="Kanav.Khanna@marriotthotels.com";
    //$hotel_email_id="amol.sonawane@hyatt.com";
  }
  else if($hotel_id==6)
  {
    //$hotel_email_id="groups.mumbai@theleela.com";
    $hotel_email_id="milind.vaidya@hyatt.com";
  }
  else if($hotel_id==7)
  {
    $hotel_email_id="Kanav.Khanna@marriotthotels.com";
  }
  else if($hotel_id==8)
  {
    $hotel_email_id="Reservations.mumbaigardencity@westin.com";
  }
  else if($hotel_id==9)
  {
    $hotel_email_id="Varsha.SODAH@sofitel.com";
  }
  else if($hotel_id==10)
  {
    $hotel_email_id="Shabnam.Bawa@oberoigroup.com";
  } 
  else if($hotel_id==11)
  {
    $hotel_email_id="Kanav.Khanna@marriotthotels.com";
  }
  else if($hotel_id==12)
  {
    $hotel_email_id="groups@theleela.com";
  } 
  
   //$to =$applicant_email_id.','.$guest_email_id.','.$hotel_email_id.',hotels@gjepcindia.com';
   //$to = "neelmani@kwebmaker.com";
   $to = $applicant_email_id.',hotels@gjepcindia.com';
   $subject = "Hotel Registration Application Status - IIJS SIGNATURE 2022"; 
  /* $headers  = 'MIME-Version: 1.0' . "\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
   $headers .= 'From: Hotel IIJS SIGNATURE 2022 <hotels@gjepc.org>';
   mail($to, $subject, $message, $headers);
   */
   $cc = "";
 $email_array = explode(",",$to);
 send_mailArray($email_array,$subject,$message,$cc);
 }
header("location: thanks.php");
exit;
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS - Hotel Registration</title>
<link rel="shortcut icon" href="images/fav.png" />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>
    <link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
<link rel="stylesheet" type="text/css" href="css/form.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
<!-- Menu -->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--<script type="text/javascript" src="js/ddsmoothmenu.js"></script>-->
<link rel="stylesheet" type="text/css" href="css/ddaccordion.css" />
    <link rel="stylesheet" type="text/css" href="css/visitor_reg.css?v=<?php echo $version;?>" />
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>
 <script src="js/common.js?v=<?php echo $version;?>"></script> 

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 

<script type="text/javascript">
function formValidator()
{ 
 
  if(document.getElementById('applicant_name').value == '')
  {
    alert("Please Enter Applicant Name");
    document.getElementById('applicant_name').focus();
    return false;
  }
  
  if(document.getElementById('applicant_company_name').value == '')
  {
    alert("Please Enter Company Name");
    document.getElementById('applicant_company_name').focus();
    return false;
  }
  if(document.getElementById('applicant_email_id').value == '')
  {
    alert("Please enter Email ID.");
    document.getElementById('applicant_email_id').focus();
    return false;
  }
  if(echeck(document.getElementById('applicant_email_id').value)==false)
  {
    document.getElementById('applicant_email_id').focus();
    return false;
  }
  if(document.getElementById('applicant_mobile_no').value == '')
  {
    alert("Please Enter Mobile No.");
    document.getElementById('applicant_mobile_no').focus();
    return false;
  }
  if(!IsNumeric(document.getElementById('applicant_mobile_no').value))
  {
    alert("Please enter valid Mobile No.")
    document.getElementById('applicant_mobile_no').focus();
    return false;
  }
  if(document.getElementById('applicant_mobile_no').value.length < 10)
  {
    alert("Please enter 10 digit Mobile No.");
    document.getElementById('applicant_mobile_no').focus();
    return false;
  }
  
  if(document.getElementById('hotel_id').value == '')
  {
    alert("Please Select Hotel Name");
    document.getElementById('hotel_id').focus();
    return false;
  }
  
  
  
  if(document.getElementById('guest_1').value == '')
  {
    alert("Please Enter Guest 1 Name");
    document.getElementById('guest_1').focus();
    return false;
  }
  
  if(document.getElementById('Guest1_Email').value == '')
  {
    alert("Please enter Guest 1 Email ID.");
    document.getElementById('Guest1_Email').focus();
    return false;
  }
  if(echeck(document.getElementById('Guest1_Email').value)==false)
  {
    document.getElementById('Guest1_Email').focus();
    return false;
  }

  if(document.getElementById('Guest1_Mobile').value == '')
  {
    alert("Please Enter Guest 1 Mobile No.");
    document.getElementById('Guest1_Mobile').focus();
    return false;
  }

  if(!IsNumeric(document.getElementById('Guest1_Mobile').value))
  {
    alert("Please enter valid Mobile No.")
    document.getElementById('Guest1_Mobile').focus();
    return false;
  }
  if(document.getElementById('Guest1_Mobile').value.length < 10)
  {
    alert("Please enter 10 digit Mobile No.");
    document.getElementById('Guest1_Mobile').focus();
    return false;
  }
  /*if(document.getElementById('guest_2').value == '')
  {
    alert("Please Enter Guest 2 Name");
    document.getElementById('guest_2').focus();
    return false;
  }
  
  if(document.getElementById('Guest2_Email').value == '')
  {
    alert("Please enter Guest 2 Email ID.");
    document.getElementById('Guest2_Email').focus();
    return false;
  }
  if(echeck(document.getElementById('Guest2_Email').value)==false)
  {
    document.getElementById('Guest2_Email').focus();
    return false;
  }

  if(document.getElementById('Guest2_Mobile').value == '')
  {
    alert("Please Enter Guest 2 Mobile No.");
    document.getElementById('Guest2_Mobile').focus();
    return false;
  }
  
  if(!IsNumeric(document.getElementById('Guest2_Mobile').value))
  {
    alert("Please enter valid Mobile No.")
    document.getElementById('Guest2_Mobile').focus();
    return false;
  }
  if(document.getElementById('Guest2_Mobile').value.length < 10)
  {
    alert("Please enter 10 digit Mobile No.");
    document.getElementById('Guest2_Mobile').focus();
    return false;
  }
  */
  
  
  
  if(document.getElementById('ck_in_dd').value == '')
  {
    alert("Please Select CheckIn Date");
    document.getElementById('ck_in_dd').focus();
    return false;
  }
  if(document.getElementById('ck_in_mm').value == '')
  {
    alert("Please Select CheckIn Date");
    document.getElementById('ck_in_mm').focus();
    return false;
  }
  if(document.getElementById('ck_in_yyyy').value == '')
  {
    alert("Please Select CheckIn Date");
    document.getElementById('ck_in_yyyy').focus();
    return false;
  }
  if(document.getElementById('ck_in_hh').value == '')
  {
    alert("Please Select CheckIn Time");
    document.getElementById('ck_in_hh').focus();
    return false;
  }
  if(document.getElementById('ck_in_ss').value == '')
  {
    alert("Please Select CheckIn Time");
    document.getElementById('ck_in_ss').focus();
    return false;
  }
  if(document.getElementById('ck_in_am').value == '')
  {
    alert("Please Select CheckIn Time");
    document.getElementById('ck_in_am').focus();
    return false;
  }
  
  if(document.getElementById('ck_out_dd').value == '')
  {
    alert("Please Select CheckOut Date");
    document.getElementById('ck_out_dd').focus();
    return false;
  }
  if(document.getElementById('ck_out_mm').value == '')
  {
    alert("Please Select CheckOut Date");
    document.getElementById('ck_out_mm').focus();
    return false;
  }
  if(document.getElementById('ck_out_yyyy').value == '')
  {
    alert("Please Select CheckOut Date");
    document.getElementById('ck_out_yyyy').focus();
    return false;
  }
  if(document.getElementById('ck_out_hh').value == '')
  {
    alert("Please Select CheckOut Time");
    document.getElementById('ck_out_hh').focus();
    return false;
  }
  if(document.getElementById('ck_out_ss').value == '')
  {
    alert("Please Select CheckOut Time");
    document.getElementById('ck_out_ss').focus();
    return false;
  }
  if(document.getElementById('ck_out_am').value == '')
  {
    alert("Please Select CheckOut Time");
    document.getElementById('ck_out_am').focus();
    return false;
  }
  
  if(document.getElementById('credit_card_type').value == '')
  {
    alert("Please Select Credit Card Type");
    document.getElementById('credit_card_type').focus();
    return false;
  }
  if(document.getElementById('credit_card_no').value == '')
  {
    alert("Please Enter Credit Card Number");
    document.getElementById('credit_card_no').focus();
    return false;
  }
  if(!IsNumeric(document.getElementById('credit_card_no').value))
  {
    alert("Please enter valid Credit Card No.")
    document.getElementById('credit_card_no').focus();
    return false;
  }
  
  if(document.getElementById('credit_card_type').value=="AmEx")
  {
    if(document.getElementById('credit_card_no').value.length < 15)
    {
      alert("Please enter 15 digit credit card No.");
      document.getElementById('credit_card_no').focus();
      return false;
    }
  }
  else 
  {
    if(document.getElementById('credit_card_no').value.length < 16)
    {
      alert("Please enter 16 digit credit card No.");
      document.getElementById('credit_card_no').focus();
      return false;
    }
  }

  var expd = document.getElementById('exp_mm').value;
  if(document.getElementById('exp_mm').value == '')
  {
    alert("Please Select Credit Card Expiry Month");
    document.getElementById('exp_mm').focus();
    return false;
  }
  if(document.getElementById('exp_yyyy').value == '')
  {
    alert("Please Select Credit Card Expiry Year");
    document.getElementById('exp_yyyy').focus();
    return false;
  }
  if(document.getElementById('exp_yyyy').value == '')
  {
    alert("Please Select Credit Card Expiry Year");
    document.getElementById('exp_yyyy').focus();
    return false;
  }
  if(document.getElementById("agree").checked==false)
  {
    alert("Please Check Terms & Conditions");
    document.getElementById('agree').focus();
    return false;
  }
  

}

function echeck(str) 
{
  var at="@"
  var dot="."
  var lat=str.indexOf(at)
  var lstr=str.length
  var ldot=str.indexOf(dot)
  if (str.indexOf(at)==-1){
     alert("Invalid E-mail ID")
     return false
  }
  if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
     alert("Invalid E-mail ID")
     return false
  }
  if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
    alert("Invalid E-mail ID")
    return false
  }
   if (str.indexOf(at,(lat+1))!=-1){
    alert("Invalid E-mail ID")
    return false
   }
   if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
    alert("Invalid E-mail ID")
    return false
   }
   if (str.indexOf(dot,(lat+2))==-1){
    alert("Invalid E-mail ID")
    return false
   }
   if (str.indexOf(" ")!=-1){
    alert("Invalid E-mail ID")
    return false
   }
   return true          
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
      blnResult = false;
         }
   }
   return blnResult;
}

</script>

<script>
$(document).ready(function(){

      $("#panForm").validate({
      rules: {
        Company_Pan:{
          required:true,
          minlength: 10,
          panno: true,
          maxlength:10
        }
      },
      messages: {
        Company_Pan:{
          required: "Pan No is required",
          minlength:"Please Enter Correct PAN NO",
          maxlength:"Please Enter no more than {0} digit."
        }
      },
      submitHandler: panAction
    });
   function panAction(){
   
   }
$("#applicant_country").change(function(){
  country=$("#applicant_country").val();
  $.ajax({ type: 'POST',
          url: 'ajax_hotel.php',
          data: "actiontype=getState&country="+country,
          dataType:'html',
          beforeSend: function(){
            //$('#progress').show();
            $('.loader').show();
            },
          success: function(data){
                  // alert(data);
                $('.loader').hide();
                   $("#stateDiv").html(data);  
              }
    });
 });

  $("#guest_1").change(function(){
  let guest_1 =$(this).val();
  $.ajax({ 
          type: 'POST',
          url: 'ajax.php',
          data: "actiontype=getVisitorInfo&visitor_id="+guest_1,
          dataType:'json',
          beforeSend: function(){
            $('.loader').show();
              },
          success: function(data){
                 
                 $('.loader').hide();
                   $("#Guest1_Email").val(data.email);  
                   $("#Guest1_Mobile").val(data.mobile);  
              }
    });
  });
  $("#guest_2").change(function(){
  let guest_2 =$(this).val();
  $.ajax({ type: 'POST',
          url: 'ajax.php',
          data: "actiontype=getVisitorInfo&visitor_id="+guest_2,
          dataType:'json',
          beforeSend: function(){
            $('.loader').show();
              },
          success: function(data){
  
                 $('.loader').hide();
                   $("#Guest2_Email").val(data.email);  
                   $("#Guest2_Mobile").val(data.mobile);  
              }
    });
  });
  
	$("#hotel_id").change(function(){
	  hotel_id=$("#hotel_id").val();
	  $.ajax({ type: 'POST',
			  url: 'ajax_hotel.php',
			  data: "actiontype=getRoom&hotel_id="+hotel_id,
			  dataType:'html',
			  beforeSend: function(){
				$('.loader').show();
				  },
			  success: function(data){
					   ///alert(data);
					 $('.loader').hide();
					   $("#hotelDiv").html(data);  
				  }
		});
	  });
  
});
 </script>
<SCRIPT type="text/javascript">
$(document).ready(function(){
  $("#ck_in_dd").change(function(){
    ck_in_dd=$("#ck_in_dd").val();
	hotel_id=$("#hotel_id").val(); 
	
	if (hotel_id==""){
        alert('Please Select Hotel');
		$('#submit').attr('disabled', true);
		 $("#ck_in_dd").val("");
    } else {
    $.ajax({
	type: 'POST',
    url: 'ajax_hotel.php',
    data: "actiontype=getAvaibility&ck_in_dd="+ck_in_dd+"&hotel_id="+hotel_id,
    dataType:'html',
    beforeSend: function(){
		$('.loader').show();
             },
    success: function(data){
	$('.loader').hide();
	//alert(data);	
	if($.trim(data)==0){
		  alert("Hotel Room Not Available");
		  $("#ck_in_dd").val("");
		  $('#submit').attr('disabled', true);
    } else {
		$('#submit').removeAttr("disabled");
	}
      }
    });
  }
  });
});
</SCRIPT>
<SCRIPT type="text/javascript">
$(document).ready(function(){
  $("#ck_in_dd").change(function(){
    ck_in_dd=$("#ck_in_dd").val();
	Company_Type=$("#Company_Type").val();
    $.ajax({ 
	type: 'POST',
    url: 'ajax_hotel.php',
    data: "actiontype=getoutDate&ck_in_dd="+ck_in_dd+"&Company_Type="+Company_Type,
    dataType:'html',
    beforeSend: function(){
		$('.loader').show();
             },
    success: function(data){
		$('.loader').hide();	
        $('#ck_out_dd').html(data);
		$("#ck_out_dd").prop('disabled', false);
      }
    });
  });
});
</SCRIPT>
<style>
.loader {
position: fixed;
left: 0px;
top: 0px;
width: 100%;
height: 100%;
z-index: 9999;
background: url('images/loader.gif') 50% 50% no-repeat rgb(249,249,249);
opacity: 80;
display:none;
}
</style>

<script type="text/javascript">
$(function() {
  var regExp = /[0-9]/;
  $('#no_of_room').on('keydown keyup', function(e) {
    var value = String.fromCharCode(e.which) || e.key;
    //console.log(e);
    // Only numbers, dots and commas
    if (!regExp.test(value)
      && e.which != 188 // ,
      && e.which != 190 // .
      && e.which != 8   // backspace
      && e.which != 46  // delete
      && (e.which < 37  // arrow keys
        || e.which > 40)) {
          e.preventDefault();
          return false;
    }
  });
});
</script>
</head>

<body>

<div class="wrapper">
<div class="loader">  <div style="display:table; width:100%; height:100%;"><span style="display:table-cell; vertical-align:middle; text-align:center; padding-top:100px;">Please wait....</span></div></div>
<div class="header">
  <?php include('header1.php'); ?>
</div>

<div class="inner_container">

  <div class="breadcrum"><a href="index.php">Home</a> > Hotel Registration</div>    
    <div class="clear"></div>
    
    <div class="content_area">

    <div class="container">
         <div class="bold_font text-center">
              <div class="d-block">
                  <img src="https://www.gjepc.org/assets/images/gold_star.png" class="">
              </div>
                Hotel Registration
          </div>
    </div>
       <div class="clear"></div>
    <?php
        $Company_Pan = $_REQUEST['Company_Pan'] ;

        if(isset($Company_Pan) && $Company_Pan !==""){ 
			$sql_company_check = "SELECT * FROM vis_hotel_registration_company_master WHERE Company_Pan='$Company_Pan' AND Status='1'";
			$result_company_check = $conn->query($sql_company_check);
			$row_company = $result_company_check->fetch_assoc();
			$Quota_Count = $row_company['Quota_Count'];
			$Company_Type = $row_company['Company_Type'];
          if($result_company_check->num_rows == 0){ ?>
           <div class="alert alert-danger" role="alert">
            Company Pan Number is not allowed
          </div>
          <?php }
        } 
    ?>
		<?php 
        $getLimit = "SELECT company_pan FROM iijs_hotel_registration_details where company_pan='$Company_Pan' AND company_pan!=''"; 
        $getLimitResult = $conn->query($getLimit); 
		$getCountx = $getLimitResult->num_rows;
		?>
		
     <?php if(isset($Company_Pan) && $Company_Pan !=="" && $result_company_check->num_rows > 0 ){ ?>
         <?php 
		 if($Quota_Count>$getCountx){ echo ''; } else { 
		echo "<script>alert('Your quota limit is full. Contact Admin!!'); window.location = 'hotel_registration.php';</script>";  } 
         $Company_Name = $row_company['Company_Name'];       
         ?>
          <div class="row">
            <div class="col-12">
             <h5 class="title text-center">
              
                <?php echo $Company_Name; ?>
          </h5>
            </div>
          </div>
          <?php 

          $query_registration_master = "SELECT id FROM registration_master where company_pan_no='$Company_Pan'  and status='1' "; 
          $result_registration_master = $conn->query($query_registration_master);               
          $row_registration_master = $result_registration_master->fetch_assoc();
          $registration_id = $row_registration_master['id'];
          
          ?>
          <form name="form1" method="post" enctype="multipart/form-data" onsubmit="return formValidator()">
            <input type="hidden" name="action" value="ADD" /> 
            <input type="hidden" name="applicant_company_name" id="applicant_company_name" 	value="<?php echo $Company_Name; ?>" /> 
            <input type="hidden" name="company_pan" id="company_pan" value="<?php echo $Company_Pan; ?>" /> 
			<input type="hidden" name="Company_Type" id="Company_Type" value="<?php echo $Company_Type; ?>" /> 
            <div id="formContainer">
            <div id="form">
            
            <div class="title">Applicant Details</div>
            <div class="borderBottom"></div>
            
            <table border="0" cellspacing="0" cellpadding="0" class="formManual table table-light">
          <tr>
            <td width="19%">Name <sup>*</sup> :</td>
            <td width="30%"><input type="text" name="applicant_name" id="applicant_name" class="bgcolor" /></td>
         <!--    <td width="3%">&nbsp;</td>
            <td width="18%">Company Name <sup>*</sup> :</td>
            <td width="30%"><input type="text" name="applicant_company_name" id="applicant_company_name" class="bgcolor" /></td>-->
          </tr>
          
          <tr>
            <td>Email ID <sup>*</sup> :</td>
            <td><input type="text" name="applicant_email_id" id="applicant_email_id" class="bgcolor" /></td>
            <td>&nbsp;</td>
            <td>Mobile No  <sup>*</sup> :</td>
            <td><input type="text" name="applicant_mobile_no" id="applicant_mobile_no" class="bgcolor" /></td>
          </tr>
          
        <!--  <tr>
          <td>Country <sup>*</sup> :</td>
          <td><select name="applicant_country" id="applicant_country" class="bgcolor">
            <option value="" selected="selected">-- Select -- </option>
            <?php 
        $sql="SELECT * FROM  `country_master` where status=1";
          $result=$conn->query($sql);
          while($rows=$result->fetch_assoc())
          {
          echo "<option value='$rows[country_code]'>$rows[country_name]</option>"; 
          }
          ?>
          </select></td>
          <td>&nbsp;</td>
          <td>State  <sup>*</sup> :</td>
          <td id="stateDiv">
          <select name="applicant_state" id="applicant_state" class="bgcolor">
            <option value="" selected="selected">-- Select -- </option>
            <?php 
          $sql="SELECT * from state_master WHERE country_code = 'IN'";
          $result=$conn->query($sql);
          while($rows=$result->fetch_assoc())
          {
          echo "<option value='$rows[state_code]'>$rows[state_name]</option>";        }
          ?>
          </select>
          </td>
        </tr>-->

        </table>
            
            <div class="clear" style="height:15px;"></div>
            
            <div class="title">Hotel Information</div>
            
            
            <table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <td width="19%">Hotel Name <sup>*</sup> :</td>
    <td width="30%">
    <select name="hotel_id" id="hotel_id" class="bgcolor">
      <option value="" selected="selected">-- Select -- </option>
        <?php 
      $sql1="SELECT * FROM  `iijs_hotel_master` where status='1'";
      $result1=$conn->query($sql1);
      while($rows1=$result1->fetch_assoc())
      {
        if($rows1['hotel_id']==$_REQUEST['hid'])
        {
               echo "<option value='$rows1[hotel_id]' selected='selected'>$rows1[hotel_name]</option>"; 
        } else
        {
          echo "<option value='$rows1[hotel_id]'>$rows1[hotel_name]</option>";
        }
      }
     ?>
    </select>
    <?php if($_REQUEST['hid']!=""){?> <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_REQUEST['hid'];?>" /><?php }?>
    </td>
    <td width="3%">&nbsp;</td>
    <td width="18%"> </td>
    <td width="30%" id="rateDiv"></td>
  </tr>
  
 
</table>
            
           
            
            <div class="title">Guest Information</div>
            <div class="borderBottom"></div>
            <?php 
            $sql_reg_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
              WHERE EXISTS 
              (SELECT * FROM visitor_order_history 
              WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' AND visitor_order_history.payment_made_for='$show') AND `visitor_approval`='Y' AND `registration_id`='$registration_id'";   
          
            ?>


            <table border="0" cellspacing="0" cellpadding="0" class="formManual table table-light">
           <tr>
            <td width="19%">Guest 1 <sup>*</sup> :</td>
            <td width="30%">
              <div class="row">
                <div class="col-md-12 mb-3">
                     <select  type="text" name="guest_1" id="guest_1" class="bgcolor" >
                         <option value="">Select Guest 1</option>
                         <?php 
						 $query_reg_vis=$conn->query($sql_reg_vis);
						 $count_reg_vis = $query_reg_vis->num_rows;
                         if($count_reg_vis > 0) {
          
                              while($row_reg_vis = $query_reg_vis->fetch_assoc()){?>
                              <option value="<?php echo $row_reg_vis['visitor_id']; ?>"><?php echo  $row_reg_vis['visitor_name'];?></option>
                              <?php }
                            }else{?>
                              <option value="0">Not found</option>
                            <?php }
                            ?>
                      </select>
                </div>
                <div class="col-md-6">
            
                  <input name="Guest1_Email" id="Guest1_Email" class="bgcolor" placeholder="Guest 1 Email Id" readonly />
                </div>
               
                 <div class="col-md-6">
                  <input name="Guest1_Mobile" id="Guest1_Mobile" placeholder="Guest 1 Mobile number" class="bgcolor" readonly />
                </div>
              </div>
           
            </td>
            <td width="3%">&nbsp;</td>
            <td width="18%">Guest 2 :</td>
            <td width="30%">
              <div class="row">
                <div class="col-md-12 mb-3">
                     <select  type="text" name="guest_2" id="guest_2" class="bgcolor" >
                         <option value="">Select Guest 2</option>
                         <?php 
                          $query_reg_vis2=$conn->query($sql_reg_vis);
                          $count_reg_vis2 = $query_reg_vis2->num_rows;
                          if($count_reg_vis2 > 0) {
          
                              while($row_reg_vis_2 = $query_reg_vis2->fetch_assoc()){?>
                              <option value="<?php echo $row_reg_vis_2['visitor_id']; ?>"><?php echo  $row_reg_vis_2['visitor_name'];?></option>
                              <?php }
                            }else{?>
                              <option value="0">Not found</option>
                            <?php }
                            ?>
                      </select>
                </div>
                <div class="col-md-6">
                  
                  <input name="Guest2_Email" id="Guest2_Email" placeholder="Guest 2 Email Id" class="bgcolor" readonly />
                </div>
                 <div class="col-md-6">
                 
                  <input name="Guest2_Mobile" id="Guest2_Mobile" placeholder="Guest 2 Mobile number"  class="bgcolor" readonly />
                </div>
              </div>
            </td>
            <td width="3%">&nbsp;</td>
            
          </tr>
          
         


          
        </table>  
            <div class="clear" style="height:15px;"></div>
            
            <div class="title">Flight Schedule</div>
            <div class="borderBottom"></div>
            
            <table border="0" cellspacing="0" cellpadding="0" class="formManual table table-light">
          <tr>
            <td width="19%">Arrival Flight No :</td>
            <td width="30%"><input type="text" name="arrival_flight_no" id="arrival_flight_no" class="bgcolor" /></td>
            <td width="3%">&nbsp;</td>
            <td width="18%">Arrival From :</td>
            <td width="30%"><input type="text" name="arrival_from" id="arrival_from" class="bgcolor" /></td>
          </tr>
          <tr>
            <td>Arrival Date :</td>
            <td>
            <select name="arrival_dd" id="arrival_dd" class="bgcolor" style="width:54px;">
                <option value="" selected="selected">DD</option>
                <option value="17">17</option>
                <option value="18">18</option>
            </select>
            <select name="arrival_mm" id="arrival_mm" class="bgcolor" style="width:55px;">
              <option value="02">02</option>
            </select>
            <select name="arrival_yyyy" id="arrival_yyyy" class="bgcolor" style="width:70px;">
              <option value="2022">2022</option>
              </select>
              
            </td>
            <td>&nbsp;</td>
            <td>Arrival Time : </td>
            <td>
            <select name="arrival_hh" id="arrival_hh" class="bgcolor" style="width:50px;">
                <option value="" selected="selected">HH</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>
              <select name="arrival_ss" id="arrival_ss" class="bgcolor" style="width:55px;">
                <option value="" selected="selected">MM</option>
                <option value="00">00</option>
                <option value="05">05</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
              </select>
              <select name="arrival_am" id="arrival_am" class="bgcolor" style="width:70px;">
                <option value="AM" selected="selected">AM</option>
                <option value="PM">PM</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Departure Flight No :</td>
            <td><input type="text" name="departure_flight_no" id="departure_flight_no" class="bgcolor" /></td>
            <td>&nbsp;</td>
            <td>Departure From :</td>
            <td><input type="text" name="departure_from" id="departure_from" class="bgcolor" /></td>
          </tr>
          <tr>
            <td>Departure Date :</td>
            <td>
            <select name="departure_dd" id="departure_dd" class="bgcolor" style="width:54px;">
                <option value="" selected="selected">DD</option>           
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
              </select>
              <select name="departure_mm" id="departure_mm" class="bgcolor" style="width:55px;">
                <option value="02">02</option>
              </select>
              <select name="departure_yyyy" id="departure_yyyy" class="bgcolor" style="width:70px;">
                <option value="2022">2022</option>
              </select>
            </td>
            <td>&nbsp;</td>
            <td>Departure Time :</td>
            <td>
            <select name="departure_hh" id="departure_hh" class="bgcolor" style="width:50px;">
                <option value="" selected="selected">HH</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>
              <select name="departure_ss" id="departure_ss" class="bgcolor" style="width:55px;">
                <option value="" selected="selected">MM</option>
                <option value="00">00</option>
                <option value="05">05</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
              </select>
              <select name="departure_am" id="departure_am" class="bgcolor" style="width:70px;">
                <option value="AM" selected="selected">AM</option>
                <option value="PM">PM</option>
              </select>
            </td>
          </tr>
        </table>
          
            <div class="clear" style="height:15px;"></div>    
            <div class="title">Check-In Check-Out Details</div>
            <div class="borderBottom"></div>
            
            <table border="0" cellspacing="0" cellpadding="0" class="formManual table table-light">
          <tr>
            <td width="19%">Check-In Date <sup>*</sup> :</td>
            <td width="30%"><select name="ck_in_dd" id="ck_in_dd" class="bgcolor" style="width:54px;">
                <option value="" selected="selected">DD</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                </select>
              <select name="ck_in_mm" id="ck_in_mm" class="bgcolor" style="width:55px;">        
                <option value="02">02</option>
              </select>
              <select name="ck_in_yyyy" id="ck_in_yyyy" class="bgcolor" style="width:70px;">        
                <option value="2022">2022</option>
              </select>
            </td>
            <td width="3%">&nbsp;</td>
            <td width="18%">Check-In Time <sup>*</sup> :</td>
            <td width="30%">
             <select name="ck_in_hh" id="ck_in_hh" class="textField" style="width:55px;">
                <option value="" selected="selected">HH</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>
              <select name="ck_in_ss" id="ck_in_ss" class="textField" style="width:55px;">
                <option value="" selected="selected">MM</option>
                <option value="00">00</option>
                <option value="05">05</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
              </select>
              <select name="ck_in_am" id="ck_in_am" class="textField" style="width:55px;">
                <option value="AM" selected="selected">AM</option>
                <option value="PM">PM</option>
              </select>
            </td>
            </tr>
		<tr>

          <tr>
            <td>Check-Out Date <sup>* </sup> :</td>
            <td>
            <select name="ck_out_dd" id="ck_out_dd" class="textField" style="width:54px;" disabled>
            <option value="" selected="selected">DD</option>
			    <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>  
                <option value="21">21</option>
                <option value="22">22</option>
            </select>
              <select name="ck_out_mm" id="ck_out_mm" class="textField" style="width:55px;">
              <option value="02">02</option>
              </select>
              <select name="ck_out_yyyy" id="ck_out_yyyy" class="textField" style="width:70px;">        
                <option value="2022">2022</option>
              </select>
            </td>
            <td>&nbsp;</td>
            <td>Check-Out Time <sup>*</sup> :</td>
            <td>
             <select name="ck_out_hh" id="ck_out_hh" class="textField" style="width:55px;">
                <option value="" selected="selected">HH</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select>
              <select name="ck_out_ss" id="ck_out_ss" class="textField" style="width:55px;">
                <option value="" selected="selected">MM</option>
                <option value="00">00</option>
                <option value="05">05</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
              </select>
              <select name="ck_out_am" id="ck_out_am" class="textField" style="width:55px;">
                <option value="AM" selected="selected">AM</option>
                <option value="PM">PM</option>
              </select>
            </td>
          </tr>
        </table>
            <div class="clear" style="height:15px;"></div>

            

            
            <div class="title">Credit Card Details</div>
            <div class="borderBottom"></div> 
                
            <table border="0" cellpadding="0" cellspacing="0" class="formManual table table-light">
            <tr>
            <td width="22%">Credit Card Details <sup>*</sup> :</td>
            <td width="30%">
            <select name="credit_card_type" id="credit_card_type" class="bgcolor">
              <option value="" selected="selected">-- Select -- </option>
              <option value="AmEx">American Express</option>
              <option value="Visa">Visa Card</option>
              <option value="MasterCard">Master Card</option>
              <option value="DinersClub">Dinners Card</option>
            </select></td>
            <td width="18%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            </tr>
            <tr>
            <td width="22%">Credit Card Number  : <br />(Don't include space)</td>
            <td width="30%"><input type="text" name="credit_card_no" id="credit_card_no" class="bgcolor" maxlength="16" /></td>
            <td width="18%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            </tr>
            <tr>
            <td width="22%">Expiry Date :</td>
            <td width="30%">
              <select name="exp_mm" id="exp_mm" class="bgcolor" style="width:60px;">
                <option value="" selected="selected">MM</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              <select name="exp_yyyy" id="exp_yyyy" class="bgcolor" style="width:70px;">
                <option value="" selected="selected">YYYY</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
              </select></td>
            <td width="18%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            </tr>
            </table>    
            
            <div class="clear" style="height:15px;"></div>
            
            <div class="title">Terms & conditions</div>
            <div class="borderBottom"></div> 
           
		<ol style="list-style:decimal;">
			<li>All reservations are to be guaranteed with a valid credit card.</li>
			<li>Kindly share your credit card number along with the expiration date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed .</li>
			<li>Cut of date for cancelation of room without any charge is 10th February, any cancellation post 10th February will attract 100% retention charges.</li>

			<li>100% retention for the entire length of stay will be applicable incase of any No-Show .</li>
			<li>The credit card shared will be considered as a guarantee for the reservation made and the same will be charged in the event of any No Show or Cancellation for the above booking .</li>

			<li>Guest will borne the charges for any additional services (incidentals) used during their stay.</li>
			<li>If the guest is covid 19 positive & unable to travel, then guest will not be charged. (Authentic Govt Covid 19 positive report needs to be submitted)</li>
			<li>Check In time at the hotel for all guests is 1400 hours (02:00 pm) IST . Guests arriving prior to this time will be allocated rooms as soon as they become available & it also depends on the hotel policies. For all early check-ins, we recommend to reserve and pay for the night before in order to guarantee early check-in.</li>
			<li>The Check Out time at the hotel for all guests is 1200 hrs (12:00 pm), late check outs will be subject to availability upon request </li>
			<li>In case of any change in the rate of taxes mandated by the Government at any future date, the same would be applicable and charged on the final billing by the hotel (Only Applicable for guest who are extending their stays).</li>
			<li>For any query or for any assistance write to us on hotels@gjepcindia.com</li>
		</ol>

            <div class="clear" style="height:15px;"></div>
          <p><input type="checkbox" name="agree" id="agree" checked="checked" /> <sup>*</sup> I agree the above mentioned Terms & Conditions.</p>
          <div class="clear"></div>
           
            <table border="0" cellpadding="0" cellspacing="0" class="formManual table table-light">
            <tr>
            <td><input name="input2" type="submit" value="Submit"  id="submit"/></td>
            </tr>
            </table>
            
            <div class="clear"></div>
            </div>
            </div>    
          </form>     
     <?php }else { ?>
     <div class="box-shadow">

              <div class="loaderWrapper">
                <div class="formLoader">
                  <img src="images/formloader.gif" alt="">
                  <p> Please Wait....</p>
                </div>
              </div>
             
              
              <div class="formwrapper2">

                <!--<div style="text-align: center;"><h1 style="font-size: 30px;text-align: center;">Registration has been closed for IIJS SIGNATURE 2021</h1></div>-->

                <form method="GET" id="panForm" autocomplete="off" class="w-100">

                <div class="row ">

                    <div class="col-md-5 form-group">
                      <label><strong>Enter Company Pan Card</strong></label>
                      <input type="text" class="form-control pan_no" id="Company_Pan" name="Company_Pan" value="<?php echo $Company_Pan; ?>" maxlength="10" autocomplete="off"/>
                  
                    </div>
                    
                    <div class="col-12 form-group">
                      <input type="submit" name="submit"  value="Submit" class="btn btn-submit">
                     
                    </div>
                      
                 
                </div>                    
                </form>
        
                </div>
                </div> 

      <?php } ?>
    
    
    
     
    <div class="clear"></div>
  </div>

  <div class="right_area">
    
    <?php //include('include_account_links.php'); ?>
    
    <div class="clear"></div>
    </div>
 

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
  <?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

<script>
function myFunction() {
    var txt;
    if (confirm("*Incase of any change in the rate of taxes mandated by the Government at any future date, the same would be applicable and charged on the final billing. Please click OK if you agree.") == true) {
        txt = "You pressed OK!";
    } else {
        alert("You Have to agree! Please click OK!");
    location.href="https://registration.gjepc.org/hotel_registration.php";
    }
   // document.getElementById("demo").innerHTML = txt;
}

$(document).ready(function(){
  // myFunction();
});

</script>
<style >
  #formContainer .title {
    font-weight: bold;
    font-size: 15px;
    line-height: 25px;
    display: block;
    border-bottom: 1px solid #dedede;
    margin-bottom: 5px;
    background: #a59459;
    padding: 10px;
    color: #fff;
}
</style>
</body>
</html>