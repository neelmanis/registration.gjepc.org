<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'modules/generic/controllers/Generic.php';

class Scanapi extends Generic{
  function __construct() {
    parent::__construct();
    $this->load->model('Mdl_api');
    $this->load->library('redis');
    
	}

	/**
   * Function to get Visitor Details
   */

	public function getVisitorDetails(){
		$redis = $this->redis->config();
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://registration.gjepc.org/getVisitorData.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"username": "mukesh@kwebmaker.com",
		"password": "123456"
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);


    
		curl_close($curl);
	

		$data = json_decode($response, true);

		// echo "<pre>";print_r($data);exit;
		$dataSize = count($data['Response']['Result']);
		$response = array();
		$insert_count = 0;
		$update_count = 0;
		// exit;
	
		foreach($data['Response']['Result'] as $row)
		{
			// echo '<pre>'; print_r($row); 
			$post_date = $row['post_date'];
			$unique_code = $row['unique_code'];
			$registration_id = $row['registration_id'];
			$visitor_id = $row['registration_number'];
			$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $row['company']));
			$name = $row['name'];
			$mobile = trim($row['mobile']);
			$pan_no = trim($row['pan_no']);
			$email = $row['email'];
			$status = $row['status'];
			$designation = $row['designation'];			
			$photo_url = $row['photo_url'];	
			$photo_download = str_replace(' ', '%20',$photo_url); 			
			$category = $row['category'];
			$updateStatus = $row['updateStatus'];
			$isReplaced = $row['isReplaced'];
			$dose_status = $row['dose_status'];
			$plant_status = $row['plant_status'];
			$country = $row['country'];
			$state = $row['state'];
			$city = $row['city'];
			$pathInfoName = pathinfo($photo_download); // Get File name & Extension
			$imgName = $pathInfoName['basename']; // get image name
			$imgNameWithoutExtension = $pathInfoName['filename']; // get image name without extension
			$imgNameWithExtension = $pathInfoName['extension']; // get image name without extension
			$photo_name = $unique_code.".".$imgNameWithExtension;	
			$save_loc = "images/".$photo_name;
			$imgagesName = file_get_contents($photo_download,true);
			$msg = file_put_contents($save_loc, $imgagesName);
			$search_param = array(
              "unique_code"=>$unique_code
            );
			$dose_status = "";
			if($category =="OV"){
				if($status =="Y"){
					$status = "Y";
				}elseif($status =="P"){
					$status = "Y";
				}else{
					$status = "D";
				}				
			} else {
				$status = "Y";
			}
			if($plant_status =="P" || $plant_status=="Y"){
				$plant_status = $plant_status;
			}else{
				$plant_status ="P";
			}
			
			if($this->Mdl_api->isExist("visitors",$search_param))
			{
				$visitor_data = array(					
						
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'country'=>$country,
							'state'=>$state,
							'city'=>$city,
							'updated_at'=> date('Y-m-d H:i:s')
						);

				$set = $redis->set($unique_code, json_encode($visitor_data));
				
				$this->Mdl_api->update("visitors",array('unique_code' => $unique_code), $visitor_data);
				// echo $this->db->last_query();exit;

			  $update_count++;
			} else {
				if($msg)
				{
					
					$visitor_data = array(					
							'unique_code' => strip_tags($unique_code),
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'country'=>$country,
							'state'=>$state,
							'city'=>$city,
							'created_at'=> date('Y-m-d H:i:s')
						);
				  $set = $redis->set($unique_code, json_encode($visitor_data));

				$this->Mdl_api->insert("visitors",$visitor_data);
				// echo $this->db->last_query();exit;


		    
				$insert_count++;
				}
				else
				{
					echo "File downloading failed.";
				}
			}
			
		}
		
		echo "<br/>Total Records Are :".$dataSize."<br/><br/>"; 
		echo "Total New Records inserted :".$insert_count;					
		echo "Total Records updated :".$update_count;					
	}


	public function getVisitorContrDetails(){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://registration.gjepc.org/getVisitorCONTRData.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"username": "mukesh@kwebmaker.com",
		"password": "123456"
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$data = json_decode($response, true);
		// echo "<pre>";print_r($data);exit;
		$dataSize = count($data['Response']['Result']);
		$response = array();
		$insert_count = 0;
		$update_count = 0;
		// exit;
	
		foreach($data['Response']['Result'] as $row)
		{
			//echo '<pre>'; print_r($row); exit;
			$post_date = $row['post_date'];
			$unique_code = $row['unique_code'];
			$registration_id = $row['registration_id'];
			$visitor_id = $row['registration_number'];
			$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $row['company']));
			$name = $row['name'];
			$mobile = trim($row['mobile']);
			$pan_no = trim($row['pan_no']);
			$email = $row['email'];
			$status = $row['status'];
			$designation = $row['designation'];			
			$photo_url = $row['photo_url'];	
			$photo_download = str_replace(' ', '%20',$photo_url); 			
			$category = $row['category'];
			$updateStatus = $row['updateStatus'];
			$isReplaced = $row['isReplaced'];
			$dose_status = $row['dose_status'];
			$plant_status = $row['plant_status'];
			$pathInfoName = pathinfo($photo_download); // Get File name & Extension
			$imgName = $pathInfoName['basename']; // get image name
			$imgNameWithoutExtension = $pathInfoName['filename']; // get image name without extension
			$imgNameWithExtension = $pathInfoName['extension']; // get image name without extension
			$photo_name = $unique_code.".".$imgNameWithExtension;	
			$save_loc = "images/".$photo_name;
			$imgagesName = file_get_contents($photo_download,true);
			$msg = file_put_contents($save_loc, $imgagesName);
			$search_param = array(
              "unique_code"=>$unique_code
            );
			$dose_status = "";
			if($category =="OV"){
				if($status =="Y"){
					$status = "Y";
				}else{
					$status = "D";
				}				
			} else {
				$status = "Y";
			}
			
			if($this->Mdl_api->isExist("visitors",$search_param))
			{
				$visitor_data = array(					
						
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'updated_at'=> date('Y-m-d H:i:s')
						);
				$this->Mdl_api->update("visitors",array('unique_code' => $unique_code), $visitor_data);

			  $update_count++;
			} else {
				if($msg)
				{
					
					$visitor_data = array(					
							'unique_code' => strip_tags($unique_code),
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'created_at'=> date('Y-m-d H:i:s')
						);
				$this->Mdl_api->insert("visitors",$visitor_data);
				$insert_count++;
				}
				else
				{
					echo "File downloading failed.";
				}
			}
			
		}
		
		echo "<br/>Total Records Are :".$dataSize."<br/><br/>"; 
		echo "Total New Records inserted :".$insert_count;					
		echo "Total Records updated :".$update_count;					
	}
	
	public function visitorScan(){
		
		if(!$this->validateToken()){
			echo json_encode(array("status"=>"error","message"=>"Token Expired"));exit;
		}else{
			$uid = $this->validateToken();
		}
		$method = $this->input->method(TRUE);  
		if($method !== 'POST'){
			echo json_encode(array('status' => 400,'message' => 'Bad request.'));exit;
		} else {  
	 
		   $content = json_decode(file_get_contents('php://input'), TRUE);
		 
		   
		   $this->form_validation->set_data($content);
		   $this->form_validation->set_rules('zone','zone','trim|xss_clean|required',array("required"=>"ZOne code is required"));
		   $this->form_validation->set_rules('unique_code','unique_code','trim|xss_clean|required',array("required"=>"unique code is required"));
		   $this->form_validation->set_rules('device_type','device_type','trim|xss_clean|required',array("required"=>"Select Check in or check out "));
		   
	 
		    if($this->form_validation->run($this) == FALSE){
	 
			 $errors = $this->form_validation->error_array();
			 echo json_encode(array('status'=>'error','errorData'=>$errors));exit;
	 
		    } else {        
			 
			//  GET SCANNER PERSON INFO
	     $scanner_info = $this->Mdl_api->retrieve("authentication",array("uid"=> $uid));
			 $user_id = $scanner_info[0]->id;
			 $device_type =$content['device_type'];
			 $current_zone = $content['zone'];

			 


			//GET VISITOR INFO
			$unique_code =  $content['unique_code'];  
			$visitor = $this->Mdl_api->retrieve("visitors",array("unique_code"=> $unique_code));
         
			if($visitor !=="NA"){
					$registration_id = trim($visitor[0]->registration_id);  
					$visitor_id = trim($visitor[0]->id);   
					$company = trim($visitor[0]->company);
					$name = trim($visitor[0]->name);
					$mobile = trim($visitor[0]->mobile);
					$email = trim($visitor[0]->email);
					$designation = trim($visitor[0]->designation);
					$photo_url = base_url("images/".$visitor[0]->photo_name);
					$category = trim($visitor[0]->category);
					$description = "";
					$getCategoryName = $this->Mdl_api->retrieve("category_master",array("short_name"=>$category));
					if($getCategoryName !=="NA"){
						$description = $getCategoryName[0]->cat_name;
					}
					$status = $visitor[0]->status;

					// Get Zone wise allow for machinery visitor
          $remark_message = "";
          if($category =="MV"){

						$zone_master = $this->Mdl_api->retrieve("zones",array("name"=> $current_zone));
					 	if($zone_master !=="NA"){
					 		$allow_machinery = $zone_master[0]->allow_machinery;

					 		if($allow_machinery == "0"){
									
									$remark_message = "blocked_check_in";
					 		}
					 	}
					}
					if($category =="SV"){
						$zone_master = $this->Mdl_api->retrieve("zones",array("name"=> $current_zone));
						if($zone_master !=="NA"){
							$allow_service = $zone_master[0]->allow_service;

							if($allow_service == "0"){
									$remark_message = "blocked_check_in";
							}
						}
					}
					if($status =="D"){
						$remark_message = "blocked_check_in";
					}
			
					$insert_data = array(
						"user_id"=>$user_id,
						"unique_code"=>$unique_code,
						"visitor_id"=>$visitor_id,
						"category"=>$category,
						"current_zone"=>$current_zone,
						"device_type"=>$device_type,
						"latitude"=>"",
						"longitude"=>"",
						"status"=>"1",
						"message"=>$remark_message,
						"type"=> $device_type,
						"role"=>"admin",
						"created_at"=>date("Y-m-d H:i:s"),
						"updated_at"=>date("Y-m-d H:i:s"),
					);

				$insert = 	$this->Mdl_api->insert("scan_logs",$insert_data);

				$status = "";

				if($visitor[0]->status =="P"){
				$status = "PENDING";
				$message = "Visitor approval is pending";

				}else if($visitor[0]->status =="Y"){
				$status = "APPROVED";
				$message = "";
				if($category =="MV"){

						$zone_master = $this->Mdl_api->retrieve("zones",array("name"=> $current_zone));
					 	if($zone_master !=="NA"){
					 		$allow_machinery = $zone_master[0]->allow_machinery;

					 		if($allow_machinery == "0"){
									
									$status = "BLOCKED";
									$message = "Machinery visitor is not allowed this zone";
					 		}
					 	}
					}
					if($category =="SV"){
						$zone_master = $this->Mdl_api->retrieve("zones",array("name"=> $current_zone));
						if($zone_master !=="NA"){
							$allow_service = $zone_master[0]->allow_service;

							if($allow_service == "0"){
									$status = "BLOCKED";
									$message = "ACCESS DENIED. ENTRY FROM GATE 2 & 4 ONLY.";
							}
						}
					}
				}else if($visitor[0]->status=="D"){
					$status = "BLOCKED";
					$message = "Visitor is blocked";
				}else if($visitor[0]->status =="DA"){
					$status = "BLOCKED";
					$message = "Visitor is blocked";
				}else if($visitor[0]->status =="R"){
					$status = "REPLACED";
					$message = "Visitor is replaced";
				}

				
				$response = array("status"=>"success","message"=>"visitor has been scanned successfully.","result"=>array("name"=>$name,"company"=>$company,"category"=>$category,"description"=>$description,"photo_url"=>$photo_url,"isReplaced"=>$visitor[0]->isReplaced,"status"=>$status,"message"=>$message));

				// }else{
				// $response = array("status"=>"error","message"=>"Visitor is blocked","result"=>array("name"=>$name,"company"=>$company,"category"=>$category,"description"=>$description,"photo_url"=>$photo_url,"isReplaced"=>$visitor[0]->isReplaced,"status"=>$visitor[0]->status,"message"=>"Visitor is blocked"));
                
				// }
			}else{
				$response = array("status"=>"error","message"=>"Visitor Record not found in scan system","result"=>array());
			}

			echo json_encode($response);exit;
			
		    }
		}
	}
	
	public function getVisitorDetailsBYid(){
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://registration.gjepc.org/getVisitorDatabyid.php',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
		"username": "mukesh@kwebmaker.com",
		"password": "123456"
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$data = json_decode($response, true);
		// echo "<pre>";print_r($data);exit;
		$dataSize = count($data['Response']['Result']);
		$response = array();
		$insert_count = 0;
		$update_count = 0;
		// exit;
	
		foreach($data['Response']['Result'] as $row)
		{
			//echo '<pre>'; print_r($row); exit;
			$post_date = $row['post_date'];
			$unique_code = $row['unique_code'];
			$registration_id = $row['registration_id'];
			$visitor_id = $row['registration_number'];
			$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $row['company']));
			$name = $row['name'];
			$mobile = trim($row['mobile']);
			$pan_no = trim($row['pan_no']);
			$email = $row['email'];
			$status = $row['status'];
			$designation = $row['designation'];			
			$photo_url = $row['photo_url'];	
			$photo_download = str_replace(' ', '%20',$photo_url); 			
			$category = $row['category'];
			$updateStatus = $row['updateStatus'];
			$isReplaced = $row['isReplaced'];
			$dose_status = $row['dose_status'];
			$plant_status = $row['plant_status'];
			$pathInfoName = pathinfo($photo_download); // Get File name & Extension
			$imgName = $pathInfoName['basename']; // get image name
			$imgNameWithoutExtension = $pathInfoName['filename']; // get image name without extension
			$imgNameWithExtension = $pathInfoName['extension']; // get image name without extension
			$photo_name = $unique_code.".".$imgNameWithExtension;	
			$save_loc = "images/".$photo_name;
			$imgagesName = file_get_contents($photo_download,true);
			$msg = file_put_contents($save_loc, $imgagesName);
			$search_param = array(
              "unique_code"=>$unique_code
            );
			$dose_status = "";
			if($category =="OV"){
				if($status =="Y"){
					$status = "Y";
				}else{
					$status = "D";
				}				
			} else {
				$status = "Y";
			}
			
			if($this->Mdl_api->isExist("visitors",$search_param))
			{
				$visitor_data = array(					
						
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'updated_at'=> date('Y-m-d H:i:s')
						);
				$this->Mdl_api->update("visitors",array('unique_code' => $unique_code), $visitor_data);

			  $update_count++;
			} else {
				if($msg)
				{
					
					$visitor_data = array(					
							'unique_code' => strip_tags($unique_code),
							'registration_id' => $registration_id,
							'visitor_id'  => $visitor_id,
							'company' => strip_tags($company),
							'name' => strip_tags(strtoupper($name)),
							'mobile' => strip_tags($mobile),							
							'email' => strip_tags($email),
							'pan_no' => strip_tags($pan_no),
							'designation' => strip_tags($designation),
							'photo_url' => $photo_url,
							'photo_name' => $photo_name,
							'category' => $category,
							'plant_status' => $plant_status,
							'updateStatus' => $updateStatus,
							'isReplaced' => $isReplaced,
							'post_date'=> $post_date,
							'status' => $status,
							'source' => 'online',
							'created_at'=> date('Y-m-d H:i:s')
						);
				$this->Mdl_api->insert("visitors",$visitor_data);
				$insert_count++;
				}
				else
				{
					echo "File downloading failed.";
				}
			}
			
		}
		
		echo "<br/>Total Records Are :".$dataSize."<br/><br/>"; 
		echo "Total New Records inserted :".$insert_count;					
		echo "Total Records updated :".$update_count;					
	}
}