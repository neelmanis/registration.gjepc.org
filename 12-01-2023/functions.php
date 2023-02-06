<?php
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}

function getCountryName($countrycode,$conn)
{
	$query_sel = "SELECT country_name FROM  country_master  where country_code='$countrycode'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	 		
		return $row['country_name'];		
	
}

function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['state_name'];		
	
}

function getStateNamefromcode($code,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$code'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['state_name'];
		
	
}

function getCityName($id,$conn)
{
	$query_sel = "SELECT city_name FROM  city_master  where id='$id'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['city_name'];
}

function getUserName($id,$conn)
{
   $query_sel = "SELECT first_name,last_name FROM  registration_master  where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
		$full_name=	$row['first_name'].' '.$row['last_name'];
		return $full_name;
}

function getCompanyName($id,$conn)
{
    $query_sel = "SELECT company_name FROM registration_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	$company_name=	$row['company_name'];
	return $company_name;	
}

function getCompanyCityName($id,$conn)
{
    $query_sel = "SELECT city FROM registration_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	$city=	$row['city'];
	return $city;	
}

function getCompanyStateName($id,$conn)
{
    $query_sel = "SELECT state FROM registration_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	$state=	$row['state'];
	return $state;	
}

function getCompanyPan($id,$conn)
{
        $query_sel = "SELECT company_pan_no FROM registration_master where id='$id'";	
        $result_sel = $conn->query($query_sel);								
	    $row = $result_sel->fetch_assoc();	 	
		$company_pan_no=	$row['company_pan_no'];
		return $company_pan_no;
	
}
function getCompanyGst($id,$conn)
{
    $query_sel = "SELECT company_gstn FROM registration_master where id='$id'";	
    $result_sel = $conn->query($query_sel);								
    $row = $result_sel->fetch_assoc();	
	$company_gstn =	$row['company_gstn'];
	return $company_gstn;
	
}

function getUserEmail($id,$conn)
{
	$query_sel = "SELECT email_id FROM  registration_master  where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['email_id'];
}

function getCompanyAddress($id,$conn)
{
	$query_sel = "SELECT address_line1,address_line2,address_line3,city,pin_code FROM  registration_master  where id='$id'";	
    $result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
	return $row['address_line1'].",".$row['address_line2'].",".$row['address_line3'].",".$row['city'].",".$row['pin_code'];
}

function getUserMobile($id,$conn)
{
	$query_sel = "SELECT mobile_no FROM  registration_master  where id='$id'";	
    $result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['mobile_no'];
}
function getUserCombo($id,$conn)
{
	$query_sel = "SELECT combo FROM  registration_master  where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['combo'];
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region_name FROM  region_master  where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['region_name'];
	
}

function getStateForVisitor($id,$conn)
{
	$query_sel = "SELECT state FROM registration_master where id='$id'";		
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['state'];
}

function getHotelName($hotel_id,$conn)
{
	$query_sel = "SELECT hotel_name FROM  iijs_hotel_master  where hotel_id='$hotel_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			 	
    return $row['hotel_name'];
}
function getRoomType($hotel_details_id)
{
	$query_sel = "SELECT room_name FROM  iijs_hotel_details  where hotel_details_id='$hotel_details_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 			
		return $row['room_name'];
}
function getguestcountry($guest_country,$conn)
{
	$query_sel = "SELECT country_name FROM  country_master  where country_code='$guest_country'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['country_name'];
}
function getRegionBankName($region_id)
{
	$query_sel = "SELECT region_bank FROM region_master where region_name='$region_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['region_bank'];
}

function uploadImage($file_name,$file_temp,$file_type,$file_size,$name)
{
	$upload_image = '';
	$target_folder = 'images/ivr_image/'.$name.'/';
	$target_path = "";
	$temp_code = $_SESSION['USERID']."_IIJS";
	$file_name = str_replace(" ","_",$file_name);
	$random_name = rand();
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	} else	if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152 )
		{
			$target_path = $target_folder.$temp_code.'_'.$name.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $temp_code.'_'.$name.'_'.$random_name.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}	
	return $upload_image;
}

	function vaccination_documents($file_name,$file_temp,$file_type,$file_size,$attach)
	{
		$upload_image = '';
		$target_folder = 'images/ivr_image/'.$attach.'/';
		$target_path = "";
		$temp_code = $_SESSION['USERID']."_IIJS";
		$file_name = str_replace(" ","_",$file_name);
		$file_name = filter($file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "application/PDF") || ($file_type == "application/pdf")) && $file_size < 2097152)
			{
				$random_name = rand();
				$target_path = $target_folder.$temp_code.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $temp_code.'_'.$attach.'_'.$random_name.$file_name;
				} else	{
					$upload_image = "failed";
				}
			} else {
				$upload_image = "invalid";
			}
		}		
		return $upload_image;
	}
	
function uploadImage_pvr($file_name,$file_temp,$file_type,$file_size,$name,$conn)
{
	$uid = $_SESSION['USERID'];
	$upload_image = '';
	$target_folder = 'images/pvr_image/'.$name.'/';
	$target_path = "";
	
	$temp_code = strtoupper($uid);
	//$temp_code = strtoupper(str_replace("/","",$_SESSION['PVRCODE']));
	$user_name = getUserName($temp_code,$conn);
		
	$qpreviousimg=$conn->query("select * from pvr_registration_details where uid='$uid' and participate_for_show='IIJS' and participation_year='2018'");
	$rpreviousimg=$qpreviousimg->fetch_assoc();	
	$imageUnlinkphoto = $rpreviousimg["photo_image"];
	$imageUnlinkpassport = $rpreviousimg["id_proof"];
	
	if($name=="photo" && $imageUnlinkphoto!="")
	{
		$photo="images/pvr_image/".$name."/".$imageUnlinkphoto;
		unlink($photo);	
	}	
	
	if($name=="passport" && $imageUnlinkpassport!="")
	{
		$passport = "images/pvr_image/".$name."/".$imageUnlinkpassport;
		unlink($passport);	
	}
	
	if(($name == "photo" && $file_name != '' ) || ($name == "passport" && $file_name != '' ))
	{
		/*if((($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152 ) */
		/*if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152 )
		{ */
			$info = pathinfo($file_name);
			$file_name = $temp_code.".".$info["extension"];			
			$target_path = $target_folder.$file_name;
			
		/*	$info = pathinfo($file_name);
			$file_name = $temp_code.".".$info["extension"];
			
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = $temp_code."_IIJS.".$ext;
			$target_path = $target_folder.$file_name;
		*/	
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
	/*	}
		else
		{
			echo "Invalid file";
		}	*/
	}	
	return $upload_image;
}

function uploadImage_ivr($file_name,$file_temp,$file_type,$file_size,$name,$conn)
{
	$upload_image = '';
	$target_folder = 'images/ivr_image/'.$name.'/';
	$target_path = "";
	$temp_code = $_SESSION['USERID'];
	
	$user_name = getUserName($temp_code,$conn);
	
	$qpreviousimg=$conn->query("select * from ivr_registration_details where uid='$temp_code' and trade_show='IIJS 2015'");
	$rpreviousimg=$qpreviousimg->fetch_assoc();
	
	if($name=="photograph")
		$imageUnlink = $rpreviousimg["photograph_fid"];
	if($name=="passport")
		$imageUnlink = $rpreviousimg["passport_fid"];
	if($name=="visiting_card")
		$imageUnlink = $rpreviousimg["visit_card_fid"];
	if($name=="nri")
		$imageUnlink = $rpreviousimg["nri_fid"];

	$filename="images/ivr_image/".$name."/".$imageUnlink;
	
	unlink($filename);
	
	if($file_name != '')
	{
		if ((($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152 )
		{
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = $temp_code."_IIJS.".$ext;
			$target_path = $target_folder.$file_name;
			
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $file_name;
				
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}
	
	return $upload_image;
}



function getMemberCompany($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM  member_directory  where registration_id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
		return $row['company_name'];
}

function getMemberContact($registration_id,$conn)
{
	$query_sel = "SELECT contact_person FROM  member_directory  where registration_id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['contact_person'];
}

function getMembershipId($registration_id,$conn)
{
	$query_sel = "SELECT membership_id FROM  approval_master  where registration_id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
	return $row['membership_id'];
}

function getMembershipType($registration_id,$conn)
{
	$query_sel = "SELECT membership_certificate_type FROM  approval_master where registration_id='$registration_id'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
	return $row['membership_certificate_type'];
}

function getMembership_Issued_Dt($registration_id,$conn)
{
	$query_sel = "SELECT membership_issued_dt FROM  approval_master  where registration_id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
		return $row['membership_issued_dt'];
}
function getMembership_Renewal_Dt($registration_id,$conn)
{
	$query_sel = "SELECT membership_renewal_dt FROM  approval_master  where registration_id='$registration_id' and membership_renewal_dt > '2015-03-31'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['membership_renewal_dt'];
}

function getSchemeDescription($scheme,$conn)
{
	$query_sel = "SELECT scheme_desc FROM  iijs_scheme_master  where scheme='$scheme'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['scheme_desc'];
}

function getSchemeDescription_signature($scheme,$conn)
{
	$query_sel = "SELECT  scheme_desc FROM  signature_scheme_master  where scheme='$scheme'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['scheme_desc'];
}

function getSection_desc($section,$conn)
{
	$query_sel = "SELECT section_desc FROM signature_section_master where section='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['section_desc'];
}

function getSection_description($section,$conn)
{
	$query_sel = "SELECT section_desc FROM iijs_section_master where section='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['section_desc'];
}

function getSection_description_tritiya($section,$conn)
{
	$query_sel = "SELECT section_desc FROM signature_section_master where section='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['section_desc'];
}
function getErpCode($pvrcode,$conn)
{
	$query_sel = "SELECT `erp_code` FROM `temp_privilege_visitor_reg` WHERE `privilege_code`='$pvrcode'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
	return $row['erp_code'];
}

function pan_no($uid,$conn)
{
	$query_sel = "SELECT pan_no FROM `information_master` WHERE `registration_id`='$uid'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['pan_no'];
}

function tan_no($uid,$conn)
{
	$query_sel = "SELECT tan_no FROM `information_master` WHERE `registration_id`='$uid'";
	$result_sel = mysql_query($query_sel);								
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
	return $row['tan_no'];
}

function chk_msme($uid,$conn)
{
	$query_sel = "SELECT msme_ssi_status FROM `information_master` WHERE `registration_id`='$uid'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['msme_ssi_status'];
}

function getGcode($uid,$conn)
{
	$query_sel = "SELECT gcode FROM registration_master where id='$uid'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['gcode'];
}

function getBPNO($registration_id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['c_bp_number'];
	
}

function getBPNObyID($id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where id='$id' AND address_identity='CTC'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['c_bp_number'];
}

function send_otp($message,$mobile_no) {
	/*$message=str_replace(" ","%20",$message);
	//$url = 'http://www.tecogis.com/tec_sms_engine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$mobile_no;
	$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$mobile_no;
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data; */
}

function number_word($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FOURTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
		  
  $result = "" .$result ."ONLY";
  //if($points!=""){$result=$result.$points . " PAISE";}
  echo $result;  
 }
 
function number_word_v($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FOURTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
		  
  $result = "" .$result ."ONLY";
  //if($points!=""){$result=$result.$points . " PAISE";}
  return $result;  
 }
 
 function containsDecimal( $value ) {
    if ( strpos( $value, "." ) !== false ) {
        return true;
    }
    return false;
}
?>
<?php
// $ids = $_REQUEST['id'];
/* 08-12-2021 comment for Compress
function uploadEVRImage($file_name,$file_temp,$file_type,$file_size,$id,$name,$conn)
{
	$upload_image = '';
	$target_folder = 'images/employee_directory/'.$_SESSION['USERID'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
	if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152)
	{
		$random_name = rand();
		$target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
		if(@move_uploaded_file($file_temp, $target_path))
		{
			$upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
		}
		else
		{
			$upload_image = "failed";
		}
	}   else {
			$upload_image = "invalid";
		}	
	}
	
	return $upload_image;
} */

function uploadEVRImage($file_name,$file_temp,$file_type,$file_size,$id,$name,$conn)
{
	$upload_image = '';
	$target_folder = 'images/employee_directory/'.$_SESSION['USERID'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
	if(($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG"))
	{
		if($file_size < 5242880)
		{
			$random_name = rand();
			$target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			//if(@move_uploaded_file($file_temp, $target_path))
			$compressedImage = compressImage($file_temp, $target_path, 75); 
			if($compressedImage)
			{
				$upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			} else {
				$upload_image = "failed";
			}
		} else {
			$upload_image = "sizeError";
		}
	}   else {
			$upload_image = "invalid";
		}	
	}
	return $upload_image;
}

function compressImage($source, $destination, $quality) 
{
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/jpg': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
    // Save image 
    imagejpeg($image, $destination, $quality); 
    // Return compressed image 
    return $destination; 
}

function uploadAddressGST($file_name,$file_temp,$file_type,$file_size,$gst_number)
{
	$upload_image = '';
	$target_folder = 'images/address_gst_copy/'.$_SESSION['USERID'].'/';
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$random_name = rand();
			$target_path = $target_folder.$user_id.'_'.$gst_number.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $user_id.'_'.$gst_number.'_'.$random_name.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "invalidfile";
		}	
	}	
	return $upload_image;
}

function uploadPanGST($file_name,$file_temp,$file_type,$file_size,$name)
{
	$upload_image = '';
	$target_folder = 'images/'.$name.'/';
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	} else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$target_path = $target_folder.$user_id.'_'.$name.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $user_id.'_'.$name.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "invalidfile";
		}	
	}	
	return $upload_image;
}

function uploadSinglePanGST($file_name,$file_temp,$file_type,$file_size,$name)
{
	$upload_image = '';
	$target_folder = 'images/'.$name.'/';
	$target_path = "";
	$user_id = $_SESSION['registration_id'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	} else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG") || ($file_type == "application/PDF")) && $file_size < 2097152)
		{
			$target_path = $target_folder.$user_id.'_'.$name.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $user_id.'_'.$name.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			//echo "invalidfile";
			$upload_image = "invalidfile";
		}	
	}	
	return $upload_image;
}

function getVisitorName($id,$conn)
{
    $query_sel = "SELECT name,lname FROM visitor_directory where visitor_id='$id'";	
    $result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	$full_name=	strtoupper($row['name']).' '.strtoupper($row['lname']);
	return $full_name;
}
function getVisitorBillingAddress($type_of_member,$delivery_id,$conn)
{
	if($type_of_member=="M")
    	$query_sel = "SELECT a.city as 'City',a.address1 as 'SHIPPING_ADDRESS1',a.address2 as 'SHIPPING_ADDRESS2',b.state_name as 'STATE',a.pincode as 'PINCODE',a.landline_no1 as 'TEL' FROM communication_address_master a , state_master b where a.id='$delivery_id' and a.state=b.state_code";
	else 	
		 $query_sel = "SELECT a.city as 'City',a.address1 as 'SHIPPING_ADDRESS1',a.address2 as 'SHIPPING_ADDRESS2',b.state_name as 'STATE',a.pin_code as 'PINCODE' FROM n_m_billing_address a, state_master b where a.id='$delivery_id' and a.state=b.state_code";

	$result_sel = $conn->query($query_sel);								
	return $row = $result_sel->fetch_assoc();	
}

function getVisitorFullName($id,$conn)
{
    $query_sel = "SELECT name,lname FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();							
	
		$full_name=	$row['name'].' '.$row['lname'];
		return $full_name;
}

function getINTLVisitorName($id,$conn)
{
    $query_sel = "SELECT first_name,last_name FROM ivr_registration_details where eid='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();							
	$full_name=	$row['first_name'].' '.$row['last_name'];
	return $full_name;
}

function getVisitorDesignationID($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['type_of_designation'];
	
}

function checkOwnerType($registration_id,$conn)
{
	$query_sel = "SELECT * FROM visitor_directory where registration_id='$registration_id' AND designation='18'";	
	$result_sel = $conn->query($query_sel);								
	$count = $result_sel->num_rows;	 	
			
		return $count;

}

function getVisitorDesignation($id,$conn)
{
	$query_sel = "SELECT designation FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	 		
		return $row['designation'];
	
}

function getINTLVisitorDesignation($id,$conn)
{
	$query_sel = "SELECT designation FROM ivr_registration_details where eid='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['designation'];
}

function getVisitorEmail($id,$conn)
{
	$query_sel = "SELECT email FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['email'];
}

function getINTLVisitorEmail($id,$conn)
{
	$query_sel = "SELECT email FROM ivr_registration_details where eid='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['email'];
}

function getVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['mobile'];
}

function getINTLVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mob_no FROM ivr_registration_details where eid='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['mob_no'];
}

function getRegisIDMobile($mobile,$conn)
{
	$query_sel = "SELECT registration_id FROM visitor_directory where mobile='$mobile' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['registration_id'];
}

function getRegisIDEmail($email,$conn)
{
	$query_sel = "SELECT registration_id FROM visitor_directory where email='$email' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['registration_id'];
}

function getRegisIDPAN($pan_no,$conn)
{
	$query_sel = "SELECT registration_id FROM visitor_directory where pan_no='$pan_no' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['registration_id'];
}

function getVisitorPAN($id,$conn)
{
	$query_sel = "SELECT pan_no FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['pan_no'];
}

function getVisitorSecondaryMobile($id,$conn)
{
	$query_sel = "SELECT secondary_mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['secondary_mobile'];
}
function getVisitorSecondaryMobileStatus($id,$conn)
{
	$query_sel = "SELECT isSecondary FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['isSecondary'];
}
function getOwnerVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mobile FROM visitor_directory where registration_id='$id' AND degn_type='OWNER'";	
    $result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			 			
	return $row['mobile'];
}

function getVisitorPhoto($id,$conn)
{
	$query_sel = "SELECT photo FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['photo'];
}

function getINTLVisitorPhoto($id,$conn)
{
	$query_sel = "SELECT photograph_fid FROM ivr_registration_details where eid='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['photograph_fid'];
}

function getAgencyVisitorPhoto($id,$conn)
{
	$query_sel = "SELECT photo FROM visitor_agency_registration where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['photo'];
}

function getVisitorDesignationType($id,$conn)
{
	$query_sel = "SELECT degn_type FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['degn_type'];
}

function getaddresstype($id,$conn)
{
	$query_sel = "SELECT type_of_comaddress_name FROM type_of_comaddress_master where id='$id' AND address_identity='CTC'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['type_of_comaddress_name'];
}
/*
function get_data($message,$number) {
	$message=str_replace(" ","%20",$message);
	//$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$number;
	$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/smsapi?action=send&Message='.$message.'&Phone='.$number.'&SenderID=GJEPCI';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;	
} */

/* Annu SMS API*/
function send_sms($message,$mobile_no) {
	$message=str_replace(" ","%20",$message);
	$url = 'http://sms.gjepc.org/submitsms.jsp?user=TheGem&key=f2474d18afXX&mobile='.$mobile_no.'&message='.$message.'&senderid=GJECPT&accusage=1';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/* For Multi Tab Regsitration */
function uploadRegistrationPan($file_name,$file_temp,$file_type,$file_size,$company_pan_no)
{
	$upload_image = '';
	$target_folder = 'images/pan_no_copy/';
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG") || ($file_type == "application/PDF")) && $file_size < 5242880)
		{
			$random_name = rand();
			$target_path = $target_folder.$company_pan_no.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $company_pan_no.'_'.$random_name.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "invalidfile";
		}
	}	
	return $upload_image;
}

function uploadRegistrationGst_copy($file_name,$file_temp,$file_type,$file_size,$gst_copy)
{
	$upload_image = '';
	$target_folder = 'images/gst_copy/';
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG") || ($file_type == "application/PDF")) && $file_size < 5242880)
		{
			$random_name = rand();
			$target_path = $target_folder.$gst_copy.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $gst_copy.'_'.$random_name.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "invalidfile";
		}
	}	
	return $upload_image;
}

/* Upload GST with Address Registration Step 2 */
function uploadRegisAddressGST($file_name,$file_temp,$file_type,$file_size,$gst_number)
{
	$upload_image = '';
	$target_folder = 'images/address_gst_copy/'.$_SESSION['regis_id'].'/';
	$target_path = "";
	$user_id = $_SESSION['regis_id'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$random_name = rand();
			$target_path = $target_folder.$user_id.'_'.$gst_number.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $user_id.'_'.$gst_number.'_'.$random_name.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "invalidfile";
		}	
	}	
	return $upload_image;
}

function uploadSingleVIsitor($file_name,$file_temp,$file_type,$file_size,$id,$name)
{
	$upload_image = '';
	$target_folder = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['registration_id'];
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") ) && $file_size < 5242880)
		{
			$random_name = rand();
			$target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			//if(@move_uploaded_file($file_temp, $target_path))
			$compressedImage = compressImage($file_temp, $target_path, 75); 
			if($compressedImage)
			{
				  $upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	return $upload_image;
}

function uploadSingleVIsitorCovid($file_name,$file_temp,$file_type,$file_size,$mobile,$name,$certificate)
{

	$upload_image = '';
	$target_folder = 'images/covid/vis/'.$_SESSION['registration_id'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['registration_id'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$random_name = rand();
			 $target_path = $target_folder.$certificate.'_'.$mobile."_".$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $certificate."_".$mobile."_".$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	
	return $upload_image;
}

function uploadBulkVIsitorCovid($file_name,$file_temp,$file_type,$file_size,$mobile,$name,$certificate)
{
	$upload_image = '';
	$target_folder = 'images/covid/vis/'.$_SESSION['USERID'].'/'.$name.'/';
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG") || ($file_type == "application/PDF")) && $file_size < 2097152)
		{
			$random_name = rand();
			 $target_path = $target_folder.$certificate.'_'.$mobile."_".$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $certificate."_".$mobile."_".$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	return $upload_image;
}

function uploadBulk_INTLVIsitorCovid($file_name,$file_temp,$file_type,$file_size,$eid,$name)
{
	$upload_image = '';
	$target_folder = 'images/covid/intl/'.$_SESSION['USERID'].'/'.$name.'/';
	$target_path = "";
	$user_id = $_SESSION['USERID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG") || ($file_type == "application/PDF")) && $file_size < 2097152)
		{
			$random_name = rand();
			$target_path = $target_folder.$user_id.'_'.$eid.'_'.$name.'_'.$random_name.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $user_id.'_'.$eid.'_'.$name.'_'.$random_name.$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	return $upload_image;
}

function uploadAgencyVisitor($file_name,$file_temp,$file_type,$file_size,$mobile_no,$name)
{
	$upload_image = '';
	$target_folder = 'images/agency_directory/'.$_SESSION['AGENCYID'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['AGENCYID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") ) && $file_size < 2097152)
		{
			$random_name = rand();
			 $target_path = $target_folder.$mobile_no."_".$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $mobile_no.'_'.$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	
	return $upload_image;
}
function uploadCovidAgencyVisitor($file_name,$file_temp,$file_type,$file_size,$mobile_no,$name)
{
	$upload_image = '';
	$target_folder = 'images/covid/contr/'.$_SESSION['AGENCYID'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['AGENCYID'];
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$random_name = rand();
			 $target_path = $target_folder.$mobile_no."_".$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				  $upload_image = $mobile_no.'_'.$file_name;
			}
			else
			{
				 $upload_image = "fail";
			}
		}
		else
		{
			 $upload_image = "invalid";
		}	
	}
	
	return $upload_image;
}

function uploadSingleVIsitorInsert($file_name,$file_temp,$file_type,$file_size,$id,$name)
{
	$upload_image = '';
	$target_folder = 'images/employee_directory/'.$_SESSION['registration_id'].'/'.$name.'/';
	//$filename="images/employee_directory/".$_SESSION['USERID'];
	$target_path = "";
	$user_id = $_SESSION['registration_id'];
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
    echo "Sorry something error while uploading..."; exit;
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/JPG") || ($file_type == "image/JPEG") || ($file_type == "image/PNG")) && $file_size < 5242880)
		{
			$random_name = rand();
			 $target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
		//	if(@move_uploaded_file($file_temp, $target_path))
			$compressedImage = compressImage($file_temp, $target_path, 75); 
			if($compressedImage)
			{
				  $upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
			}
			else
			{
				 $upload_image = "fail";//echo "Sorry error while uploading";
			}
		}
		else
		{
			$upload_image =  "invalid";
		}	
	}
	return $upload_image;
}

function send_mail($to, $subject, $message,$cc="")
{
	/*Start Config*/
	$account="noreply@gjepcindia.com";
	$password="Kweb$$911%";
	$from="noreply@gjepcindia.com";
	//$from_name="gjepc.org";
	$from_name="GJEPC INDIA";

    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	//$mail->Host = "smtp.live.com";
	$mail->Host = "smtp.office365.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->addAddress($to);
	if($cc!=''){ 
		foreach( explode(",", $cc) as $singlecc){
			$mail->AddCC($singlecc);
		}
	} 	
	if(!$mail->send()){
	 //return false;
	} else {
	 //return true;
	}
}

function send_mailArray($to, $subject, $message,$cc="")
{ 
	/*Start Config*/
	//$account="donotreply@gjepcindia.com";
	$account="noreply@gjepcindia.com";
	$password="Kweb$$911%";
	$from="noreply@gjepcindia.com";
	$from_name="GJEPC INDIA";
	// $cc="";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	//$mail->Host = "smtp.live.com";
	$mail->Host = "smtp.office365.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	foreach($to as $email_to){ $mail->addAddress($email_to); }
	if($cc!=''){ 
		foreach( explode(",", $cc) as $singlecc){
			$mail->AddCC($singlecc);
		}
	}  	
	if(!$mail->send()){
	 //return false;
	} else {
	 //return true;
	}
}


function ninjaxMailCheck($email){
   if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mailParts = explode('@', $email);
     
    if(checkdnsrr(array_pop($mailParts), 'MX')){ return true;}
        else{return false;}
    }
   else{return false;}    
}

function getVisitorOrderNO($id,$conn)
{
	$query_sel = "SELECT orderId FROM visitor_order_history where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['orderId'];
}

function getCompanyEmail($id,$conn)
{
    $query_sel = "SELECT email_id FROM registration_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['email_id'];
}
function getEventSlotDate($id,$conn)
{
    $query_sel = "SELECT `date` FROM visitor_event_date_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['date'];
}


function sendOPTIN($visitorMobiles)
{
	$visitorMobiles = trim($visitorMobiles);
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$visitorMobiles;
	$url.="&v=1.1&auth_scheme=plain&channel=WHATSAPP";
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

function visitor_covid_payment_success($visitorMobiles,$orderId)
{ 
	$visitorMobiles = trim($visitorMobiles);
	$orderId = trim($orderId);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$visitorMobiles."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Thank%20you%20for%20registration%20at%20IIJS%20SIGNATURE%202021.%20Your%20Unique%20ID%20number%20is%20".$orderId.".%20Please%20make%20sure%20to%20do%20your%20RT%20PCR%20Covid-19%20test%2072%20hours%20before%20the%20show%20visit.%20Please%20download%20GJEPC%20App%20to%20get%20the%20E-Badge%20of%20the%20show.%20Your%20E%20Badge%20will%20get%20activated%20Only%20after%20successful%20submission%20of%20the%20negative%20report.";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
		 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

function getCovidStatus($reg_id,$vis_id,$type,$conn){
	$query_sel = "SELECT approval_status FROM visitor_lab_info where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `category_for`='$type' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['approval_status'];
}
function getCovidDose($reg_id,$vis_id,$type,$conn){
	$query_sel = "SELECT dose2_status FROM visitor_lab_info where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `category_for`='$type' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['dose2_status'];
}
function getVendorStatusFromGlobal($reg_id,$vis_id,$event,$type,$conn){
	$query_sel = "SELECT status FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='$type' AND event='$event' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['status'];
}
function getVendorCategoryStatusFromGlobal($reg_id,$vis_id,$event,$type,$conn){
	$query_sel = "SELECT agency_category FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='$type' AND event='$event' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['agency_category'];
}
function getVisitorAgencyCategory($id,$conn)
{
	$query_sel = "SELECT short_name FROM  visitor_vendor_category  where id='$id' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['short_name'];
}
function getVisitorAgencyCategoryName($id,$conn)
{
	$query_sel = "SELECT cat_name FROM  visitor_vendor_category  where id='$id' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['cat_name'];
}

function getVisitorSelectedShow($id,$conn)
{
	$query_sel = "select payment_made_for from visitor_order_history where visitor_id='$id' and `show`='signature22'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['payment_made_for'];
}

function getVisitorSelectedMultipleShow($id,$conn)
{
	$query_sel = "select payment_made_for from visitor_order_history where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['payment_made_for'];
}


function getExhEventDescription($event_values,$conn)
{
	$query_sel = "select eventDescription from exh_event_master where event_values='$event_values'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['eventDescription'];
}

function getExhEventDescriptionEvent($event,$conn)
{
	$query_sel = "select eventDescription from exh_event_master where event='$event'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['eventDescription'];
}

function getExhYear($event_values,$conn)
{
	$query_sel = "select year from exh_event_master where event_values='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['year'];
}

function getExhYearEvent($event,$conn)
{
	$query_sel = "select year from exh_event_master where event='$event'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['year'];
}

function getEvent_selected($event,$conn)
{
	$query_sel = "select event_values from exh_event_master where event='$event'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['event_values'];
}

function getExhStatus($event_values,$conn)
{
	$query_sel = "select status from exh_event_master where event_values='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['status'];
}

function getExhRoi_status($event_values,$conn)
{
	$query_sel = "select roi_status from exh_event_master where event_values='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['roi_status'];
}
function getExhRoi_desc($event_values,$conn)
{
	$query_sel = "select eventDescription from exh_event_master where event_values='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['eventDescription'];
}
function getVisEventYear($event_values,$conn){
	$query_sel = "select `year` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['year'];
}
function getVisEventName($event_values,$conn){
	$query_sel = "select `event_name` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['event_name'];
}
function getVisOrderPrefix($event_values,$conn){
	$query_sel = "select `order_prefix` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['order_prefix'];
}
function checkVisEventIsFree($event_values,$conn){
	$query_sel = "select `isFree` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['isFree'];
}
function getVisitorHotelQuota($registration_id,$conn){
	$query_sel = "select `quota` from registration_master where id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['quota'];
}
function getTermsandCondition($event_values,$conn){
	$query_sel = "select `term_condition_file` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['term_condition_file'];
}
function gstInAdvanceApi($gst_no){
	$fieldsArr = '{
				"data": 
				{
				"business_gstin_number": "'.$gst_no.'",
				"consent": "Y",
				"consent_text": "Approve the values here"
				}
				}';
			
	$headers = array(
			    "auth: false",
	            "app-id: 61dd9a0d1acfae001ddde527",
				"api-key: F69KN53-A384XAC-KHX20F5-D4AF852",
	            "Content-Type: application/json"
	);
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://test.zoop.one/api/v1/in/merchant/gstin/advance',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => $fieldsArr,
	  CURLOPT_HTTPHEADER => $headers,
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response;
}
function panInAdvanceApi($pan_no){

$fieldsArr = '{
			"data": 
			{
			"customer_pan_number": "'.$pan_no.'",
			"consent": "Y",
			"consent_text": "Approve the values here"
			}
			}';
		
$headers = array(
		    "auth: false",
            "app-id: 61dd9a0d1acfae001ddde527",
			"api-key: F69KN53-A384XAC-KHX20F5-D4AF852",
            "Content-Type: application/json"
        );
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test.zoop.one/api/v1/in/identity/pan/advance',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $fieldsArr,
  CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}

function checkEventPayment($visitor_id,$registration_id,$payment_made_for,$conn){
   $sqlHistory = "SELECT * FROM visitor_order_history WHERE visitor_id='$visitor_id' AND registration_id='$registration_id' and payment_made_for='$payment_made_for' and payment_status='Y'";
   $resultHistory = $conn->query($sqlHistory);
   $countHistory = $resultHistory->num_rows;
   if($countHistory > 0){
      return true;
   }else{
   	return false;
   }
}

function getAgencyCat($agency_id,$conn)
{
	$query_sel = "SELECT category FROM  visitor_agency_master  where id='$agency_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['category'];
}
function getAgencyName($registration_id,$conn)
{
	$query_sel = "SELECT agency_name FROM  visitor_agency_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['agency_name'];
}

function getVendorUniqueIdFromGlobal($reg_id,$vis_id,$event,$type,$conn){
	$query_sel = "SELECT uniqueIdentifier FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='$type' AND event='$event' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['uniqueIdentifier'];
}
function getVendorCategoryUniqueStatusFromGlobal($reg_id,$vis_id,$event,$type,$conn){
	$query_sel = "SELECT status,uniqueIdentifier,agency_category FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='$type' AND event='$event' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row;
}
?>