<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php"); exit;
}
?>
<?php 
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
if(($_REQUEST['action']=='del') && ($_REQUEST['order_id']!=''))
{
	/*.............................Get Payment ID......................................*/
	$Payment_Master_OrderNo=$_REQUEST['order_id'];
	$qpaymentId = $conn ->query("select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$Payment_Master_OrderNo'");
	$rpaymentId = $qpaymentId->fetch_assoc();
	$Payment_Master_ID=$rpaymentId['Payment_Master_ID'];
	
	$num = $qpaymentId->num_rows;
	if($num>0)
	{	
		$qbadgeId = $conn ->query("select Badge_ID from iijs_badge where Payment_Master_ID='$Payment_Master_ID'");
		$rbadgeId = $qbadgeId->fetch_assoc();
		$Badge_ID = $rbadgeId['Badge_ID'];
		
		$m = $conn ->query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
		$mb = $conn ->query("delete from iijs_badge where Payment_Master_ID='$Payment_Master_ID'");
		$tmp = $conn ->query("delete from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code'");	
	}
	echo "<meta http-equiv=refresh content=\"0;url=exhibitors_badges.php\">";
}

if(($_REQUEST['action']=='exhdel'))
{
	$table=$_REQUEST['table'];
	$Badge_Item_ID=$_REQUEST['Badge_Item_ID'];
	if($Badge_Item_ID!=""){
	if($table=="temp"){
		$tmp = $conn ->query("delete from iijs_badge_items_tmp where Badge_Item_ID='$Badge_Item_ID'");
	}
	else if($table=="main")
		$main = $conn ->query("delete from iijs_badge_items where Badge_Item_ID='$Badge_Item_ID'");	
	}
	echo "<meta http-equiv=refresh content=\"0;url=exhibitors_badges.php\">";
}
?>

<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
$checking_time=strtotime("25-04-2021 23:59:59");
//$checking_time=strtotime("19-01-2018 14:22:00");
?>
<?php 
$sqlquery="SELECT * FROM `iijs_catalog` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1=$conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply  Compulsory Catalogue to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
}  
?>
<?php
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($exhibitor_data);
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
<title>Exhibitor Badges</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<script src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/badges.js"></script>
<!---------------- POP UP START -------------------->

<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){

$("input:radio[name=Badge_Type]").change(function(){
var Badge_Type = $("input[name='Badge_Type']:checked"). val();
	if(Badge_Type=="R")
		$("#replaceBadge").show();
	else
		$("#replaceBadge").hide();
});

$("#save1").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
	//alert(url);return false;
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert(data); // show response from the php script.
           }
         });


});	
function readUrlPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
         $('#blah1').show();
    }
}

$("#photoimg").change(function(){
  /*alert("hii");return false;*/
    readUrlPhoto(this);

});
function readUrlDocument(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah2').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
         $('#blah2').show();
    }
}

$("#document").change(function(){
  /*alert("hii");return false;*/
    readUrlDocument(this);

});
});
function validation(){
    alert("Kindly Update Badge Delivery Address..");
}
function comingSoon()
{		
	alert("Coming Soon !!!");
}
</script>
</head>
<body>
<!-- header starts -->

<div class="header_wrap">
  <?php include ('header.php'); ?>
</div>

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
    top: -23%;
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

<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Exhibitor Badges</h3>
<!--<span style="color:red;margin-left:5%;">The deadline for the form submission is <strong>21st Dec 2016</strong></span>-->
<!--<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>
<p>
<u>Exhibitor Additional Badge:</u> -Every exhibitor will be allotted Additional Badge as per available quota at an Additional cost of 1500 per badge.</p>
</li>
<li>Exhibitor/Additional badge can not be availed after the deadline</li>
</ol>
</span>
</div>-->
<!--<span style="float:right;margin-left: 10px;" class="spanbox"><a href="images/pdf/Exhibitor_Badges_Terms_Conditions_IIJS_Signature_2020.pdf" target="_blank" style="color:#FFF;">Exhibitor Badges Terms & Condition</a></span>-->
<span style="float:right;margin-left: 10px;" class="spanbox">Deadline without surcharge : <?php echo getFormDeadLine(4,$conn);?></span>
<!--<span style="float:right;margin-left: 10px;" class="spanbox">Deadline with surcharge: 10th February 2021</span>-->

<div class="clear"></div>
<h2>Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
	<tbody>
	<tr>
	<th valign="top">Sr. No.</th>
	<th valign="top">Date</th>
    <th valign="middle">Order Id</th>
	<th valign="middle">Information Status</th>
	<th valign="middle">Payment Status</th>
	<th valign="middle">Application Status</th>	
    <th valign="middle">Action </th>
	</tr>
	<?php
	$i=1;
	
	$querys=$conn->query("SELECT a.*,b.* FROM `iijs_badge` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='4' order by b.Payment_Master_ID");
	$numO = $querys->num_rows;
	
	/*$Badge_ID=$result['Badge_ID'];
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Collection_Mode=$result['Collection_Mode'];
	$Payment_Master_Approved=$result['Payment_Master_Approved'];
	$Payment_Master_Reason=$result['Payment_Master_Reason'];
	$Info_Approved=$result['Info_Approved'];
	$Info_Reason=$result['Info_Reason'];*/
	
	if($numO>0){
	while($result = $querys->fetch_assoc()){
	?>
	<tr>
	<td valign="middle"><?php echo $i;?></td>
	<td valign="middle"><a href="exhibitors_badges.php?action=view&order_id=<?php echo $result['Payment_Master_OrderNo'];?>"> Click Here (<?php echo date('d-m-Y',strtotime($result['Create_Date']));?>)</a></td>
    <td valign="middle"><?php echo $result['Payment_Master_OrderNo'];?></td>
	<td valign="middle" class="centerAlign">
	<?php  
	if($result['Info_Approved']=='Y')
	echo "<img src='images/correct.png'  alt='' />";
	else if($result['Info_Approved']=='N')
	echo "<img src='images/red_cross.png'  alt='' />";
	else
	echo "<img src='images/pending.png'  alt='' />";		
	?> 
	</td>
	<td valign="middle" colspan="1" class="centerAlign">
	<?php  
	if($result['Payment_Master_Approved']=='Y')
	echo "<img src='images/correct.png'  alt='' />";
	else if($result['Payment_Master_Approved']=='N')
	echo "<img src='images/red_cross.png'  alt='' />";
	else
	echo "<img src='images/pending.png'  alt='' />";		
	?>
	</td>
	<td valign="middle" colspan="1" class="centerAlign">
	<?php  
	$badge_pending_status=getBadgeStatus($result['Badge_ID'],$conn);
	$badge_disapprove_status=getBadgeDStatus($result['Badge_ID'],$conn);
			
	if(getPaymentStatus($result['Payment_Master_ID'],$conn)=='Y' && $badge_pending_status=='0' && $badge_disapprove_status=='0')
	echo "<img src='images/correct.png'  alt='' />";
	else if(getPaymentStatus($result['Payment_Master_ID'],$conn)=='N' && $badge_pending_status=='0' || $badge_disapprove_status!='0')
	echo "<img src='images/red_cross.png' alt='' />";
	else
	echo "<img src='images/pending.png' alt='' />";		
	?>
	</td>
    <td><?php if($result['Payment_Master_Approved']=="P"){?><a href="exhibitors_badges.php?action=del&order_id=<?php echo $result['Payment_Master_OrderNo'];?>" onclick="return(window.confirm('Are you sure you want to delete the order?'));" >Delete Order</a><?php } else { ?> &nbsp; <?php } ?></td>
	</tr>
	<?php $Payment_Master_Approved[] = $result['Payment_Master_Approved'];  $i++; } } ?>
	</tbody>
</table>
<div class="clear"></div>
<!--<a href="#" class='maroon_btn' style='float:right;' onclick="return(window.confirm('Kindly make payment of your prevous order to add new order'));" >ADD NEW ORDER</a>-->
<?php if($_REQUEST['auth']=="admin"){}
if (in_array("P", $Payment_Master_Approved)){?>
		<a href="#" class='maroon_btn' style='float:right;' onclick="return(window.confirm('Kindly make payment of your previous order to add new order'));" >Add Badges/Replace</a>
<?php }else{
	echo "<a href='exhibitors_badges.php?action=ADD' class='maroon_btn' style='float:right;'>Add Badges/Replace</a><br/>";
} ?>
<?php 
$action=$_REQUEST['action'];
$order_id=$_REQUEST['order_id'];

/*..............................Order Payment Status.....................................*/
$qpaymentStatus = $conn ->query("select Payment_Master_Approved from iijs_payment_master where Payment_Master_OrderNo='$order_id'");
$rpaymentStatus =  $qpaymentStatus->fetch_assoc();
$order_payment_status = $rpaymentStatus['Payment_Master_Approved'];

if($num==0 || $action=="view" || $action=="ADD"){?>
<div class="title"><h4>Exhibitor Information</h4></div>
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
    <td><?php  echo getSection_desc($Exhibitor_Section,$conn); ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<!--<div class="title"><h4>Car Passes Information</h4></div>-->
<?php 
/*..........................Get Maximum Car Available....................................*/
$query=$conn ->query("select * from iijs_carpass_master where CarPass_Area='$Exhibitor_Area'");
$result= $query->fetch_assoc();
$CarPass_AvailablePasses=$result['CarPass_AvailablePasses'];

/*..........................Get Car Passess Taken....................................*/
$num_avail_car=0;
$num_taken_car=0;

$query1=$conn ->query("select * from iijs_badge_address where Exhibitor_Code='$exhibitor_code' limit 0,1");
$result1= $query1->fetch_assoc();
$num1 = $query1->num_rows;
if($num1>0){
	$Badge_Addres=$result1['BadgeAddres'];
	$Badge_Country=$result1['BadgeCountry'];
	$Badge_City=$result1['BadgeCity'];
	$Badge_Pincode=$result1['BadgePincode'];
	$Badge_State=$result1['BadgeState'];
	$Badge_Mobile=$result1['BadgeMobile'];
}
?>
<!--
<div class="clear"></div>  
<div class="title"><h4>Badges Delivery Address</h4></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td>Address<sup>*</sup></td>
    <td width="250"><textarea name="Badge_Addres" id="Badge_Addres" class="textField" rows="5" cols="25" ><?php echo $Badge_Addres;?></textarea></td>
    <td>Country<sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Country" id="Badge_Country" class="textField" value="<?php echo $Badge_Country;?>" /></td>
   </tr>
   <tr>
    <td>City <sup>*</sup></td>
    <td width="250"><input type="text" name="Badge_City" id="Badge_City" class="textField" value="<?php echo $Badge_City;?>" /></td>
    <td>Pincode <sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Pincode" id="Badge_Pincode" class="textField" value="<?php echo $Badge_Pincode;?>" /></td>
   </tr>
   <tr>
    <td>State <sup>*</sup></td>
    <td width="250"><input type="text" name="Badge_State" id="Badge_State" class="textField" value="<?php echo $Badge_State;?>" /></td>
    <td>Mobile <sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $Badge_Mobile;?>" maxlength="10" /></td>
   </tr>
   <input type="hidden" name="saveAddress" value="save">
   <?php if($num1>0){?>
   <tr><td><input type="button" name="update_address" id="update_address" value="Update Address" class="maroon_btn"/></td></tr>
   <?php }else{?>
   <tr><td><input type="button" name="update_address" id="update_address" value="Add Address" class="maroon_btn"/></td></tr>
   <?php }?>
</table>
-->
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
/*..........................Get Maximum Badges Available....................................*/
if($Exhibitor_Section=="signature_club")
	$sql="select * from iijs_badge_master where Stall_Area='$Exhibitor_Area' and isDuplex='S'";
else
	$sql="select * from iijs_badge_master where Stall_Area='$Exhibitor_Area'";
		
$query = $conn ->query($sql);
$result = $query->fetch_assoc();
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
	
	$Rquery2 = $conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
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
    <td class="bold">Maximum Additional Badges Available</td>
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

<div class="title"><h4>Exhibitor Badges Taken</h4></div>
<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>
    <th align="left">Status</th>
    <!--<th align="left">Action</th>-->
    <th>Badge</th>
   </tr>
   <?php 
   // if($_SESSION['EXHIBITOR_CODE'] =="EXHK"){
   // 	print_r($_SESSION);
   // }
    $exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
	$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
	$result_c=$conn ->query($exhibitor_data);
	$fetch_data_c = $result_c->fetch_assoc(); 
	$registration_id=$fetch_data_c['Exhibitor_Registration_ID'];

	$hostname1 = "localhost";
	$uname1 = "gjepcliveuserdb";
	$pwd1 = "KGj&6(pcvmLk5";
	$database1 = "gjepclivedatabase";
	$conn1 = new mysqli($hostname1, $uname1, $pwd1, $database1);


	function getVendorStatusFromGlobal($reg_id,$vis_id,$conn1){
	 $query_sel = "SELECT uniqueIdentifier FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='EXH' AND event='iijs22' AND isReplaced is NULL limit 1";	
	$result_sel = $conn1->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['uniqueIdentifier'];
	}



	/*...................Exhibitor Badges Taken............ .............*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	else
		$query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='E' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");	
		
	$i=1;
	$Surcharge=0;
	while($result = $query->fetch_assoc()){
		$Surcharge=$Surcharge+intval($result['Surcharge']);
		$unique_id = getVendorStatusFromGlobal($registration_id,$result['Badge_Item_ID'],$conn1);
   ?>
   
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
   <tr>
	<td align="left"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td>
    <td align="left"><?php echo $result['Badge_Mobile'];?></td>
    <td align="left">
    <?php if($result['Badge_Photo']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
	<?php if($result['Badge_Approved']=="N"){?>
    	<hr/>
        <input type="file" name="replace_badge_img" id="replace_badge_img" class="textField" />
        <input type="submit" name="save" id="save" value="Update" class="maroon_btn"/>
    <?php }?>
      </td>
      <td align="left">
    <?php if($result['Badge_Document']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
		<?php if($result['Badge_Approved']=="N"){?>
        	<hr/>
            <input type="file" name="replace_badge_docuemnt" id="replace_badge_docuemnt" class="textField" />
             <input type="submit" name="save" id="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
      <td align="left">
      <?php  
			if($result['Badge_Approved']=='Y')
				echo "<img src='images/correct.png'  alt='' />";
			else if($result['Badge_Approved']=='N')
				echo "<img src='images/red_cross.png'  alt='' />"."<br/><b>Reason:</b>".$result['Badge_Reason'];
			else
				echo "<img src='images/pending.png'  alt='' />";		
	?>
    </td>
    <!--<td align="left">
    <?php 
	if($result['Badge_Approved']=='P'){
	if($order_payment_status=="P" || $order_payment_status==""){?>
    <a href="exhibitors_badges.php?action=exhdel&table=temp&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
	<?php } else {?>
    <a href="exhibitors_badges.php?action=exhdel&table=main&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
    <?php }}?>
    </td>-->
    <td><?php
		if($result['Badge_Approved']=='Y'){
			if(!empty($unique_id)){ ?>
			<a href="https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier=<?php echo $unique_id; ?>" class="button5">Download Badge</a>
    			<?php } }
     
  		?>
  	</td>
   </tr>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="E"/>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
    <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="<?php echo $result['Badge_Type'];?>"/>
    <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name'];?>"/>
    </form>
  <?php $i++;}?>
  <input type="hidden" name="Exhibitor_badge_count" id="Exhibitor_badge_count" value="<?php echo $i;?>"/>
  <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
</table>
<?php if($Service_Badges_avail > 0){ ?>
<div class="title">
  <h4>Service Badges Taken</h4>
</div>
<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>
    <th align="left">Status</th>
    <th>Badge</th>
   </tr>
   <?php
   /*..................Select Maintenance Badges Taken..........................*/
   if($order_payment_status=="P" || $order_payment_status=="")
	$query=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	else
		$query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='S' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	$j=1;
	$service_charge=0;
	while($result = $query->fetch_assoc()){
	//$service_charge=$service_charge+intval(500);
		

	 $unique_id = getVendorStatusFromGlobal($registration_id,$result['Badge_Item_ID'],$conn1);
	?>
    <form action="update_badges.php" method="post" enctype="multipart/form-data">
	<tr>
    <td align="left"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td>
    <td align="left"><?php echo $result['Badge_Mobile'];?></td>
    <td align="left">
    <?php if($result['Badge_Photo']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
       <?php if($result['Badge_Approved']=="N"){?>
    	<hr/>
        <input type="file" name="replace_badge_img1" id="replace_badge_img1" class="textField" />
        <input type="submit" name="save" id="save" value="Update" class="maroon_btn"/>
    	<?php }?>
      </td>
    <td align="left">
    <?php if($result['Badge_Document']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
		<?php if($result['Badge_Approved']=="N"){?>
        	<hr/>
            <input type="file" name="replace_badge_docuemnt1" id="replace_badge_docuemnt1" class="textField" />
             <input type="submit" name="save" id="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
      <td align="left">
      <?php  
			if($result['Badge_Approved']=='Y')
				echo "<img src='images/correct.png'  alt='' />";
			else if($result['Badge_Approved']=='N')
				echo "<img src='images/red_cross.png'  alt='' />"."<br/><b>Reason:</b>".$result['Badge_Reason'];
			else
				echo "<img src='images/pending.png'  alt='' />";		
	?>
    </td>
      <td><?php
		if($result['Badge_Approved']=='Y'){
			if(!empty($unique_id)){ ?>
			<a href="https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier=<?php echo $unique_id; ?>" class="button5">Download Badge</a>
    			<?php } }
     
  		?></td>
    </tr>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="M"/>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
    <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="<?php echo $result['Badge_Type'];?>"/>
    <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name'];?>"/>
    </form>
   <?php $j++;}?>
  <input type="hidden" name="Service_badge_count" id="Service_badge_count" value="<?php echo $j;?>"/>
  <input type="hidden" name="Service_Badges_avail" id="Service_Badges_avail" value="<?php echo $Service_Badges_avail;?>"/>
</table>

<?php } ?>

<!-- <div class="title">
  <h4>Additional Badges Taken</h4>
</div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>
    <th align="left">Status</th>
    <th align="left">Action</th>
   </tr>
   <?php 
	/*...................Management Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	else
		$query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='M' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	$k=1;
	$mangmnt_charge=0;
	while($result = $query->fetch_assoc()){
	$mangmnt_charge=$mangmnt_charge+1500;
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
   <tr>
	<td align="left"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td>
    <td align="left"><?php echo $result['Badge_Mobile'];?></td>
    <td align="left">
    <?php if($result['Badge_Photo']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
        
       <?php if($result['Badge_Approved']=="N"){?>
       <hr/>
        <input type="file" name="replace_badge_img2" id="replace_badge_img2" class="textField" />
        <input type="submit" name="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
      <td align="left">
    <?php if($result['Badge_Document']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
       <?php if($result['Badge_Approved']=="N"){?>
       <hr/>
        <input type="file" name="replace_badge_docuemnt2" id="replace_badge_docuemnt2" class="textField" />
        <input type="submit" name="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
    <td align="left">
		<?php  
        if($result['Badge_Approved']=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($result['Badge_Approved']=='N')
            echo "<img src='images/red_cross.png'  alt='' />"."<br/><b>Reason:</b>".$result['Badge_Reason'];
        else
            echo "<img src='images/pending.png'  alt='' />";		
        ?>
     </td>
     <td align="left">
    <?php 
	if($result['Badge_Approved']=='P'){
	if($order_payment_status=="P" || $order_payment_status==""){?>
    <a href="exhibitors_badges.php?action=exhdel&table=temp&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
	<?php } else {?>
    <a href="exhibitors_badges.php?action=exhdel&table=main&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
    <?php }}?>
    </td>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="M"/>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
    <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="<?php echo $result['Badge_Type'];?>"/>
    <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name'];?>"/>
 </form>
   </tr>
  <?php $k++;}?>
  <input type="hidden" name="Management_badge_count" id="Management_badge_count" value="<?php echo $k;?>"/>
  <input type="hidden" name="Management_Badges_avail" id="Management_Badges_avail" value="<?php echo $Management_Badges_avail;?>"/>
</table> -->
<div class="title">
  <h4>Replaced Badges Details</h4>
</div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <th align="left">Document</th>
    <th align="left">Status</th>
    <!--<th align="left">Action</th>-->
    <th align="left">Badge</th>
   </tr>
   <?php 
	/*...................Replacement Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=$conn ->query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
	else
		$query=$conn ->query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='R' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	$l=1;
	$replace_charges=0;
	while($result = $query->fetch_assoc()){
	$replace_charges=$replace_charges+intval($result['Surcharge']);
	$unique_id = getVendorStatusFromGlobal($registration_id,$result['Badge_Item_ID'],$conn1);
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
   <tr>
	<td align="left"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td align="left"><?php echo $result['Badge_Name'];?></td>
    <td align="left"><?php echo $result['Badge_Designation'];?></td>
    <td align="left"><?php echo $result['Badge_Mobile'];?></td>
    <td align="left">
    <?php if($result['Badge_Photo']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
       <?php if($result['Badge_Approved']=="N"){?>
       <hr/>
        <input type="file" name="replace_badge_img3" id="replace_badge_img3" class="textField" />
        <input type="submit" name="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
      <td align="left">
    <?php if($result['Badge_Document']!=""){?>
            <a href="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" target="_blank"><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Document']?>" width="50" height="50" alt="" /></a>
            <?php }else {?>
            <img src="images/scan_photo.jpg"  alt="" />
       <?php }?>
       <?php if($result['Badge_Approved']=="N"){?>
       <hr/>
        <input type="file" name="replace_badge_docuemnt3" id="replace_badge_docuemnt3" class="textField" />
        <input type="submit" name="save" value="Update" class="maroon_btn"/>
        <?php }?>
      </td>
    <td align="left">
		<?php  
        if($result['Badge_Approved']=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($result['Badge_Approved']=='N')
            echo "<img src='images/red_cross.png'  alt='' />"."<br/><b>Reason:</b>".$result['Badge_Reason'];
        else
            echo "<img src='images/pending.png'  alt='' />";		
        ?>
     </td>
     <td>
     	<?php
		if($result['Badge_Approved']=='Y'){
			if(!empty($unique_id)){ ?>
			<a href="https://registration.gjepc.org/visitor-badge.php?action=generateBadge&uniqueIdentifier=<?php echo $unique_id; ?>" class="button5">Download Badge</a>
    			<?php } }
     
  		?>
     </td>
     <!--<td align="left">
    <?php 
	if($result['Badge_Approved']=='P'){
	if($order_payment_status=="P" || $order_payment_status==""){?>
    <a href="exhibitors_badges.php?action=exhdel&table=temp&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
	<?php } else {?>
    <a href="exhibitors_badges.php?action=exhdel&table=main&Badge_Item_ID=<?php echo $result['Badge_Item_ID'];?>" onclick="return(window.confirm('Are you sure you want to delete?'));" >Delete</a>
    <?php }}?>
    </td>-->
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="R"/>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
    <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
    <input type="hidden" name="Badge_Type" id="Badge_Type" value="<?php echo $result['Badge_Type'];?>"/>
    <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name'];?>"/>
 </form>
   </tr>
  <?php $l++;}?>
  <input type="hidden" name="Replaced_badge_count" id="Replaced_badge_count" value="<?php echo $l;?>"/>
 <input type="hidden" name="Replacement_Badges_avail" id="Replacement_Badges_avail" value="<?php echo $Replacement_Badges_avail;?>"/>
</table>


<?php if($action!="view"){?>
<form id="badgeForm" name="badgeForm" method="post" enctype="multipart/form-data" action='addbadges_ajax.php'>
<P>Exhibitor  badge can not be availed after the deadline</P>
<div class="title"><h4>New Badge Details</h4></div>
<div class="loader" style="display:none">Loading....</div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:100%;"> 
  <tr>
    <td>
	<input type="hidden" name="check_exhibitor" id="check_exhibitor" value="<?php echo $check_exhibitor;?>"/>
	<input type="hidden" name="check_management" id="check_management" value="<?php echo $check_management;?>" />
    <input type="hidden" name="check_replacement" id="check_replacement" value="<?php echo $check_replacement;?>" />
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
    <input type="hidden" name="Exhibitor_Badges_taken" id="Exhibitor_Badges_taken" value="<?php echo $Exhibitor_Badges_taken;?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $Badge_ID;?>"/>
	<?php // if($_SESSION['auth']=="admin"){?>
	<input type="radio" name="Badge_Type" id="Badge_Type" value="E" />	
	</td>
    <td>Exhibitor Badge</td>
	<?php //}?>
	<?php if($Service_Badges_avail > 0 && $Service_Badges_taken <= $Service_Badges_avail){ ?>
		<td ><input type="radio" name="Badge_Type" id="Badge_Type3" value="S" /></td>
   		 <td >Service Badge</td>
	<?php }?>
	
    <!-- <td><input type="radio" name="Badge_Type" id="Badge_Type2" value="M"/></td>
    <td width="300">Additional Badge</td> -->
    <td><input type="radio" name="Badge_Type" id="Badge_Type1" value="R"/></td>
    <td>Replace Badge</td>
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
    while($rreplace = $qreplace->fetch_assoc()){
    ?>
    <option value="<?php echo $rreplace['Badge_Item_ID'];?>"><?php echo $rreplace['Badge_Name'];?></option>
    <?php } ?>
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
    <td width="100"><input type="number" maxlength="10" name="Badge_Mobile_No" id="Badge_Mobile_No" class="textField" maxlength='10' /></td>
    </tr>
   <tr>
    <td>Photo :<sup>*</sup></td>
    <td>    
        <input type="file" name="photoimg" id="photoimg" class="textField" />
        <img src="" id="blah1" width="auto" height="70px" style="margin-top: 7px;">
    </td>
    <td>Document :<sup>*</sup></td>
    <td>    
         <input type="file" name="document" id="document" class="textField" />
         <img src="" id="blah2" width="auto" height="70px" style="margin-top: 7px;">
    </td>
	<td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>  
	

    <?php if($num1>0){?>
    <?php } else {?>
    <!--<td><input type="button" value="ADD" class="maroon_btn" onclick="validation()" /></td>-->
    <?php } ?>
  </tr>
</table>
<?php }?>
</form>

<!-- 
<div class="title"><h4>Collection Mode</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td width="20"><input type="radio" name="Collection_Mode" id="Collection_Mode" value="C" checked="checked" /></td>
    <td>Courier </td>
  </tr>
</table> -->


<?php 
$qgetPaymentDetail = $conn ->query("select * from iijs_payment_master where Payment_Master_OrderNo='$order_id'");
$rgetPaymentDetail = $qgetPaymentDetail->fetch_assoc();
$ngetPaymentDetail = $qgetPaymentDetail->num_rows ;

$tds_tax=$rgetPaymentDetail['tds_tax'];
$tds_amount=$rgetPaymentDetail['tds_amount'];
$net_payable_amount=$rgetPaymentDetail['net_payable_amount'];
if($Exhibitor_Section=="International Jewellery" || $Exhibitor_Section=="International Loose")
	$action="exhibitors_tmp_badges.php#badge_final";
else if($net_payable_amount>0)
	$action="badges_payment_thankyou.php";
else
	$action="exhibitors_tmp_badges.php#badge_final";
?>
<form action="<?php echo $action;?>" method="post" onsubmit="return validate()">
	<?php if($order_payment_status=="P"){?>
  <input name="input2" id="input2" type="submit" value="Complete Applicaiton" class="maroon_btn" />
  <?php //}elseif($_REQUEST['action']=='ADD' && ($Enum_temp>0 || $Snum_live>0 || $Mnum_temp>0 || $Rnum_temp)){?>
 <?php }elseif($Enum_temp>0 || $Snum_live>0 || $Mnum_temp>0 || $Rnum_temp){?>
 <input name="input2" id="input2" type="submit" value="Complete Applicaiton" class="maroon_btn" />
 <div class="clear" style="margin-top:20px;margin-bottom: 20px;"></div>
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
 <div class="title"><h4>Payment Information</h4></div>
<div class="clear"></div>
 <?php }?>
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
    <td><?php echo $total_amount= $service_charge+$mangmnt_charge+$replace_charges+$Surcharge;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $total_amount;?>"/></td>
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
	<td>
    <select class="textField" name="tds_tax" id="tds_tax" <?php if($ngetPaymentDetail>0){?> disabled="disabled" <?php }?>>
		<option value="0" <?php if($tds_tax==0){?> selected="selected"<?php }?> >0% </option>
		<option value="2" <?php if($tds_tax==2){?> selected="selected"<?php }?>>2% </option>
		<option value="10" <?php if($tds_tax==10){?> selected="selected"<?php }?>>10%</option>
	</select>
    <?php if($ngetPaymentDetail>0){?><input type="hidden" name="tds_tax" id="tds_tax" value="<?php echo $tds_tax;?>"/><?php }?>
	</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td class="bold">TDS Amount</td>
    <td>:</td>
    <td><input name="tds_amount" id="tds_amount" type="text" class="textField" value="<?php echo $tds_amount=$total_amount*$tds_tax/100;?>" readonly/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Net Payable</td>
    <td>:</td>
    <td><input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" value="<?php echo $net_payable_amount=$grand_payble-$tds_amount;?>" readonly/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="title">
<h4>Info Approval :</h4>
</div>
<div class="clear"></div> 
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
    <tr>
      <td width="215" class="bold">Status</td>
      <td width="21">:</td>
      <td width="33">
	  <?php  
			if($Info_Approved=="Y")
			echo "<img src='images/correct.png'  alt='' />";
			else if($Info_Approved=="N")
			echo "<img src='images/red_cross.png'  alt='' />";
			else
			echo "<img src='images/pending.png'  alt='' />";		
		?>
		</td>
    </tr>

    <tr>
      <td class="bold">Reason (if disapproved)</td>
      <td>:</td>
      <td colspan="2"><textarea class="textArea" style="overflow:auto;" disabled="disabled"><?php echo $Info_Reason;?></textarea></td>
    </tr>
  </table>

<?php if($total_payble>0){?>
<div class="title"><h4>Payment Mode</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID"  value="1" checked="checked" /></td>
    <td width="100">Net Banking</td>
  </tr>
</table>

<div class="title">
<h4>Payment Approval :</h4>
</div>
<div class="clear"></div> 
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
    <tr>
      <td width="215" class="bold">Status</td>
      <td width="21">:</td>
      <td width="33">
	  <?php  
			if($Payment_Master_Approved=="Y")
			echo "<img src='images/correct.png'  alt='' />";
			else if($Payment_Master_Approved=="N")
			echo "<img src='images/red_cross.png'  alt='' />";
			else
			echo "<img src='images/pending.png'  alt='' />";		
		?>
		</td>
    </tr>

    <tr>
      <td class="bold">Reason (if disapproved)</td>
      <td>:</td>
      <td colspan="2"><textarea class="textArea" style="overflow:auto;" disabled="disabled"><?php echo $Payment_Master_Reason;?></textarea></td>
    </tr>
  </table>
<?php }?>

<!--.........................Redirect to badge temp page for no order ...........................-->

</form>
<br/>

<form  action="badges_payment_thankyou.php" method="post">
<div>
<?php if($order_id!="" && $order_payment_status=="Y"){ ?>
	<a href="print_acknowledge/exhibitors_badges.php?order_id=<?php echo $order_id?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	<?php }?>
    
	<?php if($_REQUEST['auth']=='admin'){?>
	<input name="input" id="input" type="submit" value="Update" class="maroon_btn" />
	<?php }?>
    
	<?php if($_REQUEST['badges']=="update") { ?>
	<input type="hidden" name="save" id="save" value="Save"/>
	<!--<input name="" id="" type="submit" value="Pay Now" class="maroon_btn" />-->
	<?php }?>
	<a href="manual_list.php" class="button5">Back To List</a>
</div>
</form>
<?php } ?>

</div>

<div class="clear">	
</div>

</div>
</div>

<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>
