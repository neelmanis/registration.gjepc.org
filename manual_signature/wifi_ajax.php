<?php 
include ("db.inc.php");
include ("functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails")
{
    $Item_ID = trim($_POST['Item_ID']);
    $query = $conn->query("SELECT * FROM `iijs_wifi_master` WHERE id='$Item_ID'");
    $result= $query->fetch_assoc();
	echo $Item_Rate=$result['charges']."<input type='hidden' name='rate' id='rate' value='$result[charges]'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
    $Item_ID=$_POST['Item_ID'];
	$rate=$_POST['rate'];
	$Item_Quantity=$_POST['Item_Quantity'];

   $query = $conn->query("insert into iijs_wifi_items_tmp set Exhibitor_Code='$exhibitor_code',WirelessInternet_Items_Master_Id='$Item_ID',WirelessInternet_Items_Rate='$rate', WirelessInternet_Items_Quantity='$Item_Quantity', Create_Date=NOW()");
	
	$query1 =$conn ->query("select * from iijs_wifi_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['WirelessInternet_Items_Rate']*$result1['WirelessInternet_Items_Quantity'];
	?>
    <tr>
      <td><?php echo getWifiItemDescription($result1['WirelessInternet_Items_Master_Id'],$conn);?></td>
      <td><?php echo $result1['WirelessInternet_Items_Rate']?></td>
	  <td><?php echo $tot;?></td>      
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['WirelessInternet_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_wifi_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result = $query->fetch_assoc())
{
	$tot=$tot+$result['WirelessInternet_Items_Rate']*$result['WirelessInternet_Items_Quantity'];
}
?>
  <tr>
    <td width="24%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="48%"><?php echo $tot;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $tot;?>" /></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php $she_cess_tax=$tot*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
 
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=$tot+$service_tax?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id=$_POST['id'];
	$exhibitor_code=$_POST['exhibitor_code'];
    $conn ->query("delete from iijs_wifi_items_tmp where id='$id'");
	$query1=$conn ->query("select * from iijs_wifi_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['WirelessInternet_Items_Rate']*$result1['WirelessInternet_Items_Quantity'];
 ?>
   <tr>
      <td><?php echo getItemName($result1['WirelessInternet_Items_Master_Id'],$conn);?></td>
      <td><?php echo $result1['WirelessInternet_Items_Rate']?></td>
	  <td><?php echo $tot;?></td>      
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['WirelessInternet_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_wifi_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result = $query->fetch_assoc())
{
	$tot=$tot+$result['WirelessInternet_Items_Rate']*$result['WirelessInternet_Items_Quantity'];
	$Create_Date=$result['Create_Date'];
}
?>
  <tr>
    <td width="24%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="48%"><?php echo $tot;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $tot;?>" /></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=$tot+$service_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

 <?php } ?>