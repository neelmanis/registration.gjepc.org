<?php 
session_start();
include ("db.inc.php");
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState"){
$country=$_POST['country'];
$query=$conn->query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){
?>
	  <select name="applicant_state" id="applicant_state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
<?php } else {?>
<input type="text" class="textField" id="applicant_state" name="applicant_state" />
<?php }?>
<?php }?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRoom"){
$hotel_id=$_POST['hotel_id'];
$query=$conn->query("SELECT * from vis_hotel_details WHERE hotel_id = '$hotel_id'");
?>
	  <select name="hotel_details_id" id="hotel_details_id" class="textField">
      <option value="">--Select Room Type--</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo $result['hotel_details_id'];?>"><?php echo $result['room_name'];?></option>
      <?php }?>
      </select>
<?php }?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRate"){
$hotel_details_id=$_POST['hotel_details_id'];
$query=mysql_query("SELECT * from iijs_hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
echo "Rs. ".$result['rate']." /-";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getoutDate"){
$ck_in_dd = $_POST['ck_in_dd'];
$Company_Type = $_POST['Company_Type'];
$j = $ck_in_dd+1;

for($i=$j,$k=1;$i<23;$i++,$k++){ 

if($Company_Type=="Unique")
	$limit=1;
else
	$limit=2;

if($k<=$limit){ ?>
	<option value="<?php echo $i;?>"><?php if($i==23){ echo '01'; } else { echo $i;}?></option>
<?php
}} }
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getAvaibility"){
$getDate = '2022-02-'.$_POST['ck_in_dd'];
$hotel_id = $_POST['hotel_id'];
//echo "SELECT * from vis_hotel_details WHERE hotel_id = '$hotel_id' AND date='$getDate'";
$query1 = $conn->query("SELECT * from vis_hotel_details WHERE hotel_id = '$hotel_id' AND date='$getDate'");
$results = $query1->fetch_assoc();
$qty = $results['qty'];
if($qty>0)
{
	echo 1; // Available
} else {
	echo 0; // Not Available
}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$ck_in_dd=$_POST['ck_in_dd'];
$ck_out_dd=$_POST['ck_out_dd'];
$hotel_details_id=$_POST['hotel_details_id'];
$no_of_room=$_POST['no_of_room'];
$caldate=$_POST['diffDays'];
$query=mysql_query("SELECT * from iijs_hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
$rate=$result['rate'];
echo $total_price=($caldate*$rate*$no_of_room);
}
?>

<?php 
/*if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$selected_premium_type=$_POST['selected_premium_type'];
if($selected_premium_type=="Corner")
{
	$selected_premium_type=10;
}
else if($selected_premium_type=="Island")
{
	$selected_premium_type=15;
}
else if($selected_premium_type=="Premium")
{
	$selected_premium_type=20;
}
else if($selected_premium_type=="Mezzanine")
{
	$selected_premium_type=50;
}
if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
{
	$charge=17000;
}
else
{
	$charge=550;
}
$space_rate=intval($selected_area*$charge);
echo $space_rate1=intval($selected_area*$charge)."#";
$scheme_rate=intval($selected_area*$selected_scheme_type);

echo $scheme_rate1=$scheme_rate."#";
$premium_rate=($scheme_rate*$selected_premium_type)/100;

echo $premium_rate1=$premium_rate."#";

$sub_total_cost=$space_rate+$scheme_rate+$premium_rate;
echo $sub_total_cost1=($space_rate+$scheme_rate+$premium_rate)."#";

$security_deposit=($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=($sub_total_cost*12.36)/100;
echo $govt_service_tax1=$govt_service_tax."#";

echo $grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
}
*/
?>
