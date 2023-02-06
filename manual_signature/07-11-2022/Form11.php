<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=$_REQUEST['Exhibitor_Code'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn->query($exhibitor_data);
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

$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
$Exhibitor_Premium=$fetch_data['Exhibitor_Premium'];


if($_REQUEST['save']=="Save")
{
	$getCreateDate = "select created_date from igjme_air_water where Exhibitor_Code='$exhibitor_code'";
	$executeQuery = $conn->query($getCreateDate);

	$day = $executeQuery->fetch_assoc();
	$create = $day["created_date"];
	
	$deadline = date('Y-m-d',strtotime("2014-06-21"));
	$today = strtotime($create);
	$deadline = strtotime($deadline);

	if($today>$deadline)
		$charge=true;
	else
		$charge=false;

	$payment_mode = $_POST["payment_mode"];
	$aw_item = implode(",",$_REQUEST["aw_item"]);
	
	if($charge)
	{
		if($aw_item=="1")
			$total_amount="5500";
		elseif($aw_item=="2")
			$total_amount="8500";
		elseif($aw_item=="1,2")
			$total_amount="14000";
		else
			$total_amount="0";
		
		$tax = intval($total_amount)*(12.36/100);
		$tax = round($tax);
	
		$amount_payable = $total_amount + $tax;
	}
	else
	{
		$total_amount=0;
		$tax=0;
		$amount_payable=0;
	}
	
	$Info_Approved=$_REQUEST['Info_Approved'];
	$Payment_Mode_ID=$_REQUEST['Payment_Mode_ID'];
	$Payment_Master_Approved=$_REQUEST['Payment_Master_Approved'];
	
	if($Info_Approved=='Y')
	{
		$Info_Reason="";	
	}
	else
	{
		$Info_Reason=$_REQUEST['Info_Reason'];
	}
	if($Info_Approved=='')
	{
		$Info_Approved='P';
		$Info_Reason="";	
	}
	
	if($Payment_Master_Approved=='Y')
	{
		$Payment_Master_Reason="";	
	}
	else
	{
		$Payment_Master_Reason=$_REQUEST['Payment_Master_Reason'];
	}
	if($Payment_Master_Approved=='')
	{
		$Payment_Master_Approved='P';
		$Payment_Master_Reason="";	
	}

	if($Info_Approved=='Y' && $Payment_Master_Approved=='Y')
	{
		$Application_Complete='Y';
	}
	else if($Info_Approved=='N' || $Payment_Master_Approved=='N')
	{
		$Application_Complete='N';
	}
	else
	{
		$Application_Complete='P';
	}	
	$created_date = date("Y-m-d");
	$modified_date = date("Y-m-d");
	
	$query = $conn->query("select * from igjme_air_water where Exhibitor_Code='$exhibitor_code' LIMIT 1");
	$count = $query->num_rows;
	
	$insert_query = "insert into igjme_air_water set Exhibitor_Code='$exhibitor_code',payment_mode='$payment_mode',Payment_Approved='$Payment_Master_Approved',Payment_Reason='$Payment_Master_Reason',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete',created_date='$created_date',modified_date='$modified_date',aw_item_id='$aw_item',updated_by='A'";
	
	$update_query = "update igjme_air_water set payment_mode='$payment_mode',Payment_Approved='$Payment_Master_Approved',Payment_Reason='$Payment_Master_Reason',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete',modified_date='$modified_date',aw_item_id='$aw_item', total_amount='$total_amount',tax='$tax',amount_payable='$amount_payable',updated_by='A' where Exhibitor_Code='$exhibitor_code'";
	
	if($count > 0)
	{
		$result_query = $conn->query($update_query);
	}
	else
	{
		$result_query = $conn->query($insert_query);
		//echo  $insert_query;
		//exit;
	}
		if($Info_Approved!='P' || $Payment_Master_Approved!='P')
		{
				if($Info_Approved=='Y'){$Info_Approved='Approved';}else if($Info_Approved=='N'){$Info_Approved='Disapproved';}
				if($Payment_Master_Approved=='Y'){$Payment_Master_Approved='Approved';}else if($Payment_Master_Approved=='N'){$Payment_Master_Approved='Disapproved';}
				/*.......................................Send mail to users mail id...............................................*/
				$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
				
				<tr>
				<td style="padding:30px;">
				<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
				<tr>
				<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="220"/></td>
				<td align="right" height="60px"><img src="https://gjepc.org/igjme/assets-new/images/logo.jpg" border="0"/></td>
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
				<p>Your details for the Online Application for  <strong>Form No. 11. Compresed Air Water Connection</strong> has been updated by IIJS Admin.</p>
				<p>Kindly login at our website - igjme.org to verify the same.</p>
				
				<table width="600" border="0" cellspacing="0" cellpadding="0"  style="border:1px solid #ccc;">
				  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
					<td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
					<td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >Information Approval</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Info_Reason.' </td>
				  </tr>
				  <tr style="height:20px; border:1px solid  #FF0000;">
					<td style="border:1px solid  #cccccc; padding:5px;" >Payment Approval</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Approved.'</td>
					<td style="border:1px solid  #cccccc; padding:5px;">'.$Payment_Master_Reason.' </td>
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
				
				$to ='rohit@kwebmaker.com';
				//$to =$Exhibitor_Email.',notification@gjepcindia.com,mukesh@kwebmaker.com';
				$subject = "".$event." Exhibitor Manual - Form No. 5 Compress Air Water Connection"; 
				$headers  = 'MIME-Version: 1.0' . "\r\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
				$headers .= 'From:admin@gjepc.org';			
				//mail($to, $subject, $message, $headers);
		}
	    echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully submitted your application.");'; 
		echo 'window.location.href = "manage_compressed_air_water.php?action=view";';
		echo '</script>';
}
?>
<?php 
$today = date('d-m-Y');
//$exhibitor_code = $_SESSION["EXHIBITOR_CODE"];
$deadline = getFormDeadLine(5,$conn);

$today = strtotime($today);
$deadline = strtotime($deadline);

if($today<$deadline)
	$charge=false;
else
	$charge=true;
	
$get_air_water = "select * from igjme_air_water where Exhibitor_Code='$exhibitor_code' LIMIT 1";
$execute_aw = $conn->query($get_air_water);
$display = $execute_aw->fetch_assoc();

$count = $execute_aw->num_rows;

$Info_Approved=$display['Info_Approved'];
$Info_Reason=$display['Info_Reason'];
$Payment_Master_Approved=$display['Payment_Approved'];
$Payment_Master_Reason=$display['Payment_Reason'];
$Application_Complete=$display['Application_Complete'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compressed Air Water Connection</title>

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
			alert("Please Enter Info Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}

	if($('input[name=\'ProductLogo_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('ProductLogo_Reason').value=="")
		{
			alert("Please Enter Product Logo Disapprove Reason");
			document.getElementById('ProductLogo_Reason').focus();
			return false;
		}
	}

	if($('input[name=\'CompanyLogo_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('CompanyLogo_Reason').value=="")
		{
			alert("Please Enter Company Logo Disapprove Reason");
			document.getElementById('CompanyLogo_Reason').focus();
			return false;
		}
	}
}
</script>

<script language="javascript">
function addrate(checkedStatus,id)
{
	//alert(checkedStatus);
	if(checkedStatus)
	{
		var getId = id.split("_");
		Id = getId[1];
		//alert(Id);
		
		$.ajax({
		   url:"../ajax_air_water.php",
		   type:"post",
		   data:"id="+Id,
		   //dataType:"json",
		   success:function(result){
			   		//alert(result);
    				$("#hidden_"+Id).val(result);
					//var total = parseInt($("#tot_amount").text()) + parseInt($("#hidden_"+Id).val());
					//$("#tot_amount").text(total);
			}
		});
	}
	else
	{
		$("#hidden_"+Id).val("0");
	}
}
$(document).ready(function(){
	$("#calculate").click(function(){
		//alert("test");
		var i;
		//alert();
		var loop_cnt = $("[type=checkbox]").length;
		//alert(loop_cnt);
		var total=0;
		for(i=1;i<=loop_cnt;i++)
		{
			var inc = $("#hidden_"+i).val();
			total=parseInt(total)+parseInt(inc);
		}
		var tax = parseInt(total)*(12.36/100);
		tax = parseInt(tax);
		var grand_total = parseInt(total)+parseInt(tax);
		
		$("#amt").text(total);
		$("#tax_info").text(tax);
		$("#grand_info").text(grand_total);
	});
});
</script>
</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> >Compressed Water Air Connection</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Compressed Water Air Connection</div>
 
<div class="content_details22">
<div id="formWrapper">
<h2>Notes :</h2>

<ol class="numeric">
<li>Exhibitors who are applying for the compressed air connection will be provided with the outlets for compressed air near the space alloted to the exhibitor.</li>

<li>Exhibitors will have to arrange connection to the machines from the source provided at their own cost. Organisers will provide temporary compressed air connections to exhibitors, on request. <strong>Exhibitors are not pemitted to use their own compressors.</strong></li>

<li>There will be no charge for compressed air or water connections if applied before 14th FEB 2022. After 14th FEB 2022 a surcharge  will be levied for compressed air or water connection.</li>
<li>The service will be available only for Hall 2 (Machinery Section).</li>
<li>The Deadline for form submission is 14th FEB 2022</li>
</ol>
<p>The sections marked with an <span class="red">*</span> are compulsory.</p>

<h2>Exhibitor Information</h2>

<table border="0" cellspacing="0" cellpadding="0" class="formManual info">
  <tr>
    <td width="175" class="bold">Exhibitor Name</td>
    <td width="24">:</td>
    <td width="241"><?php echo $Exhibitor_Name;?></td>
    <td width="45">&nbsp;</td>
    <td width="173" class="bold">Contact Person</td>
    <td width="35">:</td>
    <td width="215"><?php echo $Exhibitor_Contact_Person;?></td>
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

<form name="catalogue_entry" id="form1" action="" enctype="multipart/form-data" method="post" onsubmit="return validation()">
<div class="title"><h4>Facilities</h4></div>
<div class="clear"></div>
<div class="borderBottom"></div>
<?php 
$fetch_items = "select * from igjme_air_water_item_master where status = 1";
$execute_items = $conn->query($fetch_items);
?>
<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
	<th width="15%"></th>
    <th width="30%">Description</th>
    <th width="55%">Charges (After Deadline)</th>
</tr>

<?php
$i=1;
$j=1;
while($items = $execute_items->fetch_assoc())
{
	$ai_item_id = $items["ai_item_id"];
?>
<tr>
	<td align="center"><input type="checkbox" name="aw_item[]" id="checkitem_<?php echo $i++;?>" value="<?php echo $items["ai_item_id"];?>" <?php if(preg_match("/$ai_item_id/",$display["aw_item_id"])){ echo ' checked="checked"';  } ?>  onclick="addrate(this.checked,this.id)" style="width:16px; height:16px;" />
    
     <input type="hidden" id="hidden_<?php echo $j++;?>" value="0">
    </td>
    <td><?php echo $items["ai_item_desc"];?></td>
    <td><?php echo $items["rate_after_deadline"];?></td>
</tr>
<?php } ?>
</tbody>
</table>
<div class="clear"></div>
<div class="title"><h4>Info Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150" class="bold"><strong>Status</strong></td>
    <td>:</td>
    <td>
   <div class="leftStatus"><span><input name="Info_Approved" id="Info_Approved2" type="radio" value="Y" <?php if($Info_Approved=='Y'){ echo "checked='checked'";}?> />
   </span>Approval </div> 
   <div class="leftStatus"> <span><input name="Info_Approved" id="Info_Approved" type="radio" value="N" <?php if($Info_Approved=='N'){ echo "checked='checked'";}?> /></span> Disapprove</div>
    
    <div class="clear"></div>
    <textarea name="Info_Reason" id="Info_Reason" class="textArea"><?php echo $Info_Reason; ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table>

<div style="margin-bottom:15px;">
  <input type="button" value="Calculate" id="calculate" class="maroon_btn" />
</div>
<div class="title"><h4>Payment Details</h4></div>
<div class="clear"></div>
<div class="borderBottom"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:400px;">
  <tbody><tr>
    <td width="148px">Total Amount</td>
    <td width="2px">:</td>
    <td width="250px"><span id="amt"><?php echo $display["total_amount"];?></span></td>
  </tr>
  <tr>
    <td>Service Tax (14.5%)</td>
    <td>:</td>
    <td><span id="tax_info"><?php echo $display["tax"];?></span></td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><span id="grand_info"><?php echo $display["amount_payable"];?></span></td>
  </tr>
</tbody></table>

<div class="title"><h4>Payment Mode</h4></div>
<div class="clear"></div>
<div class="borderBottom"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:370px;"> 
  <tr>
    <td width="20"><input type="radio" name="payment_mode" id="Payment_Mode_ID" value="Cheque" class="radio"  <?php if(preg_match("/Cheque/",$display["payment_mode"])){ echo ' checked="checked"';  }  ?>/></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="payment_mode" id="Payment_Mode_ID" value="DD" class="radio"  <?php if(preg_match("/DD/",$display["payment_mode"])){ echo ' checked="checked"';  } ?>/></td>
    <td width="100">DD</td>

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


<div align="center">
  <input type="submit" value="Submit" class="maroon_btn" />
  <a href="manage_compressed_air_water.php?action=view">
  <input type="hidden" name="save" id="save" value="Save"/>
  <input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
</div>
</form>
</div>

</div>
  
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
