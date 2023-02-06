<?php 
include ("../db.inc.php");
include ("../functions.php");
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
	$Floral_ID=$_POST['Floral_ID'];
	$avail_qty=$_POST['avail_qty'];
	$Floral_Items_Rate=$_POST['Item_Rate'];
	$Floral_Items_Quantity=$_POST['Item_Quantity'];
	$rate=$Floral_Items_Rate*$Floral_Items_Quantity;
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	if($avail_qty < $Floral_Items_Quantity)
	{
		echo "not";		
		exit;
	}

	
	$qitem_quantity=mysql_query("select Item_Quantity from iijs_floral_items_master where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	$ritem_quantity=mysql_fetch_array($qitem_quantity);
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$Floral_Items_Quantity;
	
	mysql_query("update iijs_floral_items_master set Item_Quantity='$remain_quantity' where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	
	
	$query=mysql_query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=mysql_fetch_array($query);
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$rate+$Payment_Master_Amount1;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*2/100;
	$she_cess_tax=$Payment_Master_ServiceTax*1/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');
	
	mysql_query("update iijs_payment_master set Form_ID='10',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

	
    $query=mysql_query("insert into iijs_floral_items set Floral_ID='$Floral_ID',Floral_Items_MasterID='$Floral_Items_MasterID',Floral_Items_Rate='$Floral_Items_Rate',Floral_Items_Quantity='$Floral_Items_Quantity'");
	
	$query1=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['Floral_Items_Rate']*$result1['Floral_Items_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getFloralItemName($result1['Floral_Items_MasterID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['Floral_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Floral_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['Floral_Items_ID'];?> <?php echo $Floral_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $Floral_Items_MasterID;?>" style="cursor:pointer;">
	  </td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
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

	$Floral_Items_ID=$_POST['Floral_Items_ID'];
	$Floral_ID=$_POST['Floral_ID'];
	$Floral_Items_MasterID=$_POST['Floral_Items_MasterID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	
	$query=mysql_query("select * from iijs_floral_items where Floral_Items_ID='$Floral_Items_ID'");
	$result=mysql_fetch_array($query);
	$Item_Quantity=$result['Floral_Items_Quantity'];
	$Item_Rate=$result['Floral_Items_Rate'];
	$exact_rate=$Item_Quantity*$Item_Rate;
		
	$qitem_quantity=mysql_query("select Item_Quantity from iijs_floral_items_master where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	$ritem_quantity=mysql_fetch_array($qitem_quantity);
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity+$Item_Quantity;
	
	mysql_query("update iijs_floral_items_master set Item_Quantity='$remain_quantity' where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	
	$query=mysql_query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=mysql_fetch_array($query);
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$Payment_Master_Amount1-$exact_rate;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*2/100;
	$she_cess_tax=$Payment_Master_ServiceTax*1/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');

	
	mysql_query("update iijs_payment_master set Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");
	
    mysql_query("delete from iijs_floral_items where  Floral_Items_ID='$Floral_Items_ID'");
	
	$query1=mysql_query("select * from iijs_floral_items where  Floral_ID='$Floral_ID'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['Floral_Items_Rate']*$result1['Floral_Items_Quantity'];
	
 ?>
   <tr>
      <td><?php echo getFloralItemName($result1['Floral_Items_MasterID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['Floral_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Floral_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['Floral_Items_ID'];?> <?php echo $Floral_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $Floral_Items_MasterID;?>" style="cursor:pointer;">
</td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
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
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteOrder"){
	$Floral_ID=$_POST['Floral_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	$query=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
	while($result=mysql_fetch_array($query))
	{
		$Floral_Items_MasterID =$result['Floral_Items_MasterID'];
		$Floral_Items_Quantity =$result['Floral_Items_Quantity'];
	
		$qitem_quantity=mysql_query("select Item_Quantity from iijs_floral_items_master where Floral_Items_Master_ID='$Floral_Items_MasterID'");
		$ritem_quantity=mysql_fetch_array($qitem_quantity);
		$tot_quantity=$ritem_quantity['Item_Quantity'];
		$remain_quantity=$tot_quantity+$Floral_Items_Quantity;
		
		mysql_query("update iijs_floral_items_master set Item_Quantity='$remain_quantity' where Floral_Items_Master_ID='$Floral_Items_MasterID'");
     }

	$query=mysql_query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$query=mysql_query("delete from iijs_floral where Floral_ID='$Floral_ID'");
	$query=mysql_query("delete from iijs_floral_items where Floral_ID='$Floral_ID'");
	echo $Exhibitor_Code;
}
?> 
 