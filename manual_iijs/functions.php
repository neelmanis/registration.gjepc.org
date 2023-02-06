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


function getForm1Status($Exhibitor_Code)
{
	$query_sel = "SELECT country_name FROM  country_master  where country_code='$countrycode'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['country_name'];	
	}
}

function getExhibitorName($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT Exhibitor_Name FROM  iijs_exhibitor  where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel =$conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Exhibitor_Name'];
		
	}
}

function getEventDescription($conn)
{
	$query_sel = "SELECT eventDescription FROM exh_event_master where status='1'";
	$result_sel =$conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return $row['eventDescription'];
	}
}

function getSection_desc($section,$conn)
{
	$query_sel = "SELECT section_desc FROM signature_section_master where name='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['section_desc'];
}

function getSection_type($section,$conn)
{
	$query_sel = "SELECT type FROM signature_section_master where name='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['type'];
}

function getExhibitorID($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT Exhibitor_Registration_ID FROM iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Exhibitor_Registration_ID'];
	}
}

function getCountryName($country_id,$conn)
{
	$query_sel = "SELECT Country_Name FROM  iijs_country_master where country_code='$country_id'";
	$result_sel = $conn->query($query_sel);							
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Country_Name'];
	}
}

function getCountryCode($country_name,$conn)
{
	$query_sel = "SELECT country_code FROM iijs_country_master where Country_Name='$country_name'";
	$result_sel = $conn->query($query_sel);									
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['country_code'];
	}
}

function getCountryId($country_name,$conn)
{
	$query_sel = "SELECT Country_ID FROM  iijs_country_master where Country_Name='$country_name'";
	$result_sel = $conn->query($query_sel);									
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Country_ID'];
	}
}

function getStateName($id)
{
	$query_sel = "SELECT state_name FROM  state_master  where id='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['state_name'];
		
	}
}


function getCityName($id)
{
	$query_sel = "SELECT city_name FROM  city_master  where id='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['city_name'];
		
	}
}

function getUserName($id)
{
   $query_sel = "SELECT first_name,last_name FROM  registration_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 	
		$full_name=	$row['first_name'].' '.$row['last_name'];
		return $full_name;
	}
}

function getUserEmail($id)
{
	$query_sel = "SELECT email_id FROM  registration_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['email_id'];
	}
}

function getUserMobile($id)
{
	$query_sel = "SELECT mobile_no FROM  registration_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['mobile_no'];
	}
}
function getRegionName($id)
{
	$query_sel = "SELECT region_name FROM  region_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['region_name'];
	}
}

function uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,$loc)
{	
	$upload_image = '';
	$target_folder = "images/$loc/".$_SESSION['EXHIBITOR_CODE']."/";
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name)) {
	echo "Sorry something error while uploading..."; exit;
	} else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")))
		{
			if($file_size < 2097152)
			{				
				$target_path = $target_folder.$attach.'_'.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $attach.'_'.$file_name;
				}
				else
				{
					echo "Sorry error while uploading";
				}
			}
			else
			{
					echo "File should be less than 2MB";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}	
	return $upload_image;
}

function uploadImageAdmin($file_name,$file_temp,$file_type,$file_size,$attach,$loc,$exhibitor_code){
	
	$upload_image = '';
	$target_folder = "../images/$loc/$exhibitor_code/";
	$target_path = "";
	
	
	if($file_name != '')
	{
		if ((($file_type == "image/gif") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")))
		{
			if($file_size < 2097152)
			{
				$target_path = $target_folder.$attach.'_'.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $attach.'_'.$file_name;
				}
				else
				{
					echo "Sorry error while uploading";
				}
			}
			else
			{
					echo "File should be less than 2Mb";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}
	
	return $upload_image;

}


function getFloralItemName($id)
{
	$query_sel = "SELECT Floral_Items_Master_Description FROM  iijs_floral_items_master  where Floral_Items_Master_ID='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['Floral_Items_Master_Description'];
	}
}
function getPaymentStatus($id,$conn)
{
	$query_sel = "SELECT Payment_Master_Approved FROM iijs_payment_master where Payment_Master_ID='$id'";	
	$result_sel = $conn ->query($query_sel);							
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Payment_Master_Approved'];
	}
}

function getBadgeID($id,$conn)
{
	$query_sel = "SELECT Badge_ID FROM  iijs_badge  where Exhibitor_Code='$id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Badge_ID'];
	}
}

function getKeyName($id,$conn)
{
	$query_sel = "SELECT Badge_Name FROM  iijs_badge_items  where Badge_Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);									
	if($row =  $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Badge_Name'];
	}
}

function getKeyMobile($id,$conn)
{
	$query_sel = "SELECT Badge_Mobile FROM iijs_badge_items where Badge_Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);									
	if($row =  $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Badge_Mobile'];
	}
}
function getReplacementID($id,$conn)
{
	$query_sel = "SELECT Replacement_ID FROM iijs_badge_items where Badge_Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);									
	if($row =  $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Replacement_ID'];
	}
}

function getKeyDesignation($id,$conn)
{
	$query_sel = "SELECT Badge_Designation FROM  iijs_badge_items  where Badge_Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);							
	if($row =  $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Badge_Designation'];
	}
}
function getKeyPhoto($id,$conn)
{
	$query_sel = "SELECT Badge_Photo FROM  iijs_badge_items  where Badge_Item_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Badge_Photo'];
	}
}

function getFormDeadLine($id,$conn)
{
	$query_sel = "SELECT Dedline_Date FROM `iijs_form_details` WHERE `Dedline_Date` > NOW() and Form_No='$id' limit 1";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return date("d-m-Y",strtotime($row['Dedline_Date']));
	}
}

function getFormDeadLineTime($id,$conn)
{
	$query_sel = "SELECT Dedline_Date FROM `iijs_form_details` WHERE Form_No='$id' limit 1";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return date(strtotime($row['Dedline_Date']));
	}
}

function getApplicationStatus($table,$conn)
{
	$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
	
	$status="select * from $table where Exhibitor_Code='$exhibitor_code'";
	$result_status = $conn ->query($status);
	$num = $result_status->num_rows; 	
	if($num>0){
		$fetch_catalog = $result_status->fetch_assoc();
		$Application_Complete=$fetch_catalog['Application_Complete'];
		return $Application_Complete;
	} else
		return "application";
}

function getPaymentModeId($id,$conn)
{
	$query_sel = "SELECT Payment_Mode_ID  FROM  iijs_payment_master  where Payment_Master_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Payment_Mode_ID'];
	}
}

function getSaferentalId($id,$conn)
{
	$query_sel = "SELECT Safe_Description  FROM  iijs_safe_rental_master  where Safe_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Safe_Description'];
	}
}

function getElectronicItemName($id,$conn)
{
	$query_sel = "SELECT CCTV_Items_Master_Description FROM  iijs_cctv_items_master where CCTV_Items_Master_ID='$id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['CCTV_Items_Master_Description'];
	}
}

function getVenderId($Vendor_Section,$conn)	
{
	$query_sel = "SELECT Vendor_ID FROM  iijs_vendor_master  where Vendor_Section='$Vendor_Section'";	
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Vendor_ID'];
	}
}

function getItemName($id,$conn)
{
	$query_sel = "SELECT Item_Master_ID FROM  iijs_vendor_item_master  where Vendor_Iteam_Master_ID='$id'";	
	$result_sel = $conn->query($query_sel);									
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Item_Master_ID'];
	}
}

function getItemDescription($id,$conn)
{
	$query_sel = "SELECT Item_Description FROM  iijs_stand_items_master  where Item_ID='$id'";	
	$result_sel = $conn->query($query_sel);									
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['Item_Description'];
	}
}

function getExhibitorCountryID($Exhibitor_Code,$conn)
{
	$query_sel = "SELECT Exhibitor_Country_ID FROM  iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";	
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())	 	
	{ 		
		return $row['Exhibitor_Country_ID'];
	}
}

function getHotelName($hotel_id)
{
	$query_sel = "SELECT hotel_name FROM  hotel_master  where hotel_id='$hotel_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['hotel_name'];
	}
}

function getRoomType($hotel_details_id)
{
	$query_sel = "SELECT room_name FROM  hotel_details  where hotel_details_id='$hotel_details_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['room_name'];
	}
}

function getBadgeStatus($Badge_ID,$conn)
{
	$query_sel = "SELECT * FROM  iijs_badge_items  where Badge_ID='$Badge_ID' and Badge_Approved='P'";	
	$result_sel = $conn ->query($query_sel);								
	return $num_sel = $result_sel->num_rows;
}

function getBadgeDStatus($Badge_ID,$conn)
{
	$query_sel = "SELECT * FROM  iijs_badge_items  where Badge_ID='$Badge_ID' and Badge_Approved='N'";	
	$result_sel = $conn ->query($query_sel);							
	return $num_sel = $result_sel->num_rows;
}

function getWifiItemDescription($id,$conn)
{
	$query_sel = "SELECT description FROM  iijs_wifi_master  where id='$id'";	
	$result_sel = $conn ->query($query_sel);							
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return $row['description'];
	}
}
?>
