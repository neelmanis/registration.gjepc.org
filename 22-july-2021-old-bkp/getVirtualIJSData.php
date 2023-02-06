<?php 
include('header_include.php'); 
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
 
$username = $obj['username'];
$password = $obj['password'];
$start =$obj['start'];
$limit=$obj['limit'];

$sqlx = "select oh.visitor_id as 'RegistrationNumber',oh.create_date as 'Create_date', rm.company_name as 'Company_Name',rm.city as 'City', oh.orderId as 'Order_Id', vd.name as 'First_Name', vd.lname as 'Last_Name',vd.email as 'Email',oh.payment_made_for as 'Payment', oh.amount as 'Amount', oh.payment_status as 'Payment_Status',rm.id as 'UserID',vd.photo as 'Photo',vd.gender as 'Gender',vd.degn_type as 'DESIGNATION_TYPE',vdm.type_of_designation as 'DESIGNATION',vd.mobile as 'MOBILE',vd.secondary_mobile as 'SECONDARY_MOBILE',vd.pan_no as 'IndividualPAN',rm.company_pan_no as 'CompanyPAN',rm.company_gstn as 'CompanyGST',vd.aadhar_no as 'Aadhar' from gjepclivedatabase.visitor_order_history oh inner join gjepclivedatabase.registration_master rm on oh.registration_id=rm.id inner join gjepclivedatabase.visitor_directory vd on oh.visitor_id=vd.visitor_id inner join gjepclivedatabase.visitor_designation_master vdm  on vdm.id=vd.designation where oh.payment_status='Y' and oh.status = '1' and oh.payment_made_for='vbsm2' order by oh.Create_date ASC limit $start,$limit";

$sqlDatas = $conn->query($sqlx);
$sqlDatas->num_rows;
if($username=="mukesh@kwebmaker.com" && $password=="123456"){
	if($sqlDatas->num_rows > 0) {
				$strResponse=array();
				while($result=$sqlDatas->fetch_assoc())
				{
					//$strResponse[]= $result;
					/*..................................Get Delivery ID.....................................*/				
					$visitor_id=$result['RegistrationNumber'];
					$Order_Id=$result['Order_Id'];
		
					$q=$conn ->query("select agree as 'SocialMediaConsent' from visitor_order_detail where orderId='$Order_Id'");
					$agree=$q->fetch_assoc();
					
					/*$result1=getVisitorBillingAddress($type_of_member,$delivery_id,$conn);*/
					$strResponse[]=array_merge($result,$agree);
					$conn->query("update visitor_order_history set downlaod_status='Y' where visitor_id='$visitor_id' and payment_made_for='vbsm2'");	
				}
				$strResponse=array(
								"Result"=>$strResponse,
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