<?php include('header_include.php');
if(!isset($_SESSION['USERID'])){ header("location:login.php");	exit; }
$registration_id = $_SESSION['USERID'];

	$query=mysql_query("SELECT * FROM `registration_master` WHERE `id` = '$registration_id' limit 1");	
	$result = mysql_fetch_array($query);	
	$address1=strtoupper($result['address_line1']);
	$address2=strtoupper($result['address_line2']);
	$address3=strtoupper($result['address_line3']);
	$city=strtoupper($result['city']);
	$country=strtoupper($result['country']);
	$state=strtoupper(getStateName($result['state']));
	$pincode=$result['pin_code'];
?>

<?php
$orderid = trim($_REQUEST['orderid']);

$getapplication ="SELECT * FROM `visitor_lost_badges` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
$getApplicationResult = mysql_query($getapplication);
$getApplicationRow=mysql_fetch_array($getApplicationResult);

$total_payable = $getApplicationRow['total_payable'];
$type_of_member = $getApplicationRow['type_of_member'];
$delivery_id = $getApplicationRow['delivery_id']; //Shipping ID
$billing_delivery_id = $getApplicationRow['billing_delivery_id']; // Billing ID
$create_date = date("d-m-Y", strtotime($getApplicationRow['create_date']));

if($type_of_member == "M"){
	/* Shipping Address */
$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$delivery_id'";
$deliveryQuery = mysql_query($addflag);
$deliveryResult = mysql_fetch_array($deliveryQuery);
$d_address1=strtoupper($deliveryResult['address1']);
$d_address2=strtoupper($deliveryResult['address2']);
$d_address3=strtoupper($deliveryResult['address3']);
$d_city=strtoupper($deliveryResult['city']);
$d_country=strtoupper($deliveryResult['country']);
$d_state=strtoupper(getStateName($deliveryResult['state']));
$d_pincode=$deliveryResult['pincode'];

	/* Billing Address */
$billingflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$billing_delivery_id'";
$billingQuery = mysql_query($billingflag);
$billingResult = mysql_fetch_array($billingQuery);
$b_address1=strtoupper($billingResult['address1']);
$b_address2=strtoupper($billingResult['address2']);
$b_city=strtoupper($billingResult['city']);
$b_state=strtoupper(getStateName($billingResult['state']));
$b_pincode=$billingResult['pincode'];
} else {
	/* Shipping Address */
$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$delivery_id'";
$deliveryQuery = mysql_query($addflag);
$deliveryResult = mysql_fetch_array($deliveryQuery);
$d_address1=strtoupper($deliveryResult['address1']);
$d_address2=strtoupper($deliveryResult['address2']);
$d_city=strtoupper($deliveryResult['city']);
$d_country=strtoupper($deliveryResult['country']);
$d_state=strtoupper(getStateName($deliveryResult['state']));
$d_pincode=$deliveryResult['pin_code'];

	/* Billing Address */
$billingflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$billing_delivery_id'";
$billingQuery = mysql_query($billingflag);
$billingResult = mysql_fetch_array($billingQuery);
$b_address1=strtoupper($billingResult['address1']);
$b_address2=strtoupper($billingResult['address2']);
$b_city=strtoupper($billingResult['city']);
$b_state=strtoupper(getStateName($billingResult['state']));
$b_pincode=$billingResult['pin_code'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Print Acknowledgment</title>
	<link rel="shortcut icon" href="images/fav.png" />
    <!--navigation script-->
    <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function PrintContent(){
		var DocumentContainer = document.getElementById("divtoprint");
		var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	}
	</script>	
  </head>
  <body>
  <a onClick="PrintContent();" target="_blank" style="cursor:pointer;text-align:center;color:#FF0000;font-size:20px; display:block; border:1px solid#0000">Print</a>
  <div id="divtoprint">
<table width="80%" align="center" style="margin:2% auto; border:1px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; padding:10px;">
    <tr>
    	<td>
        	<table width="100%" cellspacing="0" style="font-family:Arial, sans-serif; color:#333333; font-size:13px; line-height:20px;">
				<tr>
                	<td align="left"> <img src="https://gjepc.org/images/gjepc_logon.png"/> </td>
                    <td align="right"> <img src="https://iijs-signature.org/images/logo.png"/> </td>
				</tr>
			</table>
        </td>
  	</tr>
  
  	<tr><td colspan="3" height="30"><hr></td></tr>	
    <tr>    	
        <td>        	
            <p align="center"> <strong> Domestic Visitor Registration </strong> </p>            
            <p> <strong> Date: <?php echo $create_date;?></strong> </p>            
            <p> <strong> Order No: <?php echo $orderid;?> </strong> </p>            
            <p> <?php echo $_SESSION['COMPANYNAME'];?>, thank you for registering with us. </p>
			<p>We have received your payment for lost badge of <strong> Rs. <?php echo $total_payable;?> </strong> in favour of The Gem & Jewellery Export Promotion Council. </p>            
            <p> <strong> Visitor Registration Details: </strong> </p>            
            <p> <strong> Company Name </strong> : <?php echo $_SESSION['COMPANYNAME'];?> </p>
			<p> <strong> Address: </strong><?php echo $b_address1.' '.$b_address2.' - '.$b_pincode.','.' '.$b_city.' '.$b_state;?></p>            
            <table width="100%" cellspacing="0" cellpadding="10" border="1" bordercolor="#ddd" style="border-collapse:collapse; font-family:Arial, sans-serif; color:#333333; font-size:13px; line-height:20px;">				
                <tr>
					<th> Sr. No. </th>
                    <th> Person Name </th>
                    <th> Show </th>
                    <th> Amount </th>
               	</tr>
                <?php 
				$getapplication ="SELECT * FROM `visitor_lost_badges` WHERE `orderId` = '$orderid' AND `regId`='$registration_id' AND payment_status='Y'";
				$getApplicationResult = mysql_query($getapplication);
				$i=1;
				while($getApplicationRow=mysql_fetch_array($getApplicationResult))
				{
					$visitor_id = $getApplicationRow['visitor_id'];
					$payment_made_for = $getApplicationRow['show'];
					if($payment_made_for=="3show") { $payment_made="3 Shows (IIJS 2019+ Signature 2020+ IIJS 2020)"; }
					if($payment_made_for=="6show") { $payment_made="6 Shows (only for owner category)(IIJS 2019+Signature 2020+IIJS 2020+ Signature 2021+ IIJS 2021+ Signature 2022)"; }
					$amount = $getApplicationRow['total_payable'];
					
					$id = $getApplicationRow['id'];
					$createDate = date('d-m-Y', strtotime($getApplicationRow['create_date']));
					$payment_status = $getApplicationRow['payment_status'];
					if($payment_status=="P") { $payment_status="Pending"; }
					if($payment_status=="Y") { $payment_status="Approved";}					
				?>   
                <tr>
					<td><?php echo $i;?></td>
                    <td><?php echo strtoupper(getVisitorFullName($visitor_id));?></td></td>
                    <td><?php echo $payment_made;?></td>
                    <td><?php echo $amount;?></td>
               	</tr>
				<?php $i++;  } ?>                
            </table>            
              
			<p> <b>Your old badge (Damaged/Lost) will get deactivated on the issuance of new badge, please use new badge only.</b></p>
			<p> Badges will be Courier to the below mentioned shipping address only if applied on or before - <b>20th Jan 2020</b></p>
            <p> <strong> Shipping Address : <?php echo $d_address1.' '.$d_address2.' - '.$d_pincode.','.' '.$d_city.' '.$d_state;?>	</strong> </p>            
            <p> <strong> I agree that: </strong> </p>            
            <ul style="line-height:22px;">
            	<li>I have read and understood the terms and conditions stated with this form with regards to the visitor's registration.</li>
                <li>Application once submitted cannot be cancelled and are non transferable under any circumstances.</li>
                <li>Visitor registration fees are non refundable under any circumstances.</li>
				<li>I agree to abide by the terms and conditions applicable for registration of National visitors set by "The Gem and Jewellery Export Promotion Council (GJEPC)".</li>
   				<li>I accept that GJEPC reserves the rights of admission to the show.</li>
   				<li>I agree to accept that the application will be rejected if the submitted documents are not agreeable.</li>
				<li>EXHIBITING COMPANIES at IIJS Premiere & IIJS Signature show will not be issued VISITOR BADGE. Exhibiting companies may avail Badges only for Machinery Section & IGJME</li>
				<li>If your company become exhibitor for any show, then your visitor registration for that particular show will get automatically cancelled and fees paid will not be refunded or adjusted under any circumstances.</li>
                <li>If in case any employee leaves the company, then it will be owner's responsibility to inform the GJEPC to discontinue the registration of that employee and company need to withdraw his details from directory.</li>
                <li>If in case employee get register for 2 / 3 shows and leaves the company, registration cost will not be refunded or replaced in any circumstances.</li>
				<li>5 / 6 shows registration will be available only for Owner/Proprietor/Partner/Directors</li>
				<li>2 / 3 shows badge is valid till IIJS PREMIERE 2020 & 5 / 6 show badge is valid till IIJS Signature 2022</li>
				<li>Visitor need to Retain 2 / 3 show badge till IIJS PREMIERE 2020 & Visitor need to Retain 5 / 6 show badge till IIJS Signature 2022</li>
				<li>In case of misplace/damage badges duplicate card charges will be Rs. 600 inclusive GST</li>
                <li><strong>For any queries kindly contact on Toll Free No. 1800-103-4353 or give miss call on 91-7208048100</strong></li>
			</ul>      
        </td>        
    </tr>
</table>
</div>