<?php
$mobile_no = "919619662253,919834797281";
if(strlen($mobile_no)==10){ echo $mobile = '91'.$mobile_no; } else { echo $mobile = $mobile_no;  }
$apiurl = sendMsg($mobile);
$getResult = json_decode($apiurl,true);
print_r($getResult);

?>

<?php
function sendMsg($mobile)
{
$url = "https://app.yellowmessenger.com/api/engagements/notifications/v2/push?bot=x1651054247211";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'
	{
    "userDetails": {
        "number": "'.$mobile.'"
	},

   "notification": {
       "templateId": "test23", 
       "params": { 
           "1" : "Vinay"
          },
       "type": "whatsapp", 
       "sender": "919619500999",
       "language": "en",
       "namespace": "f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
	}
	}',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: NFwy3IvlUOMiAaEV5Hn-6zEdDZW_feulyUhGv7SX',
    'Content-Type: application/json'
  ),
));
	//print_r($curl);
	$response = curl_exec($curl);	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		header('Content-type: application/json');
		return $response;
	 echo $response;
	}
}
?>