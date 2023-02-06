<?php
include('header_include.php');
if(!isset($_SESSION['USERID'])){	header("location:login.php");	exit;	}
//$state = getStateForVisitor($_SESSION['USERID'],$conn);

//$sql="select * from approval_master where registration_id='".$_SESSION['USERID']."' AND (`membership_issued_certificate_dt` between '2019-03-31' and '2020-03-31' || invoice_date between '2019-03-31' and '2020-03-31')";
$sql="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='".$_SESSION['USERID']."' AND issue_membership_certificate_expire_status='Y'";
$result=$conn->query($sql);
$rows1=$result->fetch_assoc();
$num_rows=$result->num_rows;
if($num_rows>0)
{
	$type='M';
} else {
	$type='NM';
}

$action = filter($_REQUEST['action']);

// FETCH ALL EMPLOYEES ON SHOW SELECTION
if($action == "get_employees"){
    $html = "";
	$show = filter($_REQUEST["show"]);
	// $sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
	// 		WHERE NOT EXISTS 
	// 		(SELECT * FROM visitor_order_history 
	// 		WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' and (visitor_order_history.payment_made_for='$show' || visitor_order_history.payment_made_for='6show') ) AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";
    
    if($show  =="signature23"){

      $sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
			WHERE NOT EXISTS 
			(SELECT * FROM visitor_order_history 
			WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' and (visitor_order_history.payment_made_for='signature23'  || visitor_order_history.payment_made_for='stcombo23' || visitor_order_history.payment_made_for='6show') ) AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";

    }else if($show =='iijstritiya23'){

      $sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
			WHERE NOT EXISTS 
			(SELECT * FROM visitor_order_history 
			WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' and (visitor_order_history.payment_made_for='iijstritiya23'  || visitor_order_history.payment_made_for='stcombo23' ) ) AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";

    }else if($show =='combo23' || $show =='stcombo23'){
    		  $sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
			WHERE NOT EXISTS 
			(SELECT * FROM visitor_order_history 
			WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' and (visitor_order_history.payment_made_for='iijstritiya23' || visitor_order_history.payment_made_for='signature23' ||  visitor_order_history.payment_made_for='combo23' || visitor_order_history.payment_made_for='stcombo23' || visitor_order_history.payment_made_for='6show') ) AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";
    	
    }else{
			$sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
			WHERE 1 limit 0";
    }
	// $sql_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
	// 		WHERE NOT EXISTS 
	// 		(SELECT * FROM visitor_order_history 
	// 		WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' AND visitor_order_history.payment_made_for='$show'  ) AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";		

	$query_vis=$conn->query($sql_vis);
	$count_vis = $query_vis->num_rows;
	$html .='<option value="">Select Employee</option>';
	if($count_vis > 0) {
	
		while($row_vis = $query_vis->fetch_assoc()){
			$html .='<option value="'.$row_vis['visitor_id'].'">'.$row_vis['visitor_name'].'</option>';
		}
	}else{
		$html .='<option value="0">Not found</option>';
	}
	echo json_encode(array("output"=>$html));exit;
}
if($action == "get_registered_employees"){
   $html = "";
	$show = filter($_REQUEST["show"]);

	$sql_reg_vis = "SELECT CONCAT(name, ' ', lname) AS visitor_name, visitor_id,visitor_approval FROM visitor_directory 
			WHERE EXISTS 
			(SELECT * FROM visitor_order_history 
			WHERE visitor_directory.visitor_id = visitor_order_history.visitor_id and visitor_order_history.payment_status='Y' AND visitor_order_history.payment_made_for='$show') AND `visitor_approval`='Y' AND `registration_id`='".$_SESSION['USERID']."'";		

	$query_reg_vis=$conn->query($sql_reg_vis);
	$count_reg_vis = $query_reg_vis->num_rows;
	$html .='<option value="">Select Employee</option>';
	if($count_reg_vis > 0) {
	
		while($row_reg_vis = $query_reg_vis->fetch_assoc()){
			$html .='<option value="'.$row_reg_vis['visitor_id'].'">'.$row_reg_vis['visitor_name'].'</option>';
		}
	} else {
		$html .='<option value="0">Not found</option>';
	}
	echo json_encode(array("output"=>$html));exit;
}

// FETCH PARTICIPATION FEES ON EMPLOYEE SELECTION
if($action == "get_fees"){
	$show = filter($_REQUEST["show"]);
	$result_event = $conn->query("SELECT * FROM `visitor_event_master` WHERE `shortcode`='$show' ");
	$count_event = $result_event->num_rows;
	if($count_event > 0){
		$row_event = $result_event->fetch_assoc();
		$isFree = $row_event['isFree'];
	}
	if($isFree =="yes"){
		$participation_fee = 0;
	} else {
		$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type' AND `shortcode`='$show'";
		$result=$conn->query($sql);
		$count = $result->num_rows;
		if($count > 0){
			$row = $result->fetch_assoc();
		 	$participation_fee = $row['fees'];
		} else {
		 	$participation_fee = "";
		}
	}
	echo json_encode(array("output"=>$participation_fee)); exit;
}


if($action == "old_code"){
	if(isset($type) && !empty($type)){
		$sql="SELECT * FROM `visitor_fee_structure` WHERE min_date <=  NOW() AND max_date >=  NOW() AND type='$type'";
		$result=$conn->query($sql);
		while($rows2=$result->fetch_assoc())
		{
			
			if($show == "signature22")
				echo $participation_fee = trim($rows2['signature22']);
			elseif($show == "igjme22")
				echo $participation_fee = trim($rows2['igjme']);
			else
				echo "";
			
			/*if($show == "iijs21" && $state!=10)
				echo $participation_fee=$rows2['iijs21'];
			elseif($show == "iijs21" && $state==10)
				echo $participation_fee = $rows2['iijs21']-250;
			elseif($show == "igjme21")
				echo $participation_fee=$rows2['igjme'];
			else
				echo "";
			*/
			/* if($show == "vbsm2")
				echo $participation_fee=$rows2['vbsm'];
			else
				echo ""; */
			/*if($show == "1show")
				echo $participation_fee=$rows2['1show'];
			elseif($show == "4show")
				echo $participation_fee=$rows2['4show'];
			elseif($show == "combo")
				echo $participation_fee=$rows2['combo'];
			elseif($show == "igjme")
				echo $participation_fee=$rows2['igjme'];
			else
				echo ""; */
		}
	}
}

?>