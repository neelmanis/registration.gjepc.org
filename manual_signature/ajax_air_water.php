<?php 
include ("db.inc.php");
if(isset($_POST["id"]))
{
	$id = intval($_POST["id"]);

	$sql = "select * from igjme_air_water_item_master where ai_item_id=$id";
	$exe = $conn ->query($sql);
	
	$data = $exe->fetch_assoc();
	echo $rate_after_deadline = $data["rate_after_deadline"];
	
	//$send_data = array("rate_after_deadline"=>$rate_after_deadline);
	//echo json_encode($send_data);
	exit;
}
/*$additional = intval($_POST["additional"]);
$tot_amount = ($additional / 100)*1000;
$tot_amount = round($tot_amount);

$tax = ($tot_amount)*(12.36/100);
$tax = round($tax);

$payable = $tot_amount + $tax;

//echo $tot_amount;
$send_data = array("tot_amount"=>$tot_amount,"tax"=>$tax,"payable"=>$payable);
echo json_encode($send_data);
*/

?>