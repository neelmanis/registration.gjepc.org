<?php
include('db.inc.php');

$checkHistory = "SELECT * FROM manual_iijs2021.zone_details;"; 
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		//echo '<pre>'; print_r($resultHistory);
		$exhibitor_code =  $resultHistory['exhibitor_code'];
		$zone = $resultHistory['zone'];
		$hall = $resultHistory['hall'];
		$vendor = $resultHistory['vendor'];
	echo $checkHistorys = "UPDATE manual_iijs2021.iijs_safe_rental SET Info_Approved='Y',Items_Reason='0' WHERE Exhibitor_Code='$exhibitor_code'";
	//$result = $conn->query($checkHistorys);
	
    //$checkHistorys = "UPDATE manual_iijs2021.iijs_exhibitor SET Exhibitor_DivisionNo='$zone',Exhibitor_HallNo='$hall',vendor='$vendor' WHERE Exhibitor_Code='$exhibitor_code'";
    //$checkHistorys = "UPDATE manual_signature.iijs_exhibitor SET `Exhibitor_DivisionNo`='$zone',Exhibitor_HallNo='$hall',vendor='$vendor' WHERE Exhibitor_Code='$exhibitor_code'";
        echo '<br/>';
	//$result = $conn->query($checkHistorys);
	}
}
?>