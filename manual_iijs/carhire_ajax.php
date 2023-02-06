<?php 
include ("db.inc.php");
include ("functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getPayment")
{
	$hrs=$_POST['hrs'];
	$kilometers=$_POST['kilometers'];
	$Car_Type_ID=$_POST['Car_Type_ID'];
	$Car_Type_Charge=$hrs."HRS+".$kilometers."KMS";
	
    $query=mysql_query("select * from  iijs_car_type_master");
	
    while($result=mysql_fetch_array($query))
	{
		if($result['Car_Type_Charge1']==$Car_Type_Charge && $result['Car_Type_ID']==$Car_Type_ID)
		{
			echo $charge_amount=$result['Car_Type_Charge1_Amount']."#";
			$total_amount=$result['Car_Type_Charge1_Amount'];	
		}
		if($result['Car_Type_Charge2']==$Car_Type_Charge && $result['Car_Type_ID']==$Car_Type_ID)
		{
			echo $charge_amount=$result['Car_Type_Charge2_Amount']."#";	
			$total_amount=$result['Car_Type_Charge2_Amount'];
		}
	}
	
	
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
  <tr>
    <td width="38%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="34%"><?php echo $total_amount;?><input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_amount;?>"/></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Service Tax (4.944%)</td>
    <td>:</td>
    <td><?php echo $service_tax=($total_amount*4.944)/100;?><input type="hidden" name="service_tax" id="service_tax" value="<?php echo $service_tax;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><?php echo $total_payble=$service_tax+$total_amount;?><input type="hidden" name="total_payble" id="total_payble" value="<?php echo $total_payble;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="addpickPayment")
{
	$pickup_facility_amount=$_POST['pickup_facility_amount'];
	$Charges=$_POST['Charges'];
	$drop_facility=$_POST['drop_facility'];
	$total_amount=$pickup_facility_amount+$Charges+drop_facility;
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
  <tr>
    <td width="38%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="34%"><?php echo $total_amount;?><input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_amount;?>"/></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Service Tax (4.944%)</td>
    <td>:</td>
    <td><?php echo $service_tax=($total_amount*4.944)/100;?><input type="hidden" name="service_tax" id="service_tax" value="<?php echo $service_tax;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><?php echo $total_payble=$service_tax+$total_amount;?><input type="hidden" name="total_payble" id="total_payble" value="<?php echo $total_payble;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="adddropPayment")
{
	$drop_facility_amount=$_POST['drop_facility_amount'];
	$Charges=$_POST['Charges'];
	$pickup_facility=$_POST['pickup_facility'];
	$total_amount=$drop_facility_amount+$Charges+$pickup_facility;
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
  <tr>
    <td width="38%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="34%"><?php echo $total_amount;?><input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_amount;?>"/></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Service Tax (4.944%)</td>
    <td>:</td>
    <td><?php echo $service_tax=($total_amount*4.944)/100;?><input type="hidden" name="service_tax" id="service_tax" value="<?php echo $service_tax;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><?php echo $total_payble=$service_tax+$total_amount;?><input type="hidden" name="total_payble" id="total_payble" value="<?php echo $total_payble;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>



