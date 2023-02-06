<?php
include ("db.inc.php");
include ("functions.php");
session_start();

$action = $_REQUEST['action'];
if($action == 'pan_number'){
	$pan_number = trim($_REQUEST['pan_no']);
	$sql =  "SELECT * FROM visitor_directory WHERE pan_no='$pan_number' order by visitor_approval limit 1";
	$result = $conn ->query($sql); 
	$count = $result->num_rows;
  
    $data = array();
	if($count>0) 
	{
		$row = $result->fetch_assoc(); 
		$company = strtoupper(str_replace('&amp;', '&', getCompanyName($row['registration_id'],$conn)));
		$mobile = trim($row['mobile']);
		$email = $row['email'];
		$designation = getVisitorDesignationID($row['designation'],$conn);
		$name = $row['name'];
		$lname = $row['lname'];
		$photo = $row['photo'];
		$reg_id = $row['registration_id'];
		$status = $row['visitor_approval'];
		$combo = $row['combo'];
		$visitorID = $row['visitor_id']; 
		$registration_id = intval(filter($row['registration_id']));
		
	  	$sqlExhibitor = "select * from exh_reg_payment_details where uid='$registration_id' AND `show`='IIJS SIGNATURE 2022' AND `year`='2022' AND allow_visitor='N' order by payment_id desc limit 0,1";
        $ansExhibitor = $conn ->query($sqlExhibitor);
        $rowExhibitor=$ansExhibitor->num_rows;
        if($rowExhibitor>0){
	    echo json_encode($data = array("status"=>'exhibitor')); exit;
        }

		$sqlData = "select * from registration_master where id='$registration_id' AND approval_status='D'";
        $ansData = $conn ->query($sqlData);
        $rowData=$ansData->num_rows;
        if($rowData>0){
			$_SESSION['registration_id'] = $row['registration_id']; 
	    echo json_encode($data = array("status"=>'companyData')); exit;
        }
		
		$newx = "SELECT * from visitor_directory where pan_no='$pan_number' AND visitor_approval='Y'";
		$query=$conn ->query($newx);
		$lettersinDB = array();
			while($rows = $query->fetch_assoc()){
			array_push($lettersinDB,array('visitor_id'=>$rows['visitor_id'],'name'=>$rows['name']));
		}		

	//	$checkHistory = "SELECT * FROM `visitor_order_history` WHERE visitor_id='$visitorID' AND payment_made_for='signature22' AND `status`='1' AND payment_status='Y'";
		$checkHistory = "SELECT * FROM gjepclivedatabase.visitor_enquiry WHERE visitor_id='$visitorID'";
		$getQuery = $conn ->query($checkHistory);
		$checkResult = $getQuery->num_rows;
		$gotcommaid = array();
		while($checkQuery = $getQuery->fetch_assoc()){	
			array_push($gotcommaid,explode(",",$checkQuery['visitor_id']));															
		}

		$finalvisitoridarray = array();
		foreach($gotcommaid as $k => $v){
			$finalvisitoridarray = array_merge($finalvisitoridarray,$v);
		}

		foreach($lettersinDB as $option_value)
		{ 							
			if(in_array($option_value['visitor_id'], $finalvisitoridarray)) {
				$data = array("status"=>'paymentAlreadyDone');
				echo json_encode($data); exit;
			}
		}

		if($status =='Y'){
		$_SESSION['registration_id'] = $row['registration_id']; 
			    $_SESSION['visitor_id'] = $row['visitor_id'];
       	  $data = array("status"=>'success',"company"=>$company, "mobile"=>$mobile,"email"=>$email,"name"=>$name,"lname"=>$lname,"photo"=>$photo,"reg_id"=>$reg_id,"visitor_id"=>$visitorID,"designation"=>$designation,"pan_number"=>$pan_number);
    
		}else if($status =='D'){
        $message = "Dear ".$name.", Kindly update your data";		
		//get_data($message,$mobile_no);
		$_SESSION['registration_id'] = $row['registration_id']; 
		$_SESSION['visitor_id'] = $row['visitor_id'];
        $data = array("status"=>'disapproved');
		}else if($status =='P'){
		$data = array("status"=>'pending');	
		}else if($status =='U'){
		$data = array("status"=>'updated');	
		}
		
	} else {
		$data = array("status"=>'notExist');
	}	
	echo json_encode($data);
}

if($action == 'send_otp'){
	//echo '<pre>'; print_r($_POST); exit;
	$mobile_no = trim($_REQUEST['mobile_no']);
	$pan = trim($_REQUEST['pan_number']);
	$visitng_show = trim($_REQUEST['visitng_show']);
	$datetime = date("Y-m-d H:i:s");
	$visitor_id = $_SESSION['visitor_id'];
	$registration_id = $_SESSION['registration_id'];
	$email = getVisitorEmail($visitor_id,$conn);
	$visitorNAME = getVisitorName($visitor_id,$conn);
   $companyNAME = getCompanyName($registration_id,$conn);

		if(isset($registration_id) && $registration_id!=""){

		$sqlb =  "SELECT * FROM gjepclivedatabase.visitor_enquiry WHERE pan = '".$pan."'";
		$resultb = $conn->query($sqlb); 
		$countb = $resultb->num_rows;
		if($countb>0) 
		{
		 $data = array("status"=>'errorAlready');
		} else {
			$insertData = $conn->query("INSERT INTO visitor_enquiry SET post_date='$datetime',registration_id='$registration_id',visitor_id='$visitor_id',name='$visitorNAME',email='$email',company='$companyNAME',mobile_no='$mobile_no',pan='$pan',visitng_show='$visitng_show'");
			if($insertData){
			$data = array("status"=>'successOtp',"mobile_no"=>"$mobile_no");
			
			$messageEmail ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
		<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
			<tr>
	            <td >
	            <div style="display:flex;justify-content:space-between">
	            	<div >
	            	<img id="ri" src="https://registration.gjepc.org/images/logo.png">            		
	            	</div>
	                <div >
	               	<img id="ri" src="https://registration.gjepc.org/images/signature-logo.png">
	               </div>
	               </div>    
	            </td>                        
			</tr>
		  <tr style="background-color:#eeee;padding:30px;">
		  <td>One Time Password for Visitor Verification is <b>'.$otp.'</b> </td></tr>
		   <tr><td>       
			  <p>Kind Regards,<br>
			  <b>GJEPC Web Team,</b>
			  </p>
			  <p> For Any Queries : </p>
			</td>
		  </tr>
		  <tr><td><b>Email us on :</b> visitors@gjepcindia.com
		 </td></tr> 
		</table>';
	  
		// $to = $email;
		 $subject = "Verification code to verify your account"; 
		 $headers  = 'MIME-Version: 1.0' . "\r\n"; 
		 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		 $headers .= 'From: IIJS SIGNATURE 2022 SHOW <admin@gjepc.org>';
			}
		}
	}
echo json_encode($data);
}
?>