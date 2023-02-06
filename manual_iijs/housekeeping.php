<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
?>
<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$formDeadLine = getFormDeadLineTime(6,$conn);
?>
<!--IF THE DEADLINE HAS PASSED, LET USER KNOW...ELSE, DISPLAY THE REGISTRATION FORM-->
<?php /*if($current_time >= $formDeadLine) { echo 'HIDE'; } else { echo 'SHOW'; } */ ?>
<?php 
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$sqlquery="SELECT * FROM `iijs_catalog` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1 = $conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply COMPULSORY CATALOGUE ENTRY FORM to access this form.");'; 
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
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];

$sql = "select * from iijs_housekeeping where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($sql);
$rows = $result->fetch_assoc();
$num_rows = $result->num_rows;

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

if($Exhibitor_Area=='9' || $Exhibitor_Area=='12'  || $Exhibitor_Area=='16' || $Exhibitor_Area=='18')
{
$Payment_Amount='935';	
}else if($Exhibitor_Area=='27')
{
$Payment_Amount='1450';	
}else if($Exhibitor_Area=='36' )
{
$Payment_Amount='1800';	
}else if($Exhibitor_Area=='54' || $Exhibitor_Area=='72' || $Exhibitor_Area=='108')
{
$Payment_Amount='2000';	
}

$tax = round(intval($Payment_Amount) * 0.18);
$PaymentIncTax = $Payment_Amount + $tax; // sending into db from here i.e. Payment_Amount field in DB
?>

<?php
$action=$_REQUEST['action'];
if($action=='SAVE')
{ //echo '<pre>'; print_r($_POST); exit;
	if(!isset($_POST['HouseKeepingService_ID'])){
	echo "<script type='text/javascript'> alert('Please Select Time of Service');
			window.location.href='housekeeping.php';
			</script>";
			return;	exit;
    } 
	
	//$Payment_Amount			= filter($_REQUEST['Payment_Amount']);
	$HouseKeepingService_ID	= filter($_REQUEST['HouseKeepingService_ID']);	
	$tds_tax 				= filter($_POST['tds_tax']);
	$tds_amount 			= filter($_POST['tds_amount']);
	$net_payable_amount 	= filter($_POST['net_payable_amount']);
	$Create_Date=date("Y-m-d");
	$Modify_Date=date("Y-m-d");

if(isset($PaymentIncTax) && !empty($PaymentIncTax) AND isset($net_payable_amount) && !empty($net_payable_amount))
{	
	$strNo = rand(1,1000000);
	$orderId = 'HOUSE22'.$strNo;
	$_SESSION['orderId'] = $orderId;
			
	$sqlx = "select * from iijs_housekeeping where Exhibitor_Code='$exhibitor_code' AND Payment_Approved!='Y'";
	$resultx = $conn ->query($sqlx);
	$countNum = $resultx->num_rows;
	if($countNum > 0)
	{
		$updatesql="update iijs_housekeeping set orderId='$orderId',HouseKeepingService_ID='$HouseKeepingService_ID',Payment_Amount='$PaymentIncTax',tds_tax='$tds_tax',tds_amount='$tds_amount',net_payable_amount='$net_payable_amount',Info_Approved='P',Info_Reason='',Application_Complete='P',Modify_Date='$Modify_Date' where Exhibitor_Code='$exhibitor_code' AND Payment_Approved!='Y'";
		$result2=$conn ->query($updatesql);
		if(!$result2) die ($conn->error);
	} else {
		$insertsql="insert into iijs_housekeeping (orderId,Exhibitor_Code,HouseKeepingService_ID,Payment_Amount,tds_tax,tds_amount,net_payable_amount,Info_Approved,Info_Reason,Payment_Approved,Payment_Reason,Application_Complete,Create_Date) values ('$orderId','$exhibitor_code','$HouseKeepingService_ID','$PaymentIncTax','$tds_tax','$tds_amount','$net_payable_amount','P','','P','','P',NOW())";
		$result2=$conn ->query($insertsql);
		if(!$result2) die ($conn->error);
	}
	if($result2){
		header('Location: ebs/housekeeping_techprocess.php');
	}
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>House Keeping Services</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<!-- place holder script for ie -->
<script type="text/javascript">
    $(function() {
        if (!$.support.placeholder) {
            var active = document.activeElement;
            
            $(':text').focus(function() {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function() {
                if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                    $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                }
            });
            $(':text').blur();         
            $(active).focus();           
        }
    });
</script>    
	<style>
	.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: 80;
	}
	</style>
	
	<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
	</script>
<!--manual form css-->
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<script language="javascript">
function validation()
{
	if($('input[name="HouseKeepingService_ID"]:checked').length == 0)
	{
		alert("Please Select Time of Service");
		document.getElementById("HouseKeepingService_ID").focus();
		return false;
	}
}
</script>

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
    top: -29%;
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
<script type="text/javascript">
$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
<script type="text/javascript">
    $(function () {
		$("#tds_tax").on('change',function(){
			var tds_tax=$('#tds_tax').val();
			var Payment_Amount=$('#Payment_Amount').val();
			var PaymentIncTax = $('#PaymentIncTax').val();
			var tds_amount = Payment_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = PaymentIncTax-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);
		});
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){	
			var tds_tax=$('#tds_tax').val();
			var Payment_Amount=$('#Payment_Amount').val();
			var PaymentIncTax = $('#PaymentIncTax').val();
			var tds_amount = Payment_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = PaymentIncTax-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);		
    });
</script>
</head>

<body>
<!-- header starts -->
<div class="loader"></div>
<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<div class="clear"></div>

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>House Keeping Services</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>The services can be availed at either of two timings - 8.00 am to 9.00 am OR 8.00 pm. to 9.00 pm. The same timing will be followed for all the show days.</li>
<li>Kindly note that the housekeeping personnel will visit the stall only once as per the timing preference mentioned. Waiting time / Postponement of the service will not be allowed.</li>
<li>Housekeeping Service will include: - Wastepaper Basket Clearance, Table top cleaning, Dusting of the stall space, Vacuuming of the stall area. (DO NOT include showcase & glass cleaning.)</li>
<li>Any complaints regarding the Housekeeping Service / Personnel should be addressed to your Zone Manager at the Service Stall.</li>
</ol>
</span>
</div>

<span style="margin-left:40%;" class="spanbox">Deadline : <strong><?php echo getFormDeadLine(4,$conn);?></strong></span>

<div class="clear"></div>
<?php if($Payment_Approved=='Y'){ ?>
<h2>Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
    <th valign="top">Date</th>
	<th valign="top">Order No</th>
    <th valign="top">Information Status</th>
    <th valign="top">Payment Status</th>
    <th valign="top">Application Status</th>
	<th valign="top" class="centerAlign">
    <div align="center">Print Acknowledgement</div></th>
</tr>

<tr>	
	<td valign="middle"><?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
	<td valign="middle"><?php echo $rows['orderId'];?></td>
    <td valign="middle" class="centerAlign">
     <?php  
        if($Info_Approved=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Info_Approved=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";        
    ?>
    </td>
    <td valign="middle" class="centerAlign">
     <?php  
        if($Payment_Approved=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Payment_Approved=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";        
    ?>
    </td>                               
    <td valign="middle" colspan="1" class="centerAlign">
      <?php  
        if($Application_Complete=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Application_Complete=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";
    ?>
    </td>
	<td>
	<a href="print_acknowledge/housekeeping.php?HouseKeeping_ID=<?php echo $HouseKeeping_ID;?>" target="_blank" class="button5">Print Acknowledgment</a>
	</td>
    </tr>	
</tbody>
</table>
<?php } ?>
<?php if($Payment_Approved=='' || $Payment_Approved!='Y'){ ?>
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

<form name="form1" id="form1" method="POST" action="" onsubmit="return validation()">
<input type="hidden" name="action" value="SAVE" />
<input type="hidden" name="Payment_Amount" id="Payment_Amount" value="<?php echo $Payment_Amount;?>"/>
<input type="hidden" name="PaymentIncTax" id="PaymentIncTax" value="<?php echo $PaymentIncTax;?>"/>

<table width="680" border="0" cellspacing="0" cellpadding="0" class="formManual">  
	<tr>
	<td class="bold"><strong>Date of Service</strong></td>
	<td>:</td>
	<td colspan="2">4th to 8th of AUGUST, 2022</td>
    </tr>  
	<tr>
    <td width="322" class="bold"><strong>Time of Service (Please tick your preference)<sup>*</sup></strong></td>
    <td width="15">:</td>
    <td width="164"><input type="radio" name="HouseKeepingService_ID" id="HouseKeepingService_ID" value="1" /> 8.00 a.m. to 9.00 a.m</td>
    <td width="179"><input type="radio" name="HouseKeepingService_ID" id="HouseKeepingService_ID" value="2" /> 8.00 p.m. to 9.00 p.m.</td>
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

<table  border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th>Sr. No.</td>
    <th>Area</td>
    <th>No. of Days</td>
    <th>Rate (Exclusive Tax)</td>
  </tr>
  <tr>
    <td>1</td>
    <td>9 to 18 Sqmt</td>
    <td>Five days (starting 4th to 8th August, 2022)</td>
    <td>INR 935/-</td>
  </tr>
  <tr>
    <td>2</td>
    <td>27 Sqmt</td>
    <td>Five days (starting 4th to 8th August, 2022)</td>
    <td>INR 1450/-</td>
  </tr>
  <tr>
    <td>3</td>
    <td>36 Sqmt</td>
    <td>Five days (starting 4th to 8th August, 2022)</td>
    <td>INR 1800/-</td>
  </tr>
  <tr>
    <td>4</td>
    <td>54 to 108 Sqmt</td>
    <td>Five days (starting 4th to 8th August, 2022)</td>
    <td>INR 2000/-</td>
  </tr>
</table>

<p>The services can be availed at either of two timings - 8.00 a.m to 9.00 a.m OR 8.00 p.m. to 9.00 p.m.</p>
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
    <td width="150">GST (18%)</td>
    <td>:</td>
    <td><?php echo $tax;?></td>
   </tr>
  <tr>
    <td width="150">Grand Total INR</td>
    <td>:</td>
    <td><?php echo $PaymentIncTax;?></td>
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
    <td><input name="net_payable_amount" id="net_payable_amount" type="text" class="textField" readonly/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="clear"></div>
<p><input type="checkbox" name="iagree" id="iagree" checked="checked" /> I have read and understood the terms and conditions as mentioned above and agree to abide by the same.</p>

<div class="clear"></div>

<div align="center"> <?php /*if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine){ */?>

<?php if( $_REQUEST['auth']=="admin" || $Payment_Approved=='P' || $Payment_Approved=='C') { ?>
<?php 
/*if($Payment_Approved=='' && $current_time >= $formDeadLine){ } else */

if($Payment_Approved=='' || $Payment_Approved=='P' || $Payment_Approved=='N' || $Payment_Approved=='C' || $_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN"  ){ // && $current_time >= $formDeadLine ?>
<input name="submit" id="submit" type="submit" value="Submit"  class="maroon_btn" />  
<?php }  else { ?>
 <a href="print_acknowledge/housekeeping.php?HouseKeeping_ID=<?php echo $HouseKeeping_ID;?>" target="_blank" class="button5">Print Acknowledgement</a>
<?php } } ?>
    <a href="manual_list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
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
</body>
</html>