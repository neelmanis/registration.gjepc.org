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

$mobile_no = 9619662253;
$otp ='1111';
$app = "GJEPC app";
$website = "IIJS PREMIERE 2022";
$badgeDate = "25th December 2022";
$clnt_txn_ref = "IIJS225465";
$link = "https://registration.gjepc.org/visitor_badge.php";
$name = "NEEL";

//$messagev = "Dear $name, your photo update request has been disapproved, kindly immediately upload your photo again from $link for $website Team GJEPC";
$messagev = "Dear $name, your photo update request has been approved, kindly download your badge from $link for $website Team GJEPC";
//send_sms($messagev,$mobile_no); 

//Dear%20Neel%2C%20your%20photo%20update%20request%20has%20been%20disapproved%2C%20kindly%20immediately%20upload%20your%20photo%20again%20from%20https%3A%2F%2Fregistration.gjepc.org%2Fvisitor_badge.php%20for%20IIJS%20Team%20GJEPC
?>
