<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php");	exit; }
?>
<?php 
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$formDeadLine = getFormDeadLineTime(2,$conn);
?>
<!--IF THE DEADLINE HAS PASSED, LET USER KNOW...ELSE, DISPLAY THE REGISTRATION FORM-->
<?php /*if($current_time >= $formDeadLine) { echo 'HIDE'; } else { echo 'SHOW'; } */ ?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$sqlquery = "SELECT * FROM `iijs_catalog` WHERE `Exhibitor_Code`='$exhibitor_code'";
$result1 = $conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<=0)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply COMPULSORY CATALOGUE Form to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
} 
?>
<?php
$exhibitor_data = "select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
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
if($Exhibitor_Section=="Allied" || $Exhibitor_Section=="International Loose" || $Exhibitor_Section=="International Jewellery")
{
	$Exhibitor_Section="Loose Stones";
}
$Exhibitor_Area=$fetch_data['Exhibitor_Area'];
$Exhibitor_DivisionNo=$fetch_data['Exhibitor_DivisionNo'];
$Exhibitor_Scheme=$fetch_data['Exhibitor_Scheme'];
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
$action=$_REQUEST['action'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=="ADD" || $action!="ADD")
{
	//$conn ->query("delete from iijs_stand_items_tmp where EXHIBITOR_CODE='$exhibitor_code'");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>STANDFITTING SERVICES</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="js/standfitting.js"></script>
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
    top: 235%;
    right: 0%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -48%;
    left: 93%;
    margin-left: -60px;
    border-width: 37px;
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
        padding: 8px 20px;
    background-color: #924b77;
    color: #fff;
}
#formWrapper .spanbox a{color:#fff;}
</style>
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

<!-- Dont Allow Space in Quantity -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
<script type="text/javascript">
function fixme(element) {
 var val = element.value;
 var pattern = new RegExp('[ ]+', 'g');
 val = val.replace(pattern, '');
 element.value = val;
} 

$(function() {
  $('#staticParent').on('keydown', '#Item_Quantity', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script>
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
			var Payment_Master_Amount=$('#Payment_Master_Amount').val();
			var Payment_Master_AmountPaid = $('#Payment_Master_AmountPaid').val();
			var tds_amount = Payment_Master_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = Payment_Master_AmountPaid-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);
		});
    });
</script>
<script type="text/javascript">
	$(document).ready(function(){	
			var tds_tax=$('#tds_tax').val();
			var Payment_Master_Amount=$('#Payment_Master_Amount').val();
			var Payment_Master_AmountPaid = $('#Payment_Master_AmountPaid').val();
			var tds_amount = Payment_Master_Amount*tds_tax/100;
			$("#tds_amount").val(tds_amount);
			
			var net_payable_amount = Payment_Master_AmountPaid-tds_amount;
			$("#net_payable_amount").val(net_payable_amount);		
    });
</script>
</head>

<body>
<div class="loader"></div>
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
<h3>Standfitting Services</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>No on site order will be available at the venue. Request you to kindly Apply before the Deadline</li>
<li>Kindly submit stall layout (Form No.3) mentioning placement of furniture's & lights ordered. In Case of Non-Submission, Lighting Option will be as per default section light.(Diamond & Colour Stone = White, Plain Gold, Loose=White)</li>
<li>No changes or modification will be accepted after placing the orders</strong></li>
</ol>
</span>
</div>

<span style="margin-left:10px;float:right" class="spanbox">Deadline : <strong><?php echo getFormDeadLine(4,$conn);?></strong></span>

<span style="margin-left:10px;float:right" class="spanbox"><a href="standfitting_items.php" target="_blank"><strong>Click here to view furniture dimensions</strong></a></span>

<div class="clear"></div>
 
<!---->
<?php if($_REQUEST['auth']=="admin"){ ?>
	<a href="standfitting_services.php?&auth=admin&action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<?php } else { ?>
<a href="standfitting_services.php?action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<?php } ?>
<h2 style="float:left">Application Summary</h2>

<div class="clear"></div>

<table cellspacing="0" cellpadding="0" class="common">
    <tbody>
        <tr>
        <th valign="top">Sr No.</th>
        <th valign="top">Date</th>
        <th valign="top">Order No</th>
        <th valign="top">
        <div align="center">Info Status</div></th>
        <th valign="top">
        <div align="center">Payment Status</div></th>
        <th valign="top" class="centerAlign">
        <div align="center">Application Status</div></th>
		<th valign="top" class="centerAlign">
        <div align="center">Print Acknowledgement</div></th>
        </tr>
    <?php
	$query = $conn ->query("SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='3' order by b.Payment_Master_ID asc");
	$order_num =  $query->num_rows;
	$i=1;
	while($result = $query->fetch_assoc()){
	?>
        <tr>
        <td><?php echo $i;?></td>
		<td><?php echo date("j M Y", strtotime($result['Create_Date']));?></td>
        <td><?php echo $result['Payment_Master_OrderNo'];?></td>
        <td class="centerAlign">
		<?php  
			if($result['Info_Approved']=='Y')
			echo "<img src='images/correct.png'  alt='' />";
			else if($result['Info_Approved']=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
			else
			echo "<img src='images/pending.png'  alt='' />";		
		?>		
        </td>
        <td  class="centerAlign">
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
			if($result['Application_Complete']=='Y')
			echo "<img src='images/correct.png'  alt='' />";
			else if($result['Application_Complete']=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
			else
			echo "<img src='images/pending.png'  alt='' />";		
		?>
        </td>
		<?php if($result['Payment_Master_OrderNo']!=""){?>
	<td> <a href="print_acknowledge/standfitting.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Stand_ID=<?php echo $result['Stand_ID'];?>&orderno=<?php echo $result['Payment_Master_OrderNo'];?>" target="_blank" class="button5">Print AcknowledgeMent</a></td>
	<?php if($result['txn_status']=="3111"){?>
	<td><a href="standfitting_payment_thankyou.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&link=link" target="_blank" class="button5">Pay</a>
	<?php } ?>
	 </td>
		<?php } ?>
        </tr>
    <?php $i++;}?>     
    </tbody>
</table>

<?php if($order_num==0 || $_REQUEST['action']=='ADD' || $_REQUEST['action']=='summary') { ?>
<p>The sections marked with an <span class="red">*</span> are compulsory.</p>

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
    <td><?php  echo getSection_desc($fetch_data['Exhibitor_Section'],$conn);  ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<div class="title"><h4>Basic Furniture</h4></div>
<div class="clear"></div>
<p><strong>Please refer Form No 4 for Booth options and basic package</strong></p>
<!--
<table border="0" cellspacing="0" cellpadding="0" class="formManual tableBorder">  
	<?php
/*	if($Exhibitor_Section=='signature_club' && $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area' and `ex_scheme`='$Exhibitor_Scheme' and `ex_stall_type`='$Exhibitor_StallType'";
	} else if($Exhibitor_Section=='loose_stones' && $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area' and `ex_scheme`='$Exhibitor_Scheme'";
	} else if($Exhibitor_Scheme=='BI1' || $Exhibitor_Scheme=='BI2')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE `ex_section`='$Exhibitor_Section' AND`ex_scheme`='$Exhibitor_Scheme' AND `ex_area`='$Exhibitor_Area'";	
	} */
	
	$getSection = getSection_type($fetch_data['Exhibitor_Section'],$conn);
	
	$sql1="SELECT * FROM iijs_stall_basic_furniture where ex_section='$getSection' AND `ex_area`='$Exhibitor_Area'";
  	$result1 = $conn ->query($sql1);
	$rows1 = $result1->fetch_assoc();
	$order_number =  $result1->num_rows;
	if($order_number>0)
	{
	?>
  <tr>
    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong>
	<?php echo getSection_desc($Exhibitor_Section,$conn); ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Tall Showcase</td>
    <td class="bold" width="14%">Top Glass Showcase</td>
    <td class="bold" width="14%">Table</td>
    <td class="bold" width="14%">Chair</td>
    <td class="bold" width="14%"><?php if($getSection=="machinery"){?>16 Watt LED Light<?php } else { ?>50 Watt Track Light<?php } ?></td>
    <td class="bold" width="14%">Dustbin</td>
    <td class="bold" width="14%">Plug Point</td>
    <td class="bold" width="14%">2mtr window Glass Unit</td>
    <td class="bold" width="14%">1mtr window Glass Unit</td>
  </tr>
  <tr>
 	<td><?php echo $rows1['tall_showcase'];?></td>
	<td><?php echo $rows1['top_glass_showcase'];?></td> 	
    <td><?php echo $rows1['no_of_table'];?></td>
    <td><?php echo $rows1['chair'];?></td>
    <td><?php echo $rows1['50_w_track_light'];?></td>
    <td><?php echo $rows1['dustbin'];?></td>
	<td><?php echo $rows1['plug_point'];?></td>
    <td><?php echo $rows1['2m_window_glass_unit'];?></td>
    <td><?php echo $rows1['1m_window_glass_unit'];?></td>
  </tr>
    <?php } ?>
</table>-->

<div class="title"><h4>Items Selection</h4></div>
<div class="clear"></div>

<form id="item_selection" name="item_selection" method="post">
<table border="0" cellspacing="0" cellpadding="0" class="formManual" id="abc">
    <tr>
      <th class="bold">Extra Items</th>
      <th class="bold"><span>Avail Qty</span></th>
      <th class="bold">Rate</th>
      <th class="bold">Quantity</th>
      <th class="bold">&nbsp;</th>
     </tr>
    <tr>	
      <td>
      <input type="hidden" name="xyz" value=""/>
      <select class="textField" id="Item_ID" name="Item_ID" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>>
      <option value="" selected="selected">--Select Item--</option>
	    <?php 
        if($Exhibitor_Section != 'machinery' && $Exhibitor_Section != 'allied'  )
		{
	  	    $sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='' ";
		} 
		else
		{
		 $sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='machinery' ";
		}
		
        $query = $conn ->query($sql);
        while($result = $query->fetch_assoc()){ ?>
       <option value="<?php echo $result['Item_ID'];?>"><?php echo $result['Item_Description'];?></option>
       <?php } ?>
       </select> 
       </td>
      <td id="avail_qty">0</td>
      <td id="rate">0</td>
      <td>
      <input type="hidden" name="exhibitor_code" id="exhibitor_code" value="<?php echo $exhibitor_code;?>" />
	  <div id="staticParent">
      <input type="text" name="Item_Quantity" id="Item_Quantity" onkeyup="if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" autocomplete="off" class="textField" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?> />
	  </div>
      </td>
    <td>
	<span class="bold">
    <?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine){ ?>
    <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>/><?php } if($current_time >= $formDeadLine) { } else { ?>
	<input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>/>
	<?php } ?>      
    </span>
	</td>
	<span id='progress' style="display:none"><img src="images/progress.gif"/></span>
    </tr>
  </table>  

<div class="title"><h4>Applied Items (Order No: <?php echo $_REQUEST['orderno'];?>)</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
     <td class="bold">Items Applied </td>
     <td class="bold">Rate</td>
     <td class="bold"><span>Amount</span></td>
     <td class="bold">Quantity</td>
	 <?php if(!isset($_REQUEST['Stand_ID'])){ ?>
     <td class="bold">Action</td>
	 <?php } ?>
    </tr>
    <tbody id="Applied_Items">
    <?php 
	if(isset($_REQUEST['Stand_ID']) && $_REQUEST['Stand_ID']!="")
	{
		$Stand_ID=$_REQUEST['Stand_ID'];		
		$query=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
	}
	else
	{
    	$query=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
	}
	while($result = $query->fetch_assoc()){ 
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	?>
    <tr>
      <td><?php echo getItemDescription($result['Item_Master_ID'],$conn);?></td>      
      <td><?php echo $result['Item_Rate']?></td>
      <td><?php echo $tot;?></td>	  
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result['Item_Quantity'];?>" disabled="disabled" /></td>
	  <?php if(!isset($_REQUEST['Stand_ID'])){ ?>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
	  <?php } ?>
   </tr>   
   <?php } ?>
  </tbody> 
  </table>

<div class="title"><h4>Payment </h4></div>
</form>
<form name="visitorRegn" action="standfitting_payment_thankyou.php" method="POST" onsubmit="return confirm('No order will be modified / deleted after submitting. Do you really want to submit the form?');document.getElementById('submit').disabled=true;
document.getElementById('submit').value='Submitting, please wait...';">

<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
if(isset($_REQUEST['Stand_ID']) && $_REQUEST['Stand_ID']!="")
{
	$Stand_ID=$_REQUEST['Stand_ID'];
	$query=$conn ->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
}
else
{
	$query=$conn ->query("select * from iijs_stand_items_tmp where Exhibitor_Code='$exhibitor_code'");
}
$tot=0;
while($result = $query->fetch_assoc())
{
	$tot=$tot+$result['Item_Rate']*$result['Item_Quantity'];
}
?>
  <tr>
    <td width="24%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="48%"><?php echo $tot;?><input type="hidden" name="Payment_Master_Amount" id="Payment_Master_Amount" value="<?php echo $tot;?>"/></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Grand Total</td>
    <td>:</td>
    <td><?php echo $grand_tot=round($tot+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>"/></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
</div>

<?php 
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
$result = $query->fetch_assoc();
$Payment_Master_Approved=$result['Payment_Master_Approved'];
$Payment_Master_Reason=$result['Payment_Master_Reason'];
?>

<?php if(isset($_REQUEST['orderno'])){?>
<?php
$Stand_ID=$_REQUEST['Stand_ID'];
//echo "select * from iijs_payment_stand where Stand_ID='$Stand_ID'";
$query=$conn ->query("select * from iijs_stand where Stand_ID='$Stand_ID'");
$result_i =$query->fetch_assoc();
 $Info_Approved=$result_i['Info_Approved'];
$Info_Reason=$result_i['Info_Reason'];
?>
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
<?php } ?>

<ol class="numeric">
<li>No on site order will be available at the venue. Request you to kindly Apply before the Deadline</li>
</ol>
    <div align="center">
     <?php if($_REQUEST['orderno']!=""){ ?>
	 <a href="print_acknowledge/standfitting.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Stand_ID=<?php echo $_REQUEST['Stand_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	 <?php } ?>

	 <?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine || $order_num==0){ ?>
     <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> 
	 <?php } ?>/><?php }  else {
	//if($current_time <= $formDeadLine) { 
    if($_REQUEST['orderno']==""){ ?>
	<input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){ ?> 
	 <?php } ?>/><?php } //}	 
	 }  ?>
	 
	 <a href="manual_list.php" class="maroon_btn">Cancel</a>
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