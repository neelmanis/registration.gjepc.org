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

//$mobile_no=9619662253;
$mobile_no=9834797281;
$otp ='4587';
$app = "GJEPC app";
$website = "IIJS SIGNATURE 2022";
$badgeDate = "25th December 2021";
$clnt_txn_ref = "IIJS225465";
$message = "One Time Password for Visitor Verification is ".$otp.", Regards GJEPC";

//$message = "Thank you for registering for $website.Your Unique ID number is $clnt_txn_ref. Generate your E-Badge from GJEPC App from $badgeDate onwards. Please note your E Badge will be only generated after approval of vaccination certificate. 2 dose of vaccines is compulsory to visit the show. Team GJEPC";
echo $otp_sendStatus = send_sms($message,$mobile_no); //Send OTP on mobile
?>