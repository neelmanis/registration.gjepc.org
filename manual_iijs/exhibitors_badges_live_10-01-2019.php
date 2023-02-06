<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php");	exit;
}
?>
<?php 
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
if (($_REQUEST['action']=='del') && ($_REQUEST['order_id']!=''))
{
	/*.............................Get Payment ID......................................*/
	$Payment_Master_OrderNo=$_REQUEST['order_id'];
	$qpaymentId=mysql_query("select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$Payment_Master_OrderNo'");
	$rpaymentId=mysql_fetch_array($qpaymentId);
	$Payment_Master_ID=$rpaymentId['Payment_Master_ID'];
	
	$num=mysql_num_rows($qpaymentId);
	if($num>0)
	{	
		$qbadgeId=mysql_query("select Badge_ID from iijs_badge where Payment_Master_ID='$Payment_Master_ID'");
		$rbadgeId=mysql_fetch_array($qbadgeId);
		$Badge_ID=$rbadgeId['Badge_ID'];
		
		mysql_query("delete from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
		mysql_query("delete from iijs_badge where Payment_Master_ID='$Payment_Master_ID'");
		mysql_query("delete from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code'");	
	}
	echo"<meta http-equiv=refresh content=\"0;url=exhibitors_badges.php\">";
}
?>
<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
$checking_time=strtotime("20-01-2018 23:59:59");
//$checking_time=strtotime("19-01-2018 14:22:00");
?>
<?php 
$sqlquery="SELECT * FROM `iijs_catalog` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1=mysql_query($sqlquery);
$total_badge=mysql_num_rows($result1);
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply  Compulsory Catalogue to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
}  
?>
<?php
//$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

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

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<script src="js/jquery-1.8.3.js"></script>
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/badges.js"></script></head>
<!---------------- POP UP START -------------------->

<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox.js"></script>

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
<h3>Exhibitor Badges </h3>
<!--<span style="color:red;margin-left:5%;">The deadline for the form submission is <strong>21st Dec 2016</strong></span>-->


<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">

<li>
	<p><strong> <u>Exhibitor Temporary Badge:</u> </strong> -The Exhibitor Temporary Badges will be provided on additional charges of Rs. 500/- + Service Tax per badge. Exhibitors may avail these facilities for Visual Merchandiser, Computer & Networking Installation, and Printers etc. or for stall Decoration & Window display.</p>
	
	<table border="1"  align="center">
		<tr>
			<td colspan="2">Exhibitor Temporary Badge Timing</td>
		</tr>
		<tr>
			<td>8th Feb</td>
			<td>01:00 pm to 06:00 pm</td>
		</tr>
		<tr>
			<td>9th Feb</td>
			<td>01:00 am to 06:00 pm</td>
		</tr>
		<tr>
			<td>13th Feb</td>
			<td>02:00 pm to 08:00 pm</td>
		</tr>
	</table>
	<p><u>** There would be No Conversion of Exhibitor Service Badges to Exhibitor’s Badges</u></p>
</li>
<li>
	<p>
		<u>Exhibitor Additional Badge:</u> -Every exhibitor will be allotted Additional Badge as per available quota at an Additional cost of 1500 per badge.
	</p>
</li>
</ol>
</span>
</div>

<span style="float:right;margin-left: 10px;" class="spanbox">Deadline : <strong>20th January 2018</strong></span>
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
	$query=mysql_query("SELECT a.*,b.* FROM `iijs_badge` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='4' order by b.Payment_Master_ID");
	$num=mysql_num_rows($query);
	$Badge_ID=$result['Badge_ID'];
	$Payment_Master_ID=$result['Payment_Master_ID'];
	$Collection_Mode=$result['Collection_Mode'];
	$Payment_Master_Approved=$result['Payment_Master_Approved'];
	$Payment_Master_Reason=$result['Payment_Master_Reason'];
	$Info_Approved=$result['Info_Approved'];
	$Info_Reason=$result['Info_Reason'];
	if($num>0){
	while($result=mysql_fetch_array($query)){
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
	 		$badge_pending_status=getBadgeStatus($result['Badge_ID']);
			$badge_disapprove_status=getBadgeDStatus($result['Badge_ID']);
			
			if(getPaymentStatus($result['Payment_Master_ID'])=='Y' && $badge_pending_status=='0' && $badge_disapprove_status=='0')
			echo "<img src='images/correct.png'  alt='' />";
			else if(getPaymentStatus($result['Payment_Master_ID'])=='N' && $badge_pending_status=='0' || $badge_disapprove_status!='0')
			echo "<img src='images/red_cross.png' alt='' />";
			else
			echo "<img src='images/pending.png' alt='' />";		
		?>
	</td>
    <td><?php if($result['Payment_Master_Approved']=="P"){?><a href="exhibitors_badges.php?action=del&order_id=<?php echo $result['Payment_Master_OrderNo'];?>" onclick="return(window.confirm('Are you sure you want to delete the order?'));" >Delete Order</a><?php } else {?> &nbsp;<?php }?></td>
	</tr>
	<?php $Payment_Master_Approved[] = $result['Payment_Master_Approved'];}}?>
	</tbody>
</table>
<div class="clear"></div>
<!--<a href="#" class='maroon_btn' style='float:right;' onclick="return(window.confirm('Kindly make payment of your prevous order to add new order'));" >ADD NEW ORDER</a>-->
<?php 
if (in_array("P", $Payment_Master_Approved)){?>
		<a href="#" class='maroon_btn' style='float:right;' onclick="return(window.confirm('Kindly make payment of your previous order to add new order'));" >ADD NEW ORDER</a>
<?php }else{
	echo "<a href='exhibitors_badges.php?action=ADD' class='maroon_btn' style='float:right;'>ADD NEW ORDER</a><br/>";
}?>
<?php 
$action=$_REQUEST['action'];
$order_id=$_REQUEST['order_id'];

/*..............................Order Payment Status.....................................*/
$qpaymentStatus=mysql_query("select Payment_Master_Approved from iijs_payment_master where Payment_Master_OrderNo='$order_id'");
$rpaymentStatus=mysql_fetch_array($qpaymentStatus);
$order_payment_status=$rpaymentStatus['Payment_Master_Approved'];


if($num==0 || $action=="view" || $action=="ADD"){?>
<div class="title">
<h4>Exhibitor Information</h4>

</div>
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
</table>

<!--<div class="title"><h4>Car Passes Information</h4></div>-->
<?php 
/*..........................Get Maximum Car Available....................................*/
$query=mysql_query("select * from iijs_carpass_master where CarPass_Area='$Exhibitor_Area'");
$result=mysql_fetch_array($query);
$CarPass_AvailablePasses=$result['CarPass_AvailablePasses'];

/*..........................Get Car Passess Taken....................................*/
$num_avail_car=0;
$num_taken_car=0;

$query1=mysql_query("select * from iijs_badge where Exhibitor_Code='$exhibitor_code' limit 0,1");
$result1=mysql_fetch_array($query1);
$num1=mysql_num_rows($query1);
if($num1>0){
	$Badge_Addres=$result1['BadgeAddres'];
	$Badge_Country=$result1['BadgeCountry'];
	$Badge_City=$result1['BadgeCity'];
	$Badge_Pincode=$result1['BadgePincode'];
	$Badge_State=$result1['BadgeState'];
	$Badge_Mobile=$result1['BadgeMobile'];
}
?>

<div class="clear"></div>  
<form id="badgeForm" name="badgeForm" method="post" enctype="multipart/form-data" action='addbadges_ajax.php'>
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
    <td width="100"><input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $Badge_Mobile;?>" /></td>
   </tr>
   <input type="hidden" name="saveAddress" value="save">
   <?php if($num>0){?>
   <tr><td><input type="button" name="updateOldAddress" id="updateOldAddress" value="UPDATE" class="maroon_btn"/></td></tr>
   <?php }?>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="50%" class="formManual">
 <tr>
    <th>No. of Booths</th>
	<th>Area (in Sq.mts)</th>
    <th colspan="2">No. of Car Sticker</th>
   </tr>
  <tr>
    <td width="40%" class="bold">1/2</td>
    <td width="40%" class="bold">9 / 18 Sq.mts </td>
    <td width="4%">:</td>
    <td width="18%">1</td>    
  </tr>
 <tr>
    <td width="40%" class="bold">3/4/6</td>
    <td width="40%" class="bold">27 / 36 / 54 Sq.mts </td>
    <td width="4%">:</td>
    <td width="18%">2</td>    
  </tr>
  <tr>
    <td width="40%" class="bold">(Signature Club) 2/3/4</td>
    <td width="40%" class="bold">(Signature Club) 24/36/48</td>
    <td width="4%">:</td>
    <td width="18%">2</td>    
  </tr>  
</table>

<div class="title"><h4>Badges Information</h4></div>
<div class="clear"></div>


<?php 
/*..........................Get Maximum Badges Available....................................*/

$query=mysql_query("select * from iijs_badge_master where Stall_Area='$Exhibitor_Area'");
$result=mysql_fetch_array($query);
$Exhibitor_Badges_avail=$result['Exhibitor_Badges'];
$Service_Badges_avail=$result['Service_Badges'];
$Management_Badges_avail=$result['Management_Badges'];

/*..........................Get Maximum Badges Taken...................................*/
/*..............................Exhibitor Total..............................*/
	$Badge_ID=$result['Badge_ID'];
	
	$Equery=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$Enum_temp=mysql_num_rows($Equery);
	$Equery=mysql_query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$Enum_live=mysql_num_rows($Equery);
	$Enum=$Enum_temp+$Enum_live;
	
	/*..............................Service Total..............................*/
	$Squery=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$Snum_temp=mysql_num_rows($Squery);
	$Squery=mysql_query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$Snum_live=mysql_num_rows($Squery);
	
	$Snum=$Snum_temp+$Snum_live;
	
	$Mquery=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$Mnum_temp=mysql_num_rows($Mquery);
	$Mquery=mysql_query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$Mnum_live=mysql_num_rows($Mquery);

	$Mnum=$Mnum_temp+$Mnum_live;
	
	if($Enum!=0){$Exhibitor_Badges_taken=$Enum;}else{$Exhibitor_Badges_taken=0;}
	if($Snum!=0){$Service_Badges_taken=$Snum;} else{$Service_Badges_taken=0;}
	if($Mnum!=0){$Management_Badges_taken=$Mnum;} else{$Management_Badges_taken=0;}


?>
<?php 
if($Exhibitor_Badges_avail<=$Exhibitor_Badges_taken)
{
	$check_exhibitor="1";
}
else
{
	$check_exhibitor="0";
}
if($Service_Badges_avail<=$Service_Badges_taken)
{
	$check_services="1";
}
else
{
	$check_services="0";
}
if($Management_Badges_avail<=$Management_Badges_taken)
{
	$check_management="1";
}
else
{
	$check_management="0";
}
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
    <td class="bold">Maximum Temporary Badges Available</td>
    <td>:</td>
    <td><?php echo $Service_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Service_Badges_taken;?></td>
  </tr>
  <tr>
    <td class="bold">Maximum Additional Badges Available</td>
    <td>:</td>
    <td><?php echo $Management_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Management_Badges_taken;?></td>
  </tr>
</table>


<div class="title"><h4>Exhibitor Badges Taken</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <th align="left">Status</th>
    <th></th>
   </tr>
   <?php 
	/*...................Exhibitor Badges Taken............ .............*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='E' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
		
	$j=1;
	$extra_charge=0;
	while($result=mysql_fetch_array($query)){
	if($result['WaveOff']!="Y")
	{
		$extra_charge=$extra_charge+intval($result['Surcharge']);
	}
   ?>
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
      </td>
      <td>
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
	  <?php if($result['Badge_Approved']=='N'){?><a href="#inline3" class="fade_anim twitter" id="<?php echo $result['Badge_Item_ID']." ".$result['Badge_Name']." ".$result['Badge_Type'];?>"><button >Update Photo</button></a><?php }?>
    </td>
   </tr>
  <?php $j++;}?>
  <input type="hidden" name="Exhibitor_badge_count" id="Exhibitor_badge_count" value="<?php echo $j;?>"/>
  <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>

</table>

<div class="title">
  <h4>Temporary Badges Taken</h4>
</div>
<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <th align="left">Date</th>
    <th align="left">Name</th>
    <th align="left">Designation</th>
    <th align="left">Mobile No</th>
    <th align="left">Photo</th>
    <!--<th align="left">Charges Applicable</th>-->
    <th align="left">Status</th>
    <th align="left"></th>
   </tr>
   <?php
   /*..................Select Maintenance Badges Taken..........................*/
   if($order_payment_status=="P" || $order_payment_status=="")
	$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='S' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	$i=1;
	$maintenance_charge=0;
	while($result=mysql_fetch_array($query)){
	$maintenance_charge=$maintenance_charge+500;
	?>
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
      </td>
    <!--<td align="left">
	<?php //echo "500";
	$maintenance_charge?>
    </td>-->
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
    	<?php if($result['Badge_Approved']=='N'){?><a href="#inline3" class="fade_anim twitter" id="<?php echo $result['Badge_Item_ID']." ".$result['Badge_Name']." ".$result['Badge_Type'];?>">Update Photo</a><?php }?>
    </td>
    </tr>
   <?php $i++;}?>
   <input type="hidden" name="maintenance_badge_count" id="maintenance_badge_count" value="<?php echo $i;?>"/>
   <input type="hidden" name="Service_Badges_avail" id="Service_Badges_avail" value="<?php echo $Service_Badges_avail;?>"/>

</table>

<div class="title">
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
    <th align="left">Status</th>
    <th></th>
   </tr>
   <?php 
	/*...................Management Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='M' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	$k=1;
	$mangmnt_charge=0;
	while($result=mysql_fetch_array($query)){
	$mangmnt_charge=$mangmnt_charge+1500;
   ?>
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
      </td>
    <td>
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
	  <?php if($result['Badge_Approved']=='N'){?><a href="#inline3" class="fade_anim twitter" id="<?php echo $result['Badge_Item_ID']." ".$result['Badge_Name']." ".$result['Badge_Type'];?>">Update Photo</a><?php }?>
 </td>
   </tr>
  <?php $k++;}?>
  <input type="hidden" name="Management_badge_count" id="Exhibitor_badge_count" value="<?php echo $k;?>"/>
  <input type="hidden" name="Management_Badges_avail" id="Management_Badges_avail" value="<?php echo $Management_Badges_avail;?>"/>
</table>


<?php if($action!="view"){?>
<div class="title"><h4>New Badge Details</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <td width="35">
	<input type="hidden" name="check_services" id="check_services" value="<?php echo $check_services;?>"/>
	<input type="hidden" name="check_exhibitor" id="check_exhibitor" value="<?php echo $check_exhibitor;?>"/>
	<input type="hidden" name="check_management" id="check_management" value="<?php echo $check_management;?>" />
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
    <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
    <input type="hidden" name="Exhibitor_Badges_taken" id="Exhibitor_Badges_taken" value="<?php echo $Exhibitor_Badges_taken;?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $Badge_ID;?>"/>
	<input type="radio" name="Badge_Type" id="Badge_Type" value="E" />	
	</td>
    <td width="300">Exhibitor Badge Badge</td>
    <td width="33"><input type="radio" name="Badge_Type" id="Badge_Type1" value="S" class="radio"/></td>
    <td width="250">Temporary  Badge</td>
    <td><input type="radio" name="Badge_Type" id="Badge_Type2" value="M"/></td>
    <td width="300">Additional Badge</td>
    </tr>
</table>


<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 
  <tr>
    <td>Name<sup>*</sup></td>
    <td>:</td>
    <td width="250"><input type="text" name="Badge_Name" id="Badge_Name" class="textField" /></td>
    <td>Designation<sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Designation" id="Badge_Designation" class="textField" /></td>
	<td>Mobile No<sup>*</sup></td>
    <td width="100"><input type="number" maxlength="10" name="Badge_Mobile_No" id="Badge_Mobile_No" class="textField" /></td>
    </tr>
   <tr>
    <td>Photo</td>
    <td>:</td>
    <td>    
	<div class="chooseButton" style="margin-bottom:0px;">
      <input type="file" name="photoimg" id="photoimg" class="textField" />
    </div>	</td>
    <?php if($_REQUEST['auth']=="admin"){?><?php } ?>
	<td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>
	
	<?php if($current_time>=$checking_time) { } else {?>
    <td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>
	<?php } ?>    
	    
  </tr>
</table>
<?php }?>
</form>

<div class="title"><h4>Collection Mode</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td width="20"><input type="radio" name="Collection_Mode" id="Collection_Mode" value="C" checked="checked" /></td>
    <td>Courier </td>
  </tr>
</table>

<div class="title"><h4>Exhibitor Badges Details</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Exhibitor Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='E' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	while($result=mysql_fetch_array($query)){
 ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?><!--21-06-2013, 08:12:29 AM--></td>
		<td width="9%">&nbsp;</td>
	</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Photo']!=""){?>
	<img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="19" height="18" alt="" />
	<?php }else {?>
	<img src="images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
    <div style="float:left">
	<?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
  		<label class="block">
    	<sup>*</sup>Name :   </label><?php echo $result['Badge_Name'];?>
    </div>
      
     <div class="bottomSpace">
        <label class="block">
    	   <sup>*</sup>Designation : 
    	</label>
			<?php echo $result['Badge_Designation'];?>
      </div> 
	  <div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
        <input type="text" name="Badge_Mobile" id="Badge_Mobile" value="<?php echo $result['Badge_Mobile'];?>"/>		
      </div>
		<?php  
				if($result['Badge_Approved']=='Y')
				echo "<img src='images/correct.png'  alt='' />"."Image Approved";
				else if($result['Badge_Approved']=='N')
				echo "<img src='images/red_cross.png'  alt='' />"."Image Dispproved";
				else
				echo "<img src='images/pending.png'  alt='' />"."Image Pending";		
		?>
      </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td><textarea class="textArea"  disabled="disabled"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
	  
	  </td>
    </td>
    <td>&nbsp;</td>
    </tr>
	<?php //if($result['Badge_Approved']=="N" && isset($_REQUEST['auth'])){?> 
	<?php if($result['Badge_Approved']=="N"){?> 
  <tr>
    <td width="13%" valign="top">Photo</td>
    <td width="5%" valign="top">:</td>
    <td width="73%" valign="top">
	<input type="file" name="replace_badge_img" id="replace_badge_img" class="textField" />
	<input type="submit" name="save" id="save" value="Save" class="maroon_btn"/>
	</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <input type="hidden" name="Badge_Type" id="Badge_Type" value="E"/>
  <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name']?>"/>
  <input type="hidden" name="Badge_Designation" id="Badge_Designation" value="<?php echo $result['Badge_Designation']?>"/>
  <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
  <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
 </form>
 <?php }?>
</table>

<div class="title">
  <h4>Temporary Badges Details</h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Maintenance Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='S' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	while($result=mysql_fetch_array($query)){
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?><!--21-06-2013, 08:12:29 AM--></td>
		<td width="9%">&nbsp;</td>
		</tr>
	  <tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Photo']!=""){?>
	<img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="19" height="18" alt="" />
	<?php }else {?>
	<img src="images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
    <div style="float:left">
    <?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
		<label class="block">
			<sup>*</sup>Name :		</label>
	<?php echo $result['Badge_Name'];?>    </div>
	<div class="bottomSpace">
		  <label class="block">
			<sup>*</sup>Designation :		  </label>
		<?php echo $result['Badge_Designation'];?>	
	</div>
	<div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
		<input type="text" name="Badge_Mobile" id="Badge_Mobile" value="<?php echo $result['Badge_Mobile'];?>"/>
	</div>  
      
	<?php  
			if($result['Badge_Approved']=='Y')
			echo "<img src='images/correct.png'  alt='' />"."Image Approved";
			else if($result['Badge_Approved']=='N')
			echo "<img src='images/red_cross.png'  alt='' />"."Image Dispproved";
			else
			echo "<img src='images/pending.png'  alt='' />"."Image Pending";		
	?> 
      </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td><textarea class="textArea"  disabled="disabled"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>	  </td>
    </td>
    </td>
    <td>&nbsp;</td>
    </tr>
  <?php if($result['Badge_Approved']=="N"){?> 
  <tr>
    <td width="13%" valign="top">Photo</td>
    <td width="5%" valign="top">:</td>
    <td width="73%" valign="top"><input type="file" name="replace_badge_img2" id="replace_badge_img2" class="textField" />
      <input type="submit" name="save" id="save" value="Save" class="maroon_btn"/>	</td>
    <td>&nbsp;</td>
    </tr>
  <?php }?>
  
   <tr>
    <td width="13%" valign="top"></td>
    <td width="5%" valign="top"></td>
    <?php if($_REQUEST['auth']=="admin"){ ?>
    <td width="73%" valign="top">
	<input type="submit" name="convert_to_exhibitor" id="convert_to_exhibitor" value="Convert To Exhibitor" class="maroon_btn"/></td>
	<?php } ?>
    <td>&nbsp;</td>
	<?php if($_REQUEST['auth']=='admin'){?><?php }?>
    </tr>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="S"/>
    <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name']?>"/>
  	<input type="hidden" name="Badge_Designation" id="Badge_Designation" value="<?php echo $result['Badge_Designation']?>"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
 </form>  
<?php }?>
</table>

<div class="title">
  <h4>Additional Badges Details</h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Management Badges Taken.........................*/
	if($order_payment_status=="P" || $order_payment_status=="")
		$query=mysql_query("select * from iijs_badge_items_tmp where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	else
		$query=mysql_query("SELECT a.Badge_ID , b.* FROM  `iijs_badge` a,  `iijs_badge_items` b WHERE 1  AND a.`Badge_ID` = b.`Badge_ID` AND b.Badge_Type='M' AND a.`Payment_Master_ID` =(select Payment_Master_ID from iijs_payment_master where Payment_Master_OrderNo='$order_id')");
		
	while($result=mysql_fetch_array($query)){
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?><!--21-06-2013, 08:12:29 AM--></td>
		<td width="9%">&nbsp;</td>
	</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Photo']!=""){?>
	<img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'].'/'.$result['Badge_Photo']?>" width="19" height="18" alt="" />
	<?php }else {?>
	<img src="images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
    <div style="float:left"> 
	<?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
  		<label class="block">
    	<sup>*</sup>Name :   </label><?php echo $result['Badge_Name'];?>
    </div>
      
     <div class="bottomSpace">
        <label class="block">
    	   <sup>*</sup>Designation : 
    	</label>
			<?php echo $result['Badge_Designation'];?>
         </div>
		<div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
		<input type="text" name="Badge_Mobile" id="Badge_Mobile" value="<?php echo $result['Badge_Mobile'];?>"/>
      </div> 
		<?php  
				if($result['Badge_Approved']=='Y')
				echo "<img src='images/correct.png'  alt='' />"."Image Approved";
				else if($result['Badge_Approved']=='N')
				echo "<img src='images/red_cross.png'  alt='' />"."Image Dispproved";
				else
				echo "<img src='images/pending.png'  alt='' />"."Image Pending";		
		?>
      </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td><textarea class="textArea"  disabled="disabled"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
	  
	  </td>
    </td>
    <td>&nbsp;</td>
    </tr>
	<?php if($result['Badge_Approved']=="N"){?> 
  <tr>
    <td width="13%" valign="top">Photo</td>
    <td width="5%" valign="top">:</td>
    <td width="73%" valign="top">
	<input type="file" name="replace_badge_img3" id="replace_badge_img3" class="textField" />
	<input type="submit" name="save" value="Save" class="maroon_btn"/>
	</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <input type="hidden" name="Badge_Type" id="Badge_Type" value="M"/>
  <input type="hidden" name="Badge_Name" id="Badge_Name" value="<?php echo $result['Badge_Name']?>"/>
  <input type="hidden" name="Badge_Designation" id="Badge_Designation" value="<?php echo $result['Badge_Designation']?>"/>
  <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
  <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
 </form>
 <?php }?>
</table>

<div class="title"><h4>Payment Information</h4></div>
<div class="clear"></div>
<?php 

$qgetPaymentDetail=mysql_query("select * from iijs_payment_master where Payment_Master_OrderNo='$order_id'");
$rgetPaymentDetail=mysql_fetch_array($qgetPaymentDetail);
$tds_tax=$rgetPaymentDetail['tds_tax'];
$tds_amount=$rgetPaymentDetail['tds_amount'];
$net_payable_amount=$rgetPaymentDetail['net_payable_amount'];
?>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
	<td class="bold"><p>Temporary badge charges</p></td>
    <td>:</td>
    <td><?php echo $maintenance_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td class="bold"><p>Additional badge charges</p></td>
    <td>:</td>
    <td><?php echo $mangmnt_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Amount </strong></td>
    <td>:</td>
    <td><?php echo $total_amount= $maintenance_charge+$mangmnt_charge;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $total_amount;?>"/></td>
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
		<option value="0" <?php if($tds_tax==0){?> selected="selected"<?php }?> >0% </option>
		<option value="2" <?php if($tds_tax==2){?> selected="selected"<?php }?>>2% </option>
		<option value="10" <?php if($tds_tax==10){?> selected="selected"<?php }?>>10%</option>
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
    <td><input name="tds_amount" id="tds_amount" type="text" class="textField" value="<?php echo $tds_amount;?>" readonly/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Net Payable</td>
    <td>:</td>
    <td><input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" value="<?php echo $net_payable_amount;?>" readonly/></td>
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

<form  action="badges_payment_thankyou.php" method="post">

<div>
<?php if($order_id!="" && $order_payment_status=="Y"){?>
	<a href="print_acknowledge/exhibitors_badges.php?order_id=<?php echo $order_id?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	<?php }?>
    
	<?php if($_REQUEST['auth']=='admin'){?>
	<input name="input" id="input" type="submit" value="Update" class="maroon_btn" />
	<?php }?>
    
	<?php if($_REQUEST['badges']=="update") { ?>
	<input type="hidden" name="save" id="save" value="Save"/>
	<!--<input name="" id="" type="submit" value="Pay Now" class="maroon_btn" />-->
	<?php }?>
    <?php if($order_payment_status=="P"){?>
		<input name="" id="" type="submit" value="Pay Now" class="maroon_btn" />
    <?php }?>
	<a href="manual_list.php" class="button5">Back To List</a>
</div>
</form>
<?php }?>

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
