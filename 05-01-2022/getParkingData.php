<?php 
include('db.inc.php'); 

if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);

$username = $obj['username'];
$password = $obj['password'];

$sqlx = "SELECT * FROM gjepclivedatabase.globalparking where 1 AND isDataPosted='N' AND status='Y'  order by created_at desc limit 0,500"; /* Parking AND status='N' */
$sqlDatas = $conn->query($sqlx);
if($username=="mukesh@kwebmaker.com" && $password=="123456"){
	if($sqlDatas->num_rows > 0) {
				$strResponse = array();
				while($result = $sqlDatas->fetch_assoc())
				{					
					$post_date = $result['created_at'];
					$id = $result['id'];
					$unique_code = $result['unique_code'];
					$registration_id = $result['registration_id'];
					$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $result['name']));
					$category = $result['category'];
					$gate_no = $result['gate_no'];
					$area = $result['area'];
					$hall_no = $result['hall_no'];
					$status = $result['status'];
					$car_pass = $result['car_pass'];
					$ground_no = $result['ground_no'];			
					$ban_reason = $result['ban_reason'];				
					$vehicle_no = $result['vehicle_no'];
					$vehicle_parking_date = $result['vehicle_parking_date'];
					$arrival_time = $result['arrival_time'];
					
					switch ($category) {
					
					  	case 'EXH':
					        $agency_category = $result['agency_category'];
					        
					        $category = $agency_category ;
					
					  	break;
					  	case 'EXHM':
						   $category = "ME";
					  	break;
					  	case 'CONTR':
							$agency_category = $result['agency_category'];

							if($agency_category =="VIP"){
								$category = 'VIP';
							}else if($agency_category =="VVIP"){
								$category = 'VVIP';
							}else if($agency_category =="G"){
								$category = 'G';
							}else if($agency_category =="O"){
								$category = 'O';
							}else if($agency_category =="SV"){
								$category = 'SV';
							}else{
							   $category = $agency_category;
							}
					  	break;
					  	default:
						   $category="";
					  	break;
					}
					
					array_push($strResponse,
                    array(
                        "post_date" => $post_date, 
                        "unique_code" => $unique_code,
                        "registration_id" => $registration_id,
                        "company" => $company,
						"category" => $category,
                        "gate_no" => $gate_no,
                        "pan_no" => $pan_no,
                        "area" => $area,
						"hall_no" => $hall_no,
                        "status" => $status,                        
                        "car_pass" => $car_pass,                        
                        "ground_no" => $ground_no,
                        "ban_reason" => $ban_reason,
                        "vehicle_no"=>$vehicle_no,
                        "vehicle_parking_date"=>$vehicle_parking_date,
                        "arrival_time"=>$arrival_time
                        )
                    );
															
					$download = "update gjepclivedatabase.globalparking set isDataPosted='Y' where unique_code='$unique_code'";
					$updates = $conn->query($download);	
				
				}
				$conn->close();
				$strResponse = array(
									"Result"=>$strResponse,
									"query"=>$download,
									"Message"=>'Success',
									"status"=>"true"
								);
		} else {
			$strResponse=array(
				"Result"=>'',
				"Message"=>'No Record Found.',
				"status"=>"false"
					);
			}
			} else {
				$strResponse=array(
				"Result"=>'',
				"Message"=>'Username & Password does not match.',
				"status"=>"false"
					);
				}	
			} else {
				$strResponse=array(
					"Result"=>'',
					"Message"=>'Use POST method.',
					"status"=>"false"
				);
			}
			header('Content-type: application/json');
     	echo json_encode(array("Response"=>$strResponse));
?>