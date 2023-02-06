<?php 
include ("db.inc.php");
include ("functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $Floral_Items_Master_ID=$_POST['Floral_Items_Master_ID'];
    $query=mysql_query("select * from iijs_floral_items_master where Floral_Items_Master_ID='$Floral_Items_Master_ID'");
    $result=mysql_fetch_array($query);
	echo $Item_Quantity=$result['Item_Quantity']."<input type='hidden' name='avail_qty' id='avail_qty' value='$result[Item_Quantity]'/>"."#";
	echo $Item_Rate=$result['Item_Rate']."<input type='hidden' name='Item_Rate' id='Item_Rate' value='$result[Item_Rate]'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
    $Floral_Items_MasterID=$_POST['Floral_Items_Master_ID'];
	$avail_qty=$_POST['avail_qty'];
	$Floral_Items_Rate=$_POST['Item_Rate'];
	$Floral_Items_Quantity=$_POST['Item_Quantity'];
	if($avail_qty < $Floral_Items_Quantity)
	{
		echo "not";		
		exit;
	}
    $query=mysql_query("insert into iijs_floral_items_tmp set Exhibitor_Code='$exhibitor_code',Floral_Items_MasterID='$Floral_Items_MasterID',Floral_Items_Rate='$Floral_Items_Rate',Floral_Items_Quantity='$Floral_Items_Quantity'");
	
	$query1=mysql_query("select * from iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['Floral_Items_Rate']*$result1['Floral_Items_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getFloralItemName($result1['Floral_Items_MasterID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['Floral_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Floral_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['Floral_Items_Rate']*$result['Floral_Items_Quantity'];
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
    <td class="bold">Service Tax (14%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*14/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Swachh Bharat Cess(.5%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$tot*.5/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php $she_cess_tax=$service_tax*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
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
    mysql_query("delete from iijs_floral_items_tmp where id='$id'");
	$query1=mysql_query("select * from iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['Floral_Items_Rate']*$result1['Floral_Items_Quantity'];
	
 ?>
   <tr>
      <td><?php echo getFloralItemName($result1['Floral_Items_MasterID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['Floral_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Floral_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['Floral_Items_Rate']*$result['Floral_Items_Quantity'];
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
    <td class="bold">Service Tax (14%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*14/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Swachh Bharat Cess (0.5%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$tot*0.5/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php $she_cess_tax=$service_tax*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
  
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
 
 