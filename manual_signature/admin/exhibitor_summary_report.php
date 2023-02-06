<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

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
<title>Exhibitor Summary Report</title>

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

</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Exhibitor Summary Report</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Exhibitor Summary Report <div style="float:right; padding-right:10px; font-size:12px;"><input type="submit" name="Print" value="Print"  class="input_submit" onClick="PrintDiv();" /></div> <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_exhibitor.php">&nbsp;Back To Exhibitor List</a></div></div>
<div id="divToPrint">
<div class="content_details22">
<div id="formWrapper">
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


<!-- ------------------------------  Form no 1 ---------------------------------------------------------->

<div class="title"><h4>Form No. 1 Compulsory Catalogue Entry</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Product Logo</td>
  <td class="bold">Product Logo Reason</td>
  <td class="bold">Company Logo</td>
  <td class="bold">Company Logo Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql1="SELECT * FROM  `iijs_catalog` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result1=mysql_query($sql1);
$rows1=mysql_fetch_array($result1);
$num1=mysql_num_rows($result1);
if($num1==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form1.php?Catalog_ID=<?php echo $rows1['Catalog_ID'];?>&Exhibitor_Code=<?php echo $rows1['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows1['Create_Date']));?></a></td>
  <td><?php if($rows1['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows1['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows1['Info_Approved']=='N'){echo $rows1['Info_Reason'];} ?></td>
  <td><?php if($rows1['ProductLogo_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows1['ProductLogo_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows1['ProductLogo_Approved']=='N'){echo $rows1['ProductLogo_Reason'];} ?></td>
  <td><?php if($rows1['CompanyLogo_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows1['CompanyLogo_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows1['CompanyLogo_Approved']=='N'){echo $rows1['CompanyLogo_Reason'];} ?></td>
  <td><?php if($rows1['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows1['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>



<!-- ------------------------------  Form no 2 ---------------------------------------------------------->


<div class="title"><h4>Form No. 2 Stall Layout</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Stall Layout Approved</td>
  <td class="bold">Layout Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql2="SELECT * FROM  `iijs_stall_master` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result2=mysql_query($sql2);
$rows2=mysql_fetch_array($result2);
$num2=mysql_num_rows($result2);
if($num2==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form2.php?Stall_ID=<?php echo $rows2['Stall_ID'];?>&Exhibitor_Code=<?php echo $rows2['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows2['Create_Date']));?></a></td>
  <td><?php if($rows2['Stall_Basic_Layout_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows2['Stall_Basic_Layout_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows2['Stall_Basic_Layout_Approved']=='N'){echo $rows2['Stall_Basic_Layout_Reason'];} ?></td>
  <td><?php if($rows2['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows2['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>



<!-- ------------------------------  Form no 3 ---------------------------------------------------------->


<div class="title"><h4>Form No. 3 Standfitting Services</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql3="SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.Payment_Master_ID AND  a.`Exhibitor_Code` = '$exhibitor_code' order by b.Payment_Master_ID asc";
$result3=mysql_query($sql3);
$num3=mysql_num_rows($result3);
if($num3==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
	$i=1;
	while($rows3=mysql_fetch_array($result3))
	{
?>
<tr>
  <td><a href="print_acknowledge/standfitting.php?Payment_Master_ID=<?php echo $rows3['Payment_Master_ID']?>&Stand_ID=<?php echo $rows3['Stand_ID'];?>&orderno=<?php echo $i;?>&Exhibitor_Code=<?php echo $rows3['Exhibitor_Code'];?>" target="_blank"><?php echo date("d-m-Y",strtotime($rows3['Create_Date']));?></a></td>
  <td><?php if($rows3['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows3['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows3['Info_Approved']=='N'){echo $rows3['Info_Reason'];} ?></td>
  <td><?php if($rows3['Payment_Master_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows3['Payment_Master_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows3['Payment_Master_Approved']=='N'){echo $rows3['Payment_Master_Reason'];} ?></td>
  <td><?php if($rows3['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows3['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php $i++;}}?>
</table>


<!-- ------------------------------  Form no 4 ---------------------------------------------------------->


<div class="title"><h4>Form No. 4 Exhibitor Badges / Car Passes</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql4="SELECT a.*,b.* FROM `iijs_badge` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.Payment_Master_ID AND  a.`Exhibitor_Code` = '$exhibitor_code'";
$result4=mysql_query($sql4);
$num4=mysql_num_rows($result4);
if($num4==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
	while($rows4=mysql_fetch_array($result4))
	{
?>
<tr>
  <td><a href="print_acknowledge/exhibitors_badges.php?Payment_Master_ID=<?php echo $rows4['Payment_Master_ID'];?>&Badge_ID=<?php echo $rows4['Badge_ID'];?>&EXHIBITOR_CODE=<?php echo $rows4['Exhibitor_Code']?>" target="_blank"><?php echo date("d-m-Y",strtotime($rows4['Create_Date']));?></a></td>
  <td><?php if($rows4['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows4['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows4['Info_Approved']=='N'){echo $rows4['Info_Reason'];} ?></td>
  <td><?php if($rows4['Payment_Master_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows4['Payment_Master_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows4['Payment_Master_Approved']=='N'){echo $rows4['Payment_Master_Reason'];} ?></td>
  <td><?php if($rows4['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows4['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }}?>
</table>



<!-- ------------------------------  Form no 5 ---------------------------------------------------------->


<div class="title"><h4>Form No. 5 Wireless Internet Connection</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Items Approved</td>
  <td class="bold">Items Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql5="SELECT * FROM  `iijs_wirelessinternet` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result5=mysql_query($sql5);
$rows5=mysql_fetch_array($result5);
$num5=mysql_num_rows($result5);
if($num5==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form5.php?WireLessInternet_ID=<?php echo $rows5['WireLessInternet_ID'];?>&Exhibitor_Code=<?php echo $rows5['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows5['Create_Date']));?></a></td>
  <td><?php if($rows5['Items_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows5['Items_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows5['Items_Approved']=='N'){echo $rows5['Items_Reason'];} ?></td>
  <td><?php if($rows5['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows5['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>



<!-- ------------------------------  Form no 8 ---------------------------------------------------------->

<div class="title"><h4>Form No. 8 Electronic Surveillance</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql8="SELECT a.*,b.* FROM `iijs_cctv` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.Payment_Master_ID AND  a.`Exhibitor_Code` = '$exhibitor_code' order by b.Payment_Master_ID asc";
$result8=mysql_query($sql8);
$num8=mysql_num_rows($result8);
if($num8==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
	$i=1;
	while($rows8=mysql_fetch_array($result8))
	{
?>
<tr>
  <td><a href="print_acknowledge/electronic_servillance.php?Payment_Master_ID=<?php echo $rows8['Payment_Master_ID']?>&CCTV_ID=<?php echo $rows8['CCTV_ID'];?>&orderno=<?php echo $i;?>&Exhibitor_Code=<?php echo $rows8['Exhibitor_Code'];?>" target="_blank"><?php echo date("d-m-Y",strtotime($rows8['Create_Date']));?></a></td>
  <td><?php if($rows8['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows8['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows8['Info_Approved']=='N'){echo $rows8['Info_Reason'];} ?></td>
  <td><?php if($rows8['Payment_Master_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows8['Payment_Master_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows8['Payment_Master_Approved']=='N'){echo $rows8['Payment_Master_Reason'];} ?></td>
  <td><?php if($rows8['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows8['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php $i++;} }?>
</table>


<?php if($Exhibitor_Area!="9"){?>
<!-- ------------------------------  Form no 9A ---------------------------------------------------------->

<div class="title"><h4>Form No. 9 Safe Rental</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$i=1; 
$qbadge_key=mysql_query("SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND `Badge_Type`='E' AND Badge_IsKeyPerson='1'");
while($rbadge_key=mysql_fetch_array($qbadge_key))
{
		if($i==1){$Badge_Item_ID1=$rbadge_key['Badge_Item_ID'];}
		if($i==2){$Badge_Item_ID2=$rbadge_key['Badge_Item_ID'];}
		$i++;
} 

$sql9A="SELECT a.*,b.* FROM `iijs_safe_rental` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.Payment_Master_ID AND  a.`Exhibitor_Code` = '$exhibitor_code' order by b.Payment_Master_ID asc";
$result9A=mysql_query($sql9A);
$num9A=mysql_num_rows($result9A);
if($num9A==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{	$i=1;
	while($rows9A=mysql_fetch_array($result9A))
	{
?>
<tr>
  <td><a href="print_acknowledge/safe_rental_or_indemnity_bond_form.php?Payment_Master_ID=<?php echo $rows9A['Payment_Master_ID']?>&Safe_Rental_ID=<?php echo $rows9A['Safe_Rental_ID'];?>&orderno=<?php echo $i;;?>&Badge_Item_ID1=<?php echo $Badge_Item_ID1;?>&Badge_Item_ID2=<?php echo $Badge_Item_ID2;?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" target="_blank" ><?php echo date("d-m-Y",strtotime($rows9A['Create_Date']));?></a></td>
  <td><?php if($rows9A['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows9A['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows9A['Info_Approved']=='N'){echo $rows9A['Info_Reason'];} ?></td>
  <td><?php if($rows9A['Payment_Master_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows9A['Payment_Master_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows9A['Payment_Master_Approved']=='N'){echo $rows9A['Payment_Master_Reason'];} ?></td>
  <td><?php if($rows9A['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows9A['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php $i++;}}?>
</table>

<?php $i++;} else {?>
<!-- ------------------------------  Form no 9B ---------------------------------------------------------->

<div class="title"><h4>Form No. 9 Storng Room</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Iteams Approved</td>
  <td class="bold">Iteams Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql9B="SELECT * FROM  `iijs_strongroom` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result9B=mysql_query($sql9B);
$rows9B=mysql_fetch_array($result9B);
$num9B=mysql_num_rows($result9B);
if($num9B==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="print_acknowledge/strong_room_print.php?exhibitor_code=<?php echo $rows9B['Exhibitor_Code'];?>&StrongRoom_ID=<?php echo $rows9B['StrongRoom_ID'];?>"><?php echo date("d-m-Y",strtotime($rows9B['Create_Date']));?></a></td>
  <td><?php if($rows9B['Items_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows9B['Items_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows9B['Items_Approved']=='N'){echo $rows9B['Items_Reason'];} ?></td>
  <td><?php if($rows9B['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows9B['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>
<?php }?>




<!-- ------------------------------  Form no 10 ---------------------------------------------------------->

<div class="title"><h4>Form No. 10 Floral /Plant Rental</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql10="SELECT a.*,b.* FROM `iijs_floral` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.Payment_Master_ID AND  a.`Exhibitor_Code` = '$exhibitor_code' order by b.Payment_Master_ID asc";
$result10=mysql_query($sql10);
$num10=mysql_num_rows($result10);
if($num10==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
	$i=1;
	while($rows10=mysql_fetch_array($result10))
	{
?>
<tr>
  <td><a href="print_acknowledge/floral_plant_rental.php?Payment_Master_ID=<?php echo $rows10['Payment_Master_ID']?>&Floral_ID=<?php echo $rows10['Floral_ID'];?>&orderno=<?php echo $i;?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" target="_blank"><?php echo date("d-m-Y",strtotime($rows10['Create_Date']));?></a></td>
  <td><?php if($rows10['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows10['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows10['Info_Approved']=='N'){echo $rows10['Info_Reason'];} ?></td>
  <td><?php if($rows10['Payment_Master_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows10['Payment_Master_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows10['Payment_Master_Approved']=='N'){echo $rows10['Payment_Master_Reason'];} ?></td>
  <td><?php if($rows10['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows10['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php $i++;} }?>
</table>



<!-- ------------------------------  Form no 13 ---------------------------------------------------------->

<div class="title"><h4>Form No. 13 Hotel Reservations</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql13="SELECT * FROM  `hotel_registration_details` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result13=mysql_query($sql13);
$rows13=mysql_fetch_array($result13);
$num13=mysql_num_rows($result13);
if($num13==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form13.php?id=<?php echo $rows13['id'];?>&Exhibitor_Code=<?php echo $rows13['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows13['Create_Date']));?></a></td>
  <td><?php if($rows13['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows13['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows13['Info_Approved']=='N'){echo $rows13['Info_Reason'];} ?></td>
  <td><?php if($rows13['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows13['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>





<!-- ------------------------------  Form no 14 ---------------------------------------------------------->

<div class="title"><h4>Form No. 14 Visa Application Assistance</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Passport Approved</td>
  <td class="bold">Passport Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql14="SELECT * FROM  `iijs_visa_application` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result14=mysql_query($sql14);
$rows14=mysql_fetch_array($result14);
$num14=mysql_num_rows($result14);
if($num14==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form14.php?Visa_Application_ID=<?php echo $rows14['Visa_Application_ID'];?>&Exhibitor_Code=<?php echo $rows14['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows14['Create_Date']));?></a></td>
  <td><?php if($rows14['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows14['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows14['Info_Approved']=='N'){echo $rows14['Info_Reason'];} ?></td>
  <td><?php if($rows14['passport_pic_approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows14['passport_pic_approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows14['passport_pic_approved']=='N'){echo $rows14['passport_pic_reason'];} ?></td>
  <td><?php if($rows14['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows14['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>




<!-- ------------------------------  Form no 16 ---------------------------------------------------------->

<div class="title"><h4>Form No. 16 Housekeeping Services</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<tr>
  <td class="bold">Date</td>
  <td class="bold">Info Approved</td>
  <td class="bold">Info Reason</td>
  <td class="bold">Payment Approved</td>
  <td class="bold">Payment Reason</td>
  <td class="bold">Application</td>
</tr>
<?php 
$sql16="SELECT * FROM  `iijs_housekeeping` WHERE 1 AND  `Exhibitor_Code` =  '$exhibitor_code'";
$result16=mysql_query($sql16);
$rows16=mysql_fetch_array($result16);
$num16=mysql_num_rows($result16);
if($num16==0)
{
echo "<tr><td>";
echo "Not Applied";
echo "</td></tr>";
}else
{
?>
<tr>
  <td><a href="Form16.php?HouseKeeping_ID=<?php echo $rows16['HouseKeeping_ID'];?>&Exhibitor_Code=<?php echo $rows16['Exhibitor_Code'];?>"><?php echo date("d-m-Y",strtotime($rows16['Create_Date']));?></a></td>
  <td><?php if($rows16['Info_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows16['Info_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows16['Info_Approved']=='N'){echo $rows16['Info_Reason'];} ?></td>
  <td><?php if($rows16['Payment_Approved']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows16['Payment_Approved']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
  <td><?php if($rows16['Payment_Approved']=='N'){echo $rows16['Payment_Reason'];} ?></td>
  <td><?php if($rows16['Application_Complete']=='Y'){echo "<img src='images/notification-tick.gif' alt='' />";}else if($rows16['Application_Complete']=='N'){echo "<img src='images/no.gif' alt='' />";}else{echo "<img src='images/notification-exclamation.gif' alt='' />";} ?></td>
</tr>
<?php }?>
</table>

</div>

</div>
</div>  
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
