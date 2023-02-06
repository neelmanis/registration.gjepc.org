<?php
include('header_include.php');

/*......................................... Get visitor show which is selected 3 & 6 show ..............................................*/

$checkHistory = "SELECT * FROM globalExhibition_migration where  isMigrated='N' and  dose2_status='Y' "; 
$resultQuery = $conn ->query($checkHistory);
$num = $resultQuery->num_rows;

if($num>0)
{
	while($resultHistory = $resultQuery->fetch_assoc())
	{
		  $id = $resultHistory['id'];
	       $query  =    "UPDATE globalExhibition SET `status` = 'Y'  WHERE id='".$resultHistory['id']."' AND `status` = 'P'";
	      $result = $conn ->query($query);
	      if ($result) {
	      	$conn ->query("UPDATE globalExhibition_migration SET isMigrated='Y' WHERE id='".$resultHistory['id']."' ");
	      	echo $id." -  Succeess";echo "<br>";
	      }else {
	      	echo $id.' - Entry not found';echo "<br>";
	      }
	} 
			
}

?>