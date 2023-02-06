<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=($_REQUEST['Exhibitor_Code']);

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
$Vendor_ID=getVenderId($Exhibitor_Section,$conn);
?>


<?php 
$save=$_REQUEST['save'];
if($save=="Save")
{
$Exhibitor_Code=$_POST['Exhibitor_Code'];
$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
$Info_Approved=$_POST['Info_Approved'];
$CCTV_ID=$_POST['CCTV_ID'];
$Payment_Master_ID=$_POST['Payment_Master_ID'];
$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
if($Info_Approved=="Y")
{
	$Info_Approved_msg="Approved";
}
else if($Info_Approved=="N")
{
	$Info_Approved_msg="Disapproved";
}
else
{
	$Info_Approved_msg="Pending";
}

if($_POST['Info_Approved']=="N"){
	$Info_Reason=$_POST['Info_Reason'];
}
else
{
	$Info_Reason="";
}

$Payment_Master_Approved=$_POST['Payment_Master_Approved'];

if($Payment_Master_Approved=="Y")
{
	$Payment_Master_Approved_msg="Approved";
}
else if($Payment_Master_Approved=="N")
{
	$Payment_Master_Approved_msg="Disapproved";
}
else
{
	$Payment_Master_Approved_msg="Pending";
}

if($Payment_Master_Approved=="N")
{
	$Payment_Master_Reason=$_POST['Payment_Master_Reason'];
}
else
{
	$Payment_Master_Reason="";
}

if($Info_Approved=='Y' && $Payment_Master_Approved=='Y')
{
	$Application_Complete='Y';
}
else if($Info_Approved=='' || $Payment_Master_Approved=='')
{
	$Application_Complete='P';
}
else
{
	$Application_Complete='N';
}

$conn ->query("update iijs_payment_master set Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Approved='$Payment_Master_Approved',Payment_Master_Reason='$Payment_Master_Reason' where  Payment_Master_ID='$Payment_Master_ID' and Form_ID='8'");

$conn ->query("update iijs_cctv set Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete' where CCTV_ID='$CCTV_ID'");


/*...............................Exhibitor Information.......................................*/
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
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


/*.......................................Send mail to users mail id...............................................*/
$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		<tr>
		<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
		<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_iijs/images/logo.png" border="0"/></td>
		</tr>
		<tr>
		<td></td>
		<td align="right"></td>
		</tr>
		
		<tr>
		<td align="right" colspan="2" height="30px"><hr /></td>
		</tr>
		
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p>Dear <strong>'.$Exhibitor_Contact_Person.',</strong> </p>
		<p>Company Name: <strong>'.$Exhibitor_Name.'</strong> </p>
		<p>Your details for the Online Application for <strong>Form No. 8. ELECTRONIC SURVEILLANCE</strong> has been updated by Signature Admin.</p>
		
		<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
		  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
			<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
			<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Information</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Approved_msg.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Reason.' </td>
		  </tr>
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Payment</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Approved_msg.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Reason.'</td>
		  </tr>
		  
</table>

		<p>Kind regards, <br />
		<strong>IIJS Web Team,</strong>
		</p>
		</td>
		</tr>
	
		<tr>
		<td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
		</td>
		</tr>
		</table>
		</td>
		
		
		</tr>
		</table>';
		
		$to =$Exhibitor_Email.',notification@gjepcindia.com';
	  //$to ='rohit@kwebmaker.com';
		$subject = "".$event." Exhibitor Manual - Form No. 8. ELECTRONIC SURVEILLANCE";
		$headers  = 'MIME-Version: 1.0' . "\n";	
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		$headers .= 'From: IIJS PREMIERE 2021 <admin@gjepc.org>';	
		@mail($to, $subject, $message, $headers);
		header('location:Form8.php?Exhibitor_Code='.$Exhibitor_Code);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manual || Electronic Surveillance||</title>

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

<script src="js/electronic_surveillance.js"></script>
</head>
<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Electronic Surveillance</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Electronic Surveillance</div>
 
<div class="content_details22">
<div id="formWrapper">
<!--<a href="standfitting_services.php?action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />-->
<h2 style="float:left">Application Summary</h2>

<div class="clear"></div>

<table  cellspacing="0" cellpadding="0" class="common">
    <tbody>
        <tr>
        <th valign="top">
        Sr No.</th>
        <th valign="top">
        Date</th>
		<th valign="top" >
        <div align="center">Item Status</div></th>
        <th valign="top" >
        <div align="center">Payment Status</div></th>
        <th valign="top" class="centerAlign">
        <div align="center">Application Status</div></th>
		<th valign="top" class="centerAlign">
        <div align="center">Delete Order</div></th>
        </tr>
    <?php
	$query=$conn ->query("SELECT a.*,b.* FROM `iijs_cctv` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='8' order by b.Payment_Master_ID asc");
	$order_num=$query->num_rows;
	$i=1;
	while($result=$query->fetch_assoc()){
	?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="Form8.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&CCTV_ID=<?php echo $result['CCTV_ID'];?>&orderno=<?php echo $i;?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
		
		<td  class="centerAlign">
		<?php  
			if($result['Info_Approved']=='Y')
			echo "<img src='../images/correct.png'  alt='' />";
			else if($result['Info_Approved']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />";
			else
			echo "<img src='../images/pending.png'  alt='' />";		
		?>
		
        </td>
		
        <td  class="centerAlign">
		<?php  
			if($result['Payment_Master_Approved']=='Y')
			echo "<img src='../images/correct.png'  alt='' />";
			else if($result['Payment_Master_Approved']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />";
			else
			echo "<img src='../images/pending.png'  alt='' />";		
		?>
		
        </td>
        <td valign="middle" colspan="1" class="centerAlign">
		<?php  
			if($result['Application_Complete']=='Y')
			echo "<img src='../images/correct.png'  alt='' />";
			else if($result['Application_Complete']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />";
			else
			echo "<img src='../images/pending.png'  alt='' />";		
		?>
        </td>
		<?php if($_SESSION['admin_role']=='Super Admin'){?>
		<td  class="centerAlign">
			<img src='../images/red_cross.png'  alt='' class="deleteOrder <?php echo $result['Payment_Master_ID']?> <?php echo $result['CCTV_ID']?> <?php echo $result['Exhibitor_Code']?>" style="cursor:pointer;" />
        </td>
		<?php }?>
        </tr>
    <?php $i++;}?>     
    </tbody>
</table>

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
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
  <tr>
    <td class="bold">Phone</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Phone; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Mobile</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Mobile; ?></td>
  </tr>
  <tr>
    <td class="bold">Email</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Email; ?></td>    
  </tr>
</table>
<p><strong>Item List :</strong></p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th width="45">Sr No</td>
    
    <th width="500">Item</th>
    <th width="140">Rent 
      [Exclusive of all taxes]</th>
    </tr>
  <tr>
    <td>1</td>
    <td>Rent Charges for 2 Nos Indoor Dome Camera to operate in regular lighting : DVR with	 HOD, Cabling, Monitor</td>
    <td>10000.00 </td>
    </tr>
  <tr>
    <td>2</td>
    <td>Rent  Charges for 4 Nos Indoor Dome Camera to operate in regular lighting : DVR with  HOD, Cabling, Monitor</td>
    <td>14000.00</td>
    </tr>
  <tr>
    <td>3</td>
    <td>Rent Charges for 6 Nos  Indoor Dome Camera to operate in regular lighting : DVR with HDD, Cabling, Monitor</td>
    <td> 18000.00</td>
    </tr>
  <tr>
    <td>4</td>
    <td>Rent Charges for 8  Nos Indoor Dome Camera to operate in regular lighting : DVR with HDD, Cabling, Monitor</td>
    <td>20000.00</td>
  </tr>
 
</table>
<p>* The above price are exclusive of service taxes,charged extra @18% on the above amount.</p>

<form  id="item_selection" name="item_selection" method="post">

<div class="title"><h4>Exhibitor CCTV services </h4></div>
<div class="clear"></div>
<?php 
   $Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
   $query=$conn ->query("select * from iijs_cctv where Payment_Master_ID='$Payment_Master_ID'");
   $result=$query->fetch_assoc();
   $cctv_company=$result['CCTV_CompanyName'];
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="20%"><strong>Choose CCTV Company :</strong></td>  
    <td width="20"><input type="radio" name="cctv_company" id="cctv_company" value="jaymit" disabled="disabled" <?php if($cctv_company=='jaymit'){?> checked="checked"<?php }?> /></td>
    <td width="200">M/s Jaymit Security Systems Pvt. Ltd</td>
	
    <td width="20"><input type="radio" name="cctv_company" id="cctv_company" value="exim" disabled="disabled" <?php if($cctv_company=='exim'){?> checked="checked"<?php }?> /></td>
    <td>Ankitst Exim</td>
	<td width="20"><input type="radio" name="cctv_company" id="cctv_company" value="sai" disabled="disabled" <?php if($cctv_company=='sai'){?> checked="checked"<?php }?> /></td>
    <td>Sai Enterprises</td>
	<td width="20"><input type="radio" name="cctv_company" id="cctv_company" value="spectra" disabled="disabled" <?php if($cctv_company=='spectra'){?> checked="checked"<?php }?> /></td>
    <td>Spectra Services</td>
  </tr>
  
</table>

<div class="title"><h4>Items</h4></div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <th class="bold">Items Allocated</th>
      <th class="bold"><span>Avail Qty</span></th>
      <th class="bold">Rate</th>
      <th class="bold">Quantity</th>
      <th class="bold">&nbsp;</th>
      </tr>
    <tr>
      <td>
      <input type="hidden" name="xyz" value=""/>
	  <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	  <input type="hidden" name="CCTV_ID" id="CCTV_ID" value="<?php echo $_REQUEST['CCTV_ID'];?>"/>
      <select class="textField" id="CCTV_Items_Master_ID" name="CCTV_Items_Master_ID" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"<?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
        $query=$conn ->query("SELECT * from iijs_cctv_items_master");
        while($result=$query->fetch_assoc()){?>
        <option value="<?php echo $result['CCTV_Items_Master_ID'];?>"><?php echo $result['CCTV_Items_Master_Description'];?></option>
        <?php }?>
       </select>  
       </td>
      <td id="avail_qty">0</td>
      <td id="rate">0</td>
      <td>
      <input type="hidden" name="exhibitor_code" id="exhibitor_code"  value="<?php echo $exhibitor_code;?>" />
      <input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"style="background:#dddddd;"<?php }?> />
      </td>
	  <?php if($_SESSION['admin_role']=='Super Admin'){?>
      <td><span class="bold">
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"style="background:#dddddd;"<?php }?>/>
      </span></td>
	  <?php }?>
      </tr>
  </table>
</form>

<form method="post">
<div class="title">
<h4>Applied Items (Order No: <?php echo $_REQUEST['orderno'];?>)</h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">

  <tr>
    <th>Items Applied</th>
    <th>Amount</th>
    <th>Rate</th>
    <th>Quantity</th>
    <th>Action</th>
  </tr>
  <tbody id="Applied_Items">
    <?php 
	if(isset($_REQUEST['CCTV_ID']) && $_REQUEST['CCTV_ID']!="")
	{
		$CCTV_ID=$_REQUEST['CCTV_ID'];
		$query=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	}
	while($result=$query->fetch_assoc()){  
	$tot=$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
	?>
    <tr>
      <td><?php echo getElectronicItemName($result['CCTV_Items_Master_ID'],$conn);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
      <?php if($_SESSION['admin_role']=='Super Admin'){?>
	  <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result['CCTV_Items_ID'];?> <?php echo $CCTV_ID;?> <?php echo $_REQUEST['Payment_Master_ID'];?> <?php echo $result['CCTV_Items_Master_ID'];?>" style="cursor:pointer;">
	  </td>
	  <?php }?>
   </tr>
   
   <?php }?>
  </tbody>
</table>

<?php 
$CCTV_ID=$_REQUEST['CCTV_ID'];
$query=$conn ->query("select Info_Approved,Info_Reason from iijs_cctv where CCTV_ID='$CCTV_ID'");
$result=$query->fetch_assoc();
$Info_Approved=$result['Info_Approved'];
$Info_Reason=$result['Info_Reason'];
?>
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


<div class="title">
        <h4>Payment </h4>
</div>

<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php  
if(isset($_REQUEST['CCTV_ID']) && $_REQUEST['CCTV_ID']!="")
	{
		$CCTV_ID=$_REQUEST['CCTV_ID'];
		$query=$conn ->query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	}
else
{
	$query=$conn ->query("select * from  iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
}
$tot=0;
while($result=$query->fetch_assoc())
{
	$tot=$tot+$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
}
?>
  <tr>
    <td width="24%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="48%"><?php echo $tot;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $tot;?>" /></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">GST (18%) 
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=round($tot+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>


<?php 
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$query=$conn ->query("select Payment_Master_Approved,Payment_Master_Reason from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
$result=$query->fetch_assoc();
$Payment_Master_Approved=$result['Payment_Master_Approved'];
$Payment_Master_Reason=$result['Payment_Master_Reason'];
?>

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

<div class="title">
        <h4>Payment Mode</h4>
      </div>

<div class="clear"></div>

<?php 
$Payment_Master_ID=getPaymentModeId($_REQUEST['Payment_Master_ID'],$conn);

?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <!--<td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1" <?php if($Payment_Master_ID==1){?> checked="checked"<?php }?> /></td>
    <td width="100">Credit Card</td>-->
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="2" <?php if($Payment_Master_ID==2){?> checked="checked"<?php }?> /></td>
    <td width="100">NEFT</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Master_ID==4){?> checked="checked"<?php }?> /></td>
    <td>RTGS</td>
  </tr>
</table> 


<!--<ol class="numeric">

<li>Payment must be made within three working days from placing the order, failing will result in cancellation of order. </li>
<li>Cheque should be in favour of ? <strong>"The Gem and Jewellery Export Promotion Council."</strong></li>
</ol>-->

    <div align="center">
     <?php 
	 $orderno=$_REQUEST['orderno'];
	 if($_REQUEST['orderno']!=""){?>
	 <a href="print_acknowledge/electronic_servillance.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&CCTV_ID=<?php echo $_REQUEST['CCTV_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" target="_blank" class="button5">Print Acknowledgement</a>
	 <?php }?>
	 <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	 <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	 <input type="hidden" name="CCTV_ID" id="CCTV_ID" value="<?php echo $CCTV_ID;?>" />
	 <input type="hidden" name="save" id="save" value="Save"/>
     <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($_REQUEST['orderno']==""){?> disabled="disabled" style="background:#dddddd;"<?php }?> />
    </div>
	
	</form>
	
		</div>
	</div>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>