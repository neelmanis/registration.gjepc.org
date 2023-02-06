<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php");
	exit;
}
?>

<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

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

$hotel_data="select * from hotel_registration_details where Exhibitor_Code='$exhibitor_code'";
$result_hotel=mysql_query($hotel_data);
$num_rows=mysql_num_rows($result_hotel);

	if($num_rows==0)
	{
	$sqlhotel="INSERT INTO  `hotel_registration_details` (`EXHIBITOR_CODE`,`applicant_name` ,`applicant_company_name` ,`applicant_email_id` ,`applicant_mobile_no` ,`applicant_country` ,`applicant_state`,`hotel_id` ,`hotel_details_id` ,`no_of_room` ,`guest_name` ,`guest_company_name` ,`guest_email_id` ,`guest_mobile_no` ,`guest_city` ,`guest_country` ,`sharer_name` ,`arrival_flight_no` ,`arrival_from` ,`arrival_date` ,`arrival_time` ,`departure_flight_no` ,`departure_from` ,`departure_date` ,`departure_time` ,`check_in_date` ,`check_in_time` ,`check_out_date` ,`check_out_time` ,`total_payable` ,`credit_card_type` ,`any_other` ,`credit_card_no` ,`exp_mm` ,`exp_yyyy` ,`ip_address` ,`Info_Recieved`,Info_Approved,Info_Reason,Application_Complete,Create_Date,Modify_Date)VALUES ('$EXHIBITOR_CODE','$applicant_name' ,  '$applicant_company_name',  '$applicant_email_id',  '$applicant_mobile_no','$applicant_country','$applicant_state','$hotel_id',  '$hotel_details_id',  '$no_of_room',  '$guest_name',  '$guest_company_name',  '$guest_email_id',  '$guest_mobile_no',  '$guest_city',  '$guest_country',  '$sharer_name',  '$arrival_flight_no',  '$arrival_from',  '$arrival_date',  '$arrival_time',  '$departure_flight_no',  '$departure_from',  '$departure_date','$departure_time',  '$check_in_date',  '$check_in_time',  '$check_out_date',  '$check_out_time',  '$total_payable',  '$credit_card_type',  '$any_other',  '$credit_card_no',  '$exp_mm',  '$exp_yyyy', '$ip_address',  '1','P','','P','$Create_Date','$Modify_Date')";
	   $resulthotel=mysql_query($sqlhotel);
		

/*.......................................Send mail to users mail id...............................................*/
$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
    <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
    
    <tr>
    <td align="left" height="60px"><img src="http://iijs-signature.org/images/logo.png" border="0" width="230" /></td>
    <td align="right" height="60px"><img src="http://iijs-signature.org/images/gjepc_logo.png" width="120" border="0"/></td>
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
   <p>Thank you for confirming your presence at Signature 2016. Our representative will get in touch in with you shortly via your email address submitted in the form.</p>
   <p>Below are the reservation details provided by you:-</p>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" style="font-weight:bold">Hotel Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.getHotelName($hotel_id).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Email ID</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_email_id.'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_name.'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Company Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_company_name.'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Mobile No</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_mobile_no.'</td>
  </tr>
  
  <tr>
    <td width="300" style="font-weight:bold">City</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_city.'</td>
  </tr>
 
  
</table>

<p></p>

<table width="542" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
  <tr style="background:#CCCCCC;">
    <td width="279" style="border:1px solid #ccc;"><p align="center"><strong>Room   Type</strong></p></td>
    <td width="122" style="border:1px solid #ccc;"><p align="center"><strong>No. Of   Rooms</strong></p></td>
    <td width="141" style="border:1px solid #ccc;"><p align="center"><strong>Cost   in INR</strong></p></td>
  </tr>
  <tr style="background:#fff;">
    <td style="border:1px solid #ccc;"><p align="center">'.getRoomType($hotel_details_id).'</p></td>
    <td style="border:1px solid #ccc;"><p align="center">'.$no_of_room.'</p></td>
    <td style="border:1px solid #ccc;"><p align="center">'.$total_payable.'</p></td>
  </tr>
</table>

<p></p>

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
    <td style="text-align:center; color:#fff;">Copyright , IIJS-Signature 2016. All Rights Reserved.</td>
  </tr>
</table>
   </td>
    </tr>
    
    <tr>
    <td align="right" colspan="2" height="30px"><hr /></td>
    </tr>
	
    <tr>
    <td align="right" colspan="2" height="30px" style="text-align:left;  ">
	For any further assistance kindly contact us on <a href="mailto:hotels@gjepcindia.com">hotels@gjepcindia.com</a><br /><br />
	<b>Note:</b> We do not have any triple occupancy rooms available in any of the hotels. Please advice credit card number with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable:<br><br>
	1) Any cancellation after the 20th Jan, 2016, will attract 100 % retention on the entire booking.<br>
	2) In case of NO - Show the entire length of stay will be charged to the credit card.<br>
	3) Please note airport transfers would be arranged only on receipt of flight details.
	</td>
    </tr>
    
    <tr>
    <td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
   </td>
    </tr>
    </table>



</td>

<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
<map name="Map2" id="Map2">

<area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" />
</map>

</tr>

</table>
';

	if($hotel_id==1)
	{
		$hotel_email_id="kris.reynolds@hyatt.com";
	}else if($hotel_id==2)
	{
		$hotel_email_id="mumgroupresv@thelalit.com";
	}else if($hotel_id==3)
	{
		$hotel_email_id="pooja.kanyalkar@marriotthotels.com";
	}
	
	 $to =$applicant_email_id.','.$guest_email_id.','.$hotel_email_id.',hotels@gjepcindia.com';
	 //$to="ajit@kwebmaker.com";
     $subject = "Signature 2016 Exhibitor Manual - Form No. 13. Hotel Reservations"; 
	 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	 $headers .= 'From:admin@gjepc.org';			
	 mail($to, $subject, $message, $headers);


	}else
	{
	$updatehotel="update `hotel_registration_details` set `applicant_name`='$applicant_name' ,`applicant_company_name`='$applicant_company_name' ,`applicant_email_id`='$applicant_email_id' ,`applicant_mobile_no`='$applicant_mobile_no' ,`applicant_country`='$applicant_country' ,`applicant_state`='$applicant_state',`hotel_id`='$hotel_id' ,`hotel_details_id`='$hotel_details_id' ,`no_of_room`='$no_of_room' ,`guest_name`='$guest_name' ,`guest_company_name`='$guest_company_name' ,`guest_email_id`='$guest_email_id' ,`guest_mobile_no`='$guest_mobile_no' ,`guest_city`='$guest_city' ,`guest_country`='$guest_country' ,`sharer_name`='$sharer_name' ,`arrival_flight_no`='$arrival_flight_no' ,`arrival_from`='$arrival_from' ,`arrival_date`='$arrival_date' ,`arrival_time`='$arrival_time' ,`departure_flight_no`='$departure_flight_no' ,`departure_from`='$departure_from' ,`departure_date`='$departure_date' ,`departure_time`='$departure_time' ,`check_in_date`='$check_in_date' ,`check_in_time`='$check_in_time' ,`check_out_date`='$check_out_date' ,`check_out_time`='$check_out_time' ,`total_payable`='$total_payable' ,`credit_card_type`='$credit_card_type' ,`any_other`='$any_other' ,`credit_card_no`='$credit_card_no' ,`exp_mm`='$exp_mm' ,`exp_yyyy`='$exp_yyyy',Info_Approved='P',Info_Reason='',Application_Complete='P',Modify_Date='$$Modify_Date' where Exhibitor_Code='$EXHIBITOR_CODE'";
	$resultupdate=mysql_query($updatehotel);

	}

	echo '<script type="text/javascript">'; 
	echo 'alert("You have successfully submitted your application.");'; 
	echo 'window.location.href = "manual_list.php";';
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
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />
<script type="text/javascript" src="js/creditcard.js"></script>

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<script type="text/javascript" src="../js/ddsmoothmenu.js">
</script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>

<!--navigation script end-->


<!-- small slider -->
	<script type="text/javascript" src="../js/jquery.cycle.all.js"></script>

<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){ 
	
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});

	</script>


<!--  SLIDER ends  -->



<link href="../css/slider.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$(function() {
	$("#scroller .item").css("width", 986);
	$("#scroller").scrollable({
			circular: true,
			speed: 1500
	}).autoscroll({ interval: 9000 }).navigator();
	api = $('#scroller').data("scrollable");
	$(window).resize(function() {
		if($('#scroller .items:animated').length == 0) {
			$("#scroller .item").css("width", $(document).width());
			nleft = $(document).width() * (api.getIndex() + 1);
			$("#scroller .items").css("left", "-"+nleft+"px");
		}
	});
});
</script>

<!--  SLIDER Ends  -->



<!-- place holder script for ie -->

<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();
         
            $(active).focus();
           
           
            
        }
    });
</script>    






<!-------------------fancybox----------------->
	<!--<script>
		!window.jQuery && document.write('<script src="js/jquery-1.4.3.min.js"><\/script>');
	</script>-->
	<!--<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>-->
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="../css/style.css" />
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/
			
			$(".example2").fancybox({
				'overlayShow'	: true,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
			
			

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			/*
			*   Examples - various
			*/

			
			
			
		});
	</script>
 <!--fancybox ends-->



<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>


<SCRIPT src="js/jquery-1.3.2.min.js" type="text/javascript"></SCRIPT>


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

<script language="javascript">
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
	
	if(document.getElementById('applicant_country').value == '')
	{
		alert("Please Select Country");
		document.getElementById('applicant_country').focus();
		return false;
	}
	if(document.getElementById('hotel_id').value == '')
	{
		alert("Please Select Hotel Name");
		document.getElementById('hotel_id').focus();
		return false;
	}
	
	if(document.getElementById('hotel_details_id').value == '')
	{
		alert("Please Select Room Type");
		document.getElementById('hotel_details_id').focus();
		return false;
	}
	
	if(document.getElementById('no_of_room').value == '')
	{
		alert("Please Enter Room Number");
		document.getElementById('no_of_room').focus();
		return false;
	}	
	
	if(!IsNumeric(document.getElementById('no_of_room').value))
	{
		alert("Please enter Numeric Value Only.")
		document.getElementById('no_of_room').focus();
		return false;
	}
	
	if(document.getElementById('guest_name').value == '')
	{
		alert("Please Enter Guest Name");
		document.getElementById('guest_name').focus();
		return false;
	}
	if(document.getElementById('guest_company_name').value == '')
	{
		alert("Please Enter Guest Company Name");
		document.getElementById('guest_company_name').focus();
		return false;
	}
	if(document.getElementById('guest_email_id').value == '')
	{
		alert("Please enter Guest Email ID.");
		document.getElementById('guest_email_id').focus();
		return false;
	}
	if(echeck(document.getElementById('guest_email_id').value)==false)
	{
		document.getElementById('guest_email_id').focus();
		return false;
	}
	if(document.getElementById('guest_mobile_no').value == '')
	{
		alert("Please Enter Guest Mobile No.");
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('guest_mobile_no').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	if(document.getElementById('guest_mobile_no').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	
	if(document.getElementById('guest_city').value == '')
	{
		alert("Please Enter City Name");
		document.getElementById('guest_city').focus();
		return false;
	}
	
	if(document.getElementById('guest_country').value == '')
	{
		alert("Please Select Country");
		document.getElementById('guest_country').focus();
		return false;
	}
	/*if(document.getElementById('arrival_flight_no').value == '')
	{
		alert("Please Enter Arrival Flight No");
		document.getElementById('arrival_flight_no').focus();
		return false;
	}
	if(document.getElementById('arrival_from').value == '')
	{
		alert("Please Enter Arrival From");
		document.getElementById('arrival_from').focus();
		return false;
	}
	if(document.getElementById('arrival_dd').value == '')
	{
		alert("Please Select Arrival Date");
		document.getElementById('arrival_dd').focus();
		return false;
	}
	if(document.getElementById('arrival_mm').value == '')
	{
		alert("Please Select Arrival Date");
		document.getElementById('arrival_mm').focus();
		return false;
	}
	if(document.getElementById('arrival_yyyy').value == '')
	{
		alert("Please Select Arrival Date");
		document.getElementById('arrival_yyyy').focus();
		return false;
	}
	if(document.getElementById('arrival_hh').value == '')
	{
		alert("Please Select Arrival Time");
		document.getElementById('arrival_hh').focus();
		return false;
	}
	if(document.getElementById('arrival_ss').value == '')
	{
		alert("Please Select Arrival Time");
		document.getElementById('arrival_ss').focus();
		return false;
	}
	if(document.getElementById('arrival_am').value == '')
	{
		alert("Please Select Arrival Time");
		document.getElementById('arrival_am').focus();
		return false;
	}*/
	
	/*if(document.getElementById('departure_flight_no').value == '')
	{
		alert("Please Enter Departure Flight No");
		document.getElementById('departure_flight_no').focus();
		return false;
	}
	if(document.getElementById('departure_from').value == '')
	{
		alert("Please Enter Departure From");
		document.getElementById('departure_from').focus();
		return false;
	}
	if(document.getElementById('departure_dd').value == '')
	{
		alert("Please Select Departure Date");
		document.getElementById('departure_dd').focus();
		return false;
	}
	if(document.getElementById('departure_mm').value == '')
	{
		alert("Please Select Departure Date");
		document.getElementById('departure_mm').focus();
		return false;
	}
	if(document.getElementById('departure_yyyy').value == '')
	{
		alert("Please Select Departure Date");
		document.getElementById('departure_yyyy').focus();
		return false;
	}
	if(document.getElementById('departure_hh').value == '')
	{
		alert("Please Select Departure Time");
		document.getElementById('departure_hh').focus();
		return false;
	}
	if(document.getElementById('departure_ss').value == '')
	{
		alert("Please Select Departure Time");
		document.getElementById('departure_ss').focus();
		return false;
	}
	if(document.getElementById('departure_am').value == '')
	{
		alert("Please Select Departure Time");
		document.getElementById('departure_am').focus();
		return false;
	}*/
	
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
	if(document.getElementById('total_payable').value == '')
	{
		alert("Please Calculate Total Payable");
		document.getElementById('total_payable').focus();
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
	
	credit_card_no = document.getElementById('credit_card_no').value;
 	credit_card_type = document.getElementById('credit_card_type').value;
  
	if (!checkCreditCard (credit_card_no,credit_card_type)) {
		alert (ccErrors[ccErrorNo]);
		document.getElementById('credit_card_no').focus();
		return false;
	}
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





</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->

<div class="clear"></div>

<!--banner starts-->
<!--<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="../images/highlight_banner.jpg" />
    </div>
</div>-->
<!--banner ends-->
	

<div class="clear"></div>


<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">




<h3>Hotel Reservations</h3>
<h2>Application Summary</h2>


<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
	<th valign="top">Date</th>
    <th valign="top">Information Status</th>
    <th valign="top">Application Status</th>
</tr>

<tr>
	<td valign="middle"><?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
    <td valign="middle">
	<?php  
        if($Info_Approved=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Info_Approved=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";
        
    ?>
   </td>
   
   
    <td valign="middle"  class="centerAlign">
	  <?php  
        if($Application_Complete=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Application_Complete=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";
    ?>
    </td>
</tr>
</tbody></table>


<h2>Notes :</h2>
<p>We do not have any triple occupancy rooms available in any of the hotels. Please advice credit card number with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable:</p>



<ol class="numeric">
<li>Any cancellation after the 24th of Jan 2015, will attract 100% retention on the entire booking.</li>
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



<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return formValidator()"> 
<input type="hidden" name="action" value="ADD" />
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $_SESSION['EXHIBITOR_CODE'];?>" />


<div class="title">
  <h4>Applicant Details</h4>
</div>

<div class="clear"></div>


<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Name <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_name" id="applicant_name" class="textField" value="<?php echo $applicant_name;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Company Name <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_company_name" id="applicant_company_name" class="textField" value="<?php echo $applicant_company_name;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  
  <tr>
    <td class="bold">Email ID <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_email_id" id="applicant_email_id" class="textField" value="<?php echo $applicant_email_id;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile No  <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="applicant_mobile_no" id="applicant_mobile_no" class="textField" value="<?php echo $applicant_mobile_no;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
  </tr>
  
  <tr>
    <td class="bold">Country <sup>*</sup></td>
    <td>:</td>
    <td><select name="applicant_country" id="applicant_country" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
    <select name="applicant_state" id="applicant_state" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <td width="32%"><select name="hotel_id" id="hotel_id" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <td id="hotelDiv"><select class="textField" name="hotel_details_id" id="hotel_details_id" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <td><input type="text" name="no_of_room" id="no_of_room" class="textField" value="<?php echo $no_of_room;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
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
      <input type="text" name="guest_name" id="guest_name" class="textField" value="<?php echo $guest_name;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Company Name <sup>*</sup></td>
    <td>:</td> 
    <td><input type="text" name="guest_company_name" id="guest_company_name" class="textField" value="<?php echo $guest_company_name;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td class="bold"><p>Email ID <sup>*</sup></p></td>
    <td>:</td>
    <td><input type="text" name="guest_email_id" id="guest_email_id" class="textField" value="<?php echo $guest_email_id;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile No <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="guest_mobile_no" id="guest_mobile_no" class="textField" value="<?php echo $guest_mobile_no;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td class="bold">City <sup>*</sup></td>
    <td>:</td>
    <td><input type="text" name="guest_city" id="guest_city" class="textField" value="<?php echo $guest_city;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    <td>&nbsp;</td>
    <td class="bold">Country <sup>*</sup></td>
    <td>:</td>
    <td>
    <select name="guest_country" id="guest_country" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
    <td><input type="text" name="sharer_name" id="sharer_name" class="textField" value="<?php echo $sharer_name;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
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
      <input type="text" name="arrival_flight_no" id="arrival_flight_no" class="textField" value="<?php echo $arrival_flight_no;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/>
   </td>
    <td>&nbsp;</td>
    <td class="bold">Arrival From </td>
    <td>:</td>
    <td><input type="text" name="arrival_from" id="arrival_from" class="textField" value="<?php echo $arrival_from;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td class="bold"><p>Arrival Date </p></td>
    <td>:</td>
    <td>
    <select name="arrival_dd" id="arrival_dd" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">DD</option>
        <option value="01" <?php if($arrival_dd=='01'){echo "selected='selected'";}?>>01</option>
        <option value="02" <?php if($arrival_dd=='02'){echo "selected='selected'";}?>>02</option>
        <option value="03" <?php if($arrival_dd=='03'){echo "selected='selected'";}?>>03</option>
        <option value="04" <?php if($arrival_dd=='04'){echo "selected='selected'";}?>>04</option>
        <option value="05" <?php if($arrival_dd=='05'){echo "selected='selected'";}?>>05</option>
        <option value="06" <?php if($arrival_dd=='06'){echo "selected='selected'";}?>>06</option>
        <option value="07" <?php if($arrival_dd=='07'){echo "selected='selected'";}?>>07</option>
        <option value="08" <?php if($arrival_dd=='08'){echo "selected='selected'";}?>>08</option>
        <option value="09" <?php if($arrival_dd=='09'){echo "selected='selected'";}?>>09</option>
        <option value="10" <?php if($arrival_dd=='10'){echo "selected='selected'";}?>>10</option>
        <option value="11" <?php if($arrival_dd=='11'){echo "selected='selected'";}?>>11</option>
        <option value="12" <?php if($arrival_dd=='12'){echo "selected='selected'";}?>>12</option>
        <option value="13" <?php if($arrival_dd=='13'){echo "selected='selected'";}?>>13</option>
        <option value="14" <?php if($arrival_dd=='14'){echo "selected='selected'";}?>>14</option>
        <option value="15" <?php if($arrival_dd=='15'){echo "selected='selected'";}?>>15</option>
        </select>
      <select name="arrival_mm" id="arrival_mm" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($arrival_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="arrival_yyyy" id="arrival_yyyy" class="textField" style="width:65px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">YYYY</option>
        <option value="2016" <?php if($arrival_yyyy=='2016'){echo "selected='selected'";}?>>2016</option>
      </select>
      
    </td>
    <td>&nbsp;</td>
    <td class="bold">Arrival Time </td>
    <td>:</td>
    <td><select name="arrival_hh" id="arrival_hh" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="arrival_ss" id="arrival_ss" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="arrival_am" id="arrival_am" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($arrival_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="bold">Departure Flight No </td>
    <td>:</td>
    <td><input type="text" name="departure_flight_no" id="departure_flight_no" value="<?php echo $departure_flight_no;?>" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?> /></td>
    <td>&nbsp;</td>
    <td class="bold">Departure From </td>
    <td>:</td>
    <td><input type="text" name="departure_from" id="departure_from" value="<?php echo $departure_from;?>" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
  </tr>
  <tr>
    <td class="bold"><p>Departure Date </p></td>
    <td>:</td>
    <td>
    <select name="departure_dd" id="departure_dd" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">DD</option>        
        <option value="01" <?php if($departure_dd=='01'){echo "selected='selected'";}?>>01</option>
        <option value="02" <?php if($departure_dd=='02'){echo "selected='selected'";}?>>02</option>
        <option value="03" <?php if($departure_dd=='03'){echo "selected='selected'";}?>>03</option>
        <option value="04" <?php if($departure_dd=='04'){echo "selected='selected'";}?>>04</option>
        <option value="05" <?php if($departure_dd=='05'){echo "selected='selected'";}?>>05</option>
        <option value="06" <?php if($departure_dd=='06'){echo "selected='selected'";}?>>06</option>
        <option value="07" <?php if($departure_dd=='07'){echo "selected='selected'";}?>>07</option>
        <option value="08" <?php if($departure_dd=='08'){echo "selected='selected'";}?>>08</option>
        <option value="09" <?php if($departure_dd=='09'){echo "selected='selected'";}?>>09</option>
        <option value="10" <?php if($departure_dd=='10'){echo "selected='selected'";}?>>10</option>
        <option value="11" <?php if($departure_dd=='11'){echo "selected='selected'";}?>>11</option>
        <option value="12" <?php if($departure_dd=='12'){echo "selected='selected'";}?>>12</option>
        <option value="13" <?php if($departure_dd=='13'){echo "selected='selected'";}?>>13</option>
        <option value="14" <?php if($departure_dd=='14'){echo "selected='selected'";}?>>14</option>
        <option value="15" <?php if($departure_dd=='15'){echo "selected='selected'";}?>>15</option>
        </select>
      <select name="departure_mm" id="departure_mm" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($departure_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>

      <select name="departure_yyyy" id="departure_yyyy" class="textField" style="width:65px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">YYYY</option>
        <option value="2016" <?php if($departure_yyyy=='2016'){echo "selected='selected'";}?>>2016</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Departure Time </td>
    <td>:</td>
    <td>
    <select name="departure_hh" id="departure_hh" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="departure_ss" id="departure_ss" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="departure_am" id="departure_am" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
    <td><select name="ck_in_dd" id="ck_in_dd" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
      <option value="" selected="selected">DD</option>
      <option value="03" <?php if($ck_in_dd=='03'){echo "selected='selected'";}?>>03</option>
      <option value="04" <?php if($ck_in_dd=='04'){echo "selected='selected'";}?>>04</option>
      <option value="05" <?php if($ck_in_dd=='05'){echo "selected='selected'";}?>>05</option>
      <option value="06" <?php if($ck_in_dd=='06'){echo "selected='selected'";}?>>06</option>
      <option value="07" <?php if($ck_in_dd=='07'){echo "selected='selected'";}?>>07</option>
      <option value="08" <?php if($ck_in_dd=='08'){echo "selected='selected'";}?>>08</option>
    </select>
      <select name="ck_in_mm" id="ck_in_mm" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
      <option value="" selected="selected">MM</option>
        <option value="02" <?php if($ck_in_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="ck_in_yyyy" id="ck_in_yyyy" class="textField" style="width:65px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">YYYY</option>
        <option value="2016" <?php if($ck_in_yyyy=='2016'){echo "selected='selected'";}?>>2016</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Check-In Time <sup>*</sup></td>
    <td>:</td>
    <td>
     <select name="ck_in_hh" id="ck_in_hh" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="ck_in_ss" id="ck_in_ss" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="ck_in_am" id="ck_in_am" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="AM" selected="selected">AM</option>
        <option value="PM" <?php if($ck_in_am=='PM'){echo "selected='selected'";}?>>PM</option>
      </select>
    </td>
    </tr>
  
  
  <tr>
    <td class="bold">Check-Out Date <sup>* </sup></td>
    <td>:</td>
    <td>
    <select name="ck_out_dd" id="ck_out_dd" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">DD</option>
        <?php if($ck_out_dd!="")
		{
			echo "<option selected='selected'>$ck_out_dd</option>";
		}
		?>
    </select>
      <select name="ck_out_mm" id="ck_out_mm" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">MM</option>
        <option value="02" <?php if($ck_out_mm=='02'){echo "selected='selected'";}?>>02</option>
      </select>
      <select name="ck_out_yyyy" id="ck_out_yyyy" class="textField" style="width:65px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">YYYY</option>
        <option value="2016" <?php if($ck_out_yyyy=='2016'){echo "selected='selected'";}?>>2016</option>
      </select>
    
    </td>
    <td>&nbsp;</td>
    <td class="bold">Check-Out Time <sup>*</sup></td>
    <td>:</td>
    <td>
     <select name="ck_out_hh" id="ck_out_hh" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="ck_out_ss" id="ck_out_ss" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <select name="ck_out_am" id="ck_out_am" class="textField" style="width:55px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
    <td><input type="text" name="total_payable" id="total_payable" class="textField" readonly="readonly" value="<?php echo $total_payable;?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
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
      
    <td><select name="credit_card_type" id="credit_card_type" class="textField" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
      <td><input type="text" name="credit_card_no" id="credit_card_no" class="textField" value="<?php echo "$credit_card_no";?>" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/></td>
    </tr>
    
    <tr>
      <td  class="bold">Expiry Date</td>
      <td>:</td>
      <td><select name="exp_mm" id="exp_mm" class="textField" style="width:60px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
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
        <select name="exp_yyyy" id="exp_yyyy" class="textField" style="width:90px;" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>>
        <option value="" selected="selected">-YYYY-</option>
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




<div class="title">
<h4>Terms & conditions</h4>

</div>
<div class="clear"></div>

<p>We do not have any triple occupancy rooms available in any of the hotels. Please advice credit card number with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable:</p>

<p>Any cancellation after the 20th January, 2016, will attract 100 % retention on the entire booking. </p>

<p>In case of NO - Show the entire length of stay will be charged to the credit card.</p>

<p>Please note airport transfers would be arranged only on receipt of flight details.</p>


<p><input type="checkbox" name="agree" id="agree" checked="checked" <?php if($Info_Approved=='Y' || $Info_Approved=='P') {echo 'disabled=disabled';} ?>/> <sup>*</sup> I agree the above mentioned Terms & Conditions.</p>

    <div align="center">
       <?php if($Info_Approved=='N' || $Info_Approved==''){ ?>
       <input type="submit" value="Submit" class="maroon_btn" disabled="disabled" style="background:#dddddd;"/>
       <?php }?>
    <a href="manual_list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
    </div>
    
    
</form>
</div>


<?php include ('advertise.php'); ?>


<div class="clear">	
 
</div>


</div>
</div>


<div class="footer_wrap">


<?php include ('footer.php'); ?>



</div>

<!--footer ends-->

</body>
</html>
