<?php 
session_start();
include ("db.inc.php");
include ("functions.php");

if(isset($_POST['actiontype']) && $_POST['actiontype']=="getItemDetails"){
    $Safe_ID = $_POST['Safe_ID'];
    $query = $conn ->query("select * from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
    $result = $query->fetch_assoc();
	$Exhibitor_Country_ID=$_SESSION['Exhibitor_Country_ID'];
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
	
	//else if(strtotime($current_date) ==strtotime("2017-01-05") && strtotime($current_date) <=strtotime("2017-01-09"))
	if(($current_date <= "2022-08-08" ))
	{
		echo $Item_Rate=$deadline_1;
	}
	else
	{
		 echo $Item_Rate=$deadline_2;
	}
	//echo "insert into iijs_safe_rental_items_tmp set Exhibitor_Code='$exhibitor_code',Safe_ID='$Safe_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate'";exit;
    $query=$conn ->query("insert into iijs_safe_rental_items_tmp set Exhibitor_Code='$exhibitor_code',Safe_ID='$Safe_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate'");
	
	$query1=$conn ->query("select * from iijs_safe_rental_items_tmp where Exhibitor_Code='$exhibitor_code'");
	$grand_tot=0;
	$safe_cnt = $query1->num_rows;
	while($result1 = $query1->fetch_assoc()){
	$tot=$result1['Item_Rate']*$result1['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;	
 ?>
    <tr>
      <td><?php echo getSaferentalId($result1['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result1['Item_Rate']?></td>
      <td><?php echo $result1['Item_Quantity'];?></td>	  
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result1['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php } ?>
 
 <input type="hidden" name="grand_tot" id="grand_tot" value="<?php echo $grand_tot?>"/>
 <?php } ?>
 
 
 <?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="deleteItemDetails"){
	$Safe_Rental_Items_ID=$_POST['Safe_Rental_Items_ID'];
	$exhibitor_code=$_POST['exhibitor_code'];

    $del = $conn ->query("delete from iijs_safe_rental_items_tmp where Safe_Rental_Items_ID='$Safe_Rental_Items_ID'");
	$query = $conn ->query("select * from iijs_safe_rental_items_tmp where Exhibitor_Code='$exhibitor_code'");
	$grand_tot=0;
	while($result = $query->fetch_assoc()){
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;
?>
   <tr>
      <td><?php echo getSaferentalId($result['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result['Item_Rate']?></td>
      <td><?php echo $result['Item_Quantity'];?></td>
	  
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
 <?php }?>
 <input type="hidden" name="grand_tot" id="grand_tot" value="<?php echo $grand_tot?>"/>
 <?php } ?>
<?php 
 if(isset($_POST['actiontype']) && $_POST['actiontype']=="getBadgeDetails"){
    $Badge_Item_ID=$_POST['Badge_Item_ID'];
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$query=$conn ->query("select * from iijs_badge_items where Badge_Item_ID='$Badge_Item_ID'");
    $rows = $query->fetch_assoc();
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
    <td><img src="images/badges/<?php echo $Exhibitor_Code;?>/<?php echo $rows['Badge_Photo']?>" width='150px' height='120' /></td>
    </tr></table>
<?php
}
?>