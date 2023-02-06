<?php

function send_sms($message,$mobile_no) {
	$message=str_replace(" ","%20",$message);
	$url = 'http://sms.gjepc.org/submitsms.jsp?user=TheGem&key=f2474d18afXX&mobile='.$mobile_no.'&message='.$message.'&senderid=GJECPT&accusage=1';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$mobile_no = 919834797281;
$otp ='1111';
$app = "GJEPC app";
$website = "IIJS PREMIERE 2022";
$badgeDate = "25th December 2022";
$clnt_txn_ref = "IIJS225465";
//$message = "One Time Password for Pan Number Verification is ".$otp." Regards GJEPC";

$fy = "2022-23";
$link = "https%3A%2F%2Fwww.dgft.gov.in";
$dgft = "Your membership for $fy renewed%2C apply for RCMC on DGFT portal $link in fill-up details as per PDF.";


//echo $message = "Dear NEEL, your VC has been approved, kindly download your E-badge from $website after $badgeDate Team GJEPC";
//$message = "Thank you for registering for $website.Your Unique ID number is $clnt_txn_ref. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
//$otp_sendStatus = send_sms($message,$mobile_no); //Send OTP on mobile
//$dgft_sendStatus = send_sms($dgft,$mobile_no); //Send OTP on mobile
//if($dgft_sendStatus){ echo 'sent';} else { echo 'Not sent'; }
$event_name = "IIJS Premiere 2022, IIJS Signature 2023, IIJS Tritiya 2023";
//$messagev = "Thank you for registering for $event_name.Your Unique ID number is $clnt_txn_ref. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";

/*
$messagev = "Dear NEEL, your documents have been approved, kindly proceed for the payment for IIJS PREMIERE 2022, click on https://registration.gjepc.org/single_visitor.php, In case of any further query please contact 1800-103-4353. Regards, GJEPC.";
$dgft_sendStatus = send_sms($messagev,$mobile_no);
if($dgft_sendStatus){ echo 'sent';} else { echo 'Not sent'; } */


$messagev = 'Thank you for registering for '.$website.' Your Unique ID number is '.$clnt_txn_ref.'. Download and print your Paper-Badge from GJEPC App from '.$badgeDate.' onwards. Please note your Badge will be only generated to get printed after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC';
$dgft_sendStatus = send_sms($$dgft,$mobile_no);
print_r($dgft_sendStatus);
?>
