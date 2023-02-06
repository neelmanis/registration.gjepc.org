<?php
include('db.inc.php');

$hotel_id = filter($_REQUEST['hotel_id']);
$status = filter($_REQUEST['status']);

if(!empty($hotel_id) && isset($status))
{
	$query_sel = "UPDATE `iijs_hotel_master` SET `status`='$status' WHERE hotel_id='$hotel_id' ";
//	$result_sel = mysql_query($query_sel);
	if($result_sel){ echo 'Hotel Status Changed'; } 
}

//https://iijs.org/update_hotel_status.php?hotel_id=1&status=1
?>