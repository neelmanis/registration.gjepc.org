<?php 
session_start();
include ("db.inc.php");
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
// print_r($_POST);	
$member_type=$_SESSION['member_type'];
$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	

$selected_area = $_POST['selected_area'];
$section = $_POST['section'];
$rate = 18000;
echo $rate = $rate."#"; 
echo $tot_space_cost_rate=$selected_area*$rate."#";
$security_deposit = round(floatval($tot_space_cost_rate*10)/100);
echo $security_deposit1 = floatval($security_deposit)."#";
echo $govt_service_tax=($tot_space_cost_rate*18/100)."#";
echo $grand_total=$security_deposit1+$tot_space_cost_rate+$govt_service_tax."#";

}
?>
