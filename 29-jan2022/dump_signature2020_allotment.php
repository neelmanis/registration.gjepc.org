<?php 
session_start(); ob_start();
include ("db.inc.php");

$last_year = "SELECT * FROM signature_last_year_allotment ";

$result_last_year = $conn->query($last_year);

$row = $result_last_year->fetch_assoc();
while ($row = $result_last_year->fetch_assoc()) {
	 $sql = "UPDATE exh_registration SET last_yr_section_flag='1' WHERE gid='".$row['gid']."' AND uid='".$row['uid']."' AND `show`='IIJS Signature 2020'";
	//$result = $conn->query($sql);
	if($result){
		echo "Success".$row['gid']."<br>";
	}
}

?>