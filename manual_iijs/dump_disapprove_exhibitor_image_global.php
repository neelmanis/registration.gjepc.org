<?php
include('db.inc.php');

$checkHistory = "SELECT * FROM manual_iijs2021.iijs_badge_items where 1"; 
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		//echo '<pre>'; print_r($resultHistory);
		$Exhibitor_Code =  $resultHistory['Exhibitor_Code'];
		$registration_id = $resultHistory['registration_id'];
		$photo = basename($resultHistory['Badge_Photo']);
		$Badge_Name = $resultHistory['Badge_Name'];
		$Badge_Mobile = $resultHistory['Badge_Mobile'];
		$Badge_Item_ID = $resultHistory['Badge_Item_ID'];
		
		$src = 'images/badges/'.$Exhibitor_Code.'/'.$photo;
		$imagesize = filesize($src);
		  if($imagesize < 1024){
			echo $Badge_Item_ID."==".$Badge_Mobile."==".$Exhibitor_Code;echo "<br/><br/>";
		}
	}

}
/*
$table .= $display;
$table .= '</table>';

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fn.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $table;
*/
?>