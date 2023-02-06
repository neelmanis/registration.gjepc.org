<?php
include('db.inc.php');
$checkHistory = "SELECT * FROM manual_signature.dump_exh_stall_no;"; 
$resultQuery = $conn->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		//echo '<pre>'; print_r($resultHistory);
		$exhibitor_code =  $resultHistory['exhibitor_code'];
		$stall_no1 = $resultHistory['stall_no1'];
		$stall_no2 = $resultHistory['stall_no2'];
		$stall_no3 = $resultHistory['stall_no3'];
		$stall_no4 = $resultHistory['stall_no4'];
		$stall_no5 = $resultHistory['stall_no5'];
		$stall_no6 = $resultHistory['stall_no6'];
		$premium = $resultHistory['premium'];

        $checkHistorys = "UPDATE manual_signature.iijs_exhibitor SET `Exhibitor_StallNo1`='$stall_no1',`Exhibitor_StallNo2`='$stall_no2',`Exhibitor_StallNo3`='$stall_no3',`Exhibitor_StallNo4`='$stall_no4',`Exhibitor_StallNo5`='$stall_no5',`Exhibitor_StallNo6`='$stall_no6',Exhibitor_StallType='$premium' WHERE exhibitor_code='$exhibitor_code'";
        echo '<br/>';
		$result = $conn->query($checkHistorys);
	}
}
?>