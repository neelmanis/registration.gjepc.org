<?php 
include ("../db.inc.php");
include ("../functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
     $Item_ID=$_POST['Item_ID'];
	 
    $query=mysql_query("SELECT * FROM `iijs_wifi_master` WHERE id='$Item_ID'");
    $result=mysql_fetch_array($query);
	echo $Item_Rate=$result['charges']."<input type='hidden' name='rate' id='rate' value='$result[charges]'/>";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
	$Item_ID=$_POST['Item_ID'];
	$wifi_Rate=$_POST['rate'];
	$WireLessInternet_ID=$_POST['WireLessInternet_ID'];
	$WirelessInternet_Items_Quantity=$_POST['Item_Quantity'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$rate=$wifi_Rate*$WirelessInternet_Items_Quantity;
	
	$query=mysql_query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=mysql_fetch_array($query);
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$rate+$Payment_Master_Amount1;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');
	
	mysql_query("update iijs_payment_master set Form_ID='7',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

	
    $query=mysql_query("insert into iijs_wirelessinternet_items set WireLessInternet_ID='$WireLessInternet_ID',WirelessInternet_Items_Master_Id='$Item_ID',WirelessInternet_Items_Rate='$wifi_Rate',WirelessInternet_Items_Quantity='$WirelessInternet_Items_Quantity'");
	
	$query1=mysql_query("select * from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['WirelessInternet_Items_Rate']*$result1['WirelessInternet_Items_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getWifiItemDescription($result1['WirelessInternet_Items_Master_Id']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['WirelessInternet_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['WirelessInternet_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['WirelessInternet_Items_ID'];?> <?php echo $WireLessInternet_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $WirelessInternet_Items_ID;?>" style="cursor:pointer;">
	  </td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
$tot=0;
while($result=mysql_fetch_array($query))
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
    <td class="bold">GST(18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <?php echo $she_cess_tax=$service_tax*1/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
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
<?php } ?>
 
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	
	$WirelessInternet_Items_ID=$_POST['WirelessInternet_Items_ID'];
	$WireLessInternet_ID=$_POST['WireLessInternet_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$WirelessInternet_Items_Master_Id=$_POST['WirelessInternet_Items_Master_Id'];	
	
    $query=mysql_query("select * from iijs_wirelessinternet_items where WirelessInternet_Items_ID='$WirelessInternet_Items_ID'");
	$result=mysql_fetch_array($query);
	$Item_Quantity=$result['WirelessInternet_Items_Quantity'];
	$Item_Rate=$result['WirelessInternet_Items_Rate'];
	$rate=$Item_Rate*$Item_Quantity;
	
	$query=mysql_query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=mysql_fetch_array($query);
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$Payment_Master_Amount1-$rate;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');
	
	mysql_query("update iijs_payment_master set Form_ID='7',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

	mysql_query("delete from iijs_wirelessinternet_items where WirelessInternet_Items_ID='$WirelessInternet_Items_ID'");
	
	$query1=mysql_query("select * from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
	while($result1=mysql_fetch_array($query1)){
	$tot=$result1['WirelessInternet_Items_Rate']*$result1['WirelessInternet_Items_Quantity'];	
 ?>
 
   <tr>
      <td><?php echo getWifiItemDescription($result1['WirelessInternet_Items_Master_Id']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['WirelessInternet_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['WirelessInternet_Items_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['WirelessInternet_Items_ID'];?> <?php echo $WireLessInternet_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $WirelessInternet_Items_Master_Id;?>" style="cursor:pointer;">
	  </td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=mysql_query("select * from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
$tot=0;
while($result=mysql_fetch_array($query))
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

  <?php echo $she_cess_tax=$service_tax*1/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
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
	$WireLessInternet_ID=$_POST['WireLessInternet_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	/*$query=mysql_query("select * from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
	while($result=mysql_fetch_array($query))
	{
		$WirelessInternet_Items_ID =$result['WirelessInternet_Items_ID'];
		$Item_Quantity =$result['Item_Quantity'];
	
		$qitem_quantity=mysql_query("select WirelessInternet_Items_Quantity from iijs_wirelessinternet_items where WirelessInternet_Items_ID='$WirelessInternet_Items_ID'");
		$ritem_quantity=mysql_fetch_array($qitem_quantity);
		$tot_quantity=$ritem_quantity['WirelessInternet_Items_Quantity'];
		$remain_quantity=$tot_quantity+$Item_Quantity;
		mysql_query("update iijs_wirelessinternet_items set WirelessInternet_Items_Quantity='$remain_quantity' where WirelessInternet_Items_ID='$WirelessInternet_Items_ID'");
     } */

	$query=mysql_query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$query=mysql_query("delete from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
	$query=mysql_query("delete from iijs_wirelessinternet_items where WireLessInternet_ID='$WireLessInternet_ID'");
	echo $Exhibitor_Code;
}
?> 