<?php 
include ("db.inc.php");
include ("functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $Item_ID=$_POST['Item_ID'];
    $query=mysql_query("select * from iijs_stand_items_master where Item_ID='$Item_ID'");
    $result=mysql_fetch_array($query);
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
    $query=mysql_query("insert into iijs_stand_items_tmp set Exhibitor_Code='$exhibitor_code',Item_ID='$Item_ID',rate='$rate', 	Item_Quantity='$Item_Quantity'");
	$query1=mysql_query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['rate']*$result1['Item_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getItemName($result1['Item_ID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['rate']*$result['Item_Quantity'];
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
    <td class="bold">Service Tax (12%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*12/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">E-Cess tax (2%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$service_tax*2/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">S.H.E. Cess Tax (1%) </td>
    <td>:</td>
    <td><?php echo $she_cess_tax=$service_tax*1/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=$tot+$service_tax+$e_cess_tax+$she_cess_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }?>
 
 
 
 
 <?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id=$_POST['id'];
	$exhibitor_code=$_POST['exhibitor_code'];
    mysql_query("delete from iijs_stand_items_tmp where id='$id'");
	$query1=mysql_query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['rate']*$result1['Item_Quantity'];
	
 ?>
   <tr>
      <td><?php echo getItemName($result1['Item_ID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['rate']*$result['Item_Quantity'];
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
    <td class="bold">Service Tax (12%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*12/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">E-Cess tax (2%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$service_tax*2/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">S.H.E. Cess Tax (1%) </td>
    <td>:</td>
    <td><?php echo $she_cess_tax=$service_tax*1/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=$tot+$service_tax+$e_cess_tax+$she_cess_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

 <?php }?>
 
 