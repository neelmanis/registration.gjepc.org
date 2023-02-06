<?php include('header_include.php');?>
<?php
$sqlx = "select * from exh_discount_dump_data";
$query= $conn ->query($sqlx);
while($row = $query->fetch_assoc())
{ 	//echo '<pre>'; print_r($row); exit;

	$uid=$row['uid'];
	$gid=$row['gid'];
	$discount=$row['discount'];
	
	$rowx = "SELECT * FROM exh_registration WHERE uid='$uid' and gid='$gid' and `show`='IIJS 2020'";
	$result = $conn ->query($rowx);
	$countx = $result->num_rows;
	if($countx > 0) 
	{
	echo $querxy = "update exh_registration set discount='$discount' where uid='$uid' AND gid='$gid' AND `show`='IIJS 2020'"; 
	echo '<br/>';
	//$result = $conn ->query($querxy);
	} else {
		
	//echo $smx ="INSERT INTO `exh_registration`(`uid`,`roi`, `last_yr_participant`, `category`,`section`, `selected_area`, `selected_scheme_type`,`selected_premium_type`,`last_yr_section_flag`, `show`,`event_selected`,`curr_last_yr_check`) VALUES ('$uid','YES','$last_year_participant','$category','$section','$area','$scheme','$selected_premium_type','$last_yr_section_flag','IIJS 2020','iijs','N')";
	//$getResult = $conn ->query($smx);	
	}
}
?>