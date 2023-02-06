<?php 
include('db.inc.php'); 

if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
 
$username = $obj['username'];
$password = $obj['password'];

$sqlx = "SELECT count(uniqueIdentifier) as `total_count` FROM globalExhibition where 1 and status='Y' and dose2_status='Y'";
$sqlDatas = $conn->query($sqlx);

if($username=="mukesh@kwebmaker.com" && $password=="123456"){
	if($sqlDatas->num_rows > 0) {
				$strResponse = array();
				while($result = $sqlDatas->fetch_assoc())
				{
					$strResponse= $result['total_count'];								
				}
				$strResponse = array(
								"Result"=>$strResponse,
								"query"=>"count",
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