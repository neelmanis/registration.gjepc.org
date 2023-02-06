<?php
include('header_include.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/
 $created_at = date("Y-m-d H:i:s");




$visitors = $conn->query("SELECT * FROM intl_visitor_directory WHERE isPush='N' and status='1' limit 0");
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
          
            /*Global Table Start */
  	
			$digits = 9;	
		    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition_migration WHERE `uniqueIdentifier`='$uniqueIdentifier'");
		    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
			while($countUniqueIdentifier > 0) {
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
			} 
							
			$checkGlobalRecord = "SELECT * FROM globalExhibition_migration WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND participant_Type='VIS'";
			$globalResult = $conn->query($checkGlobalRecord);
	        $checkGlobalCount = $globalResult->num_rows;
		    if($checkGlobalCount>0){
				echo 'Already Registered for Current Show';	
			} else { 
			$insertGlobal = "INSERT INTO globalExhibition_migration  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$visitor_name',`mobile`='$visitor_passport',`pan_no`='$visitor_passport',`designation`='$visitor_designation',`company`='$visitor_company_name',`photo_url`='$visitor_photo', `participant_type`='VIS',`covid_report_status`='pending',`status`='Y' ,`isDataPosted`='N' ,`post_date`='$created_at'";
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