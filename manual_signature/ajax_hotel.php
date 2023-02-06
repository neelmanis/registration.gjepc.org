<?php 
include ("db.inc.php");
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id=$_POST['email_id'];
    $query=mysql_query("select * from registration_master where email_id='$email_id' and status=1");
    $num=mysql_num_rows($query);
  if($num>0)
   {	
   		echo "Already registered with this email id";
   }
}
?>


<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRoom"){
$hotel_id=$_POST['hotel_id'];
$query=mysql_query("SELECT * from hotel_details WHERE hotel_id = '$hotel_id'");
?>
	  
	  <select name="hotel_details_id" id="hotel_details_id" class="textField">
      <option value="">--Select Room Type--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['hotel_details_id'];?>"><?php echo $result['room_name'];?></option>
      <?php }?>
      </select>
	
<?php }?>


<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getRate"){
$hotel_details_id=$_POST['hotel_details_id'];
$query=mysql_query("SELECT * from hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
echo "Rs. ".$result['rate']." /-";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getoutDate"){
$ck_in_dd=$_POST['ck_in_dd'];
$j=$ck_in_dd+1;
for($i=$j;$i<11;$i++){
?>
<option value="<?php echo $i;?>"><?php echo $i;?></option>
<?php
}}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$ck_in_dd=$_POST['ck_in_dd'];
$ck_out_dd=$_POST['ck_out_dd'];
$hotel_details_id=$_POST['hotel_details_id'];
$no_of_room=$_POST['no_of_room'];
$caldate=$ck_out_dd-$ck_in_dd;
$query=mysql_query("SELECT * from hotel_details WHERE hotel_details_id = '$hotel_details_id'");
$result=mysql_fetch_array($query);
$rate=$result['rate'];
echo $total_price=($caldate*$rate*$no_of_room);
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState"){
$country=$_POST['country'];
$query=mysql_query("SELECT * from iijs_state_master WHERE country_id = '$country'");
if($country=="64"){
?>
	  <select name="applicant_state" id="applicant_state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=mysql_fetch_array($query)){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
<?php } else {?>
<input type="text" class="textField" id="applicant_state" name="applicant_state" />
<?php }?>
<?php }?>


