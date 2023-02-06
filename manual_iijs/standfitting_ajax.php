<?php 
include ("db.inc.php");
include ("functions.php");

if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails")
{
    $Item_ID = $_POST['Item_ID'];
    $query = $conn ->query("select * from iijs_stand_items_master where Item_ID='$Item_ID'");
    $result= $query->fetch_assoc();
	echo $Item_Quantity=$result['Item_Quantity']."<input type='hidden' name='avail_qty' id='avail_qty' value='$result[Item_Quantity]'/>"."#";
	echo $Item_Rate=$result['Item_Rate']."<input type='hidden' name='rate' id='rate' value='$result[Item_Rate]'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
    $Item_ID=$_POST['Item_ID'];
	$avail_qty=$_POST['avail_qty'];
	$rate=$_POST['rate'];
	$Item_Quantity=$_POST['Item_Quantity'];
	if($avail_qty < $Item_Quantity)
	{
		echo "not";		
		exit;
	}
    $query=$conn ->query("insert into iijs_stand_items_tmp set Exhibitor_Code='$exhibitor_code',Item_Master_ID='$Item_ID',Item_Rate='$rate',Item_Quantity='$Item_Quantity',Create_Date=NOW()");	
	$query1=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];	
 ?>
    <tr>
      <td><?php echo getItemDescription($result1['Item_Master_ID'],$conn);?></td>
	  <td><?php echo $result1['Item_Rate']?></td>
	  <td><?php echo $tot;?></td>      	  
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result= $query->fetch_assoc())
{
	$tot=$tot+$result['Item_Rate']*$result['Item_Quantity'];
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
    <td class="bold">Total Payable INRs</td>
    <td>:</td>
    <td><?php echo $grand_tot=$tot+$service_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
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
    $conn->query("delete from iijs_stand_items_tmp where id='$id'");
	$query1=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];	
 ?>
   <tr>
      <td><?php echo getItemName($result1['Item_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result= $query->fetch_assoc())
{
	$tot=$tot+$result['Item_Rate']*$result['Item_Quantity'];
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
    <td><?php echo $grand_tot=$tot+$service_tax+$e_cess_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php } ?>