<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

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
$Exhibitor_StallType=$fetch_data['Exhibitor_StallType'];

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
<?php 
$sql="select * from iijs_housekeeping where Exhibitor_Code='$exhibitor_code'";
$results=$conn ->query($sql);
$num_rows=$results->num_rows;
$rows=$results->fetch_assoc();
$HouseKeeping_ID=$rows['HouseKeeping_ID'];
$Payment_Mode_ID=$rows['Payment_Mode_ID'];
$HouseKeepingService_ID=$rows['HouseKeepingService_ID'];
$Payment_Amount=$rows['Payment_Amount'];
$Info_Approved=$rows['Info_Approved'];
$Info_Reason=$rows['Info_Reason'];
$Payment_Approved=$rows['Payment_Approved'];
$Payment_Reason=$rows['Payment_Reason'];
$Application_Complete=$rows['Application_Complete'];
$Create_Date=$rows['Create_Date'];

/*if($Exhibitor_Area=='9' || $Exhibitor_Area=='18' || $Exhibitor_Area=='24')
{
$Payment_Amount='950.00';	
}else if($Exhibitor_Area=='27')
{
$Payment_Amount='1850.00';	
}else if($Exhibitor_Area=='36' || $Exhibitor_Area=='45')
{
$Payment_Amount='2150.00';	
}else if($Exhibitor_Area=='54')
{
$Payment_Amount='2600.00';	
} */

if($Exhibitor_Area=='9' || $Exhibitor_Area=='18')
{
$Payment_Amount='935';	
}else if($Exhibitor_Area=='27')
{
$Payment_Amount='1450';	
}else if($Exhibitor_Area=='36')
{
$Payment_Amount='1800';	
}else if($Exhibitor_Area=='54' || $Exhibitor_Area=='72'|| $Exhibitor_Area=='108')
{
$Payment_Amount='2000';	
}

$tax = round(intval($Payment_Amount) * 0.18);
$PaymentIncTax = $Payment_Amount + $tax;

if(isset($_POST['action']))
{
	$Payment_Mode_ID=filter($_REQUEST['Payment_Mode_ID']);
	$HouseKeepingService_ID=filter($_REQUEST['HouseKeepingService_ID']);
	$Payment_Amount=filter($_REQUEST['Payment_Amount']);

	$Info_Approved=filter($_REQUEST['Info_Approved']);
	if($Info_Approved=='Y')
	{
	$Info_Reason="";	
	}else
	{
	$Info_Reason=filter($_REQUEST['Info_Reason']);
	}
	if($Info_Approved=='')
	{
		$Info_Approved='P';
		$Info_Reason="";	
	}
	
	$Payment_Approved=filter($_REQUEST['Payment_Approved']);
	if($Payment_Approved=='Y')
	{
	$Payment_Reason="";	
	}else
	{
	$Payment_Reason=filter($_REQUEST['Payment_Reason']);
	}
	if($Payment_Approved=='')
	{
		$Payment_Approved='P';
		$Payment_Reason="";	
	}
	
	if($Info_Approved=='Y' && $Payment_Approved=='Y')
	{
		$Application_Complete='Y';
	}else if($Info_Approved=='P' && $Payment_Approved=='P')
	{
		$Application_Complete='P';
	}else
	{
		$Application_Complete='N';
	}	
	
	$sql_update="update iijs_housekeeping set HouseKeepingService_ID='$HouseKeepingService_ID',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Payment_Approved='$Payment_Approved',Payment_Reason='$Payment_Reason',Application_Complete='$Application_Complete',Modify_Date='$Modify_Date' where Exhibitor_Code='$exhibitor_code'";
	
	$sql_insert="insert into iijs_housekeeping (Exhibitor_Code,Payment_Mode_ID,HouseKeepingService_ID,Payment_Amount,Info_Approved,Info_Reason,Payment_Approved,Payment_Reason,Application_Complete,Create_Date,Modify_Date) values ('$exhibitor_code','$Payment_Mode_ID','$HouseKeepingService_ID','$Payment_Amount','P','','P','','P','$Create_Date','$Modify_Date'";
	
	if($num_rows>0)
	{
		  if(!$sql_update) die ($conn->error);
		if($Info_Approved!='P' && $Payment_Approved!='P')
		{
				if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='N'){$Info_Approved='Disapproved';}
				if($Payment_Approved=='Y'){$Payment_Approved='Approved';}else if($Payment_Approved=='N'){$Payment_Approved='Disapproved';}
			
				/*.......................................Send mail to users mail id...............................................*/
				$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
				
				<tr>
				<td style="padding:30px;">
				<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
				
				<tr>
					<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
					<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/SIGNATURE-LOGO-4.jpg" border="0"/></td>
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
				<p>Your details for the Online Application for <strong>Form No. 6. House Keeping Services</strong> has been updated by Signature Admin.</p>
				<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
				  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
					<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >House Keeping Services</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Reason.' </td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >Payment</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Reason.' </td>
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
				
				<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="http://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
				<map name="Map2" id="Map2"><area shape="rect" coords="2,0,312,68" href="http://www.gjepc.org/"  target="_blank" style="outline:none;" /></map>
				
				</tr>
				
				</table>';
				
				$to =$Exhibitor_Email.',notification@gjepcindia.com';
				$subject = "".$event." Exhibitor Manual - Form No. 6. HOUSE KEEPING SERVICES";
				$headers  = 'MIME-Version: 1.0' . "\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
				$headers .= 'From: ".$event." <admin@gjepc.org>';		
				mail($to, $subject, $message, $headers);				
		}

	}
	else
	{
		 if(!$sql_insert) die ($conn->error);
	}	
	
	header("location:manage_house_keeping.php?action=view");							
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>House Keeping Services</title>

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
function validation()
{
	if($('input[name=\'Info_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}
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
	<div class="breadcome"><a href="manage_house_keeping.php?action=view">Home</a> > House Keeping Services</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">House Keeping Services</div>
     	<div class="content_details22">
        <div id="formWrapper">
		
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
    <td><?php echo getSection_desc($Exhibitor_Section,$conn); ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<form name="form1" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<input type="hidden" name="action" value="SAVE" />
<input type="hidden" name="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
<input type="hidden" name="Payment_Amount" value="<?php echo $Payment_Amount;?>" />

<table width="680" border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold"><strong>Date of Service</strong></td>
    <td>:</td>
   <td colspan="2">06th to 09th of JANUARY, 2022</td>
  </tr>
  
  <tr>
    <td width="322" class="bold"><strong>Time of Service (Please tick your preference) <sup>*</sup></strong></td>
    <td width="15">:</td>
    <td width="164"><input type="radio" name="HouseKeepingService_ID" id="HouseKeepingService_ID" value="1" <?php if($HouseKeepingService_ID=='1'){echo "checked='checked'";}?> /> 8.00 a.m. to 9.00 a.m</td>
    <td width="179"><input type="radio" name="HouseKeepingService_ID" id="HouseKeepingService_ID" value="2" <?php if($HouseKeepingService_ID=='2'){echo "checked='checked'";}?> /> 8.00 p.m. to 9.00 p.m.</td>
  </tr>
  
</table>

<div class="title"><h4>Information Approval</h4></div>
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

<div class="title"><h4>TERMS & CONDITIONS</h4></div>
<div class="clear"></div>
<p>The Housekeeping Services include -</p>
<ol start="1">
	<li>Wastepaper Basket Clearance</li>
    <li>Table top cleaning</li>
    <li>Dusting of the stall space</li>
    <li>Vaccuming of the stall area</li>
</ol>

<p>The rate for the service is charged per exhibitor as given below:</p> 

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th>Sr. No.</td>
    <th>Area</td>
    <th>No. of Days</td>
    <th>Rate (Exclusive Tax)</td>
  </tr>
  <tr>
    <td>1</td>
    <td>9 to 18 Sqmt</td>
    <td>Four days (starting 05th to 09th of JANUARY, 2023)</td>
    <td>INR 935/-</td>
  </tr>
  <tr>
    <td>2</td>
    <td>27 Sqmt</td>
    <td>Four days (starting 05th to 09th of JANUARY, 2023)</td>
    <td>INR 1450/-</td>
  </tr>
    <tr>
    <td>3</td>
    <td>36 Sqmt</td>
    <td>Four days (starting 05th to 09th of JANUARY, 2023)</td>
    <td>INR 1800/-</td>
  </tr>
  <tr>
    <td>4</td>
    <td>54 to 108 Sqmt</td>
    <td>Four days (starting 05th to 09th of JANUARY, 2023)</td>
    <td>INR 2000/-</td>
  </tr>
</table>

<p>The services can be availed at either of two timings - 8.00 a.m to 9.00 a.m OR 8.00 p.m. to 9.00 p.m. The same timing will be followed for all the five days.</p>

<p>Kindly note that the housekeeping personnel will visit the stall only once as per the timing preference mentioned. Waiting time / Postponement of the service will not be allowed.</p>

<p>Housekeeping services DO NOT include showcase & glass cleaning.</p>

<p>Kindly submit this form with your preference of timing before the 30th DEC 2016 at the Council Office. Forms submitted post the 30th DEC 2016 will not be eligible for this service.</p>

<p>Payments can be made either via cash or demand draft only at the council office along with the form.</p>

<p>Payments once made are not refundable.</p>

<p class="special">For payment approval all cheques/drafts/Wire Transfer should reach the council within 3 working days after order date failing will result in  cancellation of order.</p>

<p>Any complaints regarding the Housekeeping Service / Personnel should be addressed to your Zone Manager at the Service Stall.</p>

<p>Service Tax of 15% applicable.</p>

<p>Cheque should be in favour of - <strong> "The Gem and Jewellery Export Promotion Council"</strong>.</p>

<div class="clear"></div>


<div class="title"><h4>Payment Details</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150">Amount</td>
    <td>:</td>
    <td><?php echo $Payment_Amount;?></td>
   </tr>
  <tr>
    <td width="150">Tax</td>
    <td>:</td>
    <td><?php echo $tax;?></td>
   </tr>
  <tr>
    <td width="150">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $PaymentIncTax;?></td>
   </tr>
  <tr>
    <td>Payment Mode <sup>*</sup></td>
    <td>:</td>
    <td>
    <!--<input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1" <?php if($Payment_Mode_ID=='1'){echo "checked='checked'";}?> />Credit Card-->
    <input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="2" <?php if($Payment_Mode_ID=='2'){echo "checked='checked'";}?>/>Cheque
    <input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Mode_ID=='4'){echo "checked='checked'";}?> />DD
    </td>
    </tr>
  
</table>
<div class="title"><h4>Payment Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
 
    
   <div class="leftStatus"><span><input name="Payment_Approved" id="Payment_Approved" type="radio" value="Y" <?php if($Payment_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Payment_Approved" id="Payment_Approved" type="radio" value="N" <?php if($Payment_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Payment_Reason" id="Payment_Reason" class="textArea"><?php echo "$Payment_Reason"; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>

<div class="clear"></div>
<p><input type="checkbox" name="iagree" id="iagree" checked="checked" />  I have read and understood the terms and conditions as mentioned above and agree to abide by the same.</p>

<div class="clear"></div>


<div align="center">
<input name="input2" type="submit" value="Submit" class="maroon_btn" />
<a href="print_acknowledge/housekeeping.php?HouseKeeping_ID=<?php echo $HouseKeeping_ID;?>&exhibitor_code=<?php echo $exhibitor_code;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
<a href="list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>
</form>
</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>