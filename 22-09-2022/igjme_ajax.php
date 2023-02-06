<?php 
session_start();
include ("db.inc.php");
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$selected_area=$_POST['selected_area'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$selected_scheme_type = $_POST['selected_scheme_type'];
//if($selected_scheme_type=='RW')
if($selected_scheme_type=='BI1')
{
	
	if($_SESSION['member_type']=='MEMBER')
	{
		if($category=='IGJME')
			$charge = 14500;
		if($category=='IIJS')
			$charge = 14000;
/*		if($category=='COMBO')
			$charge = 13000;*/
	}
	if($_SESSION['member_type']=='NON_MEMBER')
	{		
		 if($category=='IGJME')
			$charge = 15000;
		if($category=='IIJS')
			$charge = 15500;
		/*if($category=='COMBO')
			$charge = 14500;*/
	}
	if($_SESSION['member_type']=='INTERNATIONAL')
	{
	 $charge = 300;
	}
}
else
{
 	if($_SESSION['member_type']=='MEMBER')
	{
		if($category=='IGJME')
			$charge = 14500;
		/*if($category=='IIJS')
			$charge = 14000;
		if($category=='COMBO')
			$charge = 13000; */
	}
	if($_SESSION['member_type']=='NON_MEMBER')
	{		
		 if($category=='IGJME')
			$charge = 15000;
		/*if($category=='IIJS')
			$charge = 15500;
		if($category=='COMBO')
			$charge = 14500; */
	}
	if($_SESSION['member_type']=='INTERNATIONAL')
	{
	 $charge = 300;
	}
}
 $selected_premium_type= trim($selected_premium_type);

if(strcasecmp($selected_premium_type,"5")==0)
{
 $selected_premium_type_charge=0.05;
}
else if(strcasecmp($selected_premium_type,"10")==0)
{
	 $selected_premium_type_charge=0.1;
}else if(strcasecmp($selected_premium_type,"15")==0)
{
	 $selected_premium_type_charge=0.15;
}else
{
	$selected_premium_type_charge=0;
}

 $space_rate=intval($selected_area*$charge);

 echo $space_rate1=intval($space_rate)."#";

$premium_rate=floatval($space_rate*$selected_premium_type_charge);
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($space_rate+$premium_rate);
echo $sub_total_cost1=($space_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*18)/100;
echo $govt_service_tax1=$govt_service_tax."#";

//$swachh_bharat_cess=floatval($sub_total_cost*0)/100;
//echo $swachh_bharat_cess1=$swachh_bharat_cess."#";

//$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax+$swachh_bharat_cess);
$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="preferenceValue"){
$selected_stall_preference=$_POST['selected_stall_preference'];
	$area = $_POST['area'];
	$sql="select * from  stall_number_master where stall_no=$selected_stall_preference and area=$area";	
	
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){
		echo $result['premium'];
	?>
<?php }}}?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option = $_POST['option'];
$lastYearArea = $_POST['lastYearArea'];
	
	if($option=="More area than previous year IGJME")
	{
		$sql="select * from igjme_area_master where area>=$lastYearArea";	
	}
	else if($option=="Less area as previous year")
	{
		$sql="select * from igjme_area_master where area<=$lastYearArea";	
	}
	
	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}}?>

