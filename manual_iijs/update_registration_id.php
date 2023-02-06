<?php 
include('../db.inc.php');

$sql = "select a.id, a.gcode from kweb_demo.registration_master a, kweb_signature_manual.iijs_exhibitor b where b.Customer_No = a.gcode";
//$sql = "update kweb_signature_manual.iijs_exhibitor set Exhibitor_Registration_ID='' where Customer_No=''";

$result = mysql_query($sql);
//echo mysql_num_rows($result);
$i=0;
while($data = mysql_fetch_array($result))
{
	//echo $data['id']."<br>";
	$update = "update kweb_signature_manual.iijs_exhibitor set Exhibitor_Registration_ID=".$data['id']." where Customer_No='".$data['gcode']."'";
	mysql_query($update);
	$i++;
	
}
echo $i;
?>