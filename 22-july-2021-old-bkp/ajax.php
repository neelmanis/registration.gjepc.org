<?php 
session_start();
include ("db.inc.php");
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getCity"){
$country=$_POST['country'];
$query=$conn->query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IND" || $country=="IN")
{ ?>
	  <!--<label>State / Province : <sup>*</sup></label>-->
	  <select name="state" id="state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
	<br />
      <span id="error_first_name"></span>
<?php } else {?>
<!--<label>State / Province : <sup>*</sup></label>-->
<input type="text" class="textField" id="state" name="state" />
<br />
    <span id="error_first_name"></span>
<?php } ?>
<?php } ?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkregisuser"){
    $email_id=$_POST['email_id'];
    $query=$conn->query("select * from registration_master where email_id='$email_id' and status=1");
    $num=$query->num_rows;
	if($num>0){	
   	 echo 0;
    } else
   	echo 1;
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkpan"){
    $company_pan_no=$_POST['company_pan_no'];
    $query=$conn->query("select * from registration_master where company_pan_no='$company_pan_no'");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkgstin"){
    $company_gstn = trim($_POST['company_gstn']);
    $query=$conn->query("select * from registration_master where company_gstn='$company_gstn'");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkRegistrationMobileNO"){
    $mobile_no = $_POST['mobile_no'];
    $query=$conn->query("select * from registration_master where mobile_no='$mobile_no'");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>

<?php
function getVisitorDesignationID($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
	return $row['type_of_designation'];
}

function getCompanyName($id,$conn)
{
	$query_sel = "SELECT company_name FROM  registration_master  where id='$id'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
		return $row['company_name'];
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="Check_badge"){
    $badge_id=$_POST['badge_id'];
    $query=$conn->query("select * from visitor_directory where badge_id='$badge_id' limit 1");
    $num=$query->num_rows;
	$result=$query->fetch_assoc();
	$visitor_id = $result['visitor_id'];
	if($visitor_id!=''){
	$sqlx = "SELECT * FROM  `visitor_order_history` WHERE  `registration_id` ='".$result['registration_id']."' AND visitor_id='$visitor_id'";
	$resultx = $conn->query($sqlx);
	$countx = $resultx->num_rows;
	}
	
	if($num>0)
	{
?>
    <div class="badge">
    <div>
      <div class="batchHead">
        <div class="floatLeft">Badge Status</div>
        <div class="floatRight"><img src="images/logo.png"></div>
        <div class="clear"></div>
      </div>
      <div class="personName fieldNew">Person Name : <strong><?php echo $result['name'];?></strong> <span>(<?php echo getVisitorDesignationID($result['designation'],$conn);?>)</span></div>
      <div class="companyName fieldNew">Company Name : <strong><?php echo getCompanyName($result['registration_id'],$conn);?></strong></div>
      <div class="batchId fieldNew">BADGE ID : <strong><?php if($result['badge_id']!=""){echo $result['badge_id'];}?></strong></div>
	<div class="batchId fieldNew">Status : <strong><?php if($result['combo']=="Y" || $countx>0){echo "Active For Signature 2019 you can visit the show";}else {echo "Deactivated";}?></strong>
      <?php if($result['combo']=="N"){?> <a href="login.php"> (Click here) </a><?php }?>to register and active for IIJS Signature 2019.
      </div>
      <div class="barcode"> <img src="images/barcode.jpg" alt=""></div>
    </div>
    </div>
<?php } 
	else
	{
		echo "<span style='color:#FF0000'>Invalid badge id </span>"; 
	}
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getState"){
$country=$_POST['country'];
$query=$conn->query("SELECT * from state_master WHERE country_code = '$country'");
if($country=="IN"){
?>
	  <select name="applicant_state" id="applicant_state" class="textField">
      <option value="">--Select State--</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
      <?php }?>
      </select>
<?php } else {?>
<input type="text" class="textField" id="applicant_state" name="applicant_state" />
<?php }?>
<?php }?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="calculatePayment"){
$member_type=$_SESSION['member_type'];
$pkg=$_SESSION['combo'];

$section=$_POST['section'];
$selected_area=$_POST['selected_area'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$category=$_POST['category'];
$selected_premium_type=$_POST['selected_premium_type'];
$woman_entrepreneurs=$_POST['woman_entrepreneurs'];

if(strtoupper($_SESSION['COUNTRY'])=="IN")
{
	if($section=='machinery')
		$selected_scheme_type="0";
	else {
		if($selected_scheme_type=="RW")
		{
			$selected_scheme_type="20900";
		}
		else if($selected_scheme_type=="BI1")
		{
			$selected_scheme_type="25900";
		}
		else if($selected_scheme_type=="0")
		{
			$selected_scheme_type=0;
		}
	}
		
} else {
	if($section=='machinery')
		$selected_scheme_type="0";
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
	if($section=='machinery')
	{
		if($member_type=='MEMBER')
			$charge=16500;		
		elseif($member_type=='NON_MEMBER')
			$charge=17500;		
	} else
	{
	   $charge=20900;	
	}	
}
else
{
	if($section=='machinery')
	{
		$charge=325;			
	}
	else
	{
		$charge=500;
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

$premium_rate=floatval($space_rate*$selected_premium_type)/100;
echo $premium_rate1=$premium_rate."#";

$sub_total_cost=floatval($space_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate);
echo $sub_total_cost1=($space_rate+$mezzanine_space_charge+$scheme_rate+$premium_rate)."#";

$security_deposit=floatval($sub_total_cost*10)/100;
echo $security_deposit1=$security_deposit."#";

$govt_service_tax=floatval($sub_total_cost*18)/100;
echo $govt_service_tax1=$govt_service_tax."#";


$grand_total=round($sub_total_cost+$security_deposit+$govt_service_tax);
echo $grand_total1=$grand_total."#";

	if($selected_scheme_type=="20900")
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
/*if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=trim($_POST['option']);
$lastYearArea=$_POST['lastYearArea'];
	if($option=="More area than previous year IIJS")
	{
		$sql="select * from iijs_area_master where area>$lastYearArea order by area asc limit 0,2";	
	}
	else if($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location")
	{
		$sql="select * from iijs_area_master where area<$lastYearArea order by area asc";	
	}
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num>0){
	while($result=mysql_fetch_array($query)){*/
	?>
	
<?php //}}}?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getPremiumYype"){
	$selected_area=$_POST['selected_area'];
	
	if($selected_area=='6' || $selected_area=='9' || $selected_area=='18')
		echo $sql1="select * from  iijs_scheme_master where status='Y'";
	else
		echo $sql1="select * from  iijs_scheme_master 	where scheme='RW'";
		
	$query1=$conn->query($sql1);
	$num1=$query1->num_rows;
	if($num1>0){
	echo "<option selected='selected' value=''>-----Select Scheme Type----</option>";
	while($result1=$query1->fetch_assoc()){
	?>
	<option value="<?php echo $result1['scheme'];?>"><?php echo $result1['scheme_desc'];?></option>
<?php }} echo "#";?>

<?php 
	if($selected_area>=36)
		$sql="select * from  iijs_premium_master order by premium_id asc";
	else 
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
$area=array(12,16,28,36,56);
if(isset($_POST['actiontype']) && $_POST['actiontype']=="optionValue"){
$option=$_POST['option'];
$section=$_POST['section'];
$selected_scheme_type=$_POST['selected_scheme_type'];
$selected_premium_type=$_POST['selected_premium_type'];
$lastYearArea=$_POST['lastYearArea'];

	$sql="SELECT * FROM iijs_section_master where section='$section'";	
	$query=$conn->query($sql);
	while($result=$query->fetch_assoc)
	{
		if($result['section']==$section)
			$option1.="<option value=".$section." selected='selected'>".$result['section_desc']."</option>";
		else
			$option1.="<option value=".$result['section'].">".$result['section_desc']."</option>";
	}
	echo $option1;
	echo "#";
	
	echo "<option selected='selected' value=''>-----Select Area----</option>";
	if(($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location") && $section=="allied")
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
		
	}
	else if($option=="Less area as previous year" || $option=="Less area as previous year at diffrent location")
	{
		$sql="select * from iijs_area_master where area in ('9','18','27','36','45','54') and area<$lastYearArea";
	}
	else if($option=="More area than previous year IIJS" && $section=="machinery" && $lastYearArea=="9")
	{
		echo $sql="select * from iijs_area_master where area in (18,27)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="6")
	{
		$sql="select * from iijs_area_master where area in (18)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="9")
	{
		$sql="select * from iijs_area_master where area in (18)";
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
		$sql="select * from iijs_area_master where area in (27)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="27")
	{
		$sql="select * from iijs_area_master where area in (36)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="36")
	{
		$sql="select * from iijs_area_master where area in (45,54)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="45")
	{
		$sql="select * from iijs_area_master where area in (54)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="54")
	{
		$sql="select * from iijs_area_master where area in (72)";
	}
	else if($option=="More area than previous year IIJS" && $lastYearArea=="72")
	{
		$sql="select * from iijs_area_master where area in (108)";
	}
	else
	{
		$sql="select * from iijs_area_master where area=$lastYearArea";
	}
	$query=$conn ->query($sql);
	$num=$query->num_rows;
	if($num>0){
	while($result=$query->fetch_assoc()){
	?>
	<option value="<?php echo $result['area'];?>" <?php if($result['area']==$lastYearArea){?> selected="selected" <?php }?>><?php echo $result['area'];?></option>
<?php }} 

	$sql1="SELECT * FROM  iijs_scheme_master where status='Y'";	
	$query1=$conn ->query($sql1);
	$scheme.="<option value=''>--Select Scheme--</option>";
	while($result1=$query1->fetch_assoc())
	{
		if($result1['scheme']==$selected_scheme_type)
			$scheme.="<option value=".$selected_scheme_type." selected='selected'>".$result1['scheme_desc']."</option>";
		else
			$scheme.="<option value=".$result1['scheme'].">".$result1['scheme_desc']."</option>";
	}
	echo "#".$scheme."#";
	
	$sql2="SELECT * FROM  iijs_premium_master where 1";	
	$query2=$conn ->query($sql2);
	$premium.="<option value=''>--Select Premium--</option>";
	while($result2=$query2->fetch_assoc())
	{
		if($result2['premium']==$selected_premium_type)
			$premium.="<option value=".$selected_premium_type." selected='selected'>".$result2['premium_desc']."</option>";
		else
			$premium.="<option value=".$result2['premium'].">".$result2['premium_desc']."</option>";
	}
	echo $premium;
}?>

<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkmemsuser"){
    $email=$_POST['email'];
	//echo "select * from employee_directory where email='$email' and status=1";
    $query=$conn ->query("select * from employee_directory where email='$email' and status=1");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkmobile"){
    $mobile=$_POST['mobile'];
    $query=$conn ->query("select * from employee_directory where mobile='$mobile' and status=1");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkaadhar_no"){
    $aadhar_no=$_POST['aadhar_no'];
    $query=$conn ->query("select * from employee_directory where aadhar_no='$aadhar_no' and status=1");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}

if(isset($_POST['actiontype']) && $_POST['actiontype']=="chkpan_no"){
    $pan_no=$_POST['pan_no'];
    $query=$conn ->query("select * from employee_directory where pan_no='$pan_no' and status=1");
    $num=$query->num_rows;
  if($num>0)
   {	
   		echo 0;
   }
   else
   	echo 1;
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkDesignation")
{ //print_r($_SESSION); print_r($_POST); exit;
$registration_id = $_SESSION['USERID'];
$company_type = $_SESSION['company_type'];
$designation = $_POST['designation'];

// Proprietor Director
$sqlQuery = $conn ->query("SELECT * FROM `visitor_directory` WHERE registration_id='$registration_id' AND (designation='19' || designation='20')");
$getCount = $sqlQuery->num_rows;

if($designation=='Owner' && $getCount>0)
$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation' AND id!='18'";
else
$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation'";

$query = $conn->query($sqlx);
?>
<label><sup>*</sup>Designation :  </label>
<select class="select_v"  name="designation" id="designation" class="textField">
<option value="">-- Select Designation --</option>
<?php                                     
if($designation=='Owner')
{
                $sqlx = "SELECT * FROM `visitor_directory` WHERE registration_id='$registration_id' AND designation='18'";
                $resultx = $conn ->query($sqlx);
                $num = $resultx->num_rows;
                if($num>0)
                {
                                echo 'Already Exist';
                } else {
                                while($result=$query->fetch_assoc()){ ?>
                                <option value="<?php echo $result['id'];?>" <?php if($designation==$result['id']){?> selected="selected"<?php }?>><?php echo $result['type_of_designation'];?></option>
                                <?php }
                }
} else {
while($result=$query->fetch_assoc()){ ?>
                                <option value="<?php echo $result['id'];?>" <?php if($designation==$result['id']){?> selected="selected"<?php }?>><?php echo $result['type_of_designation'];?></option>
<?php } ?>                            
<?php } ?>
</select>
<?php
}
?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="checkDesignationSingleVisitor")
{ //print_r($_SESSION); print_r($_POST); exit;
$registration_id = $_SESSION['registration_id'];
$company_type = $_SESSION['company_type'];
 $designation = $_POST['designation'];

$sqlx= "SELECT * FROM `visitor_designation_master` WHERE type='$designation'";
$query = $conn->query($sqlx);
?>

<select class="select-control"  name="designation" id="designation" class="textField">
<option value="">-- Select Designation --</option>
<?php                                     
if($designation=='Owner')
{
                $sqlx = "SELECT * FROM `visitor_directory` WHERE registration_id='$registration_id' AND designation='18'";
                $resultx = $conn->query($sqlx);
                $num = $resultx->num_rows;
                if($num>0){ ?>
                         <option value="">Owner Added already Please Choose Employee</option>        
                <?php } else {
                                while($result=$query->fetch_assoc()){ ?>
                                <option value="<?php echo $result['id'];?>" <?php if($designation==$result['id']){?> selected="selected"<?php }?>><?php echo $result['type_of_designation'];?></option>
                                <?php }
                }
} else {
while($result=$query->fetch_assoc()){ ?>
                                <option value="<?php echo $result['id'];?>" <?php if($designation==$result['id']){?> selected="selected"<?php }?>><?php echo $result['type_of_designation'];?></option>
<?php } ?>                            
<?php } ?>
</select>
<?php
}
?>
<?php 
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getTaxation"){
$country = trim($_POST['country']);
$query=$conn->query("SELECT * from taxation_master WHERE country_code = '$country'");
?>
      <select name="taxation_code" id="taxation_code" class="textField">
      <option value="">-- Select Taxation Detail --</option>
      <?php while($result=$query->fetch_assoc()){?>
      <option value="<?php echo $result['taxation_code'];?>"><?php echo $result['taxation_description'];?></option>
      <?php }?>
      </select>

<?php } ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getVirtualPkg"){
	$event = trim($_POST['event']);
	if($event!=''){
	$sql1="SELECT * FROM virtual_event_master where event='$event' AND status='Y'";		
	$query1=$conn->query($sql1);
	$num1=$query1->num_rows;
	if($num1>0){
	echo "<option selected='selected' value=''> Additional Images Required </option>";
	while($result1=$query1->fetch_assoc()){
	if($event=="standard"){	?>
	<option value="0">0</option>
	<option value="100">100</option>
	<?php } else if($event=="premium"){ ?>
	<option value="0">0</option>
	<option value="100">100</option>
	<option value="200">200</option>
	<?php }	else if($event=="spremium"){ ?>
	<option value="0">0</option>
	<option value="100">100</option>
	<option value="200">200</option>
	<option value="300">300</option>
	<?php }	?>
<?php }} } echo "#"; ?>

<?php 
	if($event!=''){
	echo "<option selected='selected' value=''> Additional Meeting Room Required </option>";
	if($event=="standard"){	?>
	<option value="0">0</option>
	<option value="1">1</option>
	<?php } else if($event=="premium"){ ?>
	<option value="0">0</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<?php }	else if($event=="spremium"){ ?>
	<option value="0">0</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<?php } ?>
<?php }
	} ?>

<?php
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getcalculation")
{
	$member_type = strtoupper($_SESSION['member_type']);
	$msme_ssi_status = trim($_SESSION['msme_ssi_status']);
	
	$event = trim($_POST['event']);
	$selected_image_type   = trim($_POST['selected_image_type']);
	$selected_meeting_type = trim($_POST['selected_meeting_type']);
	$category = trim($_POST['category']);
	
  
if($event!='' && $selected_image_type!='' && $selected_meeting_type!=''){

if($category=="Machinery_Allied_Section"){
	if($event=="standard")
	{	
		if($member_type=="MEMBER"){ $event_rate=40000; } else { $event_rate=45000; }
	}
	else if($event=="premium")
	{
		if($member_type=="MEMBER"){ $event_rate=85000; } else { $event_rate=90000; }
	}
	else if($event=="spremium")
	{
		if($member_type=="MEMBER"){ $event_rate=125000; } else { $event_rate=130000; }
	}
}	else {
	
	if($event=="standard")
	{	
		if($_SESSION['msme_ssi_status']=="Yes"){ $event_rate=40000; } else { $event_rate=45000; }
	}
	else if($event=="premium")
	{
		$event_rate=85000;
	}
	else if($event=="spremium")
	{
		$event_rate=125000;
	}
}

if($selected_image_type==0)
{	
	$image_rate=0; 
}
else if($selected_image_type==100)
{	
	$image_rate=5000; 
}
elseif($selected_image_type==200)
{	
	$image_rate=10000; 
}
elseif($selected_image_type==300)
{	
	$image_rate=15000; 
}

if($selected_meeting_type!='')
{	
	$meeting_rate=intval(10000*$selected_meeting_type); 
}
echo $event_charge = $event_rate."#";
echo $image_charge = $image_rate."#";
echo $meeting_charge = $meeting_rate."#";
$sub_total_cost = floatval($event_rate+$image_rate+$meeting_rate);
echo $sub_total_cost1 = $sub_total_cost."#";
$gst = floatval($sub_total_cost*18)/100;
echo $gst_total = $gst."#";
$grand_totals = round($sub_total_cost+$gst);
echo $grand_total = $grand_totals."#";

}
}
?>	
