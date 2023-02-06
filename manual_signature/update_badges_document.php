<?php
include('header_include.php');

$query=mysql_query("SELECT * FROM  `iijs_badge_items` WHERE  `Badge_Document` IS NULL");
while($result=mysql_fetch_array($query))
{
	$Badge_ID=$result['Badge_ID'];
	$Badge_Item_ID=$result['Badge_Item_ID'];
	$Badge_Type=$result['Badge_Type'];
	$Exhibitor_Code=$result['Exhibitor_Code'];
	$Badge_Name=$result['Badge_Name'];
	$Badge_Photo=$result['Badge_Photo'];
	
	$Exhibitor_Name=getExhibitorName($Exhibitor_Code,$conn);
	$Badge_Document=$Badge_Type."_".$Exhibitor_Name."_".$Badge_Name;

	$directory = "images/badges/".$Exhibitor_Code;
	$images = glob($directory . "/*");
	
	foreach($images as $image)
	{
		if(preg_match('/'.$Badge_Document.'/',$image)){
			$img_name=explode("/", $image);
			$img_actual_name=end($img_name);
			echo "update `iijs_badge_items` set Badge_Document='$img_actual_name' WHERE  Exhibitor_Code='$Exhibitor_Code' and Badge_Item_ID='$Badge_Item_ID'";echo "<br/>";
		//mysql_query("update `iijs_badge_items` set Badge_Document='$img_actual_name' WHERE  Exhibitor_Code='$Exhibitor_Code' and Badge_Item_ID='$Badge_Item_ID'");
		}	
		
	}
}		
?>
