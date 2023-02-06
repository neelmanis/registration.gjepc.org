<?php 
include ("../db.inc.php");
include ("../functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $CCTV_Items_Master_ID=$_POST['CCTV_Items_Master_ID'];
	//echo "select * from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'";
    $query = $conn ->query("select * from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
    $result= $query->fetch_assoc();
	echo $Item_Quantity=$result['Item_Quantity']."<input type='hidden' name='avail_qty' id='avail_qty' value='$result[Item_Quantity]'/>"."#";
	echo $Item_Rate=$result['Item_Rate']."<input type='hidden' name='Item_Rate' id='Item_Rate' value='$result[Item_Rate]'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
    $CCTV_Items_Master_ID=$_POST['CCTV_Items_Master_ID'];
	$CCTV_ID=$_POST['CCTV_ID'];
	$avail_qty=$_POST['avail_qty'];
	$CCTV_Items_Rate=$_POST['Item_Rate'];
	$CCTV_Items_Quantity=$_POST['Item_Quantity'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$rate=$CCTV_Items_Rate*$CCTV_Items_Quantity;
	
	if($avail_qty < $CCTV_Items_Quantity)
	{
		echo "not";		
		exit;
	}
	
	$qitem_quantity = $conn ->query("select Item_Quantity from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	$ritem_quantity = $qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$CCTV_Items_Quantity;
	$update = $conn ->query("update iijs_cctv_items_master set Item_Quantity='$remain_quantity' where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	
	
	$query = $conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result =$conn ->query($query);
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$rate+$Payment_Master_Amount1;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax);
	$Create_Date=date('Y-m-d h:i:s');
	
	$iijs = $conn ->query("update iijs_payment_master set Form_ID='8',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	
	
    $query=$conn ->query("insert into iijs_cctv_items set CCTV_ID='$CCTV_ID',CCTV_Items_Master_ID='$CCTV_Items_Master_ID',CCTV_Items_Rate='$CCTV_Items_Rate',CCTV_Items_Quantity='$CCTV_Items_Quantity'");
	
	$query1=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['CCTV_Items_Rate']*$result1['CCTV_Items_Quantity'];
   ?>
    <tr>
      <td><?php echo getElectronicItemName($result1['CCTV_Items_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['CCTV_Items_ID'];?> <?php echo $CCTV_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $CCTV_Items_Master_ID;?>" style="cursor:pointer;">
	  </td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
$tot=0;
while($result=$query->fetch_assoc())
{
	$tot=$tot+$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
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
    <td class="bold">GST(18%)</td>
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
    <td><?php echo $grand_tot=round($tot+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }?>
 
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	
	$CCTV_Items_ID=$_POST['CCTV_Items_ID'];
	$CCTV_ID=$_POST['CCTV_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$CCTV_Items_Master_ID=$_POST['CCTV_Items_Master_ID'];
	
	
    $query=$conn ->query("select * from iijs_cctv_items where CCTV_Items_ID='$CCTV_Items_ID'");
	$result=$query->fetch_assoc();
	$Item_Quantity=$result['CCTV_Items_Quantity'];
	$Item_Rate=$result['CCTV_Items_Rate'];
	$rate=$Item_Rate*$Item_Quantity;
	
	$qitem_quantity=$conn ->query("select Item_Quantity from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity+$Item_Quantity;
	
	$conn ->query("update iijs_cctv_items_master set Item_Quantity='$remain_quantity' where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	
	$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=$query->fetch_assoc();
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$Payment_Master_Amount1-$rate;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax);
	$Create_Date=date('Y-m-d h:i:s');
	
	$conn ->query("update iijs_payment_master set Form_ID='8',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

	$conn ->query("delete from iijs_cctv_items where CCTV_Items_ID='$CCTV_Items_ID'");
	
	$query1=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	while($result1=$query1->fetch_assoc()){
	$tot=$result1['CCTV_Items_Rate']*$result1['CCTV_Items_Quantity'];	
 ?>
   <tr>
      <td><?php echo getElectronicItemName($result1['CCTV_Items_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['CCTV_Items_ID'];?> <?php echo $CCTV_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $CCTV_Items_Master_ID;?>" style="cursor:pointer;">
	  </td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
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
    <td class="bold">GSt(18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <?php echo $she_cess_tax=$service_tax*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=round($tot+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }?>
 
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteOrder"){
	$CCTV_ID=$_POST['CCTV_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	echo $Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	$query=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	while($result=$query->fetch_assoc())
	{
		$CCTV_Items_Master_ID =$result['CCTV_Items_Master_ID'];
		$Item_Quantity =$result['Item_Quantity'];
	
		$qitem_quantity=$conn ->query("select Item_Quantity from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
		$ritem_quantity = $qitem_quantity->fetch_assoc();
		$tot_quantity=$ritem_quantity['CCTV_Items_Quantity'];
		$remain_quantity=$tot_quantity+$Item_Quantity;
		$conn ->query("update iijs_cctv_items_master set CCTV_Items_Quantity='$remain_quantity' where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
    }

	$query=$conn ->query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$query=$conn ->query("delete from iijs_cctv where CCTV_ID='$CCTV_ID'");
	$query=$conn ->query("delete from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	echo $Exhibitor_Code;
}
?> 
 