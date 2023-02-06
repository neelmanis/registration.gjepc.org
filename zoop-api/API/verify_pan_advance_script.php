<?php
//curl request
//$url = "https://test.zoop.one/api/v1/in/identity/pan/advance"; //TEST
$url = "https://live.zoop.one/api/v1/in/identity/pan/advance"; //LIVE
$pan_no = $_POST['pan_numbers'];

$fieldsArr = '{
			"mode": "sync",
			"data": 
			{
			"customer_pan_number": "'.$pan_no.'",
			"consent": "Y",
			"consent_text": "Approve the values here"
			}
			}';
		
		$headers = array(
		    "auth: false",
            "app-id: 62a31a45791920001dd1a099",
			"api-key: TK761JV-5KFM7MF-PAFQHR7-ZFKF25K",
            "Content-Type: application/json"
        );
		
$ch = curl_init();

curl_setopt_array($ch, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $fieldsArr,
  CURLOPT_HTTPHEADER => $headers,
));

//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

//get response
$output = curl_exec($ch);

//Print error if any
if(curl_errno($ch))
{
    echo 'error:' . curl_error($ch);
}

curl_close($ch);

echo $output;
?>