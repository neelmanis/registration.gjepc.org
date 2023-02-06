<?php include('db.inc.php');

$sqlx = "select * from manual_iijs2021.exh_dump_details";
$query= $conn ->query($sqlx);
while($row = $query->fetch_assoc())
{ 	//echo '<pre>'; print_r($row); exit;
	
	$uid = $row['uid'];
	$hall= $row['hall'];
	$zone= $row['zone'];
	
	$Exhibitor_StallNo1 = $row['1'];
	$Exhibitor_StallNo2 = $row['2'];
	$Exhibitor_StallNo3 = $row['3'];
	$Exhibitor_StallNo4 = $row['4'];	
	$Exhibitor_StallNo5 = $row['5'];
	$Exhibitor_StallNo6 = $row['6'];
	$Exhibitor_StallNo7 = $row['7'];
	$Exhibitor_StallNo8 = $row['8'];
	$Exhibitor_StallNo9 = $row['9'];
	$Exhibitor_StallNo10 = $row['10'];
	$Exhibitor_StallNo11 = $row['11'];
	$Exhibitor_StallNo12 = $row['12'];
	
	$rowx = "SELECT * FROM manual_iijs2021.iijs_exhibitor WHERE Exhibitor_Registration_ID='$uid'";
	$result = $conn ->query($rowx);
	$countx = $result->num_rows;
	/*
	if($countx > 0) 
	{
	echo $querxy = "UPDATE `manual_iijs2021`.`iijs_exhibitor` SET Exhibitor_HallNo='$hall',Exhibitor_DivisionNo='$zone', 
	`Exhibitor_StallNo1` = '$Exhibitor_StallNo1', `Exhibitor_StallNo2` = '$Exhibitor_StallNo2',`Exhibitor_StallNo3` = '$Exhibitor_StallNo3', `Exhibitor_StallNo4` = '$Exhibitor_StallNo4',`Exhibitor_StallNo5` = '$Exhibitor_StallNo5',`Exhibitor_StallNo6` = '$Exhibitor_StallNo6',`Exhibitor_StallNo7` = '$Exhibitor_StallNo7',`Exhibitor_StallNo8` = '$Exhibitor_StallNo8',`Exhibitor_StallNo9` = '$Exhibitor_StallNo9',`Exhibitor_StallNo10` = '$Exhibitor_StallNo10',`Exhibitor_StallNo11` = '$Exhibitor_StallNo11',`Exhibitor_StallNo12` = '$Exhibitor_StallNo12' WHERE `Exhibitor_Registration_ID` = '$uid'"; 
	
	//echo $querxy = "UPDATE `manual_iijs2021`.`iijs_exhibitor` SET Exhibitor_DivisionNo='$hall' WHERE `Exhibitor_Registration_ID` = '$uid'";
	echo '<br/>';
	$result = $conn ->query($querxy);
	} else {
	echo 'Not Found';
	}*/
}
?>