<?php
include('header_include.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/
 $created_at = date("Y-m-d H:i:s");
//$checkHistory = "SELECT * FROM intl_visitors_registration where  reg_for_event='6' and approve='approve' isOld='N' limit 0  "; 
//$checkHistory = "SELECT * FROM intl_visitors_registration where  reg_for_event='6' and isOld='N'   "; 
//$checkHistory = "SELECT * FROM intl_visitors_registration where  reg_for_event='6' and  isOld='N'  "; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		   $registration_id = $resultHistory['id'];
		   $email  = $resultHistory['email'];
		   $company_name  = $resultHistory['company_name'];
		   $city  = $resultHistory['city'];
		   $state  = $resultHistory['state'];
		   $country  = $resultHistory['country'];
		  
		   $buyer1  = $resultHistory['buyer1'];
		   $buyer1_degn  = $resultHistory['buyer1_degn'];
		   $buyer1_nationality  = $resultHistory['buyer1_nationality'];
		   $buyer1_passport_no  = $resultHistory['buyer1_passport_no'];
		   $buyer1_photo  = $resultHistory['buyer1_photo'];
		   $buyer1_vis_card  = $resultHistory['buyer1_vis_card'];
		   $buyer1_passport  = $resultHistory['buyer1_passport'];

		   $buyer2  = $resultHistory['buyer2'];
		   $buyer2_degn  = $resultHistory['buyer2_degn'];
		   $buyer2_nationality  = $resultHistory['buyer2_nationality'];
		   $buyer2_passport_no  = $resultHistory['buyer2_passport_no'];
		   $buyer2_photo  = $resultHistory['buyer2_photo'];
		   $buyer2_vis_card  = $resultHistory['buyer2_vis_card'];
		   $buyer2_passport  = $resultHistory['buyer2_passport'];
		   $status =  $resultHistory['approve']; 
		   if($status   =="approve"){
		   	$status_approval = "Y";
		   }else{
		   	$status_approval = "D";

		   }

           // check already inserted or not
		   $sql_visitor_directory_check = $conn->query("SELECT id from intl_visitor_directory WHERE registration_id='$registration_id'");
			   if($sql_visitor_directory_check->num_rows == 0){
			   	 if($buyer1 !==""){
			   	  $buyer1_sql = "INSERT INTO intl_visitor_directory SET registration_id='$registration_id',name='$buyer1', designation='$buyer1_degn',company_name='$company_name',email='$email',passport='$buyer1_passport_no',nationality='$buyer1_nationality',photo='$buyer1_photo',visiting_card='$buyer1_vis_card',city='$city',state='$state',country='$country',isPush='N','status'='$status_approval',created_at='$created_at'";
			   	$buyer1_insert = $conn->query($buyer1_sql);
			   		if($buyer1_insert){
			   		echo $conn->error;
			   	}
			   }
			   if($buyer2 !==""){
			   	 $buyer2_sql = "INSERT INTO intl_visitor_directory SET registration_id='$registration_id',name='$buyer2', designation='$buyer2_degn',company_name='$company_name',email='$email',passport='$buyer2_passport_no',nationality='$buyer2_nationality',photo='$buyer2_photo',visiting_card='$buyer2_vis_card',city='$city',state='$state',country='$country',isPush='N','status'='$status_approval',created_at='$created_at'";
			   	$buyer2_insert = $conn->query($buyer2_sql);
			   	if($buyer2_insert){
			   		echo $conn->error;
			   	}

			   }
		   }else{
		   	     $get_visitor = $conn->query("SELECT * FROM intl_visitor_directory WHERE registration_id='$registration_id' ");
		   	     if($get_visitor->num_rows > 0){
                   while($row_vis = $get_visitor->fetch_assoc()){
                   	$visitorId = $row_vis['id']; 
  					 $buyer = "UPDATE  intl_visitor_directory SET `status`='$status_approval' WHERE registration_id='$registration_id' and id='$visitorId'";
			   		$buyer_insert = $conn->query($buyer);
			   			if($buyer_insert){
			   		echo $conn->error;
			   		}
			
			     echo  $visitorId ."_is updated"."<br/>";
			   

                   }
		   	     }
		   	 	 
			   	


		   }
	     
	} 
			
}



$visitors = $conn->query("SELECT * FROM intl_visitor_directory WHERE isPush='N' and status='1' limit 0");
//$visitors = $conn->query("SELECT * FROM intl_visitor_directory WHERE isPush='N' ");
	if($visitors->num_rows > 0 ){
		while($visitorResult = $visitors->fetch_assoc())
		{
            $registration_id = $visitorResult['registration_id'];
            $visitor_id = $visitorResult['id'];
            $visitor_name = $visitorResult['name'];
            $visitor_designation = $visitorResult['designation'];
            $visitor_company_name = $visitorResult['company_name'];
            $visitor_email = $visitorResult['email'];
            $visitor_passport = $visitorResult['passport'];
            $visitor_nationality = $visitorResult['nationality'];
            $visitor_visiting_card = $visitorResult['visiting_card'];
            if($visitorResult['photo'] !==""){
            	$visitor_photo = 'https://intl.gjepc.org/'.$visitorResult['photo'];
        	}else{
 				$visitor_photo = "";
            }
          
            $visitor_city = $visitorResult['city'];
            $visitor_state = $visitorResult['state'];
            $visitor_country = $visitorResult['country'];
            $status = $visitorResult['status'];
          
            /*Global Table Start */
  	
			$digits = 9;	
		    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition_migration WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
			while($countUniqueIdentifier > 0) {
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
			} 
							
			$checkGlobalRecord = "SELECT * FROM globalExhibition_migration WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND participant_Type='INTL'";
			$globalResult = $conn->query($checkGlobalRecord);
	        $checkGlobalCount = $globalResult->num_rows;
		    if($checkGlobalCount>0){
					$updateGlobal = "UPDATE  globalExhibition_migration  SET `fname`='$visitor_name',`mobile`='$visitor_passport',`pan_no`='$visitor_passport',`designation`='$visitor_designation',`company`='$visitor_company_name',`email`='$visitor_email',`photo_url`='$visitor_photo',`covid_report_status`='pending',`status`='$status' ,`isDataPosted`='N' ,`modified_date`='$created_at' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND participant_Type='INTL'";
			$updateGlobalResult = $conn->query($updateGlobal);
			if($updateGlobalResult){
				
				$visitor = $conn->query("UPDATE intl_visitor_directory SET  isPush='Y',updated_at='$created_at' WHERE id='$visitor_id' ");
				echo $visitor ."Visitor updated to global";
			}

			} else { 
			$insertGlobal = "INSERT INTO globalExhibition_migration  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$visitor_name',`mobile`='$visitor_passport',`pan_no`='$visitor_passport',`email`='$visitor_email',`designation`='$visitor_designation',`company`='$visitor_company_name',`photo_url`='$visitor_photo', `participant_type`='INTL',`covid_report_status`='pending',`status`='$status' ,`isDataPosted`='N' ,`post_date`='$created_at'";
			$insertGlobalResult = $conn->query($insertGlobal);
			if($insertGlobalResult){
				
				$visitor = $conn->query("UPDATE intl_visitor_directory SET  isPush='Y',updated_at='$created_at' WHERE id='$visitor_id' ");
				echo $visitor ."Visitor added to global";
			}
			
			
			}
			
			/*Global Table End */

		}
	}else{
		echo "No data to push";
	}




?>