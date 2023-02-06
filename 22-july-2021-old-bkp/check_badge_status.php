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
$show = "signature";
$year = 2020;

$getapplication ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
$getApplicationResult = mysql_query($getapplication);
$getApplicationRow=mysql_fetch_array($getApplicationResult);

//$orderId = $getApplicationRow['orderId'];
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
    
    <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '398834417477910');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=398834417477910&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
    
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
            <p align="center"> <strong> Check Your Badge Status </strong> </p>            
            <p> <strong> Company Name </strong> : <?php echo filter($_SESSION['COMPANYNAME']);?> </p>       
            <p> <strong> Order No: <?php echo $orderid;?> </strong> </p>                    
			<table width="100%" cellspacing="0" cellpadding="10" border="1" bordercolor="#ddd" style="border-collapse:collapse; font-family:Arial, sans-serif; color:#333333; font-size:13px; line-height:20px;">				
                <tr>
					<th> Registration No. </th>
                    <th> Person Name </th>
                    <th> Badge Status </th>
                    <th> Tracking No </th>
                    <th> Remarks </th>
               	</tr>
                <?php 
				$getapplication ="SELECT * FROM `visitor_order_history` WHERE `orderId` = '$orderid' AND `registration_id`='$registration_id' AND `show`='$show' AND `year`='$year' AND payment_status='Y'";
				$getApplicationResult = mysql_query($getapplication);
				$i=1;
				while($getApplicationRow=mysql_fetch_array($getApplicationResult))
				{
					$visitor_id = $getApplicationRow['visitor_id'];
					if($getApplicationRow['badge_status']=="P") { $badge_status = "Processing"; }
					if($getApplicationRow['badge_status']=="C") { $badge_status = "Couriered"; }
					if($getApplicationRow['badge_status']=="CR") { $badge_status = "Courier Returned"; }
					$tracking_no = $getApplicationRow['tracking_no'];
					$remarks = $getApplicationRow['remarks'];
					
					$id = $getApplicationRow['id'];
					$payment_status = $getApplicationRow['payment_status'];
					if($payment_status=="P") { $payment_status="Pending"; }
					if($payment_status=="Y") { $payment_status="Approved";}					
				?>   
                <tr>
					<td><?php echo $visitor_id;?></td>
                    <td><?php echo strtoupper(getVisitorFullName($visitor_id));?></td></td>
                    <td align="center"><?php echo $badge_status;?></td>
                    <td align="center"><?php echo $tracking_no;?></td>
                    <td align="center"><?php echo $remarks;?></td>
               	</tr>
				<?php $i++;  } ?>                
               		
            </table>            
              
        </td>        
    </tr>
</table>
</div>