<?php 
include ("db.inc.php");
include ("functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails")
{
     $CCTV_Items_Master_ID = $_POST['CCTV_Items_Master_ID'];
	//echo "select * from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'";
    $query = $conn ->query("select * from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
    $result= $query->fetch_assoc();
	echo $Item_Quantity=$result['Item_Quantity']."<input type='hidden' name='avail_qty' id='avail_qty' value='$result[Item_Quantity]'/>"."#";
	echo $Item_Rate=$result['Item_Rate']."<input type='hidden' name='Item_Rate' id='Item_Rate' value='$result[Item_Rate]'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code = $_POST['exhibitor_code'];
    $CCTV_Items_Master_ID=$_POST['CCTV_Items_Master_ID'];
	$avail_qty=$_POST['avail_qty'];
	$CCTV_Items_Rate=$_POST['Item_Rate'];
	$CCTV_Items_Quantity=$_POST['Item_Quantity'];
	
	if($avail_qty < $CCTV_Items_Quantity)
	{
		echo "not";		
		exit;
	}
    $query = $conn ->query("insert into iijs_cctv_items_master_tmp set Exhibitor_Code='$exhibitor_code',CCTV_Items_Master_ID='$CCTV_Items_Master_ID',CCTV_Items_Rate='$CCTV_Items_Rate',CCTV_Items_Quantity='$CCTV_Items_Quantity', Create_Date=NOW()");
	
	$query1 = $conn ->query("select * from iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
	$cctv_cnt = $query1->num_rows;
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['CCTV_Items_Rate']*$result1['CCTV_Items_Quantity'];	
 ?>
    <tr>
      <td><?php echo getElectronicItemName($result1['CCTV_Items_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query = $conn->query("select * from iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result = $query->fetch_assoc())
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
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr>
    <td class="bold">Swachh Bharat Cess(0.50%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$tot*.50/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>-->
  <?php $she_cess_tax=$tot*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
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
 
  
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$id = $_POST['id'];
	$exhibitor_code = $_POST['exhibitor_code'];
    $del = $conn->query("delete from iijs_cctv_items_master_tmp where id='$id'");
	$query1 = $conn->query("select * from iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
	$cctv_cnt = $query1->num_rows;
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['CCTV_Items_Rate']*$result1['CCTV_Items_Quantity'];	
   ?>
   <tr>
      <td><?php echo getElectronicItemName($result1['CCTV_Items_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result1['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query = $conn->query("select * from iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result = $query->fetch_assoc())
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
    <td><?php echo $grand_tot=$tot+$service_tax;?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>