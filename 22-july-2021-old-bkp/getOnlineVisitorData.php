<?php 
include('header_include.php'); 
if($_SERVER['REQUEST_METHOD'] == "POST"){

$json = file_get_contents('php://input');
$obj = json_decode($json,true);
 
$username = $obj['username'];
$password = $obj['password'];

$sqlx = "select oh.visitor_id as 'RegistrationNumber',oh.create_date as 'Create_date', rm.company_name as 'Company_Name', oh.orderId as 'Order_Id', vd.name as 'First_Name', vd.lname as 'Last_Name',oh.payment_made_for as 'Payment', oh.amount as 'Amount', oh.payment_status as 'Payment_Status',rm.id as 'UserID',vd.photo as 'Photo',vd.BADGE_ID as 'BADGEID' ,vd.gender as 'Gender',vd.degn_type as 'DESIGNATION_TYPE',vdm.type_of_designation as 'DESIGNATION',vd.mobile as 'MOBILE',vd.pan_no as 'IndividualPAN',rm.company_pan_no as 'CompanyPAN',rm.company_gstn as 'CompanyGST',vd.aadhar_no as 'Aadhar', vd.bp_number as 'BPno' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id inner join visitor_designation_master vdm  on vdm.id=vd.designation where oh.payment_status='Y' and oh.status = '1' and oh.downlaod_status='N' and oh.payment_made_for='signature2'";

$sqlDatas = $conn->query($sqlx);
$sqlDatas->num_rows;
if($username=="mukesh@kwebmaker.com" && $password=="123456"){
	if($sqlDatas->num_rows > 0) {
		 
				$strResponse=array();
				while($result=$sqlDatas->fetch_assoc())
				{
					$strResponse[]= $result;
					$Order_Id=$result['Order_Id'];
					$visitor_id=$result['RegistrationNumber'];
					/*..................................Get Delivery ID.....................................*/
					/*$q=$conn ->query("select type_of_member,delivery_id from visitor_order_detail where orderId='$Order_Id'");
					$r=$q->fetch_assoc();
					$type_of_member=$r['type_of_member'];
					$delivery_id=$r['delivery_id'];
					
					$result1=getVisitorBillingAddress($type_of_member,$delivery_id,$conn);
					$strResponse[]=array_merge($result,$result1);
					mysql_query("update visitor_order_history set downlaod_status='Y' where visitor_id='$visitor_id'");	
					*/
				}
				$strResponse=array(
								"Result"=>$strResponse,
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
	}else {
		$strResponse=array(
								"Result"=>'',
								"Message"=>'Username & Password does not match.',
								"status"=>"false"
									);
		}	
	}else {
		$strResponse=array(
								"Result"=>'',
								"Message"=>'Use POST method.',
								"status"=>"false"
									);
	}
	header('Content-type: application/json');
     echo json_encode(array("Response"=>$strResponse));
?>