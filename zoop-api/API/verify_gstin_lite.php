<?php
//curl request
$url = "https://test.zoop.one/api/v1/in/merchant/gstin/lite";
$gstin_no = $_POST['gstin_no'];

$fieldsArr = '{
			"data": 
			{
			"business_gstin_number": "'.$gstin_no.'",
			"consent": "Y",
			"consent_text": "Approve the values here"
			}
			}';
		
		$headers = array(
		    "auth: false",
            "app-id: 61dd9a0d1acfae001ddde527",
			"api-key: F69KN53-A384XAC-KHX20F5-D4AF852",
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