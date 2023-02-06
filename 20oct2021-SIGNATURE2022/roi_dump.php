<?php include('header_include.php');?>
<?php
/*
$sqlx = "select * from roi_dump_data";
$query= $conn ->query($sqlx);
while($row = $query->fetch_assoc())
{ 	//echo '<pre>'; print_r($row); exit;
	$last_year_participant=$row['last_yr_participant'];
	if($last_year_participant=="YES")
	{
		$last_yr_section_flag=1;
	}
	$uid=$row['uid'];
	$gid=$row['gid'];
	$section=$row['section'];
	$area=$row['selected_area'];
	$category=$row['category'];
	$selected_premium_type=$row['selected_premium_type'];	
	$scheme=$row['scheme'];	
	$discount=$row['discount'];	
	$incentive=$row['incentive'];	
	
	$rowx = "SELECT * FROM exh_registration WHERE uid='$uid' and gid='$gid' and `show`='IIJS 2020'";
	$result = $conn ->query($rowx);
	$countx = $result->num_rows;
	if($countx > 0) 
	{
	echo $querxy = "update exh_registration set roi='YES',last_yr_participant='$last_year_participant',category='$category',section='$section',selected_area='$area',selected_scheme_type='$scheme',selected_premium_type='$selected_premium_type',last_yr_section_flag='$last_yr_section_flag',curr_last_yr_check='N',discount='$discount',incentive='$incentive' where uid='$uid' AND gid='$gid' AND `show`='IIJS 2020'"; 
	echo '<br/>';
//	$result = $conn ->query($querxy);
	} else {
		
	//echo $smx ="INSERT INTO `exh_registration`(`uid`,`roi`, `last_yr_participant`, `category`,`section`, `selected_area`, `selected_scheme_type`,`selected_premium_type`,`last_yr_section_flag`, `show`,`event_selected`,`curr_last_yr_check`) VALUES ('$uid','YES','$last_year_participant','$category','$section','$area','$scheme','$selected_premium_type','$last_yr_section_flag','IIJS 2020','iijs','N')";
	//$getResult = $conn ->query($smx);	
	}
} */
/*
$sqlx = "select * from discountt";
$query= $conn ->query($sqlx);
while($row = $query->fetch_assoc())
{
	$uid = $row['uid'];
	$discount = $row['discount'];	
	
	$rowx = "SELECT * FROM exh_registration WHERE uid='$uid' and `show`='IIJS 2020'";
	$result = $conn ->query($rowx);
	$countx = $result->num_rows;
	if($countx > 0) 
	{
		echo $querxy = "update exh_registration set discount='$discount' where uid='$uid' AND `show`='IIJS 2020'"; 
		echo '<br/>';
	//	$result = $conn ->query($querxy);
	}
}*/
/*
$sqlx = "select * from dump_address";
$query= $conn ->query($sqlx);
while($row = $query->fetch_assoc())
{ 	echo '<pre>'; print_r($row);
	$registration_id = $row['registration_id'];
	$state_id = $row['state_id'];	
	$address_line1 = $row['address_line1'];	
	$address_line2 = $row['address_line2'];	
	$city = $row['city'];	
	$pin_code = $row['pin_code'];	
	
	$rowx = "SELECT * FROM registration_master WHERE id='$registration_id'";
	$result = $conn ->query($rowx);
	$countx = $result->num_rows;
	if($countx > 0) 
	{
		echo $querxy = "update registration_master set address_line1='$address_line1',address_line2='$address_line2',pin_code='$pin_code',state='$state_id',city='$city' where id='$registration_id'"; 
		echo '<br/>';
	//	$result = $conn ->query($querxy);
	}
}*/
?>