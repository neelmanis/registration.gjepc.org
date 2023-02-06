<?php
include('header_include.php');

function getFormDeadLinesss($id,$conn)
{
	 $query_sel = "SELECT Dedline_Date FROM `iijs_form_details` WHERE Form_No='$id' limit 1";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())			 	
	{ 		
		return $row['Dedline_Date'];
	}
}

$cr_date = date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$formDeadLine = strtotime(getFormDeadLinesss(6,$conn));
if($current_time <= $formDeadLine) { echo 'Open'; } else { echo 'closed'; }


/*
$cr_dates = date('d-m-Y H:i:s');
$current_time = strtotime($cr_dates);

$closetime = strtotime("05-12-2022 23:55:00");
if($current_time <= $closetime) { echo 'open'; } else { echo 'closed'; }

2022-12-09 23:59:59
*/
?>