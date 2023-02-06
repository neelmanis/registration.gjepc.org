<?php
require('rz_config_dev.php');
//require('rz_config.php');
require('razorpay-php/Razorpay.php');
//session_start();

if(!isset($_SESSION['USERID'])){ header("location:login.php"); exit; }

$eventInfo = $_SESSION['eventInfo']; /* Get Event Selected */
$event_selected = $eventInfo['event_selected'];
// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);


if(!is_numeric($amountPay)){
    echo 'Please check amount'; exit;
}

$strNo = rand(1,1000000);
$orderId = "SPACE23".$strNo;
$_SESSION['orderId'] = $orderId;
//$net_payable_amount = 1;      
$orderData = [
    'receipt'         => $orderId,
    'amount'          => $amountPay * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

//echo '<pre>'. print_r($_SESSION); exit;
$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

/*$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
} */

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "GJEPC",
    "description"       => "Space Application",
    "image"             => "https://gjepc.org/assets/images/logo.png",
    "prefill"           => [
        "name"          => "GJEPC",
        //"email"         => trim($_SESSION['EMAILID']),
        "email"         => "santosh@kwebmaker.com",
        "contact"       => "9999999999",
    ],
    "notes"                 => [
        'name'              => strtoupper(str_replace(array('&amp;','&AMP;'), '&', $_SESSION['COMPANYNAME'])),
        'registration_id'   => trim($_SESSION['USERID']),
        'amountPaid'        => $amountPay,
        'merchant_order_id' => $orderData['receipt']
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

$registration_id =  $_SESSION['USERID'];
$gid_iijs = $_SESSION['gid_iijs'];
$gid_signature = $_SESSION['gid_signature'];
$gid_tritiya = $_SESSION['gid_tritiya'];
//$amountPay_iijs = $_SESSION['amountPay_iijs'];
$amountPay_signature = $_SESSION['amountPay_signature'];
$amountPay_tritiya = $_SESSION['amountPay_tritiya'];
$merchant_order_id = $orderData['receipt'];
$payment_date = date('Y-m-d');
$year = "2023";

$razorpay_signature = "";

// $insertUTR_iijs = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`,`utr_number`,`tdsAmount`,`razorpay_signature`,`amountPaid`, `razorpay_order_id`, `merchant_order_id`,`payment_status`,`payment_date`,`show`,`event_selected`, `year`, `status`,`payment_made_for`,`source`) VALUES (NOW(),'$registration_id','$gid_iijs','$merchant_order_id','0','$razorpay_signature','$amountPay_iijs','$razorpayOrderId','$merchant_order_id','pending','$payment_date','IIJS PREMIERE 2022','iijs22','$year','1','SPACE','stepwise')";
$insertUTR_signature = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`,`utr_number`,`tdsAmount`,`razorpay_signature`,`amountPaid`, `razorpay_order_id`, `merchant_order_id`,`payment_status`,`payment_date`,`show`,`event_selected`, `year`, `status`,`payment_made_for`,`source`,`tds_holder`,`cheque_tds_per`,`cheque_tds_amount`) VALUES (NOW(),'$registration_id','$gid_signature','$merchant_order_id','0','$razorpay_signature','$amountPay_signature','$razorpayOrderId','$merchant_order_id','pending','$payment_date','IIJS SIGNATURE 2023','signature23','$year','1','SPACE','stepwise','$signature_tds_holder','$signature_cheque_tds_per','$signature_cheque_tds_amount')";
$insertUTR_tritiya = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`,`utr_number`,`tdsAmount`,`razorpay_signature`,`amountPaid`, `razorpay_order_id`, `merchant_order_id`,`payment_status`,`payment_date`,`show`,`event_selected`, `year`, `status`,`payment_made_for`,`source`,`tds_holder`,`cheque_tds_per`,`cheque_tds_amount`) VALUES (NOW(),'$registration_id','$gid_tritiya','$merchant_order_id','0','$razorpay_signature','$amountPay_tritiya','$razorpayOrderId','$merchant_order_id','pending','$payment_date','IIJS TRITIYA 2023','iijstritiya23','$year','1','SPACE','stepwise','$tritiya_tds_holder','$tritiya_cheque_tds_per','$tritiya_cheque_tds_amount')";
// $resultUTR_iijs = $conn->query($insertUTR_iijs);
// if(!$resultUTR_iijs) { die('Error: Insert iijs query failed' . $conn->error); }

$resultUTR_signature = $conn->query($insertUTR_signature);
if(!$resultUTR_signature) { die('Error: Insert signature query failed' . $conn->error); }

$resultUTR_tritiya = $conn->query($insertUTR_tritiya);
if(!$resultUTR_tritiya) { die('Error: Insert query tritiya failed' . $conn->error); }


// $resultPay_iijs = $conn->query("INSERT INTO `space_payment_log`(`registration_id`,`gid`,`merchant_order_id`,`amount`, `razorpay_order_id`,`post_date`,`source`,`payment_status`,`event_selected`) VALUES ('$registration_id','$gid_iijs','$merchant_order_id','$amountPay_iijs','$razorpayOrderId','$payment_date','stepwise','pending','iijs22')");

$resultPay_signature = $conn->query("INSERT INTO `space_payment_log`(`registration_id`,`gid`,`merchant_order_id`,`amount`, `razorpay_order_id`,`post_date`,`source`,`payment_status`,`event_selected`) VALUES ('$registration_id','$gid_signature','$merchant_order_id','$amountPay_signature','$razorpayOrderId','$payment_date','stepwise','pending','signature22')");

$resultPay_tritiya = $conn->query("INSERT INTO `space_payment_log`(`registration_id`,`gid`,`merchant_order_id`,`amount`, `razorpay_order_id`,`post_date`,`source`,`payment_status`,`event_selected`) VALUES ('$registration_id','$gid_tritiya','$merchant_order_id','$amountPay_tritiya','$razorpayOrderId','$payment_date','stepwise','pending','iijstritiya23')");
//  header("Location: my_dashboard.php");
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="rz_comobo_verify_test.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
        window.location.href = 'my_dashboard.php';
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

$(document).ready(function(){
    rzp.open();
//    e.preventDefault();   
});
</script>