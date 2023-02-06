<?php 
session_start();
include ("../db.inc.php");
include ("../functions.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $Safe_ID = $_POST['Safe_ID'];
    $query = $conn ->query("select * from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
    $result = $query->fetch_assoc();
	$Exhibitor_Country_ID="IN";
	if($Exhibitor_Country_ID=="IN"){$deadline_1=$result['deadline_1_inr'];}else{$deadline_1=$result['deadline_1_us'];}
	if($Exhibitor_Country_ID=="IN"){$deadline_2=$result['deadline_2_inr'];}else{$deadline_2=$result['deadline_2_us'];}
	if($Exhibitor_Country_ID=="IN"){$deadline_3=$result['deadline_3_inr'];}else{$deadline_3=$result['deadline_3_us'];}
	$Item_Quantity=$result['Item_Quantity'];
	echo $deadline_1."<input type='hidden' name='deadline_1' id='deadline_1' value='$deadline_1'/>"."#";
	echo $deadline_2."<input type='hidden' name='deadline_2' id='deadline_2' value='$deadline_2'/>"."#";
	echo $deadline_3."<input type='hidden' name='deadline_3' id='deadline_3' value='$deadline_3'/>"."#";
	echo $Item_Quantity."<input type='hidden' name='avail_qty' id='avail_qty' value='$Item_Quantity'/>";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="saveItemDetails"){
	$exhibitor_code=$_POST['exhibitor_code'];
    $Safe_ID=$_POST['Safe_ID'];
	$Safe_Rental_ID=$_POST['Safe_Rental_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$deadline_1=$_POST['deadline_1'];
	$deadline_2=$_POST['deadline_2'];
	$deadline_3=$_POST['deadline_3'];
	$avail_qty=$_POST['avail_qty'];
	$Item_Quantity=$_POST['Item_Quantity'];
	$current_date=date('Y-m-d');
	
	if($avail_qty < $Item_Quantity)
	{
		echo "not";		
		exit;
	}
	
	if(strtotime($current_date) <=strtotime("2017-01-04"))
	{
		$Item_Rate=$deadline_1;
	}
	//else if(strtotime($current_date) >strtotime("2017-01-05") && strtotime($current_date) <=strtotime("2017-01-09"))
	else if ( ( $current_date >= "2017-01-05" ) && ( $current_date <= "2017-01-09" ) )
	{
		$Item_Rate=$deadline_2;
	}
	else
	{
		 $Item_Rate=$deadline_3;
	}
	$rate=$Item_Rate*$Item_Quantity;
	
    $query=$conn->query("insert into iijs_safe_rental_items set Safe_Rental_ID='$Safe_Rental_ID',Safe_ID='$Safe_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate'");
	
	$qitem_quantity=$conn->query("select Item_Quantity from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$Item_Quantity;
	
	$conn->query("update iijs_safe_rental_master set Item_Quantity='$remain_quantity' where Safe_ID='$Safe_ID'");
	
	$query=$conn->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=$query->fetch_assoc();
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$rate+$Payment_Master_Amount1;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*2/100;
	$she_cess_tax=$Payment_Master_ServiceTax*1/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');
		
	$conn->query("update iijs_payment_master set Form_ID='9',Exhibitor_Code='$exhibitor_code',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");	

	$query1=$conn->query("select * from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
	$grand_tot=0;
	while($result1=$query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;
 ?>
    <tr>
      <td><?php echo getSaferentalId($result1['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result1['Item_Rate']?></td>
      <td><?php echo $result1['Item_Quantity'];?></td>
      <td>
	  <img src="../images/red_cross.png" class="deleteItem <?php echo $result1['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?> <?php echo $Payment_Master_ID;?> <?php echo $result1['Safe_ID'];?> <?php echo $result1['Safe_Rental_ID'];?>" style="cursor:pointer;" />
	  </td>
   </tr>
 <?php } ?>
 <input type="hidden" name="grand_tot" id="grand_tot" value="<?php echo $grand_tot?>"/>
 <?php } ?>
 
 
 
 
 
 <?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$Safe_Rental_Items_ID=$_POST['Safe_Rental_Items_ID'];
	$exhibitor_code=$_POST['exhibitor_code'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Safe_ID=$_POST['Safe_ID'];
	$Safe_Rental_ID=$_POST['Safe_Rental_ID'];

	
	$query=$conn ->query("select * from iijs_safe_rental_items where Safe_Rental_Items_ID='$Safe_Rental_Items_ID'");
	$result=$query->fetch_assoc();
	$Item_Quantity=$result['Item_Quantity'];
	$Item_Rate=$result['Item_Rate'];
	$rate=$Item_Rate*$Item_Quantity;
	
	$qitem_quantity=$conn ->query("select Item_Quantity from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity+$Item_Quantity;

	$conn ->query("update  iijs_safe_rental_master set Item_Quantity='$remain_quantity' where  Safe_ID='$Safe_ID'");
	
	$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");	
	$result=$query->fetch_assoc();
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Payment_Master_Amount1=$result['Payment_Master_Amount'];
	$Payment_Master_Amount=$Payment_Master_Amount1-$rate;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_ServiceTax=$Payment_Master_Amount*12/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*2/100;
	$she_cess_tax=$Payment_Master_ServiceTax*1/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);
	$Create_Date=date('Y-m-d h:i:s');

	
	$conn ->query("update iijs_payment_master set Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Modify_Date='$Create_Date' where Payment_Master_ID='$Payment_Master_ID'");
	
	
    $conn ->query("delete from iijs_safe_rental_items where Safe_Rental_Items_ID='$Safe_Rental_Items_ID'");
	
	$query=$conn ->query("select * from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
	$grand_tot=0;
	while($result=$query->fetch_assoc()){
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;
?>
   <tr>
      <td><?php echo getSaferentalId($result['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result['Item_Rate']?></td>
      <td><?php echo $result['Item_Quantity'];?></td>
	  
      <td><img src="../images/red_cross.png" class="deleteItem <?php echo $result['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?> <?php echo $Payment_Master_ID;?> <?php echo $result['Safe_ID'];?> <?php echo $result['Safe_Rental_ID'];?>" style="cursor:pointer;" /></td>
   </tr>
 <?php }?>
 <input type="hidden" name="grand_tot" id="grand_tot" value="<?php echo $grand_tot?>"/>
 <?php }?>
<?php 
 if(isset($_POST['actiontype']) && $_POST['actiontype']=="getBadgeDetails"){
    $Badge_Item_ID=$_POST['Badge_Item_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$query=$conn->query("select * from iijs_badge_items where Badge_Item_ID='$Badge_Item_ID'");
    $rows=$query->fetch_assoc();
?>
<table border='0' cellspacing='0' cellpadding='0' class='formManual'>
	<tr>
		<td width='29%'>Name</td>
		<td width='6%'>:</td>
		<td width='65%'><?php echo $rows['Badge_Name'];?></td>
	</tr>
	<tr>
		<td width='29%'>Designation</td>
		<td width='6%'>:</td>
		<td width='65%'><?php echo $rows['Badge_Designation'];?></td>
	</tr>
    <tr>
    <td>Photo</td>
    <td>:</td>
    <td><img src="../images/badges/<?php echo $Exhibitor_Code;?>/<?php echo $rows['Badge_Photo']?>" width='150px' height='120' /></td>
    </tr></table>
<?php
}
?>
 
 <?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteOrder"){
	$Safe_Rental_ID=$_POST['Safe_Rental_ID'];
	$Payment_Master_ID=$_POST['Payment_Master_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];

	$query=$conn ->query("select * from iijs_safe_rental_items where  Safe_Rental_ID='$Safe_Rental_ID'");
	while($result=$query->fetch_assoc())
	{
		$Safe_ID =$result['Safe_ID'];
		$Item_Quantity =$result['Item_Quantity'];
	
		$qitem_quantity=$conn ->query("select Item_Quantity from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
		$ritem_quantity=$qitem_quantity->fetch_assoc();
		$tot_quantity=$ritem_quantity['Item_Quantity'];
		$remain_quantity=$tot_quantity+$Item_Quantity;
		$conn ->query("update iijs_safe_rental_master set Item_Quantity='$remain_quantity' where Safe_ID='$Safe_ID'");
     }

	$query=$conn ->query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$query=$conn ->query("delete from iijs_safe_rental where Safe_Rental_ID='$Safe_Rental_ID'");
	$query=$conn ->query("delete from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
	echo $Exhibitor_Code;
}
?> 
 
 
