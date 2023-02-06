<?php 
include('header_include.php');

?>
<?php 
   $exh_list_sql =  "SELECT * FROM `iijs_badge_items` WHERE 1 limit  7000,1000";
   $exh_list_result = $conn->query($exh_list_sql);
   $i=1;
    while($exh_list_row = $exh_list_result->fetch_assoc()){
	$Badge_Item_ID=$exh_list_row['Badge_Item_ID'];
	$Exhibitor_Code=$exh_list_row['Exhibitor_Code'];
	$name = strtoupper(getKeyName($Badge_Item_ID,$conn));
	$mobile = getKeyMobile($Badge_Item_ID,$conn);
	$designation = strtoupper(getKeyDesignation($Badge_Item_ID,$conn));
	$Badge_Photo = getKeyPhoto($Badge_Item_ID,$conn);
	$company = getExhibitorName($Exhibitor_Code,$conn);
	$registration_id = getExhibitorID($Exhibitor_Code,$conn);

	$photo_url = "https://registration.gjepc.org/manual_iijs/images/badges/".$Exhibitor_Code."/".$Badge_Photo;

	$digits = 9;	
	$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
	
	while($countUniqueIdentifier > 0) {
	$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	} 

	$check = "SELECT * FROM gjepclivedatabase.globalExhibition where visitor_id='$Badge_Item_ID' AND participant_Type='EXH'";
	$getResult = $conn ->query($check);
	$countx = $getResult->num_rows;
	/*if($countx>0){
	echo $global = "UPDATE gjepclivedatabase.globalExhibition SET registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',designation='$designation',company='$company',photo_url='$photo_url',days_allow='all',mobile='$mobile' where visitor_id='$Badge_Item_ID' AND participant_Type='EXH'";
	echo "<br/>";
	$globalQuery = $conn ->query($global);
	if(!$globalQuery) die ($conn->error);
	} else { 
	echo $global = "INSERT INTO gjepclivedatabase.globalExhibition SET `uniqueIdentifier`='$uniqueIdentifier',registration_id='$registration_id',visitor_id='$Badge_Item_ID',fname='$name',mobile='$mobile',designation='$designation',company='$company',photo_url='$photo_url',participant_Type='EXH',days_allow='all'";
	$globalQuery = $conn ->query($global);
	if(!$globalQuery) die ($conn->error);*/
	echo "<br/>";
	}
	$i++;
  }
  echo $i."<br/>";
?>