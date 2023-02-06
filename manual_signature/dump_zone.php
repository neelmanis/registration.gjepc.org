<?php
include('db.inc.php');

$checkHistory = "SELECT * FROM manual_signature.zone_details;"; 
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

    $checkHistorys = "UPDATE manual_signature.iijs_exhibitor SET vendor='$vendor' WHERE Exhibitor_Code='$exhibitor_code'"; 
    //$checkHistorys = "UPDATE manual_signature.iijs_exhibitor SET `Exhibitor_DivisionNo`='$zone',Exhibitor_HallNo='$hall',vendor='$vendor' WHERE Exhibitor_Code='$exhibitor_code'";
        echo '<br/>';
	$result = $conn->query($checkHistorys);
	}
}
?>