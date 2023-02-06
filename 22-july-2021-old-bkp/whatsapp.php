<?php
include 'functions.php';
/* First optin API After that Msg API */
	 $visitorMobile = "+919619662253,7498949490";
	 $orderId = "SIGN32363";
	 $name = "MUKESH";
	 $disapprove_reason = "Kindly specify Nature of business & what product dealing in the jewellery industry with a document on visitors@gjepcindia.com";
	 
	$apiurl = sendOPTIN($visitorMobile);
	//print_r($apiurl);
	$getResult = json_decode($apiurl,true);
	if($getResult['response']['status']=="success")
	{
		foreach($getResult['data'] as $value)
		{
			$code = $value[0]['id'];
			$msg  = $value[0]['details'];
			$phone = $value[0]['phone'];
			//echo $visitorMobile.'--'.$name.'--'.$disapprove_reason; 
			$msgurl = visitor_Individual_Directory_Disapproval($visitorMobile,$name,$disapprove_reason);
			$getResults = json_decode($msgurl,true);
			print_r($getResults);
			if($getResults['response']['status']=="success")
			{
				echo $getResults['response']['status'];
			} else { 
				echo $getResults['response']['details'];
			}		
		}
	} else { 
		echo $getResult['response']['details'];
	}
	

function visitor_Individual_Directory_Disapproval($visitorMobile,$name,$disapprove_reason)
{ 
	$visitorMobiles = trim($visitorMobile);
	$name = trim($name);
	$disapprove_reason = rawurlencode($disapprove_reason);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$visitorMobiles."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20".$name."%2C%20your%20data%20for%20visitor%20badge%20has%20been%20disapproved%2C%20Due%20to%20".$disapprove_reason."%20kindly%20update%20your%20record%20at%20IIJS%20SIGNATURE";
	//echo $url ; exit;
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
		 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	 echo $response;
	}
}
?>