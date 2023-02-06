<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){	header("location:index.php");	exit; }
?>
<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time=strtotime($cr_date);
$checking_time = getFormDeadLineTime(12,$conn);
//$checking_time=strtotime("19-01-2018 15:01:00");
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result = $conn->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

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
?>

<?php
$today = date('Y-m-d');
$deadline = date('Y-m-d',strtotime("2022-12-09"));

$today = strtotime($today);
$deadline = strtotime($deadline);

if($today>$deadline)
	$charge=true;
else
	$charge=false;

$get_air_water = "select * from igjme_air_water where Exhibitor_Code='$exhibitor_code' LIMIT 1";
$execute_aw = $conn ->query($get_air_water);
$display = $execute_aw->fetch_assoc();
$count = $execute_aw->num_rows;

if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="update")
{
	$payment_mode = $_POST["payment_mode"];
	$aw_item = implode(",",$_REQUEST["aw_item"]);
	if($charge){
	if($aw_item=="1")
		$total_amount="5500";
	elseif($aw_item=="2")
		$total_amount="8500";
	elseif($aw_item=="1,2" || $aw_item=="1,2,3")
		$total_amount="14000";
	else
		$total_amount="0";
	}
	else
	{
		$total_amount=0;
	}
		
	$tax = intval($total_amount)*(18/100);
	$tax = round($tax);
	
	$amount_payable = $total_amount + $tax;
	
	$created_date = date("Y-m-d");
	$modified_date = date("Y-m-d");
	
	$insert_query = "insert into igjme_air_water set Exhibitor_Code='$exhibitor_code',payment_mode='$payment_mode',created_date='$created_date',aw_item_id='$aw_item',total_amount='$total_amount',tax='$tax',amount_payable='$amount_payable',updated_by='U'";
	
	if($charge)
	{
		$update_query = "update igjme_air_water set payment_mode='$payment_mode',modified_date='$modified_date',aw_item_id='$aw_item',total_amount='$total_amount',tax='$tax',amount_payable='$amount_payable',updated_by='U' where Exhibitor_Code='$exhibitor_code'";
	}
	else
	{
		$update_query = "update igjme_air_water set payment_mode='$payment_mode',modified_date='$modified_date',aw_item_id='$aw_item',updated_by='U' where Exhibitor_Code='$exhibitor_code'";
	}
	
	if($count > 0)
	{
		$result_query = $conn ->query($update_query);
		//echo $update_query;
	}
	else
	{
		$result_query = $conn ->query($insert_query);
		//echo $insert_query;
	}
	if($result_query)
	{
		echo "<script>alert('Form Successfully submitted'); window.location = 'manual_list.php';</script>"; 
	}
	else
	{
		echo "<script language='javascript'>alert('Problems While Updating Record')<script>";
        //echo mysql_error();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compressed Air Water Connection || IGJME</title>
<link rel="shortcut icon" href="https://gjepc.org/assets/images/fav_icon.png">
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<!--<script type="text/javascript" src="../js/jquery_002.js"></script>-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script> 
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

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
    top: -8%;
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

#formWrapper .spanbox{
    padding: 8px 20px;
	float:right;
	color:#fff;
    background-color: #924b77;	
	margin-left:10px;
}
#formWrapper .spanbox a,#formWrapper .spanbox strong{
	color:#fff;
}
.tooltip{float:right;}

.bigTextField { width: 100%; height: 110px; }
</style>
<script language="javascript">
function validate()
{
	if($('input[name="aw_item[]"]:checked').length == 0)
	{
		alert("Please Select between facilites");
		return false;
	}
	<?php /* if($charge)
	{
	?>
	if( $('input[name="payment_mode"]:checked').length == 0)
	{
		alert("Please select atleast one Payment Mode.");
		return false;
	}
	<?php } */?>
}
</script>

<script language="javascript">
function addrate(checkedStatus,id)
{	
	if(checkedStatus)
	{
		var getId = id.split("_");
		Id = getId[1];
		//alert(Id);
		
		$.ajax({
		   url:"ajax_air_water.php",
		   type:"post",
		   data:"id="+Id,
		  //dataType:"json",
		   success:function(result){
			   		//alert(result.rate_after_deadline);
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
		var tax = parseInt(total)*(18/100);
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
<!-- header starts -->
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->
<div class="clear"></div>
<div class="clear"></div>

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Compressed Air / Water Connection</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>Exhibitors who are applying for the compressed air connection will be provided with the outlets for compressed air near the space alloted to the exhibitor.</li>
<li>Exhibitors will have to arrange connection to the machines from the source provided at their own cost. Organisers will provide temporary compressed air connections to exhibitors, on request. <strong>Exhibitors are not pemitted to use their own compressors.</strong></li>
<li>There will be no charge for compressed air or water connections if applied before14th FEB 2022. After 14th FEB 2022 a surcharge  will be levied for compressed air or water connection.</li>
<li>The Deadline for form submission is <?php echo getFormDeadLine(12,$conn);?></li>
</ol>
</span>
</div>
<span class="spanbox">Deadline : <strong><?php echo getFormDeadLine(12,$conn);?></strong></span>

<?php
//echo $count;
//exit;
if($count!=0) { ?>
<h2>Application Summary</h2>

<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
	<th valign="top">Date</th>
    <th valign="top">Information Status</th>
    <th valign="top">Payment Status</th>
    <th valign="top">Application Status</th>
</tr>
<tr>
	<td valign="middle"><?php echo date("d-m-Y",strtotime($display["created_date"]));?></td>
    <td valign="middle">
	<?php  
		if($display["Info_Approved"]=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($display["Info_Approved"]=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else
			echo "<img src='images/pending.png'  alt='' />";                                        	
   ?>
   </td>
   
    <td valign="middle">
    <?php  
		if($display["Payment_Approved"]=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($display["Payment_Approved"]=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else
			echo "<img src='images/pending.png'  alt='' />";                                        	
   ?>    
    </td>
    <td valign="middle" >
	 <?php  
		if($display["Application_Complete"]=='Y')
			echo "<img src='images/correct.png'  alt='' />";
		else if($display["Application_Complete"]=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
		else
			echo "<img src='images/pending.png'  alt='' />";                                        	
	?>        
    </td>
</tr>

</tbody></table>
<?php } ?>
<h2>Notes :</h2>

<ol class="numeric">
<li>Exhibitors who are applying for the compressed air connection will be provided with the outlets for compressed air near the space alloted to the exhibitor.</li>
<li>Exhibitors will have to arrange connection to the machines from the source provided at their own cost. Organisers will provide temporary compressed air connections to exhibitors, on request. <strong>Exhibitors are not pemitted to use their own compressors.</strong></li>
<li>There will be no charge for compressed air or water connections if applied before14th FEB 2022. After 14th FEB 2022 a surcharge  will be levied for compressed air or water connection.</li>
<li>The Deadline for form submission is <?php echo getFormDeadLine(12,$conn);?></li>
</ol>

<p>The sections marked with an <span class="red">*</span> are compulsory.</p>

<h2>Exhibitor Information :</h2>
<div class="clear"></div>
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

<form method="POST" action="compressed_air_water_connection.php?action=update" name="compressed_air_water" onsubmit="return validate()">

<div class="title"><span class="red">*</span> Facilities</div>
<div class="clear"></div>
<div class="borderBottom"></div>

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
$fetch_items = "select * from igjme_air_water_item_master where status = '1'";
$execute_items = $conn ->query($fetch_items);
while($items = $execute_items->fetch_assoc())
{
	$ai_item_id = $items["ai_item_id"];
?>
<tr>
	<td align="center">
    <input type="checkbox" name="aw_item[]" id="checkitem_<?php echo $i++;?>" value="<?php echo $items["ai_item_id"];?>" <?php if(preg_match("/$ai_item_id/",$display["aw_item_id"])){ echo ' checked="checked"';  } ?> style="width:16px; height:16px;" onclick="addrate(this.checked,this.id)" />
    <input type="hidden" id="hidden_<?php echo $j++;?>" value="0">    
    </td>
    <td><?php echo $items["ai_item_desc"];?></td>
    <td><?php echo $items["rate_after_deadline"];?></td>
</tr>
<?php } ?>
</tbody>
</table>
<!--
<div style="margin-bottom:15px;"><input type="button" value="Calculate" id="calculate" class="maroon_btn" /></div>

<div class="title">Payment Details</div>
<div class="clear"></div>
<div class="borderBottom"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:400px;">
  <tbody><tr>
    <td width="148px">Total Amount</td>
    <td width="2px">:</td>
    <td width="250px"><span id="amt"><?php echo $display["total_amount"];?></span></td>
  </tr>
  <tr>
    <td>Service Tax (Including swachh bharat cess)(15%)</td>
    <td>:</td>
    <td><span id="tax_info"><?php echo $display["tax"];?></span></td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><span id="grand_info"><?php echo $display["amount_payable"];?></span></td>
  </tr>
</tbody></table>


<div class="title"><span class="red">*</span> Payment Mode</div>
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


<ol class="numeric">
<li>Payment must be made within three working days from placing the order, failing will result in cancellation of order. </li>
<li>Cheque should be in favour of - <strong>The Gems & Jewellery Export Promotion Council</strong>. </li>
</ol>
-->
<div class="clear"></div>
    <div align="center">
    <?php if($count<=0 || $display["Payment_Approved"]=="N" || $display["Info_Approved"]=="N" ){?><?php //} ?>
	<?php //if($_REQUEST['auth']=="admin" || $_SESSION['Exhibitor_Country_ID']!=64 ){
	/*if($_REQUEST['auth']=="admin"){	*/?>
  	<input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" />
  	<?php } ?>
	  
    <a href="manual_list.php"><input name="input2" type="button" value="Back To List" class="maroon_btn" /></a>
    </div>

</form>
</div>

</div>

<div class="clear" style="height:10px;"></div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>

</body>
</html>