<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){ header("location:index.php"); exit; }
$event = getEventDescription($conn);
?>
<?php
date_default_timezone_set('Asia/Kolkata');
$cr_date=date('d-m-Y H:i:s');
$current_time = strtotime($cr_date);
$formDeadLine = getFormDeadLineTime(5,$conn);
?>
<!--IF THE DEADLINE HAS PASSED, LET USER KNOW...ELSE, DISPLAY THE REGISTRATION FORM-->
<?php /*if($current_time >= $formDeadLine) { echo 'HIDE'; } else { echo 'SHOW'; } */ ?>
<?php  
// Define path and new folder name 
$create_dir = "images/Location_Layout/".$_SESSION['EXHIBITOR_CODE']; 
if(!file_exists($create_dir)) { 
   mkdir($create_dir, 0777);
}  
?>
<?php
$exhibitor_code = $_SESSION['EXHIBITOR_CODE'];
$sqlquery = "SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M')";
$result1 = $conn ->query($sqlquery);
$total_badge = $result1->num_rows;
if($total_badge<2)
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Please Apply Minimum 2 Exhibitor Badges to access this form.");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';	
}
?>
<?php
$Exhibitor_Country_ID=$_SESSION['Exhibitor_Country_ID'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=$conn->query($exhibitor_data);
$fetch_data = $result->fetch_assoc();

$Exhibitor_Name=$fetch_data['Exhibitor_Name'];
$Exhibitor_Contact_Person=$fetch_data['Exhibitor_Contact_Person'];
$Exhibitor_Phone=$fetch_data['Exhibitor_Phone'];
$Exhibitor_Fax=$fetch_data['Exhibitor_Fax'];

$Exhibitor_StallNo[]="";

// for($i=0;$i<8;$i++){
// 	if($fetch_data["Exhibitor_StallNo".($i+1)]!="")
// 		$Exhibitor_StallNo[$i]=$fetch_data["Exhibitor_StallNo".($i+1)];
// }
for($i=0;$i<1;$i++){
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

<?php 
if(isset($_POST['save']) && $_POST['save']=="Save" )
{
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	$query_cnt=$conn ->query("SELECT * FROM `iijs_safe_rental_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	$safe_cnt=$query_cnt->num_rows;
	if($safe_cnt==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Items in order');
		window.location.href='safe_rental_or_indemnity_bond_form.php?action=ADD';
		</script>"	;
		return;
	}
	
	$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
	$Payment_Master_Amount=$_POST['grand_tot'];
	$Payment_Master_AmountPaid=$Payment_Master_Amount;
	$Create_Date=date('Y-m-d h:i:s');
	$Badge_Item_ID1=$_POST['keyperson1'];
	$Badge_Item_ID2=$_POST['keyperson2'];
	$gstin = trim($_POST['gstin']);
	$utr_no = trim($_POST['utr_no']);
	$iagree = trim($_POST['iagree']);

	$iijs_badge_items1 = $conn ->query("update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$Badge_Item_ID1'");
	$iijs_badge_items2 = $conn ->query("update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$Badge_Item_ID2'");
	
	/*..........................Payment Update..................................*/
	
	$iijs_payment_master = $conn ->query("insert into iijs_payment_master set Form_ID='5A',Exhibitor_Code='$Exhibitor_Code',Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',tds_tax='0',Payment_Master_Approved='P',tds_amount='0',net_payable_amount='0',Create_Date='$Create_Date'");
	$Payment_Master_ID = mysqli_insert_id($conn);
	
	/*list($txt, $ext) = explode(".", $_FILES['Location_Layout']['name']);
			$Location_Layout = $exhibitor_code.".".$ext; */
	$Location_Layout=$exhibitor_code.'_'.addslashes($_FILES['Location_Layout']["name"]);
	$target_path=$create_dir."/".$Location_Layout;
	/*$target_path="Location_Layout/".$Location_Layout;
	$target_path=$create_dir."/".$Location_Layout;*/
	$tmp = $_FILES['Location_Layout']['tmp_name'];
	move_uploaded_file($tmp,$target_path);
	
	$iijs_safe_rental = $conn ->query("insert into iijs_safe_rental set Exhibitor_Code='$Exhibitor_Code',gstin='$gstin',utr_no='$utr_no',iagree='$iagree',Location_Layout='$Location_Layout',Create_Date='$Create_Date',Modify_Date='$Create_Date',Payment_Master_ID='$Payment_Master_ID'");
	$Safe_Rental_ID = mysqli_insert_id($conn);
	//$conn ->query("update iijs_safe_rental set Location_Layout='$Location_Layout' where Exhibitor_Code='$Exhibitor_Code'");

	$query=$conn ->query("SELECT * FROM `iijs_safe_rental_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result=$query->fetch_assoc())
	{
	$Safe_Rental_Items_ID=$result['Safe_Rental_Items_ID'];
	$Safe_ID=$result['Safe_ID'];
	$Item_Rate=$result['Item_Rate'];
	$Item_Quantity=$result['Item_Quantity'];
		
	$item = $conn ->query("insert into iijs_safe_rental_items set Safe_Rental_ID='$Safe_Rental_ID',Safe_ID='$Safe_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate',Create_Date='$Create_Date'");
	
	/*......................Get Stand Fitting Item Quantity...............................*/
	$qitem_quantity = $conn ->query("select Item_Quantity from iijs_safe_rental_master where Safe_ID='$Safe_ID'");
	$ritem_quantity = $qitem_quantity->fetch_assoc();
	$tot_quantity = $ritem_quantity['Item_Quantity'];
	$remain_quantity = $tot_quantity-$Item_Quantity;
	$safe = $conn->query("update iijs_safe_rental_master set Item_Quantity='$remain_quantity' where Safe_ID='$Safe_ID'");	
	$tmp = $conn->query("delete from iijs_safe_rental_items_tmp where Safe_Rental_Items_ID='$Safe_Rental_Items_ID'");
	}
	
	$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	<tr>
	<td style="padding:30px;">
	<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
	<tr>
	<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="230" /></td>
	<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/SIGNATURE-LOGO-4.jpg" width="120" border="0"/></td>
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
	<p>Thank you for applying Online for <strong>SAFE RENTAL</strong>. Please note your application is under approval process. </p>
	
	<p>All the applicant members will have to send the requisite payment along with the print acknowledgment receipt which will be available after successful submission of online application with company seal in 4 working days from date of online submission.</p>
	
	<p>A system generated notification will be sent to you on successful Approval/Disapproval of your application</p>
	
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
	$subject = "".$event." Exhibitor Manual - SAFE RENTAL";	
	$headers  = 'MIME-Version: 1.0' . "\n";	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	$headers .= 'From: "'.$event.'" <admin@gjepc.org>';            
	@mail($to, $subject, $message, $headers);

		echo '<script type="text/javascript">'; 
		echo 'alert("You have successfully submitted your application...\n Kindly take print acknowledgment of your order and submit to council office along with requisite payment");'; 
		echo 'window.location.href = "safe_rental_or_indemnity_bond_form.php"';
		echo '</script>';
}

if(isset($_POST['update']))
{
	//echo '<pre>'; print_r($_POST); exit;
	$Location_Layout = $exhibitor_code.'_'.$_FILES['Location_Layout']['name'];
	$target_path=$create_dir."/".$Location_Layout;
	$tmp = $_FILES['Location_Layout']['tmp_name'];
	move_uploaded_file($tmp,$target_path);	
	$Safe_Rental_ID = $_POST['Safe_Rental_ID'];
	$Payment_Master_ID = $_POST['Payment_Master_ID'];
	$rent = $conn ->query("update iijs_safe_rental set Location_Layout='$Location_Layout',Layout_Approve ='P',Layout_Reason='',Application_Complete='P',iagree='".$_POST['iagree']."',utr_no='".$_POST['utr_no']."' where Safe_Rental_ID='$Safe_Rental_ID'");

	$pay = "update iijs_payment_master set Payment_Master_Approved='P' where Payment_Master_ID='$Payment_Master_ID' AND Exhibitor_Code='$exhibitor_code' and Form_ID='5A'";
	$iijs_payment_master = $conn ->query($pay);
	
header('location:safe_rental_or_indemnity_bond_form.php');
}
/*
if(isset($_POST['update']))
{
	$Location_Layout = $exhibitor_code.'_'.$_FILES['Location_Layout']['name'];
	//$target_path="Location_Layout/".$Location_Layout;
	$target_path=$create_dir."/".$Location_Layout;
	$tmp = $_FILES['Location_Layout']['tmp_name'];
	move_uploaded_file($tmp,$target_path );	
	$Safe_Rental_ID=$_POST['Safe_Rental_ID'];
$conn ->query("update iijs_safe_rental set Location_Layout='$Location_Layout',Layout_Approve ='P',Application_Complete='P' where Safe_Rental_ID='$Safe_Rental_ID'");
	header('location:safe_rental_or_indemnity_bond_form.php');
}
*/
$action=$_REQUEST['action'];
if($action!="ADD")
$tmps = $conn ->query("delete  from iijs_safe_rental_items_tmp where Exhibitor_Code='$exhibitor_code'");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Safe Rental</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<!--<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>-->

<!--navigation script end-->

<script src="js/saferental.js"></script>
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
    top: -24%;
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

.tooltiptext a{color:#fff;}

#formWrapper{width:100%;}
#formWrapper > h3{float:left;}
.tooltip{float:right;}

#formWrapper .spanbox{
    padding: 8px 20px;
	float:right;
	color:#fff;
	margin-left:10px;
    background-color: #924b77;	
}
</style>

<script type="text/javascript">
function validate()
{
	//tot=$("#grand_tot").val();
	//alert(tot);
	
	/*safe_cnt=$("#safe_cnt").val();
	alert(safe_cnt);
	if($("#safe_cnt").val()==0)
	{
		alert('Please Add items in order');
		return false;
	}*/
	
	if($("#keyperson1").val()=="")
	{
		alert("Please select Key Person 1");
		$("#keyperson1").focus();
		return false;
	}
	if($("#keyperson2").val()=="")
	{
		alert("Please select Key Person 2");
		$("#keyperson2").focus();
		return false;
	}
	Payment_Mode_ID=$("input[type='radio'][name='Payment_Mode_ID']:checked").val();
	if(Payment_Mode_ID==undefined)
	{
		alert("Please select payment method");
		return false;
	}
	if($("#gstin").val()=="")
	{
		alert("Please Enter your GSTIN No");
		$("#gstin").focus();
		return false;
	}
	// if($("#utr_no").val()=="")	
	// {	
	// 	alert("Please Enter your UTR No");	
	// 	$("#utr_no").focus();	
	// 	return false;	
	// }
	
	var iagree  = document.getElementById("iagree").checked;
	if(iagree==false)	
	{	
		alert ('Please select Terms & Condition!');
        return false;
    } else { 
        return true;
    }
	
	if($("#Location_Layout").val()=="")
	{
		alert("Please Upload Safe Location Layout");
		$("#Location_Layout").focus();
		return false;
	}
	
	var fup = document.getElementById('Location_Layout');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1); 
	if(ext=="jpg" || ext=="JPG" || ext=="png" || ext=="PNG" || ext=="jpeg" || ext=="JPEG")
    {
    }
    else
    {
        alert("Upload Jpg,Png files only");
        return false;
    }	
	
	//alert('Kindly Submit AFFIDAVIT CUM INDEMNITY BOND" printed on Rs. 200/- stamp paper Along with demand draft');
}
</script>
<!-- Dont Allow Space in Quantity -->
<script type="text/javascript">
function fixme(element) {
 var val = element.value;
 //var pattern = new RegExp('[ ]+', 'g');
 var pattern = new RegExp('[a-zA-Z '); //make sure the var is a number
 //var pattern = new RegExp('[a-zA-Z `~!@#$%^&*()_|+-=]+'); //make sure the var is a number
 val = val.replace(pattern, '');
 element.value = val;
} 
</script>

<script type="text/javaScript">
$(document).ready(function() {
	$(".myiagree").hide();
	$('input[type="checkbox"]').click(function(){
    if ($(this).is(":checked")){
      $(".myiagree").show();
  window.location.href = "https://registration.gjepc.org/manual_signature/generate-safe-doc.php";
    } else {
      $(".myiagree").hide();
	}
  });
});
</script>
<style type="text/css" media="all">	
.shadow {	
    position:relative;	
    width:auto;	
    padding:0;	
    margin:0;	
}	
.shadow:before,	
.shadow:after {	
    content:"";	
    position:absolute; 	
    z-index:-1;	
}	
.arch01:after {	
    position:absolute;	
    padding:0; margin:0;	
    height:34px;	
    width:100%;	
    bottom:-30px;	
    left:0px; right:0px;	
    background-image: url('arch_01.png');	
    background-size:100% 100%;	
    background-position:left top;	
}	
</style>
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

<h3>Safe Rental / Indemnity Bond Form</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<?php if($Exhibitor_Country_ID!='IN') { ?>

<li>
	<strong><u>For International Exhibitors only</u></strong><br />
	Please note that the bank / Wire Transfer is only Applicable For International Exhibitors<br />
	For Remittance for the safe rental given below is the bank details.
</li>

<li>
    After form submission, please print an acknowledgement and submit on your company's letter head and <br />
    <strong>Return to:</strong><br />
     The Gem &amp; Jewellery Export Promotion Council<br />
     D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse,<br />
     Bandra Kurla Complex,<br />
     Bandra (E) Mumbai 400 051 - India<br />
     Tel: +91 22 4226 3600 <br />
     Email: <a href="mailto:iijs@gjepcindia.com">iijs@gjepcindia.com </a><br />  
</li>

<li>For payment approval Wire Transfer should reach the council within 3 working days after order date.</li>
<li>The final deadline for the online form submission is <?php echo getFormDeadLine(5,$conn);?>.</li>
<?php } if($Exhibitor_Country_ID=='IN'){ ?>
	
	<li>
	<strong><u>For Domestic Exhibitors only</u></strong><br />
	<li>Payment must be made within three working days from placing the order, failing will result in cancellation of order.</li>			
	<li>Kindly note No Cheque and Demand Draft will be accepted. Payments will be accepted only via NEFT.</li>			
	<li>TDS should not be deducted of Safe Amount.</li>			
	<li>Payment Details:<br />	
			Company Name : Godrej & Boyce Mfg. Co. Ltd<br />	
			Name of the Bank : CITIBANK<br />	
			Branch Address : D. N. Road, Fort, Mumbai 400001<br />	
			MICR code : 400037002<br />	
			Type of Account with code (10/11/13) : Current Account 11<br />	
			Account Number : 0003708748<br />	
			NEFT IFSC Code (11 digit) : CITI0100000<br />	
			Call Centre No. : 1800-103-4353 Missed Call No: +91 7208048100<br />	
		 	
			Telephone No: 022 66515603/04<br /> 	
	</li>
<?php }?>
</ol>
</span>
</div>
<span  class="spanbox">Deadline : <strong><?php echo getFormDeadLine(5,$conn);?></strong></span>
<!-- <span  class="spanbox"><a href="images/pdf/Safe_Rental_Indemnity_Bond_IIJS_Premiere_2022.pdf" target="_blank" style="color:#fff;"><strong>DOWNLOAD AFFIDAVIT CUM INDEMNITY BOND</strong></a></span> -->

<div class="clear"></div>
<?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine){ ?>
<a href="safe_rental_or_indemnity_bond_form.php?&auth=admin&action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<?php } if($current_time >= strtotime($formDeadLine)) { } else { ?>
<a href="safe_rental_or_indemnity_bond_form.php?action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<?php } ?>

<h2 style="float:left">Application Summary</h2>

<table  cellspacing="0" cellpadding="0" class="common">
                                    <tbody>
                                    <tr>
                                      <th valign="top"><span class="table_head" style="width: 58px; height: 13px">Sr. No</span></th>
									  <th valign="top"><span class="table_head" style="width: 78px; height: 13px">Date</span></th>
                                      <th valign="top" class="centerAlign">
                                      <div align="center"><span class="table_head" style="width: 128px; height: 13px;"> Items Approved</span></div></th>
                                       <th valign="top" class="centerAlign">
                                      <div align="center"><span class="table_head" style="height: 13px"> Layout Status</span></div></th>
                                      
                                       <th valign="top" class="centerAlign">
                                      <div align="center"><span class="table_head" style="width: 120px; height: 13px"> Payment Status</span></div></th>
                                       <th valign="top" class="centerAlign">
                                      <div align="center"><span class="table_head" style="height: 13px"> Application Status</span></div></th>
                                    </tr>                                                                        
                                  	
<?php 
$query = $conn->query("SELECT a.*,b.* FROM `iijs_safe_rental` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='5A' order by b.Payment_Master_ID asc");
$order_num = $query->num_rows;
$i=1;
while($result = $query->fetch_assoc())
{
?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="safe_rental_or_indemnity_bond_form.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Safe_Rental_ID=<?php echo $result['Safe_Rental_ID'];?>&orderno=<?php echo $i;?>&action=summary" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
        
        <td valign="middle" colspan="1" class="centerAlign">
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
			if($result['Layout_Approve']=='Y')
			echo "<img src='images/correct.png'  alt='' />";
			else if($result['Layout_Approve']=='N')
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
			if($result['Application_Complete']=='Y')
			echo "<img src='images/correct.png'  alt='' />";
			else if($result['Application_Complete']=='N')
			echo "<img src='images/red_cross.png'  alt='' />";
			else
			echo "<img src='images/pending.png'  alt='' />";		
		?>
        </td>
        </tr>
    <?php $i++;}?>     
    </tbody>
</table>

<?php if($order_num==0 || $_REQUEST['action']=='ADD' || $_REQUEST['action']=='summary') { ?>

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
    <td><?php echo getSection_desc($Exhibitor_Section,$conn); ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<div class="title">
    <h4>DIMENSIONS OF SAFES (mm)</h4>
</div>
<div class="clear"></div>

<table width="533" border="0" cellpadding="0" cellspacing="0" class="formManual" > 
    <tr>
    <th width="48" class="bold borderRight"><div align="center">Sr. No.</div></th>
    <th width="112" class="bold borderRight"><div align="center">Item Desc</div></th>
    <th colspan="3" class="bold borderRight"><div align="center">Outside</div></th>
    <th colspan="3" class="bold borderRight"><div align="center">Inside</div></th>
    <th width="66" class="bold borderRight"><div align="center">Adj. Shelves</div></th>
    <th width="101" class="bold borderRight"> <div align="center">Drawers / Lockers</div></th>
    <th width="78" class="bold borderRight"><div align="center">Volume (In Ltrs.)</div></th>
  </tr> 
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="50">Ht.</td>
      <td width="48">Wdt</td>
      <td width="39">Dpt</td>
      <td width="39">Ht</td>
      <td width="42">Wdt</td>
      <td width="42">Opt</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <?php 
  $i=1;
  
  	if($Exhibitor_HallNo == "1"){ 
		$vendors = 'godrej'; 
	} else 
	{ 
		//$vendors = 'vendor2'; 
		$vendors = 'godrej'; 
	}
  
  $querys=$conn->query("select * from iijs_safe_rental_master where vendor='$vendors'");
  while($result=$querys->fetch_assoc()){  
  ?>
    <tr>
      <td><div align="center"><?php echo $i;?></div></td>
	  <td><?php echo $result['Safe_Description'];?></td>
      <td><?php echo $result['Outside_height'];?></td>
      <td><?php echo $result['Outside_width'];?></td>
      <td><?php echo $result['Outside_depth'];?></td>
      <td><?php echo $result['Inside_height'];?></td>
      <td><?php echo $result['Inside_width'];?></td>
      <td><?php echo $result['Inside_depth'];?></td>
      <td><?php echo $result['Adj_Shelves'];?></td>
      <td><div align="center"><?php echo $result['Lockers'];?></div></td>
      <td><div align="center"><?php echo $result['Cap'];?></div></td>
    </tr>
	<?php $i++;}?>
</table>

<div class="clear"></div>

<table width="530" border="1" cellpadding="0" cellspacing="0" class="formManual" > 
  <tr>
    <th width="30" class="bold borderRight"><div align="center">Sr. No.</div></th>
    <th width="300" class="bold borderRight"><div align="center">Job Description</div></th>
    <th width="100" class="bold borderRight"><div align="center">Safe Model No.40 / 1060</div></th>
    <th width="100" class="bold borderRight"><div align="center">Safe Model No.1360</div></th>
  </tr>
 
	<tr>
      <td>1</td>
      <td>Loss of Key / Duplicate Key from Godrej (Per Key)</td>
      <td>5,200</td>
      <td>5,200</td>     
    </tr>
	<tr>
      <td>2</td>
      <td>Replacement of Lock with new set of keys</td>
      <td>6,200</td>
      <td>8,200</td>     
    </tr>
	<tr>
      <td>3</td>
      <td>Damage / Breaking Lock (force-opening)</td>
      <td>18,000</td>
      <td>28,000</td>     
    </tr>
	<tr>
      <td>4</td>
      <td>Re- Shifting charges(if required)</td>
      <td>3,000</td>
      <td>3,500</td>     
    </tr>
	<tr>
      <td>5</td>
      <td>Loss of key pouch </td>
      <td>200</td>
      <td>200</td>     
    </tr>
	<tr>
      <td>6</td>
      <td>Any other service jobs will be charged extra at actual. Other Govt. Levies & taxes will be extra.</td>
      <td></td>
      <td></td>     
    </tr> 
</table>
<div class="title"> <h4>IMPORTANT</h4> </div>
<div class="clear"></div>

<p>All safes will be supplied with wooden pedestal of height approx 100mm Safes must be installed on this pedestal only.</p>
<p>Please consider this extra height of 100mm while designing your stall layout.</p>
<p>Form for rental of safes( For Indian Exhibitors) - Lease charges (INR)</p>

<form id="item_selection" name="item_selection" method="post" onSubmit="return validate()" enctype="multipart/form-data">
<table border="0" cellspacing="0" cellpadding="0" class="formManual" id="abc">
    <tr>
		<th class="bold">Item Description</th>
		<th class="bold">Up To <br />9/12/2022</th>
		<!--<th class="bold">Up To <br />11/01/2020</th>-->
		<!--<th class="bold">Up To <br />14/01/2017</th>-->
		<th class="bold">Avail Qty</th>
		<th class="bold">Qty.</th>
		<th class="bold">&nbsp;</th>
    </tr>
    <tr>
      <td>
      <input type="hidden" name="xyz" value=""/>
      <select class="textField" id="Safe_ID" name="Safe_ID" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
        $query=$conn ->query("SELECT * from iijs_safe_rental_master where vendor = '$vendors'");
        while($result=$query->fetch_assoc()){ ?>
        <option value="<?php echo $result['Safe_ID'];?>"><?php echo $result['Safe_Description'];?></option>
        <?php } ?>
       </select>  
       </td>
      <td id="deadline_1">0</td>
      <!--<td id="deadline_2">0</td>-->
	  <!--<td id="deadline_3">0</td>-->
      <td id="avail_qty">0</td>
	  <td>
	  <input type="hidden" name="exhibitor_code" id="exhibitor_code"  value="<?php echo $exhibitor_code;?>" />
	  <input type="text" name="Item_Quantity" autocomplete="off" id="Item_Quantity" class="qty" onkeyup="if(/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"/>
	  <!--<input type="text" name="Item_Quantity" id="Item_Quantity" class="qty" onkeyup="fixme(this)" onblur="fixme(this)"/>-->
	  </td>
      <td>
	  <span class="bold">
	  <?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine){ ?>
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php } ?>/>
		<?php } 
		 
		if($current_time >= strtotime($formDeadLine)) {  } else { ?>
	<input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php } ?>/>
	<?php } ?> 
      </span>
	  </td>
      </tr>
  </table>
<div class="title">
<h4>Applied Items <!--(Order No: 14)--></h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">

    <tr>
      <td  class="bold">Items Applied </td>
      <td class="bold"><span>Amount</span></td>
      <td class="bold">Rate</td>
      <td class="bold">Quantity</td>
	  <?php if(!isset($_REQUEST['Safe_Rental_ID'])){?>
      <td class="bold">Action</td>
	  <?php }?>
    </tr>
    <tbody id="Applied_Items">
    <?php 
	//echo $_REQUEST['Safe_Rental_ID'];
	if(isset($_REQUEST['Safe_Rental_ID']) && $_REQUEST['Safe_Rental_ID']!="")
	{
		$Safe_Rental_ID=$_REQUEST['Safe_Rental_ID'];
		$query=$conn ->query("select * from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
	}
	else
	{
    	$query=$conn ->query("select * from iijs_safe_rental_items_tmp where Exhibitor_Code='$exhibitor_code'");
	}
	$grand_tot=0;
	$safe_cnt = $query->num_rows;
	while($result=$query->fetch_assoc())
	{  
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;
	?>
    <tr>
      <td><?php echo getSaferentalId($result['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result['Item_Rate']?></td>
      <td><?php echo $result['Item_Quantity'];?></td>
	  
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
   <?php } ?>
   <!--<input type="hidden" name="safe_cnt" id="safe_cnt" value="<?php echo $safe_cnt;?>">-->
  </tbody> 
</table>

<!--<div class="title">
<h4>Item Approval</h4>

</div>
<div class="clear"></div>


<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">

    
    <tr>
      <td width="215" class="bold">Status</td>
      <td width="21">:</td>
      <td width="33"><img src="../manual/images/correct.png" /></td>
      <td width="281">Approved</td>
    </tr>
    
    
    <tr>
      <td class="bold">Reason (if disapproved)</td>
      <td>:</td>
      <td colspan="2"><textarea class="textArea" style="overflow:auto;"></textarea></td>
    </tr>
  </table>-->

<?php
$i=1; 
$query1=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' ||`Badge_Type`='M' ||`Badge_Type`='R') AND Badge_IsKeyPerson='1'");
while($result1 = $query1->fetch_assoc())
{
		if($i==1){$Badge_Item_ID1=$result1['Badge_Item_ID'];}
		if($i==2){$Badge_Item_ID2=$result1['Badge_Item_ID'];}
		$i++;
} 

?>
<!-- <p><strong>Please print this form and attached it with the "AFFIDAVIT CUM INDEMNITY BOND" printed on Rs.200/- stamp paper.</strong></p> -->
<div id="preloader"></div>
<div class="title">
<h4>Key Persons</h4>
</div>
<div class="clear">
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <td width="14%" class="bold"><sup>* </sup>Key Person</td>
      <td width="3%">:</td>
      <td width="29%"> 
	  <select name="keyperson1" id="keyperson1" class="textField" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>>>
        <option selected="selected" value="">--Select--</option>
        <?php 
		$sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M' || `Badge_Type`='R')";
		$result = $conn ->query($sql);
		while($rows = $result->fetch_assoc())
		{
		if($rows['Badge_Item_ID']==$Badge_Item_ID1)
		{
			echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";
		}
			else
			{
				echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}
		}
		?>
      </select>
	  <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>"/>
	  </td>
      <td width="5%">&nbsp;</td>
      <td class="bold"><sup>*</sup> Key Person</td>
      <td width="5%">:</td>
      <td width="32%">
	  <select name="keyperson2" id="keyperson2" class="textField" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled"<?php }?>>
        <option selected="selected" value="">--Select--</option>
        <?php 
		$sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M' || `Badge_Type`='R')";
		$result=$conn ->query($sql);
		while($rows =  $result->fetch_assoc())
		{
			if($rows['Badge_Item_ID']==$Badge_Item_ID2)
			{
				echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";
			}
			else
			{
				echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}
		}
		?>
      </select>
	  </td>
    </tr>
	<?php 
		$sql=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Badge_Item_ID`='$Badge_Item_ID1'");
		$result =  $sql->fetch_assoc();
		$name1=$result['Badge_Name'];
		$Badge_Designation1=$result['Badge_Designation'];
		$Badge_Photo1=$result['Badge_Photo'];
		
		$sql2=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Badge_Item_ID`='$Badge_Item_ID2'");
		$result2= $sql2->fetch_assoc();
		$name2=$result2['Badge_Name'];
		$Badge_Designation2=$result2['Badge_Designation'];
		$Badge_Photo2=$result2['Badge_Photo'];
	?>
    <tr>
      <td colspan="3" class="bold" id="keydesc1">
		<table border='0' cellspacing='0' cellpadding='0' class='formManual'>
			<tr>
				<td width='29%'>Name</td>
				<td width='6%'>:</td>
				<td width='65%'><?php echo $name1;?></td>
			</tr>
			<tr>
				<td width='29%'>Designation</td>
				<td width='6%'>:</td>
				<td width='65%'><?php echo $Badge_Designation1;?></td>
			</tr>
			<tr>
				<td>Photo</td>
				<td>:</td>
				<td><img src="images/badges/<?php echo $exhibitor_code."/".$Badge_Photo1;?>" width="100" height="100"/></td>
			</tr>
		</table>
	</td>
	<td>&nbsp;</td>
	<td colspan="3" class="bold" id="keydesc2">
	<table border='0' cellspacing='0' cellpadding='0' class='formManual'>
			<tr>
				<td width='29%'>Name</td>
				<td width='6%'>:</td>
				<td width='65%'><?php echo $name2;?></td>
			</tr>
			<tr>
				<td width='29%'>Designation</td>
				<td width='6%'>:</td>
				<td width='65%'><?php echo $Badge_Designation2;?></td>
			</tr>
			<tr>
				<td>Photo</td>
				<td>:</td>
				<td><img src="images/badges/<?php echo $exhibitor_code."/".$Badge_Photo2;?>" width="100" height="100" /></td>
			</tr>
		</table>
	</td>
   </tr>    
   </table>
  
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <td colspan="7" class="bold"><h2>Upload Safe Location Layout</h2></td>
    </tr>
    <tr>
      <td colspan="7" >Please upload the safe location layout and accepted file formats are - JPG, JPEG and GIF and its size upto 2MB</td>
    </tr>
	<?php 
	$query=$conn ->query("select gstin,utr_no,iagree,Location_Layout,Layout_Approve,Layout_Reason from iijs_safe_rental where Safe_Rental_ID='".$_REQUEST['Safe_Rental_ID']."'");
	$result = $query->fetch_assoc();
	$Location_Layout=$result['Location_Layout'];
	$Layout_Approve=$result['Layout_Approve'];
	$Layout_Reason=$result['Layout_Reason'];
	$gstin=$result['gstin'];
	$utr_no=$result['utr_no'];
	$iagree=$result['iagree'];
	?>
	<tr>
	<?php if($Layout_Approve=="N" || $Location_Layout==""){?>
	<td colspan="3" class="bold"><input type="file" name="Location_Layout" id="Location_Layout" class="textField" value="Browse..."/></td>
	<?php }?>
		  <td>&nbsp;</td>
		 <!-- <td colspan="3" class="bold">Information Approval</td>-->
	</tr>
	<tr>
		<td colspan="3" rowspan="2" class="bold">
		<?php if($Location_Layout!=""){?><img src="<?php echo $create_dir."/".$Location_Layout;?>" width="100" height="100" /><?php } else {?>
		<img src="images/user_pic.jpg" />
		<?php }?>
		</td>
		<td>&nbsp;</td>
		<td class="bold">Status :</td>
		<td>
		<?php  
			if($Layout_Approve=="Y")
			echo "<img src='images/correct.png'  alt='' />";
			else if($Layout_Approve=="N")
			echo "<img src='images/red_cross.png'  alt='' />";
			else if($Layout_Approve=="P")
			echo "<img src='images/pending.png'  alt='' />";		
		?>
		</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" class="bold">Reason (If Rejected) : 
        <textarea name="textarea" class="textArea" disabled="disabled"><?php echo $Layout_Reason;?></textarea>
    </td>
      </tr>
  </table>
</div>

<div class="title"><h4>Payment Details:</h4></div>
<div class="clear"></div>

  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <?php 
   $Payment_Master_ID = $_REQUEST['Payment_Master_ID'];
   $Payment_Mode_ID = getPaymentModeId($_REQUEST['Payment_Master_ID'],$conn);
   $query=$conn ->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
   $result = $query->fetch_assoc();
   $Payment_Master_Approved=$result['Payment_Master_Approved'];
   $Payment_Master_Reason=$result['Payment_Master_Reason'];
   ?>
    
     <tr>
      <td width="143" class="bold"><sup>*</sup> Payment Mode</td>
      <td width="44">:</td>
      <td width="478" colspan="3"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?>  />NEFT/RTGS
	  <?php /*?><input type="hidden" name="grand_tot" id="grand_tot" value="<?php echo $grand_tot?>"/><?php */?>
	  </td>
	  <td width="143" class="bold"><sup>*</sup> GSTIN NO.</td>
      <td width="44">:</td>
      <td width="478" colspan="3">
	  <input type="text"name="gstin" id="gstin" value="<?php echo $gstin;?>" minlength="15" maxlength="15" autocomplete="off" required/></td>
    </tr>
	<tr>	
	
	
	<tr>	
	<td width="143" class="bold" colspan="3"><sup>*</sup><input type="checkbox" name="iagree" id="iagree" value="Y" <?php if($iagree=='Y'){?> checked="checked"<?php }?> /> I have read and understood the terms and conditions as mentioned.
	<?php
	$filename = "../manual_signature/images/safe/".$_SESSION['EXHIBITOR_CODE'].".pdf";
	if(file_exists($filename)) { $safePdf = $filename; } else { $safePdf = "#"; } 
	?>
	<a href="<?php echo $safePdf;?>" <?php if(file_exists($filename)){ ?>target="_blank" <?php } ?> class="myiagree"><strong>Terms & Condition </strong></a>
	</td>	
      <td width="0"></td>	
      <td width="0" colspan=""></td>
    </tr>
    
    <tr>
    	<td colspan="8" > 1. Payment must be made within three working days from placing the order, failing will result in cancellation of order, <br/> 	
        2. Kindly note No Cheque and Demand Draft will be accepted. Payments will be accepted only via NEFT <br/>	
        3. TDS should not be deducted of Safe Amount.<br />	
		4. Payment Details:<br />	
			Company Name : Godrej & Boyce Mfg. Co. Ltd<br />	
			Name of the Bank : CITIBANK<br />	
			Branch Address : D. N. Road, Fort, Mumbai 400001<br />	
			MICR code : 400037002<br />	
			Type of Account with code (10/11/13) : Current Account 11<br />	
			Account Number : 0003708748<br />	
			NEFT IFSC Code (11 digit) : CITI0100000<br />	
			Call Centre No. : 1800-103-4353 Missed Call No: +91 7208048100<br />	
		 	Telephone No: 022 66515603/04<br />     
		</td>
      </tr>
 
  </table>
  
<?php 
if(isset($_REQUEST['orderno'])){
$Safe_Rental_ID = $_REQUEST['Safe_Rental_ID'];
$query=$conn->query("select * from iijs_safe_rental where Safe_Rental_ID='$Safe_Rental_ID'");
$result_i= $query->fetch_assoc();
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
<?php }?>
<table>
	<tr>
		<td width="200" class="bold"><sup>*</sup> UTR NO / Payment details.</td>	
      <td width="44">:</td>	
      <td width="478" colspan="">	
	  <input type="text"name="utr_no" id="utr_no" value="<?php echo $utr_no;?>" autocomplete="off" /> </td>
    </tr>
	</tr>
</table>
    <div align="center">
	<?php if($_REQUEST['orderno']!=""){ ?>
      <a href="print_acknowledge/safe_rental_or_indemnity_bond_form.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Safe_Rental_ID=<?php echo $_REQUEST['Safe_Rental_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>&Badge_Item_ID1=<?php echo $Badge_Item_ID1;?>&Badge_Item_ID2=<?php echo $Badge_Item_ID2;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	<?php } else { if($current_time <= strtotime($formDeadLine)) { ?>
	<input name="save" id="save" type="submit" value="Save" class="maroon_btn" /> 
	<?php } } ?>
	  <input type="hidden" name="Safe_Rental_ID" id="Safe_Rental_ID" value="<?php echo $_REQUEST['Safe_Rental_ID'];?>"/>
	  <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
      <?php if($_REQUEST['auth']=="admin" || $_SESSION['ACCESS']=="ADMIN" && $current_time >= $formDeadLine ){ ?>
	  <input name="save" id="save" type="submit" value="Save" class="maroon_btn" /> <?php }  ?>
	  <?php if($Layout_Approve=="N" || $result['Payment_Master_Approved']=="N"){ ?>
      <input name="update" id="update" type="submit" value="Update" class="maroon_btn"/>
	  <?php } ?>
      </div>
</form>
<?php } ?>
</div>

<div class="clear">	</div>
</div>
</div>
<div class="footer_wrap">
<?php include ('footer.php'); ?>
</div>
<!--footer ends-->
</body>
</html>