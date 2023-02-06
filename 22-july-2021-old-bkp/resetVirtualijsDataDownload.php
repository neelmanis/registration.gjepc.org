<?php 
include('header_include.php'); 
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
 
$username = $obj['username'];
$password = $obj['password'];
$start =$obj['start'];
$limit=$obj['limit'];

$sqlx = "SELECT * FROM gjepclivedatabase.visitor_order_history where payment_made_for='vbsm' order by Create_date ASC limit $start,$limit";
$sqlDatas = $conn->query($sqlx);
$sqlDatas->num_rows;
if($username=="mukesh@kwebmaker.com" && $password=="123456"){
	if($sqlDatas->num_rows > 0) {
				$strResponse=array();
				while($result=$sqlDatas->fetch_assoc())
				{
				
					/*..................................Get Delivery ID.....................................*/
					$id=$result['id'];
					$conn->query("update visitor_order_history set downlaod_status='N' where id='$id' and payment_made_for='vbsm'");	
				}
				$strResponse=array(
								"Result"=>'',
								"Message"=>'Success',
								"status"=>"true"
								);
	} else {
		$strResponse=array(
								"Result"=>'',
								"Message"=>'No Data Found.',
								"status"=>"false"
									);
	    }
	}else {
		$strResponse=array(
								"Result"=>'',
								"Message"=>'Username and password mismatch.',
								"status"=>"false"
									);
		}	
	}else {
		$strResponse=array(
								"Result"=>'',
								"Message"=>'Post request is not correct.',
								"status"=>"false"
							);
	}
	header('Content-type: application/json');
    echo json_encode(array("Response"=>$strResponse));
?>