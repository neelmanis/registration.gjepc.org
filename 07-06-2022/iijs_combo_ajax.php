<?php 
session_start();
include ("db.inc.php");
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$member_type = $_SESSION['member_type'];
//$membership_certificate_type = trim($_SESSION['membership_certificate_type']);
//$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
//$pkg=$_SESSION['combo'];

$section=$_POST['section'];
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$category=$_POST['category'];
$selected_premium_type = $_POST['selected_premium_type'];
$last_yr_participant = trim($_POST['last_yr_participant']);
$woman_entrepreneurs = $_POST['woman_entrepreneurs'];

$discount = $_POST['discount'];
$incentive = $_POST['incentive'];

if(strtoupper($_SESSION['COUNTRY'])=="IN")
{
	if($section=='machinery')
		$selected_scheme_type="22000";
	else {
		if($selected_scheme_type=="RW")
		{
			$selected_scheme_type="22000";
		}
		else if($selected_scheme_type=="BI1")
		{
			$selected_scheme_type="22000";
		}
		else if($selected_scheme_type=="0")
		{
			$selected_scheme_type=0;
		}
	}
		
} else {
	if($section=='machinery')
		$selected_scheme_type="75";
	else
	{
		if($selected_scheme_type=="RW")
		{
			$selected_scheme_type="500";
		}
		else if($selected_scheme_type=="BI1")
		{
			$selected_scheme_type="650";
		}
		else if($selected_scheme_type=="0")
		{
			$selected_scheme_type=0;
		}
	}
}
if($selected_premium_type=="normal")
{
	$selected_premium_type=0;
}
else if($selected_premium_type=="corner")
{
	$selected_premium_type=10;
}
else if($selected_premium_type=="island")
{
	$selected_premium_type=15;
}
else if($selected_premium_type=="premium")
{
	$selected_premium_type=25;
}
else if($selected_premium_type=="duplex")
{
	$selected_premium_type=50;
}

if(strtoupper($_SESSION['COUNTRY'])=="IN")
{
	if($section=='machinery' || $section=='allied')
	{
		if($member_type=='MEMBER')
			$charge=14500;		
		elseif($member_type=='NON_MEMBER')
			$charge=15000;		
	} else
	{
	   $charge=22000;	
	}	
}
else
{
	if($section=='machinery')
	{
		$charge=300;			
	}
	else
	{
		$charge=350;
	}
}

if($category=="mezzanine" && $selected_area>=36)
{
	$space_rate=intval(9*$charge);
}
else if($section=='hall_of_innovation')
{
	$space_rate=125000;
}
else if($section=='special_clusters')
{
	$space_rate=140000;
}
else
{
	$space_rate=intval($selected_area*$charge);
}

if($woman_entrepreneurs==1)
{
	$space_rate=($space_rate-$space_rate*0.25);
}

echo $space_rate1=intval($space_rate)."#";

/*
if(strtoupper($last_yr_participant)=="YES")
{
if($membership_certificate_type!=''){
	if($membership_certificate_type=='ZASSOC')
	{
		$space_rate_discount=($space_rate*0.05);
	}
	if($membership_certificate_type=='ZASSOC' && $_SESSION['msme_ssi_status']=="Yes")
	{
		$space_rate_discount=($space_rate*0.10);
	}
	if($membership_certificate_type=='ZORDIN')
	{
		$space_rate_discount=($space_rate*0.15);
	}
}
}

echo $tot_space_cost_discount=intval($space_rate_discount)."#"; // Hide for discount rate
*/
/*
if($incentive!=''){
	$incentivePer = floatval($incentive);
	$incentiveData = $space_rate1-$incentivePer*$selected_area; 
	echo $incentiveRate = intval($incentiveData)."#";
} else { echo $incentiveRate = '0'."#"; }

if($discount!=''){
	echo $discountRate = intval($discount)."#"; 
} else { echo $discountRate = '0'."#"; }


$get_tot_space_cost = $incentiveRate-$discountRate;  // Get the total difference of Space cost Rate - Discount space cost rate



if($incentiveRate==0 && $discountRate==0) {
	echo $get_tot_space_cost_rate = intval($space_rate1)."#"; 
	} else { 
	echo $get_tot_space_cost_rate = intval($get_tot_space_cost)."#"; // Hide for discount rate }
}

if($category=="mezzanine" && $selected_area>=36)
{
	$mezzanine_space_charge=intval(($selected_area-9)*9500);
	echo $mezzanine_space_charge."#";
}
else
{
	$mezzanine_space_charge=0;
	echo $mezzanine_space_charge."#";
}

if($selected_scheme_type==0)
	$scheme_rate=0;
else
	$scheme_rate=intval($selected_area*($selected_scheme_type-$charge));
	
echo $scheme_rate1=$scheme_rate."#";

//$premium_rate=floatval($get_tot_space_cost*$selected_premium_type)/100; // Hide for discount rate
$premium_rate=floatval($space_rate*$selected_premium_type)/100; 
echo $premium_rate1=$premium_rate."#";

/* $sub_total_cost=floatval($get_tot_space_cost+$mezzanine_space_charge+$scheme_rate+$premium_rate);  
echo $sub_total_cost1=($get_tot_space_cost+$mezzanine_space_charge+$scheme_rate+$premium_rate)."#"; 
 
// Hide for discount rate
*/

$sub_total_cost = floatval($space_rate);
echo $sub_total_cost1 = $sub_total_cost."#";

$security_deposit = round(floatval($sub_total_cost*10)/100);
echo $security_deposit1 = $security_deposit."#";

$govt_service_tax = round(floatval($sub_total_cost*18)/100);
echo $govt_service_tax1 = $govt_service_tax."#";


$grand_total = round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";

	if($selected_scheme_type=="22000")
	{
		$mcb_exact_charges=($selected_area/9)*1000;
		$mcb_service_charges=($mcb_exact_charges*18)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	}
	else if($selected_scheme_type=="500")
	{
		$mcb_exact_charges=($selected_area/9)*16;
		$mcb_service_charges=($mcb_exact_charges*18)/100;
		echo $mcb_charges=round($mcb_exact_charges+$mcb_service_charges);
	}
	else
	{
		echo $mcb_charges=0;
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="selectArea"){
	//print_r($_POST);
$section=$_POST['section'];
$option=$_POST['option'];
$selected_area=$_POST['selected_area'];

if($option=="New participant" && $section=="machinery")
{
	$sql="select * from iijs_area_master where 1";
} else {
	$sql="select * from iijs_area_master where 1 AND area='$selected_area'";
}
//echo $sql;
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
	
	if($selected_area=='6' || $selected_area=='9' || $selected_area=='18')
		echo $sql1="select * from  iijs_scheme_master where status='Y'";
	/*else
		echo $sql1="select * from  iijs_scheme_master 	where scheme='RW'"; */
		
	$query1=$conn->query($sql1);
	$num1=$query1->num_rows;
	if($num1>0){
	echo "<option selected='selected' value=''>-----Select Scheme Type----</option>";
	while($result1=$query1->fetch_assoc()){
	?>
	<option value="<?php echo $result1['scheme'];?>"><?php echo $result1['scheme_desc'];?></option>
<?php }} echo "#";?>

<?php 
	/*if($selected_area>=36)
		$sql="select * from  iijs_premium_master order by premium_id asc";
	else */
		$sql="select * from  iijs_premium_master where status='Y' order by premium_id asc"; 
		
	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	echo "<option selected='selected' value=''>-----Select Premium Type----</option>";
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['premium'];?>"><?php echo $result['premium_desc'];?></option>
<?php }}} ?>

<?php
//$area=array(12,16,28,36,56);
$area=array(28,36,56);
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
	//print_r($_POST);
$option=$_POST['option'];
$section=$_POST['section'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$selected_premium_type=$_POST['selected_premium_type'];
$lastYearArea=$_POST['lastYearArea'];

	$sql="SELECT * FROM iijs_section_master where section='$section'";	
	$query=$conn->query($sql);
	while($result=$query->fetch_assoc())
	{
		if($result['section']==$section)
			$option1.="<option value=".$section." selected='selected'>".$result['section_desc']."</option>";
		else
			$option1.="<option value=".$result['section'].">".$result['section_desc']."</option>";
	}
	echo $option1;
	echo "#";
	
	echo "<option selected='selected' value=''>-----Select Area----</option>";
	/*if(($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location") && $section=="allied")
	{
		$option="";
		foreach($area as $key=>$value)
		{
			if($value <= $lastYearArea)
			{
				$option.="<option value=".$value.">".$value."</option>";
			}
		}
		
		echo $option;
		return;
		
	} */
	if($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location")
	{
		$sql="select * from iijs_area_master where area in ('9','18','27','36','54','72','108') and area<$lastYearArea";
	}
	else if($option=="More area than previous year IIJS" && $section=="machinery" && $lastYearArea=="9")
	{
		 $sql="select * from iijs_area_master where area in (18,27)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="6")
	{
		$sql="select * from iijs_area_master where area in (18)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="9")
	{
		$sql="select * from iijs_area_master where area in (18,27,36,54,72,108)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="12")
	{
		$sql="select * from iijs_area_master where area in (27)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="24")
	{
		$sql="select * from iijs_area_master where area in (45)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="18")
	{
		$sql="select * from iijs_area_master where area in (27,36,54,72,108)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="27")
	{
		$sql="select * from iijs_area_master where area in (36,54,72,108)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="36")
	{
		$sql="select * from iijs_area_master where area in (54,72,108)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="45")
	{
		$sql="select * from iijs_area_master where area in (54)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="54")
	{
		$sql="select * from iijs_area_master where area in (72,108)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="72")
	{
		$sql="select * from iijs_area_master where area in (108)";
	}
	else
	{
		$sql="select * from iijs_area_master where area=$lastYearArea";
	}

	$query=$conn->query($sql);
	$num=$query->num_rows;
	if($num>0){
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }}

	$sql1="SELECT * FROM  iijs_scheme_master where status='Y'";	
	$query1=$conn->query($sql1);
	$scheme.="<option value=''>--Select Scheme--</option>";
	while($result1=$query1->fetch_assoc())
	{
		if($result1['scheme']==$selected_scheme_type)
			$scheme.="<option value=".$selected_scheme_type." selected='selected'>".$result1['scheme_desc']."</option>";
		else
			$scheme.="<option value=".$result1['scheme'].">".$result1['scheme_desc']."</option>";
	}
	echo "#".$scheme."#";
	
	$sql2="SELECT * FROM iijs_premium_master where status='Y' order by premium_id asc";	
	$query2=$conn->query($sql2);
	$premium.="<option value=''>--Select Premium--</option>";
	while($result2=$query2->fetch_assoc())
	{
		if($result2['premium']==$selected_premium_type)
			$premium.="<option value=".$selected_premium_type." selected='selected'>".$result2['premium_desc']."</option>";
		else
			$premium.="<option value=".$result2['premium'].">".$result2['premium_desc']."</option>";
	}
	echo $premium;
}
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="TRITIYACAL"){
	$selected_area=$_POST['selected_area'];
	$event_name=$_POST['event_name'];
	/*...........................event rate..............................*/
	$query=$conn->query("select rate from exh_event_master where event_values='$event_name'");
	$result=$query->fetch_assoc();
	$rate= 18000;
	echo $tot_space_cost_rate=$selected_area*$rate."#";
	echo $govt_service_tax=($tot_space_cost_rate*18/100)."#";
	echo $grand_total=$tot_space_cost_rate+$govt_service_tax;
}	
?>
<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="ROICAL"){
	$selected_area=$_POST['selected_area'];
	$event_name=$_POST['event_name'];
	/*...........................event rate..............................*/
	$query=$conn->query("select rate from exh_event_master where event_values='$event_name'");
	$result=$query->fetch_assoc();
	$rate=$result['rate'];
	echo $tot_space_cost_rate=$selected_area*$rate."#";
	echo $govt_service_tax=($tot_space_cost_rate*18/100)."#";
	echo $grand_total=$tot_space_cost_rate+$govt_service_tax;
}	
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="ROIALLOEDAREA"){
	$section=$_POST['section'];
	/*...........................get area .............................*/
	if($section=="women_entrepreneur_startup" || $section=="budding_designer_entrepreneur_startup")
		$sql="SELECT * FROM gjepclivedatabase.signature_area_master where area='6'";
	else
		$sql="SELECT * FROM gjepclivedatabase.signature_area_master where roi_status='Y' and area!='6' order by area asc ";
	
	$query=$conn->query($sql);
?>
      <select name="selected_area" id="selected_area" class="form-control">
      <option  value="">-----Select Area----</option>
      <?php while($result=$query->fetch_assoc()){?>
		<option value="<?php echo $result['area'];?>"><?php echo $result['area'];?></option>
      <?php } ?>
      </select>
<?php }	?>

