<?php session_start();ob_start(); ?>
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
$sql="select * from iijs_strongroom where Exhibitor_Code='$exhibitor_code'";
$result=$conn ->query($sql);
$rows=$result->fetch_assoc();
$num_rows=$result->num_rows;
$StrongRoom_ID=$rows['StrongRoom_ID'];
$StrongRoom_Taken=$rows['StrongRoom_Taken'];
$keyperson1=$rows['keyperson1'];
$keyperson2=$rows['keyperson2'];
$Items_Approved=$rows['Items_Approved'];
$Items_Reason=$rows['Items_Reason'];
$Application_Complete=$rows['Application_Complete'];
$Create_Date=$rows['Create_Date'];

$Badge_ID=getBadgeID($exhibitor_code,$conn);
?>
<?php 
$save=$_REQUEST['save'];
if($save=="Save")
{
$Exhibitor_Code=$_POST['Exhibitor_Code'];
$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
$Info_Approved=$_POST['Info_Approved'];
$Safe_Rental_ID=$_POST['Safe_Rental_ID'];
$Payment_Master_ID=$_POST['Payment_Master_ID'];
$Layout_Approve=$_POST['Layout_Approve'];
$Payment_Master_Approved=$_POST['Payment_Master_Approved'];
	 $Badge_Item_ID1=$_POST['keyperson1'];
	 $Badge_Item_ID2=$_POST['keyperson2'];	
	
	$conn ->query("update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$Badge_Item_ID1' and Exhibitor_Code='$Exhibitor_Code'");
	$conn ->query("update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$Badge_Item_ID2' and Exhibitor_Code='$Exhibitor_Code'");
	$conn ->query("update iijs_badge_items set Badge_IsKeyPerson='0' where Exhibitor_Code='$Exhibitor_Code' and Badge_Item_ID NOT IN('$Badge_Item_ID1','$Badge_Item_ID2')");
	
	//$Location_Layout = $exhibitor_code.'_'.$_FILES['Location_Layout']['name'];
	$create_dir = "../images/Location_Layout/".$Exhibitor_Code; 
	if (!file_exists($create_dir)) { 
		mkdir($create_dir, 0777);
	} 
	if($_FILES['Location_Layout']['name']!=""){
	
	$Location_Layout=$Exhibitor_Code.'_'.$_FILES['Location_Layout']["name"];
	$target_path=$create_dir."/".$Location_Layout;
	
	$tmp = $_FILES['Location_Layout']['tmp_name'];
	
/*	echo $tmp;echo "<br/>";
	echo $target_path;*/
	if(move_uploaded_file($tmp,$target_path ))
	{
		echo "yes";
	}
	else
	{
		echo "No";
	}
}

	//exit;
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

	if($Layout_Approve=="Y")
	{
		$Layout_Approve_msg="Approved";
	}
	else if($Layout_Approve=="N")
	{
		$Layout_Approve_msg="Disapproved";
	}
	else
	{
		$Layout_Approve_msg="Pending";
	}


	if($_POST['Layout_Approve']=="N"){
		$Layout_Reason=$_POST['Layout_Reason'];
	}
	else
	{
		$Layout_Reason="";
	}

	if($_POST['Info_Approved']=="N"){
		$Info_Reason=$_POST['Info_Reason'];
	}
	else
	{
		$Info_Reason="";
	}


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

	if($Info_Approved=='Y' && $Payment_Master_Approved=='Y' && $Layout_Approve=="Y")
	{
		$Application_Complete='Y';
	}
	else if($Info_Approved=='' || $Payment_Master_Approved=='' || $Layout_Approve=="")
	{
		$Application_Complete='P';
	}
	else
	{
		$Application_Complete='N';
	}
	if($Payment_Master_Approved == '' || $Payment_Master_Approved == null ){
		$Payment_Master_Approved = 'P';
	}
	$gstin=$_POST['gstin'];
	$utr_no=$_POST['utr_no'];

$payment = $conn->query("update iijs_payment_master set Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Approved='$Payment_Master_Approved',Payment_Master_Reason='$Payment_Master_Reason' where  Payment_Master_ID='$Payment_Master_ID' and Form_ID='5A'");

$sql="update iijs_safe_rental set gstin='$gstin',utr_no='$utr_no',Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Layout_Approve='$Layout_Approve',Layout_Reason='$Layout_Reason',Application_Complete='$Application_Complete'";
if($Location_Layout!=""){
	$sql.=" ,Location_Layout='$Location_Layout'";
}
$sql.= " where Safe_Rental_ID='$Safe_Rental_ID'";

$safe = $conn ->query($sql);

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
		<p>Your details for the Online Application for <strong>Safe Rental </strong> has been updated by IIJS Admin.</p>
				
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
		  
		  <tr style="height:20px; border:1px solid  #FF0000;">
			<td style="border:1px solid  #cccccc; padding:5px;" >Layout</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Layout_Approve_msg.'</td>
			<td style="border:1px solid  #cccccc; padding:5px;">'.$Layout_Reason.'</td>
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
		$subject = "".$event." Exhibitor Manual -  SAFE RENTAL";	
		$headers  = 'MIME-Version: 1.0' . "\n";	
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		$headers .= 'From:admin@gjepc.org';	
		@mail($to, $subject, $message, $headers);
		header('location:Form9A.php?Exhibitor_Code='.$Exhibitor_Code);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Safe Rental</title>
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
function check_disable(){
    if ($('input[name=\'Stall_Image_Layout_Type[]\']:checked').val() == "Custom"){
        $("#custom_lay").show();
    }
    else{
        $("#custom_lay").hide();
    }	
}
</script>
<script src="js/saferental.js"></script>

<script type="text/javascript">
function validation()
{
	if($('input[name=\'Info_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Info_Reason').value=="")
		{
			alert("Please Enter Item Disapprove Reason");
			document.getElementById('Info_Reason').focus();
			return false;
		}
	}
	
	if($('input[name=\'Layout_Approve\']:checked').val() == "N")
	{
		if(document.getElementById('Layout_Reason').value=="")
		{
			alert("Please Enter Layout Disapprove Reason");
			document.getElementById('Layout_Reason').focus();
			return false;
		}
	}
	
	if($('input[name=\'Payment_Master_Approved\']:checked').val() == "N")
	{
		if(document.getElementById('Payment_Master_Reason').value=="")
		{
			alert("Please Enter Payment Disapprove Reason");
			document.getElementById('Payment_Master_Reason').focus();
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
	<div class="breadcome"><a href="manage_safe_rental.php?action=view">Home</a> > Safe Rental / Indemnity Bond Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Safe Rental / Indemnity Bond Form
		
		<a href="../images/pdf/Safe_Rental_Indemnity_Bond_IIJS_Premiere_2022.pdf" target="_blank" style="color:#F00;"><strong>AFFIDAVIT CUM INDEMNITY BOND</strong></a>
		</div>
     	<div class="content_details22">
        <div id="formWrapper">

<!--<a href="Form9A.php?Exhibitor_Code=<?php echo $exhibitor_code;?>&action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />-->
<h2>Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
<th valign="top"><span class="table_head" style="width: 58px; height: 13px">Sr. No</span></th>
<th valign="top"><span class="table_head" style="width: 78px; height: 13px">Date</span></th>
<th valign="top" >
<div align="center">
<span class="table_head" style="width: 120px; height: 13px;"> Item Status</span>
</div></th>
<th valign="top" >
<div align="center"><span class="table_head" style="width: 120px; height: 13px;"> Layout Status</span></div></th>
<th valign="top" class="centerAlign">
<div align="center"><span class="table_head" style="width: 120px; height: 13px"> Payment Status</span></div></th>
<th valign="top" class="centerAlign">
<div align="center"><span class="table_head" style="height: 13px"> Application Status</span></div></th>
<?php if($_SESSION['admin_role']=='Super Admin') { ?>
<th valign="top" class="centerAlign">
<div align="center"><span class="table_head" style="height: 13px"> Delete Order</span></div></th>
<?php } ?>
</tr>
                                  	
<?php 
$query=$conn ->query("SELECT a.*,b.* FROM `iijs_safe_rental` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='5A' order by b.Payment_Master_ID asc");
$order_num=$query->num_rows;
$i=1;
while($result=$query->fetch_assoc()){
?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="Form9A.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Safe_Rental_ID=<?php echo $result['Safe_Rental_ID'];?>&Exhibitor_Code=<?php echo $exhibitor_code;?>&orderno=<?php echo $i;?>" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
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
			if($result['Layout_Approve']=='Y')
			echo "<img src='../images/correct.png'  alt='' />";
			else if($result['Layout_Approve']=='N')
			echo "<img src='../images/red_cross.png'  alt='' />";
			else
			echo "<img src='../images/pending.png'  alt='' />";		
		?>
		
        </td>
		
		 <td valign="middle" colspan="1" class="centerAlign">
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
        <?php if($_SESSION['admin_role']=='Super Admin') { ?>
		<td valign="middle" colspan="1" class="centerAlign">
		<img src='../images/red_cross.png'  alt='' class="deleteOrder <?php echo $result['Payment_Master_ID']?> <?php echo $result['Safe_Rental_ID']?> <?php echo $result['Exhibitor_Code']?>" style="cursor:pointer;" />
        </td>
        <?php } ?>
        </tr>
    <?php $i++;}?>     
    </tbody>
</table>

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
<div class="title">
        <h4>DIMENSIONS OF SAFES (mm)</h4>
      </div>
<div class="clear"></div>

<table border="0" cellpadding="0" cellspacing="0" class="formManual" > 
    <tr>
    <th width="48" class="bold borderRight"><div align="center">Sr. No.</div></th>
    <th width="112" class="bold borderRight"><div align="center">Item Desc</div></th>
    <th colspan="3" class="bold borderRight"><div align="center">Outside</div></th>
    <th colspan="3" class="bold borderRight"><div align="center">Inside</div></th>
    <th width="66" class="bold borderRight"><div align="center">Adj. Shelves</div></th>
    <th width="101" class="bold borderRight"> <div align="center">Drawers / Lockers</div></th>
    <th width="78" class="bold borderRight"><div align="center">Cap (Cubic Mtr.)</div></th>
  </tr>
 

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
  $query=$conn ->query("select * from iijs_safe_rental_master");
  while($result=$query->fetch_assoc()){
  
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

<div class="title"><h4>IMPORTANT</h4></div>

<div class="clear"></div>


<p>All safes will be supplied with wooden pedestal of height approx 100mm Safes must be installed on this pedestal only.</p>
<p>Please consider this extra height of 100mm while designing your stall layout charges mentioned above include 12.5% Lease Tax</p>
<p>Form for rental of safes( For Indian Exhibitors) - Lease charges (INR)</p>
<form  id="item_selection" name="item_selection" method="post" onSubmit="return validate()" enctype="multipart/form-data">
<table border="0" cellspacing="0" cellpadding="0" class="formManual" id="abc">
   <tr>
		<th class="bold">Item Description</th>
		<th class="bold">Up To <br />31/12/2016</th>
		<!-- <th class="bold">Up To <br />07/01/2016</th>
		<th class="bold">Up To <br />14/01/2016</th> -->
		<th class="bold">Avail Qty</th>
		<th class="bold">Qty.</th>
		<th class="bold">&nbsp;</th>
    </tr>
    <tr>
      <td>
      <input type="hidden" name="xyz" value=""/>
	  <input type="hidden" name="exhibitor_code" id="exhibitor_code" value="<?php echo $exhibitor_code;?>"/>
	  <input type="hidden" name="Safe_Rental_ID" id="Safe_Rental_ID" value="<?php echo $_REQUEST['Safe_Rental_ID'];?>"/>
	  <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	  <input type="hidden" name="Exhibitor_Country_ID" id="Exhibitor_Country_ID" value="<?php echo $Exhibitor_Country_ID;?>"/>
	  
      <select class="textField" id="Safe_ID" name="Safe_ID" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"<?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
        $query=$conn ->query("SELECT * from iijs_safe_rental_master");
        while($result=$query->fetch_assoc()){?>
        <option value="<?php echo $result['Safe_ID'];?>"><?php echo $result['Safe_Description'];?></option>
        <?php } ?>
       </select>  
       </td>
      <td id="deadline_1">0</td>
      <!-- <td id="deadline_2">0</td>
	  <td id="deadline_3">0</td> -->
      <td id="avail_qty">0</td>
	  <td>
	  <input type="hidden" name="exhibitor_code" id="exhibitor_code"  value="<?php echo $exhibitor_code;?>" />
	  <input type="text" name="Item_Quantity" id="Item_Quantity" class="qty" <?php if(!isset($_REQUEST['orderno'])){?> disabled="disabled"<?php }?> />
	  </td>
	  <?php if($_SESSION['admin_role']=='Super Admin'){?>
      <td><span class="bold">
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if(!isset($_REQUEST['orderno'])){?> disabled="disabled" style="background:#dddddd;"<?php }?>/>
      </span></td>
	  <?php }?>
      </tr>
  </table>
</form>
  
<div class="title">
<h4>Applied Items</h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">

    <tr>
      <td  class="bold">Items Applied </td>
      <td class="bold"><span>Amount</span></td>
      <td class="bold">Rate</td>
      <td class="bold">Quantity</td>
      <td class="bold">Action</td>
    </tr>
    <tbody id="Applied_Items">
    <?php 
	if(isset($_REQUEST['Safe_Rental_ID']) && $_REQUEST['Safe_Rental_ID']!="")
	{
		$Safe_Rental_ID=$_REQUEST['Safe_Rental_ID'];
		$query=$conn ->query("select * from iijs_safe_rental_items where Safe_Rental_ID='$Safe_Rental_ID'");
	}
	
	$grand_tot=0;
	
	while($result=$query->fetch_assoc()){  
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	$grand_tot=$grand_tot+$tot;
	?>
    <tr>
      <td><?php echo getSaferentalId($result['Safe_ID'],$conn);?></td>
	  <td><?php echo $tot;?></td>
      <td><?php echo $result['Item_Rate']?></td>
      <td><?php echo $result['Item_Quantity'];?></td>
	  <?php if($_SESSION['admin_role']=='Super Admin'){?>
      <td><img src="../images/red_cross.png" class="deleteItem <?php echo $result['Safe_Rental_Items_ID'];?> <?php echo $exhibitor_code;?> <?php echo $_REQUEST['Payment_Master_ID'];?> <?php echo $result['Safe_ID'];?> <?php echo $result['Safe_Rental_ID'];?>" style="cursor:pointer;" /></td>   
	  <?php }?>
   </tr>
   <?php }?>
  </tbody> 
</table>

 
<form method="post" enctype="multipart/form-data" onsubmit="return validation()">
<?php 
$Safe_Rental_ID=$_REQUEST['Safe_Rental_ID'];
$query=$conn ->query("select * from iijs_safe_rental where Safe_Rental_ID='$Safe_Rental_ID'");
$result=$query->fetch_assoc();
$Info_Approved=$result['Info_Approved'];
$Info_Reason=$result['Info_Reason'];
$Layout_Approve=$result['Layout_Approve'];
$Layout_Reason=$result['Layout_Reason'];
$Location_Layout =$result['Location_Layout'];
$gstin=$result['gstin'];
$utr_no=$result['utr_no'];
?>
<div class="clear"></div>
<div class="title"><h4>Item Approval</h4></div>
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

<?php
$i=1; 
$query1=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M' || `Badge_Type`='R') AND Badge_IsKeyPerson='1'");
while($result1=$query1->fetch_assoc())
{
		if($i==1){$Badge_Item_ID1=$result1['Badge_Item_ID'];}
		if($i==2){$Badge_Item_ID2=$result1['Badge_Item_ID'];}
		$i++;
} 

?>
<p><strong>Please print this form and attached it with the "AFFIDAVIT CUM INDEMNITY BOND" printed on Rs.200/- stamp paper.</strong></p>
<div class="title">
<h4>Key Persons</h4>
</div>
<div class="clear">

  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <td width="14%" class="bold"><sup>* </sup>Key Person</td>
      <td width="3%">:</td>
      <td width="29%"> 
	  <select name="keyperson1" id="keyperson1" class="textField" <?php if($order_num>0){?> <?php }?>>
        <option selected="selected" value="">--Select--</option>
        <?php $sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M' || `Badge_Type`='R')";
		$result=$conn ->query($sql);
		while($rows=$result->fetch_assoc())
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
	  <select name="keyperson2" id="keyperson2" class="textField" <?php if($order_num>0){?> <?php }?>>
        <option selected="selected" value="">--Select--</option>
        <?php 
		echo $Badge_Item_ID2."===";
		$sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M' || `Badge_Type`='R')";
		$result=$conn ->query($sql);
		while($rows=$result->fetch_assoc())
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
		$result=$sql->fetch_assoc();
		$name1=$result['Badge_Name'];
		$Badge_Designation1=$result['Badge_Designation'];
		$Badge_Photo1=$result['Badge_Photo'];
		$sql=$conn ->query("SELECT * FROM `iijs_badge_items` WHERE `Badge_Item_ID`='$Badge_Item_ID2'");
		$result=$sql->fetch_assoc();
		$name2=$result['Badge_Name'];
		$Badge_Designation2=$result['Badge_Designation'];
		$Badge_Photo2=$result['Badge_Photo'];
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
				<td><img src="../images/badges/<?php echo $exhibitor_code."/".$Badge_Photo1;?>" width="100" height="100"/></td>
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
				<td><img src="../images/badges/<?php echo $exhibitor_code."/".$Badge_Photo2;?>" width="100" height="100" /></td>
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
	
	<tr>
		<td colspan="3" class="bold">
		<?php if($Location_Layout!=""){?> 
		<a href="../images/Location_Layout/<?php echo $exhibitor_code ."/".$Location_Layout;?>" target="_blank">
		<img src="../images/Location_Layout/<?php echo $exhibitor_code."/".$Location_Layout;?>" width="100" height="100" /></a>
		<?php } else {?>
		<img src="../images/user_pic.jpg" />
		<?php }?>
        <br /><br />
<input type="file" name="Location_Layout" id="Location_Layout" class="textField" value="Browse..."/>
		</td>
		<td><div class="bottomSpace">
        <strong>Layout Approval</strong>
        </div>
        <div class="bottomSpace">
	   <div class="leftStatus">
       <span><input name="Layout_Approve" id="Layout_Approve" type="radio" value="Y" <?php if($Layout_Approve=='Y'){ echo "checked='checked'";}?> /></span> Approved</div>
       
       <div class="leftStatus">
       <span><input name="Layout_Approve" id="Layout_Approve" type="radio" value="N" <?php if($Layout_Approve=='N'){ echo "checked='checked'"; }?> /></span> Disapproved</div>
       <div class="clear"></div>
       <textarea name="Layout_Reason" id="Layout_Reason" class="newTextArea"><?php echo $Layout_Reason;?></textarea>
</div></td>
	</tr>
     
  </table>
</div>
<div class="clear"></div>

  <table border="0" cellspacing="0" cellpadding="0" class="formManual">  
	<tr>
      <td width="143"  class="bold">GSTIN NO.</td>
      <td width="44">:</td>
      <td width="478" colspan="3"><input type="text"name="gstin" id="gstin" value="<?php echo $gstin;?>" />
	  </td>
	  <td width="143"  class="bold"><sup>*</sup> UTR NO / Payment details.</td>
      <td width="44">:</td>
      <td width="478" colspan="3">
	  <input type="text"name="utr_no" id="utr_no" value="<?php echo $utr_no;?>" />
    </tr>
   <?php $Payment_Master_ID=getPaymentModeId($_REQUEST['Payment_Master_ID'],$conn);?>    
     <tr>
      <td width="143"  class="bold"><sup>*</sup> Payment Mode</td>
      <td width="44">:</td>
      <td width="478" colspan="3"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Master_ID==4){?> checked="checked"<?php }?>  />NEFT
	  </td>
    </tr>    
    <tr>
    	<td colspan="5" > 1. Payment must be made within three working days from placing the order, failing will result in cancellation of order,   	      
		</td>
    </tr>
 
  </table>
  
 <?php 
$Payment_Master_ID=$_REQUEST['Payment_Master_ID'];
$query=$conn ->query("select Payment_Master_Approved,Payment_Master_Reason from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
$result=$query->fetch_assoc();
$Payment_Master_Approved=$result['Payment_Master_Approved'];
$Payment_Master_Reason=$result['Payment_Master_Reason'];
?> 
  
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
	
      <a href="print_acknowledge/safe_rental_or_indemnity_bond_form.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Safe_Rental_ID=<?php echo $_REQUEST['Safe_Rental_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>&Badge_Item_ID1=<?php echo $Badge_Item_ID1;?>&Badge_Item_ID2=<?php echo $Badge_Item_ID2;?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	  
	 <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	 <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	 <input type="hidden" name="Safe_Rental_ID" id="Safe_Rental_ID" value="<?php echo $_REQUEST['Safe_Rental_ID'];?>" />
	 <input type="hidden" name="save" id="save" value="Save"/>
      <input name="input2" type="submit" value="Submit" class="maroon_btn" <?php if(!isset($_REQUEST['orderno'])){?> disabled="disabled"style="background:#dddddd;"<?php }?> />
      </div>
</form>
</div>
		</div>
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
