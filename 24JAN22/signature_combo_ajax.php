<?php 
session_start();
include ("db.inc.php");
?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
	
$member_type=$_SESSION['member_type'];
$membership_certificate_type = trim($_SESSION['membership_certificate_type']);	
$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
$selected_area = $_POST['selected_area'];
$section = $_POST['section'];
$category = $_POST['category'];
$selected_scheme_type = $_POST['selected_scheme_type'];
$selected_premium_type = $_POST['selected_premium_type'];
$last_yr_participant = trim($_POST['last_yr_participant']);
$woman_entrepreneurs = $_POST['woman_entrepreneurs'];

if(strtoupper($_SESSION['COUNTRY'])=="IN")
{
	if($section=="plain_gold")
	{
		$charge="23500";
	}
	else if($section=="loose_stones")
	{
		$charge="23500";
	}
	else if($section=="signature_club")
	{
		$charge="30500";
	}
	else if($section=="studded_jewellery")
	{
		$charge="23500";
	}
	else if($section=="lab_edu")
	{
		$charge="23500";
	}
	else if($section=="allied")
	{
		$charge="23500";
	} 
	else if($section=="synthetics")
	{
		$charge="23500";
	}
	else if($section=="silver_jewellery_artifacts")
	{
		$charge="23500";
	}
	
} else {
		if($section=="International Jewellery")
		{
			$charge="450";
		}
		else if($section=="International Loose")
		{
			$charge="450";
		}
}

if($category=="normal")
{
	$category=0;
}
else if($category=="corner_2side")
{
	$category=0.05;
}
else if($category=="corner_3side")
{
	$category=0.1;
}
else if($category=="island_4side")
{
	$category=0.15;
}

if($selected_premium_type=="normal")
{
	$selected_premium_type=0;
}
else if($selected_premium_type=="premium")
{
	$selected_premium_type=0.05;
}

$space_rate=intval($selected_area*$charge);

if($woman_entrepreneurs==1)
{
	$space_rate=($space_rate-$space_rate*0.25);
}

echo $space_rate1=intval($space_rate)."#";

// if(strtoupper($last_yr_participant)=="YES")
// {
// if($membership_certificate_type!=''){
// 	if($membership_certificate_type=='ZASSOC')
// 	{
// 		$space_rate_discount=($space_rate*0.05);
// 	}
// 	if($membership_certificate_type=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
// 	{
// 		$space_rate_discount=($space_rate*0.10);
// 	}
// 	if($membership_certificate_type=='ZORDIN')
// 	{
// 		$space_rate_discount=($space_rate*0.15);
// 	}
// }
// }

//echo $tot_space_cost_discount=intval($space_rate_discount)."#";

$get_tot_space_cost = $space_rate;  // Get the total difference of Space cost Rate - Discount space cost rate

//echo $get_tot_space_cost_rate = intval($get_tot_space_cost)."#";

$category_rate=$get_tot_space_cost*$category;
echo $category_rate1=$category_rate."#";

if($selected_scheme_type=="BI1" || $selected_scheme_type==0){	$scheme_rate=0;	}
echo $scheme_rate1=$scheme_rate."#";
		
$premium_rate=floatval($get_tot_space_cost*$selected_premium_type);
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($get_tot_space_cost+$category_rate+$premium_rate);
echo $sub_total_cost1=($get_tot_space_cost+$category_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*18)/100;
echo $govt_service_tax1=$govt_service_tax."#";

$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="selectArea"){
$section=$_POST['section'];
$option=$_POST['option'];
$selected_area=$_POST['selected_area'];
if($option=="Same area but different location as of previous year Signature")
{
	$sql="select * from signature_area_master where area='$selected_area'";	
}
else if($section=="signature_club" && $option=="More area than previous year Signature")
{
	$sql="select * from signature_area_master where area in ('24','36','48') and area>$selected_area";	
}
else if($section=="signature_club" && $option=="Less area as previous year")
{
	$sql="select * from signature_area_master where area in ('24','36','48') and area<$selected_area";	
}
else if($option=="Less area as previous year" && $section!="signature_club")
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$selected_area";
}
else if($option=="More area than previous year Signature" && $section!="signature_club")
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area>$selected_area";
}
else if($option=="New participant" && $section=="signature_club")
{
	$sql="select * from signature_area_master where area in ('24','36','48')";
}
else
{
	$sql="select * from signature_area_master where area in ('9','18','27','36','45','54')";
}


$query=$conn->query($sql);
$num=$query->num_rows;
if($num>0){
while($result=$query->fetch_assoc()){
?>
<option value="<?php echo $result['area'];?>"><?php echo $result['area'];?></option>
<?php }}}?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getPremiumType"){
	$selected_area=$_POST['selected_area'];
	
	if($selected_area=='9' || $selected_area=='18')
		echo $sql1="select * from signature_scheme_master where status='Y'";
	else
		echo $sql1="select * from signature_scheme_master where scheme='BI2'";
		
	$query1=$conn->query($sql1);
	$num1=$query1->num_rows;
	if($num1>0){
//	echo "<option selected='selected' value=''>--- Select Scheme Type ---</option>";
	while($result1=$query1->fetch_assoc()){
	?>
	<option value="<?php echo $result1['scheme'];?>"><?php echo $result1['scheme_desc'];?></option>
<?php }} echo "#";?>

<?php 
	if($selected_area>=36)
		$sql="select * from  signature_premium_master order by premium_id asc";
	else 
		$sql="select * from  signature_premium_master where status='Y' order by premium_id asc";
		
	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	echo "<option selected='selected' value=''>-----Select Premium Type----</option>";
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['premium'];?>"><?php echo $result['premium_desc'];?></option>
<?php }}} ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
	//echo '<pre>'; print_r($_POST);
$option=$_POST['option'];
$section=$_POST['section'];
$signature_selected_scheme_type=$_POST['signature_selected_scheme_type'];
$lastYearArea=$_POST['lastYearArea'];  

	if($option=="Same stall position size as of previous year")
	{
		$sql="select * from signature_area_master where 1";	
	}
	elseif($option=="Same area but different location as of previous year Signature")
	{
		$sql="select * from signature_area_master where 1";	
	}
	else if($section=="signature_club" && $option=="More area than previous year Signature")
	{
		$sql="select * from signature_area_master where area in ('12','24','36','48') and area>$lastYearArea";	
	}
	else if($section=="signature_club" && $option=="Less area as previous year")
	{
		$sql="select * from signature_area_master where area in ('12','24','36','48') and area<$lastYearArea";	
	}
	else if($option=="Less area as previous year" && $section!="signature_club")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$lastYearArea";
	}
	else if($option=="More area than previous year Signature" && $section!="signature_club")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area>$lastYearArea";
	}
	else if($option=="Less area as previous year")
	{
		$sql="select * from signature_area_master where area in ('9','18','27','36','45','54') and area<$lastYearArea";
	}
	//echo $sql;
	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	echo "<option value=''>--Select Area--</option>";
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}
	$sql1="SELECT * FROM  signature_scheme_master where status='Y'";	
	$query1=$conn->query($sql1);
//	$scheme.="<option value=''>--Select Scheme--</option>";
	while($result1=$query1->fetch_assoc())
	{
		if($result1['scheme']==$signature_selected_scheme_type)
			$scheme.="<option value=".$signature_selected_scheme_type." selected='selected'>".$result1['scheme_desc']."</option>";
		else
			$scheme.="<option value=".$result1['scheme'].">".$result1['scheme_desc']."</option>";
	}
	echo "#".$scheme."#";

} ?>