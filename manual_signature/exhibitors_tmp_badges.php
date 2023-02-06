<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php"); exit; }
?>
<?php 
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
if(($_REQUEST['action']=='del') && ($_REQUEST['Badge_Item_ID']!=''))
{
	/*.............................Get Payment ID......................................*/
	$Badge_Item_ID = $_REQUEST['Badge_Item_ID'];
	$del = $conn ->query("delete from iijs_badge_items_tmp where Badge_Item_ID='$Badge_Item_ID'");
	echo "<meta http-equiv=refresh content=\"0;url=exhibitors_tmp_badges.php\">";
}
?>
<?php
$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];

$Exhibitor_StallNo[]="";

for($i=0;$i<8;$i++){
	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
}

$stall_no=implode(", ",$Exhibitor_StallNo);

$Exhibitor_HallNo=$fetch_data['Exhibitor_HallNo'];
$Exhibitor_Region=$fetch_data['Exhibitor_Region'];
$Exhibitor_Section=$fetch_data['Exhibitor_Section'];
$Exhibitor_Category=$fetch_data['Exhibitor_Category'];
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];

$Exhibitor_Address1=$fetch_data['Exhibitor_Address1'];
$Exhibitor_Address2=$fetch_data['Exhibitor_Address2'];
$Exhibitor_Address3=$fetch_data['Exhibitor_Address3'];

$Exhibitor_Email=$fetch_data['Exhibitor_Email'];
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Signature</title>

<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<script type="text/javascript" src="../js/jquery_002.js"></script>
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/badges.js"></script>
<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    padding: 7.5px 30px;
	margin-left: 10px;
	color:#fff;
    background-color: #924b77;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 600px;
    background-color: #924b77;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 250%;
    right: 0%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -18%;
    left: 93%;
    margin-left: -60px;
    border-width: 50px;
    border-style: solid;
    border-color: #924b77 transparent transparent transparent;
	transform: rotate(180deg);
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

#formWrapper{width:100%;}
#formWrapper > h3{float:left;}
.tooltip{float:right;}

#formWrapper .spanbox{
        padding: 8px 15px;
    background-color: #924b77;
    color: #fff;
}
</style>

<script type="text/javascript">
    $(function () {
		$("#tds_tax").live('change',function(){
			var tds_tax=$('#tds_tax').val();
			var Payment_Master_Amount=$('#Payment_Master_Amount').val();
			var Payment_Master_AmountPaid = $('#Payment_Master_AmountPaid').val();
			var tds_amount = Payment_Master_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = Payment_Master_AmountPaid-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);
		});
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){	
			var tds_tax=$('#tds_tax').val();
			var Payment_Master_Amount=$('#Payment_Master_Amount').val();
			var Payment_Master_AmountPaid = $('#Payment_Master_AmountPaid').val();
			var tds_amount = Payment_Master_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = Payment_Master_AmountPaid-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);		
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("input:radio[name=Badge_Type]").change(function(){
	var Badge_Type = $("input[name='Badge_Type']:checked"). val();
	
	if(Badge_Type=="R")
		$("#replaceBadge").show();
	else
		$("#replaceBadge").hide();
	});	
});
</script>
</head>

<body>
<!-- header starts -->

<div class="header_wrap"><?php include ('header.php'); ?></div>
<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>
<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<!--<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>
<p>
<u>Exhibitor Additional Badge:</u> - Every exhibitor will be allotted Additional Badge as per available quota at an Additional cost of 1500 per badge.
</p>
</li>
<li>Exhibitor/Additional badge can not be availed after the deadline</li>
</ol>
</span>
</div>-->

<!--<span style="float:right;margin-left: 10px;" class="spanbox"><a href="images/pdf/Exhibitor_Badges_Terms_Conditions_IIJS_Signature_2020.pdf" target="_blank" style="color:#FFF;">Exhibitor Badges Terms & Condition</a></span>-->
<span style="float:right;margin-left: 10px;" class="spanbox">Deadline without surcharge : <?php echo getFormDeadLine(1,$conn);?></span>
<!--<span style="float:right;margin-left: 10px;" class="spanbox">Deadline with surcharge: 10th February 2021</span>-->


<div class="clear"></div>
<div class="title">
<h4>Exhibitor Information</h4></div>

<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold">Exhibitor Name</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Name;?></td>
    <td width="50">&nbsp;</td>
    <td class="bold">Contact Person</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Contact_Person;?></td>
  </tr>
  <tr>
    <td class="bold">Stall No(s)</td>
    <td>:</td>
    <td><?php echo $stall_no;?></td>
    <td>&nbsp;</td>
    <td class="bold">Hall No</td>
    <td>:</td>
    <td><?php echo $Exhibitor_HallNo;?></td>
  </tr>
  <tr>
    <td class="bold">Zone</td>
    <td>:</td>
    <td><?php echo $Exhibitor_DivisionNo; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Region</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Region;?></td>
  </tr>
  <tr>
    <td class="bold">Section</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
  <tr>
    <td class="bold">Scheme</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Scheme; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Premium</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Premium; ?></td>
  </tr>
</table>

<?php 
/*..........................Get Maximum Car Available....................................*/
$query = $conn ->query("select * from iijs_carpass_master where CarPass_Area='$Exhibitor_Area'");
$result= $query->fetch_assoc();
$CarPass_AvailablePasses=$result['CarPass_AvailablePasses'];

/*..........................Get Car Passess Taken....................................*/
$num_avail_car=0;
$num_taken_car=0;
$query1 = $conn ->query("select * from iijs_badge_address where Exhibitor_Code='$exhibitor_code'");
$result1 = $query1->fetch_assoc();;
$num1 = $query1->num_rows;
if($num1>0){
	$CarPass1=$result1['CarPass1'];
	$CarPass2=$result1['CarPass2'];
	$_SESSION['Badge_Addres']=$result1['BadgeAddres'];
	$_SESSION['Badge_Country']=$result1['BadgeCountry'];
	$_SESSION['Badge_City']=$result1['BadgeCity'];
	$_SESSION['Badge_Pincode']=$result1['BadgePincode'];
	$_SESSION['Badge_State']=$result1['BadgeState'];
	$_SESSION['Badge_Mobile']=$result1['BadgeMobile'];
}
?>

<div class="clear"></div> 

<form id="badgeForm" name="badgeForm" method="post" enctype="multipart/form-data" action='addbadges_ajax.php'> 
<!--
<div class="title"><h4>Badges Delivery Address</h4></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td>Address<sup>*</sup></td>
    <td width="250"><textarea name="Badge_Addres" id="Badge_Addres" class="textField" rows="5" cols="25" ><?php echo $_SESSION['Badge_Addres'];?></textarea></td>
    <td>Country<sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Country" id="Badge_Country" class="textField"  value="<?php echo $_SESSION['Badge_Country'];?>" /></td>
   </tr>
   <tr>
    <td>City <sup>*</sup></td>
    <td width="250"><input type="text" name="Badge_City" id="Badge_City" class="textField" value="<?php echo $_SESSION['Badge_City'];?>"/></td>
    <td>Pincode <sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Pincode" id="Badge_Pincode" class="textField" value="<?php echo $_SESSION['Badge_Pincode'];?>" /></td>
   </tr>
   <tr>
    <td>State <sup>*</sup></td>
    <td width="250"><input type="text" name="Badge_State" id="Badge_State" class="textField" value="<?php echo $_SESSION['Badge_State'];?>" /></td>
    <td>Mobile <sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $_SESSION['Badge_Mobile'];?>" /></td>
   </tr>
</table>
<div class="clear"></div>
-->
<div class="title"><h4>Car Pass</h4></div>
<div class="clear"></div>
<!--
<table border="0" cellspacing="0" cellpadding="0" width="50%" class="formManual">
 <tr>
    <th>No. of Booths</th>
	<th>Area (in Sq.mts)</th>
    <th colspan="2">No. of Car Sticker</th>
   </tr>
  <tr>
    <td width="40%" class="bold">1-2</td>
    <td width="40%" class="bold">9-18 Sq.mts </td>
    <td width="4%">:</td>
    <td width="18%">1</td>    
  </tr>
 <tr>
    <td width="40%" class="bold">3-6</td>
    <td width="40%" class="bold">27-54 Sq.mts (Normal)</td>
    <td width="4%">:</td>
    <td width="18%">2</td>    
  </tr>
  <tr>
    <td width="40%" class="bold">2-4</td>
    <td width="40%" class="bold">24 Sq.mts (Signature Club) - 48 Sq.mts (Signature Club)</td>
    <td width="4%">:</td>
    <td width="18%">2</td>    
  </tr>  
 </table>
-->
<div class="title"><h4>Badges Information</h4></div>
<div class="clear"></div>
<?php 
if($Exhibitor_Section=="signature_club")
	$sql="select * from iijs_badge_master where Stall_Area='$Exhibitor_Area' and isDuplex='S'";
else
	$sql="select * from iijs_badge_master where Stall_Area='$Exhibitor_Area'";
	
$query = $conn ->query($sql);
$result= $query->fetch_assoc();
$Exhibitor_Badges_avail=$result['Exhibitor_Badges'];
$Service_Badges_avail=$result['Service_Badges'];
$Management_Badges_avail=$result['Management_Badges'];
$Replacement_Badges_avail=$result['Replace_Badges'];

/*..........................Get Maximum Badges Taken...................................*/

	/*..............................Exhibitor Total..............................*/
	$Badge_ID=$result['Badge_ID'];
	
	$Equery=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$Enum_temp = $Equery->num_rows;
	$Equery2=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$Enum_live = $Equery2->num_rows;
	$Enum=$Enum_temp+$Enum_live;
	
	/*..............................Temp Badge Total..............................*/
	$Squery=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$Snum_temp = $Squery->num_rows; 
	
	$Squery=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$Snum_live = $Squery->num_rows; 
	$Snum=$Snum_temp+$Snum_live;
	
	/*..............................Additional Total..............................*/
	$Mquery=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$Mnum_temp = $Mquery->num_rows; 
	
	$Mquery2=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$Mnum_live = $Mquery2->num_rows; 
	$Mnum=$Mnum_temp+$Mnum_live;
	
	/*..............................Replacement Badge Total..............................*/
	$Rquery=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
	$Rnum_temp = $Rquery->num_rows; 
	
	$Rquery2=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
	$Rnum_live = $Rquery2->num_rows; 
	$Rnum=$Rnum_temp+$Rnum_live;
	
	if($Enum!=0){$Exhibitor_Badges_taken=$Enum;}else{$Exhibitor_Badges_taken=0;}
	if($Snum!=0){$Service_Badges_taken=$Snum;}else{$Service_Badges_taken=0;}
	if($Mnum!=0){$Management_Badges_taken=$Mnum;} else{$Management_Badges_taken=0;}
	if($Rnum!=0){$Rplacement_Badges_taken=$Rnum;} else{$Rplacement_Badges_taken=0;}
?>

<?php 
if($Exhibitor_Badges_avail<=$Exhibitor_Badges_taken)
	$check_exhibitor="1";
else
	$check_exhibitor="0";
	
if($Management_Badges_avail<=$Management_Badges_taken)
	$check_management="1";
else
	$check_management="0";

if($Service_Badges_avail<=$Service_Badges_taken)
	$check_service="1";
else
	$check_service="0";

if($Replacement_Badges_avail<=$Rplacement_Badges_taken)
	$check_replacement="1";
else
	$check_replacement="0";
?>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="40%" class="bold">Maximum Exhibitor Badges Available</td>
    <td width="4%">:</td>
    <td width="18%"><?php echo $Exhibitor_Badges_avail;?></td>
    <td width="3%">&nbsp;</td>
    <td width="27%" class="bold">Badges Taken</td>
    <td width="3%">:</td>
    <td width="5%"><?php echo $Exhibitor_Badges_taken;?></td>
  </tr>

  <tr>
    <td class="bold">Maximum Service Badges Available</td>
    <td>:</td>
    <td><?php echo $Service_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Service_Badges_taken;?></td>
  </tr>
    <!--
  <tr>
    <td class="bold">Maximum Additional Available</td>
    <td>:</td>
    <td><?php echo $Management_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Management_Badges_taken;?></td>
  </tr>
  -->
  <tr>
    <td class="bold">Maximum Replacement Badges Available</td>
    <td>:</td>
    <td><?php echo $Replacement_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Rplacement_Badges_taken;?></td>
  </tr>
</table>

<div class="title"><h4>Exhibitor Badges Details</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>  
    <th align="left">Action</th>  
   </tr>
   <?php 
	/*...................Exhibitor Badges Taken.........................*/
	$query = $conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$E_num =  $query->num_rows;
	$i=1;
	$Surcharge=0;
	while($result = $query->fetch_assoc()){
	$Surcharge=$Surcharge+intval($result['Surcharge']);
   ?>
   <tr>
	<td align="left"><?php echo $result['post_date'];?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td> 
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a></td>  
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a></td>
    <td align="left"><a href="exhibitors_tmp_badges.php?action=del&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a></td>  
   </tr>
  <?php $i++;}?>
  <input type="hidden" name="Exhibitor_badge_count" id="Exhibitor_badge_count" value="<?php echo $i;?>"/>
  <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
</table>


<div class="title"><h4>Service Badges Details</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>  
    <th align="left">Action</th>  
   </tr>
   <?php 
	/*...................Temp Badges Taken.........................*/
	$query = $conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$E_num =  $query->num_rows;
	$j=1;
	$service_charge=0;
	while($result = $query->fetch_assoc()){
	//$service_charge=$service_charge+intval(500);
   ?>
   <tr>
	<td align="left"><?php echo $result['post_date'];?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td> 
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a></td>  
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a></td>
    <td align="left"><a href="exhibitors_tmp_badges.php?action=del&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a></td>  
   </tr>
  <?php $j++;}?>
  <input type="hidden" name="Service_badge_count" id="Service_badge_count" value="<?php echo $j;?>"/>
  <input type="hidden" name="Service_Badges_avail" id="Service_Badges_avail" value="<?php echo $Service_Badges_avail;?>"/>
</table>
<!--
<div class="title"><h4>Additional Badges Taken</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>
    <th align="left">Charges Applicable</th>
    <th align="left">Action</th>
   </tr>
   <?php 
	/*...................Additional Badges Taken.........................*/
	$query = $conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$M_num =  $query->num_rows;
	$k=1;
	$mangmnt_charge=0;
	while($result = $query->fetch_assoc()){
		$mangmnt_charge=$mangmnt_charge+intval(1500);
   ?>
   <tr>
	<td align="left"><?php echo $result['post_date'];?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td>
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a></td>  
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a></td>
    <td>1500</td>
    <td align="left"><a href="exhibitors_tmp_badges.php?action=del&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a></td>
    
   </tr>
  <?php $k++;}?>
  <input type="hidden" name="Management_badge_count" id="Management_badge_count" value="<?php echo $k;?>"/>
  <input type="hidden" name="Management_Badges_avail" id="Management_Badges_avail" value="<?php echo $Management_Badges_avail;?>"/>
</table>
-->
<div class="title"><h4>Replaced Badges Details</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>  
    <th align="left">Action</th>  
   </tr>
   <?php 
	/*...................Replaced Badges Taken.........................*/
	$query = $conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
	$R_num = $query->num_rows;
	$l=1;
	$replace_charges=0;
	while($result = $query->fetch_assoc()){
	$replace_charges=$replace_charges+intval($result['Surcharge']);
   ?>
   <tr>
	<td align="left"><?php echo $result['post_date'];?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td> 
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a></td>  
    <td align="left"><a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a></td>
    <td align="left"><a href="exhibitors_tmp_badges.php?action=del&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a></td>  
   </tr>
  <?php $l++;}?>
 <input type="hidden" name="Replaced_badge_count" id="Replaced_badge_count" value="<?php echo $l;?>"/>
 <input type="hidden" name="Replacement_Badges_avail" id="Replacement_Badges_avail" value="<?php echo $Replacement_Badges_avail;?>"/>
</table>
<p>Exhibitor/Additional badge can not be availed after the deadline</p>
<div class="title"><h4>New Badge Details</h4></div>
<div class="loader" style="display:none">Loading....</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:100%"> 
  <tr>
    <td width="35">
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="check_exhibitor" id="check_exhibitor" value="<?php echo $check_exhibitor;?>"/>
    <input type="hidden" name="check_management" id="check_management" value="<?php echo $check_management;?>"/>
    <input type="hidden" name="check_replacement" id="check_replacement" value="<?php echo $check_replacement;?>"/>
	<?php //if($_SESSION['auth']=="admin"){?>
	<input type="radio" name="Badge_Type" id="Badge_Type" value="E" />
	</td>
    <td width="189">Exhibitor Badge</td>
	<?php //}?>
    <!--<td width="20"><input type="radio" name="Badge_Type" id="Badge_Type3" value="S" /></td>
    <td width="125">Temporary Badge</td>
    <td width="20"><input type="radio" name="Badge_Type" id="Badge_Type2" value="M" /></td>
    <td width="125">Additional Badge</td>-->
    <td><input type="radio" name="Badge_Type" id="Badge_Type1" value="R"/></td>
    <td width="300">Replace Badge</td>
    </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
      <tbody id="replaceBadge" style="display:none;">
        <td width="100">Select Name To Replace</td>
        <td width="100">
        <select name="RBadge_Item_ID" id="RBadge_Item_ID" class="textField">
        <option value="">--Select Badge To Replace--</option>
        <?php 
			$qreplace=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code'");
			while($rreplace=$qreplace->fetch_assoc()){
        ?>
            <option value="<?php echo $rreplace['Badge_Item_ID'];?>"><?php echo $rreplace['Badge_Name'];?></option>
         <?php }?>
        </select>
       </td>
       </tbody>
    <td>Name :<sup>*</sup></td>
    <td width="250"><input type="text" name="Badge_Name" id="Badge_Name" class="textField" /></td>
    <td>Designation :<sup>*</sup></td>
    <td width="100">
    <select name="Badge_Designation" id="Badge_Designation" class="textField">
        <option value="">--Select Designation--</option>
        <option value="Chairman">Chairman</option>
        <option value="CEO">CEO</option>
        <option value="Managing Director">Managing Director</option>
        <option value="Partner">Partner</option>
        <option value="Director">Director</option>
        <option value="Proprietor">Proprieter</option>
        <option value="Marketing">Marketing</option>
        <option value="Sales">Sales</option>
        <option value="Finance">Finance</option>
        <option value="Purchase">Purchase</option>
        <option value="Staff">Staff</option>
        <option value="Hostess">Hostess</option>
    </select>
    </td>
    <td>Mobile No :<sup>*</sup></td>
    <td width="100"><input type="number" name="Badge_Mobile_No" id="Badge_Mobile_No" class="textField" maxlength="10" /></td>
    </tr>
    <tr>
    <td>Photo :<sup>*</sup></td>
    <td>    
      <input type="file" name="photoimg" id="photoimg" class="textField" />
    </td>
    <td>Document :<sup>*</sup></td>
    <td>    
         <input type="file" name="document" id="document" class="textField" />
    </td>
	<?php if($_REQUEST['auth']=="admin"){?><?php }?>
    <td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>
	
    <td>&nbsp;</td>
    </tr>
</table>
</form>
<b><p>Documents to be uploaded for exhibitor badges mentioned below</p></b>
<b>1) For Proprietor / Partners / Directors </b>
<p>RCMC certificate / GST certificate / IEC Copy</p>
<b>2) For Direct Employees (On companies payroll)</b>
<p>Letter from the Partner/Proprietor/Director of the Company on the letterhead stamped and signed
</br>OR</br>
CA Certificate </br>OR</br>
Salary Slip of each staff</p>
<b>3) For Indirect Employees (Karigars, Babus, Hostesses etc)</b>
<p>Letter from the Partner/Proprietor/Director of the Company on the letterhead, duly stamped & signed as per quota</p>


<form action="badges_payment_thankyou.php" method="POST" onsubmit="return validate()">
<div class="title"><h4>Collection Mode</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td width="20"><input type="radio" name="Collection_Mode" id="Collection_Mode" value="C" checked="checked" /></td>
    <td>Courier </td>
    </tr>
</table>
<div class="title"><h4>Payment Information</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
	<td class="bold"><p>Surcharge</p></td>
    <td>:</td>
    <td><?php echo $Surcharge;?></td>
    <td>&nbsp;</td>
  </tr>
  <!--
  <tr>
	<td class="bold"><p>Temporary Badges Charges </p></td>
    <td>:</td>
    <td><?php echo $service_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td class="bold"><p>Additional badge charges</p></td>
    <td>:</td>
    <td><?php echo $mangmnt_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  -->
  <tr>
	<td class="bold"><p>Replacement badge charges</p></td>
    <td>:</td>
    <td><?php echo $replace_charges;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Amount </strong></td>
    <td>:</td>
    <td><?php echo $total_amount= $Surcharge+$service_charge+$mangmnt_charge+$replace_charges;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $total_amount;?>"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$total_amount*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Grand Total</td>
    <td>:</td>
    <td><?php echo $grand_payble=round($total_amount+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_payble;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">TDS</td>
    <td>:</td>
	<td><select class="textField" name="tds_tax" id="tds_tax">
		<option value="0">0% </option>
		<option value="2">2% </option>
		<option value="10">10%</option>
		</select>
	</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td class="bold">TDS Amount</td>
    <td>:</td>
    <td><input name="tds_amount" id="tds_amount" type="text" class="textField" readonly/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Net Payable</td>
    <td>:</td>
    <td><input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" readonly></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1"/> 

<div>
	<!--<input name="input2" type="button" value="Print Acknowledgement" class="maroon_btn" />-->
    
    <?php 
	if($Enum==0 && $Snum==0 && $Mnum==0 && $Rnum==0){ ?>
		<a href="manual_list.php" class="button5">Back To Form</a>
	<?php }else if($Exhibitor_Section=="International Jewellery" || $Exhibitor_Section=="International Loose"){ ?>
			<!--<input name="badge_final" id="badge_final" type="button" value="Submit" class="maroon_btn"/>-->
     <?php } else if($grand_payble>0){ ?>
            <input name="" id="" type="Submit" value="Submit" class="maroon_btn"/>
     <?php } else { ?> 
     		<input name="badge_final" id="badge_final" type="button" value="Submit" class="maroon_btn"/>
     <?php } ?>
     <?php if($_REQUEST['action']=="admin"){ ?>
     	<input name="badge_final" id="badge_final" type="button" value="Submit" class="maroon_btn"/>
       <?php }?>
       
	<!--<input name="input" type="button" value="Reset" class="maroon_btn" />
	<input name="input3" type="button" value="Cancel" class="maroon_btn" />-->
</div>
</div>
<div class="clear">	
</div>
</form>

</div>
</div>

<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>