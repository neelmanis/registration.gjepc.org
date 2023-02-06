<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$exhibitor_code=mysql_real_escape_string($_REQUEST['Exhibitor_Code']);

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

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
<title>Manual || Exhibitor badges / Car Passes||</title>

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
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
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
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
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
<script src="js/badges.js"></script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > EXHIBITOR BADGES / CAR PASSES FORM</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">EXHIBITOR BADGES / CAR PASSES FORM</div>
		<div class="content_details22">
			<div id="formWrapper">
	<h2>Notes :</h2>
	<ol class="numeric">
	<li>The deadline for the submission of Exhibitor badge without surcharge is <strong>20th January 2014</strong></li>


<li>Badges received after the <strong>20th January 2014</strong> Rs. 1750/- will be charged per Exhibitior Badge</li>

<li>The Final deadline with Surcharge for the submission of badge is <strong>25th January 2014</strong></li>
<li>Collection of Badges entries made after the<strong> 20th January 2014</strong> will be at the venue.</li>

</ol>
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

<div class="title">
<h4>Car Passes Information</h4>
</div>
<?php 
/*..........................Get Maximum Car Available....................................*/
$query=mysql_query("select * from iijs_carpass_master where CarPass_Area='$Exhibitor_Area'");
$result=mysql_fetch_array($query);
$CarPass_AvailablePasses=$result['CarPass_AvailablePasses'];

/*..........................Get Car Passess Taken....................................*/
$num_avail_car=0;
$num_taken_car=0;
$query1=mysql_query("select * from iijs_badge where Exhibitor_Code='$exhibitor_code'");
$result1=mysql_fetch_array($query1);
$Collection_Mode=$result1['Collection_Mode'];
$Info_Approved=$result1['Info_Approved'];
$Info_Reason=$result1['Info_Reason'];
$num1=mysql_num_rows($query1);
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
?>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
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
<div class="title">
<h4>Badges Information</h4>

</div>
<div class="clear"></div>
<?php 
/*..........................Get Maximum Badges Available....................................*/

$query=mysql_query("select * from iijs_badge_master where Stall_Area='$Exhibitor_Area'");
$result=mysql_fetch_array($query);
$Exhibitor_Badges_avail=$result['Exhibitor_Badges'];
$Service_Badges_avail=$result['Service_Badges'];

/*..........................Get Maximum Badges Taken...................................*/

$query=mysql_query("select Badge_ID from iijs_badge where Exhibitor_Code='$exhibitor_code'");
$result=mysql_fetch_array($query);
$num=mysql_num_rows($query);
if($num>0)
{
	$Badge_ID=$result['Badge_ID'];
	$Equery=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='E'");
	$Enum=mysql_num_rows($Equery);
	$Exhibitor_Badges_taken=$Enum;
	$Squery=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='S'");
	$Snum=mysql_num_rows($Squery);
	$Service_Badges_taken=$Snum;
}
else
{
	$Exhibitor_Badges_taken=0;
	$Service_Badges_taken=0;
}

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
    <td class="bold">Maximum Maintenance Available</td>
    <td>:</td>
    <td><?php echo $Service_Badges_avail;?></td>
    <td>&nbsp;</td>
    <td class="bold">Badges Taken</td>
    <td>:</td>
    <td><?php echo $Service_Badges_taken;?></td>
  </tr>
</table>

<div class="title">
        <h4>Exhibitor Badges Taken</h4>
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
	/*...................Exhibitor Badges Taken.........................*/
	$query=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='E'");
	$j=1;
	$extra_charge=0;
	while($result=mysql_fetch_array($query)){
	if($result['WaveOff']!="Y")
	{
		$extra_charge=$extra_charge+intval($result['Surcharge']);
	}
   ?>
   <tr>
	<td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
    <td><?php echo $result['Surcharge'];?></td>
   </tr>
  <?php $j++;}?>
  <input type="hidden" name="Exhibitor_badge_count" id="Exhibitor_badge_count" value="<?php echo $j;?>"/>
  <input type="hidden" name="Exhibitor_Badges_avail" id="Exhibitor_Badges_avail" value="<?php echo $Exhibitor_Badges_avail;?>"/>

</table>

<div class="title">
        <h4>Maintenance Badges Taken</h4>
</div>

<div class="clear"></div>
<table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <th>Date</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Charges Applicable</th>
   </tr>
   <?php
   /*..................Select Maintenance Badges Taken..........................*/
	$query=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='S'");
	$i=1;
	$maintenance_charge=0;
	while($result=mysql_fetch_array($query)){
	$maintenance_charge=$maintenance_charge+500;
	?>
	<tr>
    <td><?php echo date('d-m-Y',strtotime($result['Create_Date']));?></td>
    <td><?php echo $result['Badge_Name'];?></td>
    <td><?php echo $result['Badge_Designation'];?></td>
    <td>500</td>
    </tr>
   <?php $i++;}?>
   <input type="hidden" name="maintenance_badge_count" id="maintenance_badge_count" value="<?php echo $i;?>"/>
   <input type="hidden" name="Service_Badges_avail" id="Service_Badges_avail" value="<?php echo $Service_Badges_avail;?>"/>

</table>
<div class="title">
        <h4>New Badge Details</h4>
</div>
<div class="clear"></div>
<form id="badgeForm" name="badgeForm" method="post" enctype="multipart/form-data" action='addbadges_ajax.php'>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <td width="20">
	<input type="hidden" name="check_services" id="check_services" value="<?php echo $check_services;?>"/>
	<input type="hidden" name="check_exhibitor" id="check_exhibitor" value="<?php echo $check_exhibitor;?>"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $Badge_ID;?>"/>
	<input type="radio" name="Badge_Type" id="Badge_Type" value="E" />
	
	</td>
    <td width="100">Exhibitor Badge</td>
    <td width="20"><input type="radio" name="Badge_Type" id="Badge_Type1" value="S" /></td>
    <td width="100">Maintenance Badge
</td>
    </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td>Name<sup>*</sup></td>
    <td>:</td>
    <td width="250"><input type="text" name="Badge_Name" id="Badge_Name" class="textField" /></td>
    <td>Designation<sup>*</sup></td>
    <td width="100"><input type="text" name="Badge_Designation" id="Badge_Designation" class="textField" /></td>
    </tr>
  <tr>
    <td>Photo</td>
    <td>:</td>
    <td>    
	<div class="chooseButton" style="margin-bottom:0px;">
      <input type="file" name="photoimg" id="photoimg" class="textField" />
    </div>	</td>
    <td><input type="button" name="addbadge" id="addbadge" value="ADD" class="maroon_btn" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<div class="title">
        <h4>Collection Mode</h4>
      </div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual"> 
  <tr>
    <td width="20"><input type="radio" name="Collection_Mode" id="Collection_Mode" value="C" <?php if($Collection_Mode=="C"){?> checked="checked"<?php }?>/></td>
    <td>Courier </td>
    </tr>
</table>

<div class="title">
        <h4>Exhibitor Badges Details</h4>
      </div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<form action="update_badges.php" method="post" enctype="multipart/form-data"> 
 <?php
	/*...................Exhibitor Badges Taken.........................*/
	$i=1;
	$query=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='E'");
	while($result=mysql_fetch_array($query)){
   ?>

	<tr>
		<td colspan="3" valign="top"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?><!--21-06-2013, 08:12:29 AM--></td>
		<td width="9%">&nbsp;</td>
	</tr>
	
	<tr>
    <td colspan="3" valign="top">
	<div class="uploadPhoto" style="float:left; margin-right:20px;">
		<?php if($result['Badge_Photo']!=""){?>
		<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo']?>" width="117" height="147" alt="" /></a>
		<?php }else {?>
		<img src="../images/scan_photo.jpg"  alt="" />
		<?php }?>
	</div>
	<?php  
			if($result['Badge_Approved']=='Y')
			echo "<img src='../images/correct.png'  alt='' />"."Image Approved";
			else if($result['Badge_Approved']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />"."Image Dispproved";
			else
			echo "<img src='../images/pending.png'  alt='' />"."Image Pending";		
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
			<sup>*</sup>Photo :</label>
		    <input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
		</div> 
      </div>
    	<td>Disapprove Reason </td>
      	<td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved[<?php echo $i;?>]" id="Badge_Approved[<?php echo $i;?>]" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved[<?php echo $i;?>]" id="Badge_Approved[<?php echo $i;?>]" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason[<?php echo $i;?>]" id="Badge_Reason[<?php echo $i;?>]" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		</td>
	
	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
   </tr>	

  <input type="hidden" name="Badge_Type" id="Badge_Type" value="E"/>
  <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  <input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
  <input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>
 
<?php $i++; }?>
</table>

<div class="title">
        <h4>Maintinance Badges Details</h4>
      </div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
 <?php
	/*...................Maintinance Badges Taken.........................*/
	$query=mysql_query("SELECT * from iijs_badge_items where Badge_ID='$Badge_ID' and Badge_Type='S'");
	while($result=mysql_fetch_array($query)){
   ?>
 <!--  <form action="update_badges.php" method="post" enctype="multipart/form-data">-->
	 <tr>
		<td colspan="3" valign="top"><?php echo date('d-m-Y',strtotime($result['Create_Date']));?><!--21-06-2013, 08:12:29 AM--></td>
		<td width="9%">&nbsp;</td>
		</tr>
	<tr>
    <td colspan="3" valign="top">
    <div class="uploadPhoto" style="float:left; margin-right:20px;">
	<?php if($result['Badge_Photo']!=""){?>
	<a href="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo'];?>" target="_blank"><img src="../images/badges/<?php echo $exhibitor_code.'/'.$result['Badge_Photo'];?>" width="100" height="80" alt="" /></a>
	<?php }else {?>
	<img src="../images/scan_photo.jpg"  alt="" />
	<?php }?>
	</div>
	<?php  
				if($result['Badge_Approved']=='Y')
				echo "<img src='../images/correct.png'  alt='' />"."Image Approved";
				else if($result['Badge_Approved']=='N')
				echo "<img src='../images/red_cross.png'  alt='' />"."Image Dispproved";
				else
				echo "<img src='../images/pending.png'  alt='' />"."Image Pending";		
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
			<sup>*</sup>Photo :</label>
			<input type="file" name="photoimg" id="photoimg" class="textField" />
			<input type="submit" name="" value="Save" class="maroon_btn"/>
	 </div>  
  </div>
    <td>Disapprove Reason </td>
      <td>:</td>
      <td>    
	   <div class="leftStatus"><span><input name="Badge_Approved[<?php echo $i;?>]" id="Badge_Approved[<?php echo $i;?>]" type="radio" value="Y" <?php if($result['Badge_Approved']=='Y'){ echo "checked='checked'";}?> />
	   </span>Approval </div> 
	   <div class="leftStatus"> <span><input name="Badge_Approved[<?php echo $i;?>]" id="Badge_Approved[<?php echo $i;?>]" type="radio" value="N" <?php if($result['Badge_Approved']=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
		
		<div class="clear"></div>
		<textarea name="Badge_Reason[<?php echo $i;?>]" id="Badge_Reason[<?php echo $i;?>]" class="textArea"><?php if($result['Badge_Approved']=='N'){echo $result['Badge_Reason']; }?></textarea>
		</td>
    	<td><img src="../images/red_cross.png"  alt="" class="badges_delete <?php echo $result['Badge_Item_ID'];?> <?php echo $result['Badge_Type'];?>" style="cursor:pointer;" /></td>
    </tr>
	<input type="hidden" name="Badge_Type" id="Badge_Type" value="S"/>
	<input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	<input type="hidden" name="Badge_Item_ID" id="Badge_Item_ID" value="<?php echo $result['Badge_Item_ID'];?>"/>
	<input type="hidden" name="Badge_ID" id="Badge_ID" value="<?php echo $result['Badge_ID'];?>"/>

<?php $i++; }?>
</form>
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
$wquery=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and WaveOff!='Y' and Badge_Type='E'");
$wquery1=mysql_query("select * from iijs_badge_items where Badge_ID='$Badge_ID' and WaveOff='Y' and Badge_Type='E'");
$wresult=mysql_fetch_array($wquery1);
$wnum=mysql_num_rows($wquery);
$WaveOff_Reason=$wresult['WaveOff_Reason'];
?>

<div class="title"><h4>Wawe Off</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   		<div class="leftStatus"><span><input name="WaveOff" id="WaveOff" type="radio" value="Y" <?php if($wnum==0){?> checked="checked"<?php }?>/>
   		</span>Yes </div> 
   		<div class="leftStatus"> <span><input name="WaveOff" id="WaveOff" type="radio" value="P" <?php if($wnum>0){?> checked="checked"<?php }?>/></span> No</div>
    	<div class="clear"></div>
    	<textarea name="WaveOff_Reason" id="WaveOff_Reason" class="textArea"><?php if($wnum==0){echo $WaveOff_Reason; }?></textarea>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>



<div class="title">
        <h4>Payment Information</h4>
      </div>

<div class="clear"></div>
<?php 
	$query=mysql_query("SELECT * from iijs_payment_master where Exhibitor_Code='$exhibitor_code' and Form_ID='4'");
	$result=mysql_fetch_array($query);
	$Payment_Mode_ID=$result['Payment_Mode_ID'];
	$Payment_Master_Approved=$result['Payment_Master_Approved'];
	$Payment_Master_Reason=$result['Payment_Master_Reason'];
	$Payment_Master_ID=$result['Payment_Master_ID'];
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="25%" class="bold">Replacement Charges</td>
    <td width="3%">:</td>
    <td width="19%"><?php echo $replacement_charges=0;?></td>
    <td width="11%">&nbsp;</td>
	<td class="bold"><p>Exhibitor Maintenance badge charges</p></td>
    <td>:</td>
    <td><?php echo $exhibitor_maintenance_charge=$maintenance_charge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
    <td class="bold">Surcharge</td>
    <td>:</td>
    <td>
	<?php 
		if($wnum>0)
		{
			echo $surcharge=$extra_charge;
		}
		else
		{
			echo $surcharge=0;
		}
	?>
	</td>
  </tr>
 
  <tr>
    <td><strong>Total Amount </strong></td>
    <td>:</td>
    <td><?php echo $total_amount= $exhibitor_maintenance_charge+$surcharge;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Service Tax (12%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$total_amount*12/100;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">E-Cess tax (2%) </td>
    <td>:</td>
    <td><?php echo $ecess_tax=$service_tax*2/100;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">S.H.E. Cess Tax (1%) </td>
    <td>:</td>
    <td><?php echo $she_cess_tax=$service_tax*1/100; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable </td>
    <td>:</td>
    <td><?php echo $total_payble=round($total_amount+$service_tax+$ecess_tax+$she_cess_tax);?></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>





<div class="title">
        <h4>Payment Mode</h4>
      </div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID"  value="1" <?php if($Payment_Mode_ID==1){?> checked="checked"<?php }?> /></td>
    <td width="100">Credit Card</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID"  value="2" <?php if($Payment_Mode_ID==2){?> checked="checked"<?php }?> /></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID"  value="4" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?> /></td>
    <td>DD</td>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  </tr>
</table>
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


<ol class="numeric">
<li>Cheque should be in favour of ? <strong>"The Gem and Jewellery Export Promotion Council."</strong></li>
<li>For payment approval all cheques/drafts/ Wire Transfer should reach the council within<strong> 3 working days after order date</strong> failing will result in cancellation of order.</li>


</ol>


<div>
	<a href="print_acknowledge/exhibitors_badges.php?Payment_Master_ID=<?php echo $Payment_Master_ID?>&Badge_ID=<?php echo $Badge_ID;?>&EXHIBITOR_CODE=<?php echo $exhibitor_code?>" target="_blank" class="button5">Print AcknoledgeMent</a>
	<input type="hidden" name="save" id="save" value="Save"/>
	<input name="update_badge" id="update_badge" type="button" value="Update" class="maroon_btn" />
	</div>


		</div>
	</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
