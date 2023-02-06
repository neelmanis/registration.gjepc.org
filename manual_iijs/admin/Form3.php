<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$event = getEventDescription($conn);
$exhibitor_code=filter($_REQUEST['Exhibitor_Code']);

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

if($Exhibitor_Section=="Allied" || $Exhibitor_Section=="International Loose" || $Exhibitor_Section=="International Jewellery")
{
	$Exhibitor_Section="Loose Stones";
} 

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
$Vendor_ID=getVenderId($Exhibitor_Section,$conn);
?>


<?php 
$save=$_REQUEST['save'];
if($save=="Save")
{
$Exhibitor_Code=$_POST['Exhibitor_Code'];
$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
$Info_Approved=$_POST['Info_Approved'];
$Stand_ID=$_POST['Stand_ID'];
$Payment_Master_ID=$_POST['Payment_Master_ID'];
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

$conn->query("update iijs_payment_master set Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Approved='$Payment_Master_Approved',Payment_Master_Reason='$Payment_Master_Reason' where  Payment_Master_ID='$Payment_Master_ID' and Form_ID='3'");

$conn->query("update iijs_stand set Info_Approved='$Info_Approved',Info_Reason='$Info_Reason',Application_Complete='$Application_Complete' where Stand_ID='$Stand_ID'");


/*...............................Exhibitor Information.......................................*/
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
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
		<p>Your details for the Online Application for  <strong>Form No. 3. Standfitting Services</strong> has been updated by Signature Admin.</p>
		<p>Kindly login at our website - iijs-signature.org to verify the same.</p>
		
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
		//$to = 'rohit@kwebmaker.com';
		$subject = "".$event." Exhibitor Manual - Form No. 3. STANDFITTING SERVICES";
		$headers  = 'MIME-Version: 1.0' . "\n";	
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		$headers .= 'From:admin@gjepc.org';	
		@mail($to, $subject, $message, $headers);
		header('location:manage_stadfitting.php?action=view');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manual || Standfitting Services||</title>

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
<script src="js/standfitting.js"></script>
<script>
</script>
</head>
<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="manage_stadfitting.php?action=view">Home</a> > Standfitting Services</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Standfitting Services</div>
 
<div class="content_details22">
<div id="formWrapper">
<?php if($_SESSION['admin_role']!='Vendor'){?>
	<a href="add_new_standfitting.php?Exhibitor_Code=<?php echo $exhibitor_code;?>&action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<?php }?>
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
        <div align="center">Payment Status</div></th>
        <th valign="top" class="centerAlign">
        <div align="center">Application Status</div></th>
        <?php if($_SESSION['admin_role']=='Super Admin') {?>
		<th valign="top" class="centerAlign">
        <div align="center">Delete Order</div></th>
        <?php }?>
        </tr>
    <?php
	$query=$conn->query("SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='3' order by b.Payment_Master_ID asc");
	$order_num=$query->num_rows;
	$i=1;
	while($result=$query->fetch_assoc()){
	?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="Form3.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Stand_ID=<?php echo $result['Stand_ID'];?>&orderno=<?php echo $result['Payment_Master_OrderNo'];?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
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
		<?php if($_SESSION['admin_role']=='Super Admin') { ?>
		<td  class="centerAlign">
			<img src='../images/red_cross.png'  alt='' class="deleteOrder <?php echo $result['Payment_Master_ID']?> <?php echo $result['Stand_ID']?> <?php echo $result['Exhibitor_Code']?>" style="cursor:pointer;" />
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
    <td><?php echo $fetch_data['Exhibitor_Section']; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>


<div class="title"><h4>Basic Furniture</h4></div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual tableBorder">  
  <?php 
	if($Exhibitor_Section=='signature_club')
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE 1 and `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area' and `ex_stall_type`='$Exhibitor_StallType'";
	}else
	{
	$sql1="SELECT * FROM `iijs_stall_basic_furniture` WHERE 1 and `ex_section`='$Exhibitor_Section' and `ex_area`='$Exhibitor_Area'";	
	}
  	$result1=$conn->query($sql1);
	$rows1=$result1->fetch_assoc();
  
  ?>
  
<?php
if($Exhibitor_Section=='signature_club')
{
?>
  <tr>
    <th colspan="10" class="bold" align="center" style="text-align:center;"><strong><?php echo $Exhibitor_Section; ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="10%">Table</td>
    <td class="bold" width="10%">Chair</td>
    <td class="bold" width="10%">Normal Display ( Module A)</td>
    <td class="bold" width="10%">Multi display (Module B)</td>
    <td class="bold" width="10%">Inside Display (Module C)</td>
    <td class="bold" width="10%">L Display (Module D)</td>
    <td class="bold" width="10%">Tray Storage </td>
    <td class="bold" width="10%">9 W LED For General Lighting- in movable fixture</td>
    <td class="bold" width="10%">Dustbin</td>
    <td class="bold" width="10%">Plug Point 5/15 amp</td>    
  </tr>
  <tr>
    <td><?php echo $rows1['no_of_table'];?></td>
    <td><?php echo $rows1['chair'];?></td>
    <td><?php echo $rows1['a_display'];?></td>
    <td><?php echo $rows1['b_display'];?></td>
    <td><?php echo $rows1['c_display'];?></td>
    <td><?php echo $rows1['l_window'];?></td>
    <td><?php echo $rows1['open_tray'];?></td>
    <td><?php echo $rows1['cfl'];?></td>
    <td><?php echo $rows1['dustbin'];?></td>
    <td><?php echo $rows1['plug_point'];?></td>
   
  </tr>
    <?php
	}
	else if($Exhibitor_Section=='loose_stones')
	{
	?>
  <tr>
    <th colspan="8" class="bold" align="center" style="text-align:center;"><strong><?php echo $Exhibitor_Section; ?> - <?php echo $Exhibitor_Area; ?>sqmt (<?php echo $Exhibitor_StallType;?>)</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Top Glass Showcase with LED Strip, 2 LED Spot & lockable storage (Yellow/White)</td>
    <td class="bold" width="14%">Table (All side Open)</td>
    <td class="bold" width="14%">Chairs</td>
    <td class="bold" width="14%">23 W CFL's (Spiral) for General Lighting White/Yellow in movable Fixture </td>
    <td class="bold" width="14%">Dustbin </td>
    <td class="bold" width="14%">Plug Point 15AMP</td>
  </tr>
  <tr>
 	 <td><?php echo $rows1['top_glass_showcase'];?></td>
    <td><?php echo $rows1['no_of_table'];?></td>
     <td><?php echo $rows1['chair'];?></td>
    <td><?php echo $rows1['cfl'];?></td>
    <td><?php echo $rows1['dustbin'];?></td>
    <td><?php echo $rows1['plug_point'];?></td>
  </tr>
    <?php 	
	}  
    else
	{
	?>
  <tr>
    <th colspan="8" class="bold" align="center" style="text-align:center;"><strong><?php echo $Exhibitor_Section; ?> - <?php echo $Exhibitor_Area; ?>sqmt</strong></th>
  </tr>
  <tr>
    <td class="bold" width="14%">Top Glass Showcase with LED Strip, 2 LED Spot & lockable storage (Yellow/White)</td>
    <td class="bold" width="14%">Tall Glass Showcase with LED Strip, 6 LED Spot & lockable storage (Yellow/White)</td>
    <td class="bold" width="14%">Table (All side Open)</td>
    <td class="bold" width="14%">Chairs</td>
    <td class="bold" width="14%">23 W CFL's (Spiral) for General Lighting White/Yellow in movable Fixture </td>
    <td class="bold" width="14%">Dustbin </td>
    <td class="bold" width="14%">Plug Point 15AMP</td>
  </tr>
  <tr>
  <td><?php echo $rows1['top_glass_showcase'];?></td>
   <td><?php echo $rows1['tall_showcase'];?></td>
    <td><?php echo $rows1['no_of_table'];?></td>
    <td><?php echo $rows1['chair'];?></td>
    <td><?php echo $rows1['cfl'];?></td>
    <td><?php echo $rows1['dustbin'];?></td>
    <td><?php echo $rows1['plug_point'];?></td>
  </tr>
    <?php 	
	}  
    ?>
 
</table>
<div class="title">
<h4>Items Selection</h4>
</div>
<div class="clear"></div>
<form  id="item_selection" name="item_selection" method="post" onSubmit="return validate()">
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
	  <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	  <input type="hidden" name="Stand_ID" id="Stand_ID" value="<?php echo $_REQUEST['Stand_ID'];?>"/>
      <select class="textField" id="Item_ID" name="Item_ID" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"<?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
	  /*
	    if($Exhibitor_Section=='signature_club')
		{
	  	$sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='SIGNATURE CLUB'";
		}
		else
		{
		$sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type!='SIGNATURE CLUB'";
		}
		*/
		if($Exhibitor_HallNo=="2" || $Exhibitor_HallNo=="4" || $Exhibitor_HallNo=="5" || $Exhibitor_HallNo=="")
		{
			$sql="SELECT * FROM iijs_stand_items_master where hall='All'";
		}
		else if($Exhibitor_HallNo=="3")
		{
			$sql="SELECT * FROM iijs_stand_items_master where hall='3'";
		}
		else
		{
			$sql="SELECT * FROM iijs_stand_items_master where hall='1'";
		}	 
        $query=$conn->query($sql);
        while($result=$query->fetch_assoc()){?>
        <option value="<?php echo $result['Item_ID'];?>"><?php echo $result['Item_Description'];?></option>
        <?php }?>
       </select>  
       </td>
      <td id="avail_qty">0</td>
      <td id="rate">0</td>
      <td>
      <input type="hidden" name="exhibitor_code" id="exhibitor_code"  value="<?php echo $exhibitor_code;?>" />
      <input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"<?php }?>  />
      </td>
      <?php if($_SESSION['admin_role']=='Super Admin'){?>
      <td><span class="bold">
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($_REQUEST['orderno']==""){?> disabled="disabled"style="background:#dddddd;"<?php }?>  />
      </span>
	  </td>
      <?php }?>
	  <span id='progress' style="display:none"><img src="../images/progress.gif"/></span>
      </tr>
  </table>  
</form>
<form method="post" onSubmit="return validate_reason()">

<div class="title">
<h4>Applied Items (Order No: <?php echo $_REQUEST['orderno'];?>)</h4>
</div>
<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">

    <tr>
      <td  class="bold">Items Applied </td>
      <td class="bold">Rate</td>
	  <td class="bold"><span>Amount</span></td>      
      <td class="bold">Quantity</td>
      <td class="bold">Action</td>
    </tr>
    <tbody id="Applied_Items">
    <?php 
	if(isset($_REQUEST['Stand_ID']) && $_REQUEST['Stand_ID']!="")
	{
		$Stand_ID=$_REQUEST['Stand_ID'];
		$query=$conn->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
	}
	while($result=$query->fetch_assoc()){  
	$tot=$result['Item_Rate']*$result['Item_Quantity'];
	?>
    <tr>
      <td><?php echo getItemDescription($result['Item_Master_ID'],$conn);?></td>
      <td><?php echo $result['Item_Rate']?></td>
	  <td><?php echo $tot;?></td>      
     <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" value="<?php echo $result['Item_Quantity'];?>" disabled="disabled"/></td>
      
      <td>
      <?php if($_SESSION['admin_role']=='Super Admin'){?>
	  <img src="images/delete.png" class="deleteItem <?php echo $result['Stand_Item_ID'];?> <?php echo $Stand_ID;?> <?php echo $_REQUEST['Payment_Master_ID'];?> <?php echo $result['Item_Master_ID'];?>" style="cursor:pointer;">
       <?php }?>
	  </td>
     
   </tr>
   
   <?php }?>
  </tbody> 
  </table>


<?php 
	$Payment_Master_ID=filter($_REQUEST['Payment_Master_ID']);
	$query=$conn->query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
	$result=$query->fetch_assoc();
	$Payment_Master_Approved=$result['Payment_Master_Approved'];
	$Payment_Master_Reason=$result['Payment_Master_Reason'];
	$tds_amount=$result['tds_amount'];
	$tds_tax=$result['tds_tax'];
	$net_payable_amount=$result['net_payable_amount'];
	$txn_status=$result['txn_status'];
	$tpsl_txn_time=date("d-m-Y", strtotime($result['tpsl_txn_time']));
?>

<div class="title"><h4>Payment </h4></div>
<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php 
if(isset($_REQUEST['Stand_ID']) && $_REQUEST['Stand_ID']!="")
{
	$Stand_ID=$_REQUEST['Stand_ID'];
	$query=$conn->query("select * from iijs_stand_items where Stand_ID='$Stand_ID'");
}
$tot=0;
while($result=$query->fetch_assoc())
{
	$tot=$tot+$result['Item_Rate']*$result['Item_Quantity'];
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
    <td class="bold">GST (18%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*18/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr>
    <td class="bold">Swachh Bharat Cess (0.50%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$tot*.50/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>-->
  <?php $she_cess_tax=$tot*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=round($tot+$service_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">TDS</td>
    <td>:</td>
    <td><?php echo $tds_tax;?>%</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td class="bold">TDS Amount</td>
    <td>:</td>
    <td><?php echo $tds_amount;?></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Net payable</td>
    <td>:</td>
    <td><?php echo $net_payable_amount;?></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
  
  
</table>
</div>
<?php 
$Stand_ID=filter($_REQUEST['Stand_ID']);
$query=$conn->query("select Info_Approved,Info_Reason from iijs_stand where Stand_ID='$Stand_ID'");
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
<?php 
$Payment_Master_ID=getPaymentModeId($_REQUEST['Payment_Master_ID'],$conn);
?>
<input type="hidden" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1"/>

    <div align="center">
     <?php 
	 $orderno=$_REQUEST['orderno'];
	 if($_REQUEST['orderno']!=""){?>
	 <a href="../print_acknowledge/standfitting.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Stand_ID=<?php echo $_REQUEST['Stand_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>&EXHIBITOR_CODE=<?php echo $exhibitor_code;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	 <?php }?>
	 <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	 <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	 <input type="hidden" name="Stand_ID" id="Stand_ID" value="<?php echo $Stand_ID;?>" />
	 <input type="hidden" name="save" id="save" value="Save"/>
     <?php if($_SESSION['admin_role']=='Super Admin'){ ?>
     <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($_REQUEST['orderno']==""){?> disabled="disabled" style="background:#dddddd;"<?php }?> />
     <?php } else if($_SESSION['admin_role']=='Admin' && $txn_status!='300'){ ?>
     <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($_REQUEST['orderno']==""){?> disabled="disabled" style="background:#dddddd;"<?php }?> />
     <?php } ?>
    </div>
	
	</form>
	
		</div>
	</div>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
