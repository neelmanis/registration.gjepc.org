<?php 
include ("../db.inc.php");
include ("../functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $Item_ID=$_POST['Item_ID'];
    $query=$conn ->query("select * from iijs_stand_items_master where Item_ID='$Item_ID'");
    $result=$query->fetch_assoc();
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
	$exact_rate=$rate*$Item_Quantity;
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Stand_ID=$_POST['Stand_ID'];
	if($avail_qty < $Item_Quantity)
	{
		echo "not";		
		exit;
	}
	
	$qitem_quantity=$conn ->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$Item_Quantity;
	$conn ->query("update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'");
	
	
	$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=$query->fetch_assoc();
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$exact_rate+$Payment_Master_Amount1;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');
	
	$conn ->query("update iijs_payment_master set Form_ID='3',Exhibitor_Code='$exhibitor_code',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

//echo "insert into iijs_stand_items set Stand_ID='$Stand_ID',Item_Master_ID='$Item_ID',Item_Rate='$rate', 	Item_Quantity='$Item_Quantity',Create_Date='$Create_Date'";exit;
  $query=$conn ->query("insert into iijs_stand_items set Stand_ID='$Stand_ID',Item_Master_ID='$Item_ID',Item_Rate='$rate', 	Item_Quantity='$Item_Quantity',Create_Date='$Create_Date'");
	
	$query1=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
	while($result1=$query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getItemDescription($result1['Item_Master_ID'],$conn);?></td>
      <td><?php echo $result1['Item_Rate']?></td>
	  <td><?php echo $tot;?></td>
      <td><input type="text" name="textfield" id="Item_Quantity" class="Item_Quantity" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled"  /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['Stand_Item_ID'];?> <?php echo $Stand_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $Item_Master_ID;?>" style="cursor:pointer;">&nbsp;
	  
	  </td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
$tot=0;
while($result=$query->fetch_assoc())
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
	$Stand_Item_ID=$_POST['Stand_Item_ID'];
	$Stand_ID=$_POST['Stand_ID'];
	$Item_Master_ID=$_POST['Item_Master_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	
	$query=$conn ->query("select * from iijs_stand_items where Stand_Item_ID='$Stand_Item_ID'");
	$result=$query->fetch_assoc();
	$Item_Quantity=$result['Item_Quantity'];
	$Item_Rate=$result['Item_Rate'];
	
	$exact_rate=$Item_Rate*$Item_Quantity;
	
	$qitem_quantity=$conn ->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity+$Item_Quantity;
	$conn ->query("update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'");
	
	$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=$query->fetch_assoc();
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$Payment_Master_Amount1-$exact_rate;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax);
	$Create_Date=date('Y-m-d h:i:s');
	
	$conn ->query("update iijs_payment_master set Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");
	
    $conn ->query("delete from iijs_stand_items where Stand_Item_ID='$Stand_Item_ID'");
	
	$query1=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
	while($result1=$query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];
	
 ?>
   <tr>
      <td><?php echo getItemDescription($result1['Item_Master_ID'],$conn);?></td>
      <td><?php echo $result1['Item_Rate']?></td>
	  <td><?php echo $tot;?></td>      
      <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result1['Stand_Item_ID'];?> <?php echo $Stand_ID;?> <?php echo $Payment_Master_ID;?> <?php echo $Item_Master_ID;?>" style="cursor:pointer;">&nbsp;
	  </td>
   </tr>
 <?php } echo "#";?>
 
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_stand_items where Stand_ID ='$Stand_ID '");
$tot=0;
while($result=$query->fetch_assoc())
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
    <td><?php echo $grand_tot=round($tot+$service_tax+$e_cess_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }?>


<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteOrder"){
	$Stand_ID=$_POST['Stand_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	$query=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
	while($result=$query->fetch_assoc())
	{
		$Item_Master_ID =$result['Item_Master_ID'];
		$Item_Quantity =$result['Item_Quantity'];
	
		$qitem_quantity=$conn ->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
		$ritem_quantity=$qitem_quantity->fetch_assoc();
		$tot_quantity=$ritem_quantity['Item_Quantity'];
		$remain_quantity=$tot_quantity+$Item_Quantity;
		$conn ->query("update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'");
     }

	$query=$conn ->query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$query=$conn ->query("delete from iijs_stand where Stand_ID='$Stand_ID'");
	$query=$conn ->query("delete from iijs_stand_items where Stand_ID='$Stand_ID'");
	echo $Exhibitor_Code;
}
?> 



<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="addItemDetails"){
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
  $query=$conn ->query("insert into iijs_stand_items_tmp set Exhibitor_Code='$exhibitor_code',Item_Master_ID='$Item_ID',Item_Rate='$rate', Item_Quantity='$Item_Quantity', Create_Date=NOW()");
	
	$query1=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	while($result1=$query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];
	
 ?>
    <tr>
      <td><?php echo getItemDescription($result1['Item_Master_ID'],$conn);?></td>
      <td><?php echo $result1['Item_Rate']?></td>
	  <td><?php echo $tot;?></td>
      
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result1['Item_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/delete.png" class="deleteItem <?php echo $result1['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } echo "#"; ?>
 <table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
$query=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
$tot=0;
while($result=$query->fetch_assoc())
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
<?php }?>
 