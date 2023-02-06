<?php 
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

$hostname = "localhost";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

$dbconn = @mysql_connect($hostname,$uname,$pwd);
@mysql_select_db($database);

$query=mysql_query("SELECT * FROM  `visitor_history_dump_free` WHERE 1");
while($rowx = mysql_fetch_array($query))
{
//	echo '<pre>';	print_r($rowx); echo '<br/>';
	$getVisitorId = $rowx['visitor_id'];
	$rowx = "SELECT * FROM  visitor_order_history WHERE visitor_id='$getVisitorId'";
	$result = mysql_query($rowx);
	$countx = mysql_num_rows($result);

	if($countx > 0) 
	{
		echo 'Found'; echo '<br/>';
		while($rowx1 = mysql_fetch_array($result))
		{
			echo $getVisitorId.'</br>';
			/* 
			Y -> Downloaded
			N -> Ready to Download
			*/
			//$update = mysql_query("UPDATE visitor_order_history SET downlaod_status='N' WHERE visitor_id ='$getVisitorId' ");
			if($update){
				echo $getVisitorId . '---- Status Updated'.'</br>';

			}else{
               echo $getVisitorId . '---- Status Not Updated'.'</br>';
			}
		}
		
	} else {
	echo $getVisitorId.'Not Found'; echo '<br/>';
	}
}
?>