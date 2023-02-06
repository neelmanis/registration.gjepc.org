<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php

$exhibitor_code=$_REQUEST['Exhibitor_Code'];
$Badge_ID=$_REQUEST['Badge_ID'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($exhibitor_data);
$fetch_data=$result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Designation=$fetch_data['Exhibitor_Designation'];
$Exhibitor_Mobile=$fetch_data['Exhibitor_Mobile'];
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
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];

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
<title>Manual || Exhibitor badges </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!-- form css -->
<link rel="stylesheet" type="text/css" href="css/adminForm.css">
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});

function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
			$("div.fancyDemo a").fancybox();
</script>
<!-- lightbox Thum -->
<script type="text/javascript">     
        function PrintDiv() {    
           var divToPrint = document.getElementById('divToPrint');
           var popupWin = window.open('', '_blank', 'width=600,height=600');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
                }
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="js/badges.js?v=1.2"></script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="manage_badges.php?action=view">Home</a> > EXHIBITOR BADGES / CAR PASSES FORM</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">EXHIBITOR BADGES / CAR PASSES FORM</div>
		<div class="content_details22">
			<div id="formWrapper">
            
    <div class="title">
    	<h2>Application Summary</h2>
    </div>
      <table  cellspacing="0" cellpadding="0" class="common">
	<tbody>
	<tr>
	<th valign="top">Sr. No.</th>
	<th valign="top">Date</th>
    <th valign="middle">Order Id</th>
	<th valign="middle">Information Status</th>
	<th valign="middle">Payment Status</th>
	<th valign="middle">Application Status</th>	
	</tr>
	<?php
	$i=1; 
	$query=$conn ->query("SELECT a.*,b.* FROM `iijs_badge` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='4' order by b.Payment_Master_ID");
	$num=$query->num_rows;;
	//$Badge_ID=$result['Badge_ID'];
	/*$Payment_Master_ID=$result['Payment_Master_ID'];
	$Collection_Mode=$result['Collection_Mode'];
	$Payment_Master_Approved=$result['Payment_Master_Approved'];
	$Payment_Master_Reason=$result['Payment_Master_Reason'];
	$Info_Approved=$result['Info_Approved'];
	$Info_Reason=$result['Info_Reason']; */
	if($num>0){
	while($result=$query->fetch_assoc()){
	?>
	<tr>
	<td valign="middle"><?php echo $i;?></td>
	<td valign="middle">
    <a href="Form4.php?Badge_ID=<?php echo $result['Badge_ID'];?>&Exhibitor_Code=<?php echo $result['Exhibitor_Code'];?>&order_id=<?php echo $result['Payment_Master_OrderNo'];?>">Click Here (<?php echo date('d-m-Y',strtotime($result['Create_Date']));?>)</a>
    </td>
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
	</tr>
	<?php }}?>
	</tbody>
</table>  
<?php 
	$order_id=$_REQUEST['order_id'];
	$Badge_ID=$_REQUEST['Badge_ID'];
?>
<div class="clear"></div>
 <div <?php if($Badge_ID==''){?>style="display:none;" <?php }?>>    
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
<form id="badgeForm" name="badgeForm" method="post" enctype="multipart/form-data" action='addbadges_ajax.php'>
<!--<div class="title"><h4>Car Passes Information</h4></div>-->
<?php 
/*..........................Get Maximum Car Available....................................*/
$query=$conn ->query("select * from iijs_carpass_master where CarPass_Area='$Exhibitor_Area'");
$result=$query->fetch_assoc();
$CarPass_AvailablePasses=$result['CarPass_AvailablePasses'];

/*..........................Get Car Passess Taken....................................*/
$num_avail_car=0;
$num_taken_car=0;
$query1=$conn ->query("select * from iijs_badge where Exhibitor_Code='$exhibitor_code' and Badge_ID='$Badge_ID'");
$result1=$query1->fetch_assoc();
$Collection_Mode=$result1['Collection_Mode'];
$Info_Approved=$result1['Info_Approved'];
if($Info_Approved=='Y')
{
	$Info_Reason='';
}else if($Info_Approved=='N')
{
	$Info_Reason=$result1['Info_Reason'];
}else
{
	$Info_Reason='';
}
	$num1=$query1->num_rows;

if($num1>0){
	$CarPass1=$result1['CarPass1'];
	$CarPass2=$result1['CarPass2'];
	$CarPass3=$result['CarPass3'];
	$CarPass4=$result['CarPass4'];
	$CarPass5=$result['CarPass5'];
	if($CarPass1!="" && $CarPass1!="undefined"){$num_avail_car=$CarPass_AvailablePasses-1;$num_taken_car=1;}
	if($CarPass2!="" && $CarPass2!="undefined"){$num_avail_car=$CarPass_AvailablePasses-2;$num_taken_car=2;}
	if($CarPass3!="" && $CarPass3!="undefined"){$num_avail_car=$CarPass_AvailablePasses-3;$num_taken_car=3;}	
}
else
{
	$num_avail_car=$CarPass_AvailablePasses;
}
	
	$query2=$conn ->query("select * from iijs_badge_address where Exhibitor_Code='$exhibitor_code' limit 0,1");
	$result2=$query2->fetch_assoc();
	
	$Badge_Addres=$result2['BadgeAddres'];
	$Badge_Country=$result2['BadgeCountry'];
	$Badge_City=$result2['BadgeCity'];
	$Badge_Pincode=$result2['BadgePincode'];
	$Badge_State=$result2['BadgeState'];
	$Badge_Mobile=$result2['BadgeMobile'];	
?>
<div class="clear"></div>
<!--<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="40%" class="bold">Maximum Car Passes Available</td>
    <td width="4%">:</td>
    <td width="18%"><?php echo $CarPass_AvailablePasses;?></td>
    <td width="3%">&nbsp;</td>
    <td width="27%" class="bold">Car Passes Taken</td>
    <td width="3%">:</td>
    <td width="5%"><?php echo $num_taken_car;?></td>
  </tr>
  <tr>
    <td class="bold"> Required Car Passes</td>
    <td>:</td>
  </tr>
  <tbody id="carno_div">
  <?php 
  for($i=1;$i<=$CarPass_AvailablePasses;$i++){ ?>
	 <tr>
		<td class="bold"> Car no.<?php echo $i;?> </td>
		<td>:</td>
		<td>
		<input type="text" name="CarPass<?php echo $i;?>" id="CarPass<?php echo $i;?>" class="textField" value="<?php echo $result1['CarPass'.$i];?>"  />
		</td>
	  </tr>
<?php }?>
	  
  </tbody>
</table>
<div class="title"><h4>Badges Delivery Address</h4></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td>Address<sup>*</sup></td>
    <td width="250"><textarea name="Badge_Addres" id="Badge_Addres" class="textField" ><?php echo $Badge_Addres;?></textarea></td>
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
    <td width="100"><input type="text" name="address_mobile" id="address_mobile" class="textField" value="<?php echo $Badge_Mobile;?>" /></td>
   </tr>
   <input type="hidden" name="saveAddress" value="save">
   <?php if($num1>0){?>
   <tr><td><input type="button" name="update_address" id="update_address" value="Update Address" class="maroon_btn"/></td></tr>
   <?php }else{?>
   <tr><td><input type="button" name="update_address" id="update_address" value="Add Address" class="maroon_btn"/></td></tr>
   <?php }?>
</table>
-->
<div class="title"><h4>Badges Information</h4></div>
<div class="clear"></div>
<?php 
/*..........................Get Maximum Badges Available....................................*/
if($Exhibitor_Section=="signature_club")
	$query=$conn ->query("select * from iijs_badge_master where Stall_Area='$Exhibitor_Area' and isDuplex='S'");
else
	$query=$conn ->query("select * from iijs_badge_master where Stall_Area='$Exhibitor_Area'");

$result=$query->fetch_assoc();
$Exhibitor_Badges_avail=$result['Exhibitor_Badges'];
$Service_Badges_avail=$result['Service_Badges'];
$Management_Badges_avail=$result['Management_Badges'];
$Replacement_Badges_avail=$result['Replace_Badges'];

/*..........................Get Maximum Badges Taken...................................*/

$query=$conn ->query("select Badge_ID from iijs_badge where Exhibitor_Code='$exhibitor_code'");
$result=$query->fetch_assoc();
$num=$query->num_rows;
if($num>0)
{
	$Equery=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='E'");
	$Enum=$Equery->num_rows;
	$Exhibitor_Badges_taken=$Enum;
	
	$Squery=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='S'");
	$Snum=$Squery->num_rows;
	$Service_Badges_taken=$Snum;
	
	$Mquery=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='M'");
	$Mnum=$Mquery->num_rows;
	$Management_Badges_taken=$Mnum;
	
	$Rquery=$conn ->query("select * from iijs_badge_items where Exhibitor_Code='$exhibitor_code' and Badge_Type='R'");
	$Rnum=$Rquery->num_rows;
	$Rplacement_Badges_taken=$Rnum;
}
else
{
	$Exhibitor_Badges_taken=0;
	$Service_Badges_taken=0;
	$Management_Badges_taken=0;
	$Rplacement_Badges_taken=0;
}

?>
<?php 
if($Exhibitor_Badges_avail<=$Exhibitor_Badges_taken)
	$check_exhibitor="1";
else
	$check_exhibitor="0";

if($Service_Badges_avail<=$Service_Badges_taken)
	$check_service="1";
else
	$check_service="0";
	
if($Management_Badges_avail<=$Management_Badges_taken)
	$check_management="1";
else
	$check_management="0";

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
    <td class="bold">Maximum Temporary Available</td>
    <td>:</td>
    <td><?php echo $Service_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Service_Badges_taken;?></td>
  </tr>
   <!--<tr>
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
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
   </tr>
   <?php 
	/*...................Exhibitor Badges Taken.........................*/
	$query=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='E'");
	$j=1;	
	while($result=$query->fetch_assoc()){
   ?>
   <tr>
      <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
      <td><?php echo $result['Badge_Name'];?></td>
      <td><?php echo $result['Badge_Designation'];?></td>
   </tr>
  <?php $j++;} ?>
  <input type="hidden" name="Exhibitor_badge_count" id="Exhibitor_badge_count" value="<?php echo $j;?>"/>
  <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
</table>

<div class="title">
  <h4>Temporary Badges Taken</h4>
</div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
   <th>Date</th>
   <th>Name</th>
   <th>Designation</th>
   <th>Charges Applicable</th>
   <th>Replace status</th>
   </tr>
   <?php 
	/*................... Service/Maintenance Badges Taken.........................*/
	$query=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='S'");
	$i=1;
	$maintenance_charge=0;
	while($result=$query->fetch_assoc()){
	$maintenance_charge=$maintenance_charge+500;
   ?>
    <tr>
        <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
        <td><?php echo $result['Badge_Name'];?></td>
        <td><?php echo $result['Badge_Designation'];?></td>
        <td><?php if($result['Badge_Type'] =="R"){ echo "Replaced"; };?></td>
        <td>500</td>
  </tr>
  <?php $i++; } ?>
 <input type="hidden" name="maintenance_badge_count" id="maintenance_badge_count" value="<?php echo $i;?>"/>
 <input type="hidden" name="Service_Badges_avail" id="Service_Badges_avail" value="<?php echo $Service_Badges_avail;?>"/>
</table>

<!-- <div class="title"><h4>Additional  Badges Taken</h4></div>
<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
   </tr>
   <?php
   /*..................Select Management Badges Taken..........................*/
	$query=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='M'");
	$k=1;
	$mangmnt_charge=0;
	while($result=$query->fetch_assoc()){
	$mangmnt_charge=$mangmnt_charge+1500;
	?>
	<tr>
    <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
    </tr>
   <?php $k++;}?>
    <input type="hidden" name="Management_badge_count" id="Exhibitor_badge_count" value="<?php echo $k;?>"/>
    <input type="hidden" name="Management_Badges_avail" id="Management_Badges_avail" value="<?php echo $Management_Badges_avail;?>"/>
</table> -->

<div class="title">
  <h4>Replaced Badges Details</h4>
</div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
   <th>Date</th>
   <th>Name</th>
   <th>Designation</th>
   <th>Charges Applicable</th>
   </tr>
   <?php 
	/*................... Replacement Badges Taken.........................*/
	$query=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='R'");
	$l=1;
	$replacement_charge=0;
	while($result=$query->fetch_assoc()){
	$replacement_charge=$replacement_charge+intval($result['Surcharge']);
   ?>
    <tr>
        <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
        <td><?php echo $result['Badge_Name'];?></td>
        <td><?php echo $result['Badge_Designation'];?></td>
        <td><?php echo $result['Surcharge'];?></td>
  </tr>
  <?php $l++;}?>
 <input type="hidden" name="Replaced_badge_count" id="Replaced_badge_count" value="<?php echo $l;?>"/>
 <input type="hidden" name="Replacement_Badges_avail" id="Replacement_Badges_avail" value="<?php echo $Replacement_Badges_avail;?>"/>
</table>

<div class="title"><h4>New Badge Details</h4></div>
<div class="clear"></div>

		<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;">
         <tr>
          <td width="20">
            <input type="hidden" name="check_exhibitor" id="check_exhibitor" value="<?php echo $check_exhibitor;?>"/>
            <input type="hidden" name="check_management" id="check_management" value="<?php echo $check_management;?>" />
            <input type="hidden" name="check_service" id="check_service" value="<?php echo $check_service;?>" />
            <input type="hidden" name="check_replacement" id="check_replacement" value="<?php echo $check_replacement;?>" />
            
            <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
            <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>
            <input type="hidden" name="Exhibitor_Badges_taken" id="Exhibitor_Badges_taken" value="<?php echo $Exhibitor_Badges_taken;?>"/>
            <input type="hidden" name="Rplacement_Badges_taken" id="Rplacement_Badges_taken" value="<?php echo $Rplacement_Badges_taken;?>"/>
          <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $Badge_ID;?>"/>
          <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id;?>"/>
          <input type="radio" name="Badge_Type" id="Badge_Type" value="E"/>
          </td>
          <td width="100">Exhibitor / Additional Badge</td>
          <!--<td width="20"><input type="radio" name="Badge_Type" id="Badge_Type1" value="S"/></td>
          <td width="100">Temporary  Badge</td>
          <td width="20"><input type="radio" name="Badge_Type" id="Badge_Type2" value="M"/></td>
          <td width="125">Additional Badge</td>
		  -->
        <td><input type="radio" name="Badge_Type" id="Badge_Type1" value="R"/></td>
        <td width="300">Replace Badge</td>
          </tr>
		</table>

        <table border="0" cellspacing="0" cellpadding="0" class="formManual">
        <tr>
          <td>Name<sup>*</sup></td>
          <td>:</td>
          <td width="250"><input type="text" name="Badge_Name" id="Badge_Name" class="textField" /></td>
          <td>Designation<sup>*</sup></td>
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
          <td>Mobile No<sup>*</sup></td>
          <td width="100"><input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" /></td>
        </tr>
        <tr>
          <td>Photo</td>
          <td>:</td>
          <td><div class="chooseButton" style="margin-bottom:0px;">
              <input type="file" name="photoimg" id="photoimg" class="textField" />
          </div></td>
          <?php if($_SESSION['admin_admin_access']=='ALL'){?>
          <!--<td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>-->
          <?php }?>
          <td>&nbsp;</td>
        </tr>
        </table>
</form>

<div class="title"><h4>Collection Mode</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td width="20"><input type="radio" name="Collection_Mode" id="Collection_Mode" value="C" <?php if($Collection_Mode=="C"){?> checked="checked"<?php }?>/></td>
    <td>Courier </td>
    </tr>
</table>

<div class="title"><h4>Exhibitor Badges Details</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Exhibitor Badges Taken.........................*/
	$badges_cnt=1;
	$query=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='E'");
	$e_badge=$query->num_rows;
	while($result=$query->fetch_assoc()){
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
		<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" width="120" height="120" alt="" /></a>
		<?php }else {?>
		<img src="../images/scan_photo.jpg"  alt="" />
		<?php }?>
    <hr/>
	<?php if($result['Badge_Document']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" width="120" height="120" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
	<?php  
			if($result['Badge_Approved']=='Y')
			echo "<img src='../images/correct.png'  alt='' />"." Image Approved";
			else if($result['Badge_Approved']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />"." Image Dispproved";
			else
			echo "<img src='../images/pending.png'  alt='' />"." Image Pending";		
	?>	
    <div style="float:left">
		<?php if($result['Badge_IsKeyPerson']==1){?><img src="../../images/Key.png" alt="" /><?php }?>
		<div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Name :   </label>
			<input type="text" name="Badge_Name" id="Badge_Name" class="textField" value="<?php echo $result['Badge_Name'];?>" />
		</div>
		
		<div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Designation :
			</label>
            <select name="Badge_Designation" id="Badge_Designation" class="textField">
        <option value="">--Select Designation--</option>
        <option  value="Chairman" <?php if($result['Badge_Designation']=="Chairman"){?>selected="selected" <?php }?>>Chairman</option>
        <option value="CEO" <?php if($result['Badge_Designation']=="CEO"){?>selected="selected" <?php }?>>CEO</option>
        <option value="Managing Director" <?php if($result['Badge_Designation']=="Managing Director"){?>selected="selected" <?php }?>>Managing Director</option>
        <option value="Partner" <?php if($result['Badge_Designation']=="Partner"){?>selected="selected" <?php }?>>Partner</option>
        <option value="Director" <?php if($result['Badge_Designation']=="Director"){?>selected="selected" <?php }?>>Director</option>
        <option value="Proprietor" <?php if($result['Badge_Designation']=="Proprietor"){?>selected="selected" <?php }?>>Proprieter</option>
        <option value="Marketing" <?php if($result['Badge_Designation']=="Marketing"){?>selected="selected" <?php }?>>Marketing</option>
        <option value="Sales" <?php if($result['Badge_Designation']=="Sales"){?>selected="selected" <?php }?>>Sales</option>
        <option value="Finance" <?php if($result['Badge_Designation']=="Finance"){?>selected="selected" <?php }?>>Finance</option>
        <option value="Purchase" <?php if($result['Badge_Designation']=="Purchase"){?>selected="selected" <?php }?>>Purchase</option>
        <option value="Staff" <?php if($result['Badge_Designation']=="Staff"){?>selected="selected" <?php }?>>Staff</option>
        <option value="Hostess" <?php if($result['Badge_Designation']=="Hostess"){?>selected="selected" <?php }?>>Hostess</option>
    </select>
		</div> 
		<div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
        <input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $result['Badge_Mobile'];?>" />
      </div>
		<div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Photo :</label>
		    <input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
		</div> 
      </div>
    	<td>Disapprove Reason </td>
      	<td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason" id="Badge_Reason<?php echo $badges_cnt;?>" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		<br/>
        Charges Applicable:
        <?php 
		if($result['Is_Additional']=='Y')
			echo 0;
		else
		    echo "0";
		?>
		</td>
	
	<?php if($_SESSION['admin_admin_access']=='ALL'){?>
	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
    <?php }?>
   </tr>	
	<input type="hidden" name="Badge_Item_ID<?php echo $badges_cnt;?>" id="Badge_Item_ID<?php echo $badges_cnt;?>" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_T" id="Badge_T<?php echo $badges_cnt;?>" value="E"/>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="E"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
 </form>
<?php $badges_cnt++; }?>
</table>

<div class="title"><h4>Maintenance Badges Details</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Maintinance Badges Taken.........................*/
	$query=$conn ->query("SELECT * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='S'");
	$m_badge=$query->num_rows;
	while($result=$query->fetch_assoc()){
   ?>
   
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
		<td width="9%">&nbsp;</td>
	</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Photo']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo'];?>" width="120" height="120" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
    <hr/>
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Document']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" width="120" height="120" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
    
	<?php  
		if($result['Badge_Approved']=='Y')
		echo "<img src='../images/correct.png'  alt='' />"." Image Approved";
		else if($result['Badge_Approved']=='N')
		echo "<img src='../images/red_cross.png'  alt='' />"." Image Dispproved";
		else
		echo "<img src='../images/pending.png'  alt='' />"." Image Pending";		
	?> 
    <div style="float:left">
    <?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
  	<label class="block">
    <sup>*</sup>Name :   </label>
    <input type="text" name="Badge_Name" id="Badge_Name" class="textField" value="<?php echo $result['Badge_Name'];?>" />
    </div>
      
     <div class="bottomSpace">
        <label class="block">
    	<sup>*</sup>Designation : 
    	</label>
      	<input type="text" name="Badge_Designation" id="Badge_Designation" class="textField" value="<?php echo $result['Badge_Designation'];?>" />
      </div> 
	  <div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
		
        <input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $result['Badge_Mobile'];?>" />
	</div> 
	 <div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Photo :</label>
			<input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
	 </div>  
  </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason<?php echo $badges_cnt;?>" id="Badge_Reason<?php echo $badges_cnt;?>" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		<br/>
        Charges Applicable:
        <?php 
		echo intval(500);
	    ?>
		</td>
        <?php if($_SESSION['admin_admin_access']=='ALL'){?>
    	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
        <?php }?>
    </tr>
    <input type="hidden" name="Badge_Item_ID<?php echo $badges_cnt;?>" id="Badge_Item_ID<?php echo $badges_cnt;?>" value="<?php echo $result['Badge_Item_ID'];?>"/>
    <input type="hidden" name="Badge_T" id="Badge_T<?php echo $badges_cnt;?>" value="S"/>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="S"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
</form>
<?php $badges_cnt++; } ?>
</table>
<!--
<div class="title"><h4>Additional Badge Details</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*................... Management Badges Taken.........................*/
	//echo "SELECT * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='M'";
	$query=$conn ->query("SELECT * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='M'");
	$s_badge=$query->num_rows;
	while($result=$query->fetch_assoc()){
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
		<td width="9%">&nbsp;</td>
		</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
		<?php if($result['Badge_Photo']!=""){?>
		<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" width="120" height="120" alt="" /></a>
		<?php }else {?>
		<img src="../images/scan_photo.jpg"  alt="" />
		<?php }?>
    <hr/>
	<?php if($result['Badge_Document']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" width="120" height="120" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
	<?php  
				if($result['Badge_Approved']=='Y')
				echo "<img src='../images/correct.png'  alt='' />"." Image Approved";
				else if($result['Badge_Approved']=='N')
				echo "<img src='../images/red_cross.png'  alt='' />"." Image Dispproved";
				else
				echo "<img src='../images/pending.png'  alt='' />"." Image Pending";		
	?> 
    <div style="float:left">
    <?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
  	<label class="block">
    <sup>*</sup>Name :   </label>
    <input type="text" name="Badge_Name" id="Badge_Name" class="textField" value="<?php echo $result['Badge_Name'];?>" />
    </div>
      
     <div class="bottomSpace">
        <label class="block">
    	<sup>*</sup>Designation : 
    	</label>
         <select name="Badge_Designation" id="Badge_Designation" class="textField">
        <option value="">--Select Designation--</option>
        <option  value="Chairman" <?php if($result['Badge_Designation']=="Chairman"){?>selected="selected" <?php }?>>Chairman</option>
        <option value="CEO" <?php if($result['Badge_Designation']=="CEO"){?>selected="selected" <?php }?>>CEO</option>
        <option value="Managing Director" <?php if($result['Badge_Designation']=="Managing Director"){?>selected="selected" <?php }?>>Managing Director</option>
        <option value="Partner" <?php if($result['Badge_Designation']=="Partner"){?>selected="selected" <?php }?>>Partner</option>
        <option value="Director" <?php if($result['Badge_Designation']=="Director"){?>selected="selected" <?php }?>>Director</option>
        <option value="Proprietor" <?php if($result['Badge_Designation']=="Proprietor"){?>selected="selected" <?php }?>>Proprieter</option>
        <option value="Marketing" <?php if($result['Badge_Designation']=="Marketing"){?>selected="selected" <?php }?>>Marketing</option>
        <option value="Sales" <?php if($result['Badge_Designation']=="Sales"){?>selected="selected" <?php }?>>Sales</option>
        <option value="Finance" <?php if($result['Badge_Designation']=="Finance"){?>selected="selected" <?php }?>>Finance</option>
        <option value="Purchase" <?php if($result['Badge_Designation']=="Purchase"){?>selected="selected" <?php }?>>Purchase</option>
        <option value="Staff" <?php if($result['Badge_Designation']=="Staff"){?>selected="selected" <?php }?>>Staff</option>
        <option value="Hostess" <?php if($result['Badge_Designation']=="Hostess"){?>selected="selected" <?php }?>>Hostess</option>
    </select>
      </div> 
	  <div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
      <input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $result['Badge_Mobile'];?>"/>	
	</div> 
	 <div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Photo :</label>
			<input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
	 </div>  
  </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason<?php echo $badges_cnt;?>" id="Badge_Reason<?php echo $badges_cnt;?>" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		<br/>
		Charges Applicable: 1500; 
		</td>
        <?php if($_SESSION['admin_admin_access']=='ALL'){?>
    	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
        <?php }?>
    </tr>
    <input type="hidden" name="Badge_Item_ID<?php echo $badges_cnt;?>" id="Badge_Item_ID<?php echo $badges_cnt;?>" value="<?php echo $result['Badge_Item_ID'];?>"/>

    <input type="hidden" name="Badge_T" id="Badge_T<?php echo $badges_cnt;?>" value="M"/>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="M"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
</form>
<?php $badges_cnt++; } ?>
</table>
-->

<div class="title"><h4>Replaced Badges Details</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*................... Replacement Badges Taken.........................*/
	$query=$conn ->query("SELECT * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='R'");
	$r_badge=$query->num_rows;
	while($result=$query->fetch_assoc()){
   ?>
   <form action="update_badges.php" method="post" enctype="multipart/form-data">
	 <tr>
		<td colspan="3" valign="top">Date : <?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
		<td width="9%">&nbsp;</td>
		</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
		<?php if($result['Badge_Photo']!=""){?>
		<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" width="120" height="120" alt="" /></a>
		<?php }else {?>
		<img src="../images/scan_photo.jpg"  alt="" />
		<?php }?>
    <hr/>
	<?php if($result['Badge_Document']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Document'];?>" width="120" height="120" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
	<?php  
				if($result['Badge_Approved']=='Y')
				echo "<img src='../images/correct.png'  alt='' />"." Image Approved";
				else if($result['Badge_Approved']=='N')
				echo "<img src='../images/red_cross.png'  alt='' />"." Image Dispproved";
				else
				echo "<img src='../images/pending.png'  alt='' />"." Image Pending";		
	?> 
    <div style="float:left">
    <?php if($result['Badge_IsKeyPerson']==1){?><img src="../images/Key.png" alt="" /><?php }?>
	<div class="bottomSpace">
  	<label class="block">
    <sup>*</sup>Name :   </label>
    <input type="text" name="Badge_Name" id="Badge_Name" class="textField" value="<?php echo $result['Badge_Name'];?>" />
    </div>
      
     <div class="bottomSpace">
        <label class="block">
    	<sup>*</sup>Designation : 
    	</label>
         <select name="Badge_Designation" id="Badge_Designation" class="textField">
        <option value="">--Select Designation--</option>
        <option  value="Chairman" <?php if($result['Badge_Designation']=="Chairman"){?>selected="selected" <?php }?>>Chairman</option>
        <option value="CEO" <?php if($result['Badge_Designation']=="CEO"){?>selected="selected" <?php }?>>CEO</option>
        <option value="Managing Director" <?php if($result['Badge_Designation']=="Managing Director"){?>selected="selected" <?php }?>>Managing Director</option>
        <option value="Partner" <?php if($result['Badge_Designation']=="Partner"){?>selected="selected" <?php }?>>Partner</option>
        <option value="Director" <?php if($result['Badge_Designation']=="Director"){?>selected="selected" <?php }?>>Director</option>
        <option value="Proprietor" <?php if($result['Badge_Designation']=="Proprietor"){?>selected="selected" <?php }?>>Proprieter</option>
        <option value="Marketing" <?php if($result['Badge_Designation']=="Marketing"){?>selected="selected" <?php }?>>Marketing</option>
        <option value="Sales" <?php if($result['Badge_Designation']=="Sales"){?>selected="selected" <?php }?>>Sales</option>
        <option value="Finance" <?php if($result['Badge_Designation']=="Finance"){?>selected="selected" <?php }?>>Finance</option>
        <option value="Purchase" <?php if($result['Badge_Designation']=="Purchase"){?>selected="selected" <?php }?>>Purchase</option>
        <option value="Staff" <?php if($result['Badge_Designation']=="Staff"){?>selected="selected" <?php }?>>Staff</option>
        <option value="Hostess" <?php if($result['Badge_Designation']=="Hostess"){?>selected="selected" <?php }?>>Hostess</option>
    </select>
      </div> 
	  <div class="bottomSpace">
      	<label class="block">
    		<sup>*</sup>Mobile No : 
    	</label>
      <input type="text" name="Badge_Mobile" id="Badge_Mobile" class="textField" value="<?php echo $result['Badge_Mobile'];?>"/>	
	</div> 
	 <div class="bottomSpace">
			<label class="block">
			<sup>*</sup>Photo :</label>
			<input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
	 </div>
	<?php if($result['Replacement_ID']!='') {?>
	<div class="bottomSpace">
			<label class="block"><sup>*</sup>Replaced with : <?php echo getKeyName($result['Replacement_ID'],$conn);?></label>
	</div>
	<?php } ?>
  </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved<?php echo $badges_cnt;?>" id="Badge_Approved<?php echo $badges_cnt;?>" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason<?php echo $badges_cnt;?>" id="Badge_Reason<?php echo $badges_cnt;?>" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		<br/>
		Charges Applicable: 500; 
		</td>
        <?php  if($_SESSION['admin_admin_access']=='ALL'){?>
    	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
        <?php }?>
    </tr>
    <input type="hidden" name="Badge_Item_ID<?php echo $badges_cnt;?>" id="Badge_Item_ID<?php echo $badges_cnt;?>" value="<?php echo $result['Badge_Item_ID'];?>"/>

    <input type="hidden" name="Badge_T" id="Badge_T<?php echo $badges_cnt;?>" value="R"/>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="M"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
</form>
<?php $badges_cnt++; }?>
<input type="hidden" name="Badges_count" id="Badges_count" value="<?php echo $e_badge+$s_badge+$m_badge+$r_badge;?>"/>
</table>

<div class="clear"></div>
<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>   
    <div class="leftStatus"><span><input name="Info_Approved" id="Info_Approved" type="radio" value="Y" <?php if($Info_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Info_Approved" id="Info_Approved" type="radio" value="N" <?php if($Info_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>    
    <div class="clear"></div>
    <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo "$Info_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="clear"></div>

<?php 
$wquery=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and WaveOff!='Y' and Badge_Type='E'");
$wquery1=$conn ->query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and WaveOff='Y' and Badge_Type='E'");

$wresult = $wquery1->fetch_assoc(); 
$wnum=$wquery->num_rows;
$WaveOff_Reason=$wresult['WaveOff_Reason'];
if($_SESSION['admin_admin_access']=='ALL'){
?>

<input type="hidden" name="WaveOff" id="WaveOff" value="P"/>
<!--
<div class="title"><h4>Wawe Off</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   		<div class="leftStatus"><span><input name="WaveOff" id="WaveOff" type="radio" value="Y" <?php if($wnum>=0){?> checked="checked"<?php }?>/>
   		</span>Yes </div> 
   		<div class="leftStatus"> <span><input name="WaveOff" id="WaveOff" type="radio" value="P" <?php if($wnum==0){?> checked="checked"<?php }?>/></span> No</div>
    	<div class="clear"></div>
    	<textarea name="WaveOff_Reason" id="WaveOff_Reason" class="textArea"><?php if($wnum==0){echo $WaveOff_Reason; }?></textarea>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } else{?>
<input name="WaveOff" id="WaveOff" type="hidden" value="P" checked="checked"/>
<?php }?>
-->
<div class="title"><h4>Payment Information</h4></div>
<div class="clear"></div>
<?php 
	$qgetPaymentDetail=$conn ->query("select * from iijs_payment_master where Payment_Master_OrderNo='$order_id'");
	$rgetPaymentDetail=$qgetPaymentDetail->fetch_assoc();
	$Payment_Master_Approved=$rgetPaymentDetail['Payment_Master_Approved'];
	$tds_tax=$rgetPaymentDetail['tds_tax'];
	$tds_amount=$rgetPaymentDetail['tds_amount'];
	$net_payable_amount=$rgetPaymentDetail['net_payable_amount'];
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<!--
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
  -->
  <tr>
	<td class="bold"><p>Replacement badge charges</p></td>
    <td>:</td>
    <td><?php echo $replacement_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Total Amount </strong></td>
    <td>:</td>
    <td><?php echo $total_amount= $maintenance_charge+$mangmnt_charge+$replacement_charge;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $total_amount;?>"/></td>
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

<input type="hidden" name="Payment_Mode_ID" id="Payment_Mode_ID"  value="1" checked="checked" />

<?php if($_SESSION['admin_admin_access']=='ALL'){?>
<div class="clear"></div>
<div class="title"><h4>Payment Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   <div class="leftStatus"><span><input name="Payment_Master_Approved" id="Payment_Master_Approved" type="radio" value="Y" <?php if($Payment_Master_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Payment_Master_Approved" id="Payment_Master_Approved" type="radio" value="N" <?php if($Payment_Master_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Payment_Master_Reason" id="Payment_Master_Reason" class="textArea"><?php echo "$Payment_Master_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } else {?>
<input name="Payment_Master_Approved" id="Payment_Master_Approved" type="hidden" value="<?php echo $Payment_Master_Approved;?>"/>
<?php }?>
<div>
    <a href="../print_acknowledge/exhibitors_badges.php?order_id=<?php echo $_REQUEST['order_id'];?>&EXHIBITOR_CODE=<?php echo $exhibitor_code?>" class="button5" target="_blank">Print AcknowledgeMent</a>
	<input type="hidden" name="save" id="save" value="Save"/>
    <input name="update_badge" id="update_badge" type="button" value="Update" class="maroon_btn" />
</div>
</div>
		</div>
	</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
