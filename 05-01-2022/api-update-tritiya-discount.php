		<?php
		include('db.inc.php');

		$curl = curl_init(); 

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://scanapp.kwebmaker.com/visitor_check_in_api.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"username": "neelmani@kwebmaker.com",
		"password": "123456"
		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));
		
		$response = curl_exec($curl);
		if (curl_errno($curl)) {
			$error_msg = curl_error($curl);
		} 
		if(isset($error_msg))
		{
			echo 'Curl error: ' . $error_msg;
		} else	{
			//echo 'Operation completed without any errors';
		}
		
		curl_close($curl);
		//echo "<pre>"; print_r($response);  exit;
		
		$data = json_decode($response, true);
		$dataSize = count($data['Response']['Result']);
		$response = array();
		$update_count = 0;
		
		//echo '<pre>'; print_r($data);
		//count($data['Response']['Result']);
		foreach($data['Response']['Result'] as $row)
		{
			//echo '<pre>'; print_r($row); exit;
			$registration_id = $row['registration_id'];
			$visitor_id = $row['visitor_id'];
			$pan_no = trim($row['pan_no']);
			
			$doCheck = "SELECT visitor_id,registration_id,pan_no FROM `visitor_directory` WHERE pan_no='$pan_no' AND registration_id='$registration_id' AND visitor_id='$visitor_id'";
			$doResult = $conn->query($doCheck);
			$countxx = $doResult->num_rows;
			if($countxx > 0){
			$download = "UPDATE visitor_directory set discount='Y' WHERE pan_no='$pan_no' AND registration_id='$registration_id' AND visitor_id='$visitor_id'";
			$updates = $conn->query($download);	
			$update_count++;
			} else {
			echo 'insert query';
			}
		}
		echo "Total Data Updated : ".$update_count."<br/><br/>"; 
		?>