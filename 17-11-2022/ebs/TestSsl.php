<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');

$uid = $_REQUEST['uid'];

$user_query="select * from pvr_registration_details where uid='$uid' and participate_for_show='IIJS' and participation_year='2018' LIMIT 1";
$execute_query=mysql_query($user_query);
if(!$execute_query)
	echo mysql_error();

$user_details = mysql_fetch_array($execute_query);

$order_no=strtoupper(str_replace("/","",$user_details['privilege_code']));
$contact_person=$user_details['contact_person'];
$ip_address=$user_details['ip_address'];
$address1=$user_details['address1'];
$address2=$user_details['address2'];
$address3=$user_details['address3'];
$city=$user_details['city'];
$state=$user_details['state'];
$pincode=$user_details['pincode'];
$email=$user_details['email'];
$phone=$user_details['telephone_no_office'];
$participation_fee=$user_details['participation_fee'];
$payment_mode=$user_details['payment_mode'];

$newx1="UPDATE `pvr_registration_details` SET order_no='$order_no' where uid='$uid' and participate_for_show='IIJS' and participation_year='2018' LIMIT 1";
$result_query=mysql_query($newx1);
?>
<?php 
ini_set('display_errors',1);
error_reporting(E_ALL);

$hashData = "9f471d6db2137ae1e5660bc3a670201c"; //Pass your Registered Secret Key

unset($_POST['submitted']);
ksort($_POST);

//echo $hashData;
$return_url='https://iijs.org/national_visitor_registration.php';
//echo "<pre>";print_r($_POST);
//$hash = "ebskey"."|".urlencode(20771)."|".urlencode($participation_fee)."|".urlencode($order_no)."|".$return_url."|".urlencode('TEST');
//echo $hash;
 $ebs_args =  array(
                    'channel' => '0',
					'account_id' => '20771',
                    'page_id' => '4947',
					'mode' => 'LIVE',
                    'currency' => 'INR',
					'reference_no' => $order_no,
					'amount' => $participation_fee,
					'description' => 'description',
					'name' => $contact_person,
					'address' => $address1.$address2.$address3,
					'city' => $city,
					'state' => $state,
					'postal_code' => $pincode,
					'country' => 'IND',
					'email' => $email,
					'phone' => $phone,
					'return_url' => $return_url,
					'payment_mode' =>$payment_mode,
                    
			);	

            
		ksort($ebs_args);		
		foreach ($ebs_args as $key => $value){
			if (strlen($value) > 0) {
				$hashData .= '|'.$value;
			}
		}
//echo $hashData; exit;
$secure_hash = strtoupper(hash('SHA512',$hashData));
?>

			<form action="https://secure.ebs.in/pg/ma/payment/request" name="payment" id="stack" method="POST">
			<input type="hidden" value="20771" name="account_id"/>
			<input type="hidden" value="<?php echo $order_no;?>" name="reference_no"/>
			<input type="hidden" value="0" name="channel"/>
			<input type="hidden" value="<?php echo $participation_fee;?>" name="amount"/>
			<input type="hidden" value="<?php echo $address1.$address2.$address3;?>" name="address"/>
			<input type="hidden" value="<?php echo $city;?>" name="city"/>
			<input type="hidden" value="<?php echo $state;?>" name="state"/>
			<input type="hidden" value="IND" name="country"/>
			<input type="hidden" value="INR" name="currency"/>
			<input type="hidden" value="<?php echo $email;?>" name="email"/>
			<input type="hidden" value="<?php echo $payment_mode;?>" name="payment_mode"/>
			<input type="hidden" value="<?php echo $contact_person;?>" name="name"/>
			<input type="hidden" value="4947" name="page_id"/>
			<input type="hidden" value="LIVE" name="mode"/>
			<input type="hidden" value="<?php echo $phone;?>" name="phone"/>
			<input type="hidden" value="<?php echo $pincode;?>" name="postal_code"/>
			<input type="hidden" value="description" name="description"/>
			<input type="hidden" value="https://iijs.org/national_visitor_registration.php" name="return_url"/>
			<input type="hidden" value="<?php echo $secure_hash; ?>" name="secure_hash"/>			
			</form>
			<script type="text/javascript">
			document.getElementById('stack').submit();
			</script>
