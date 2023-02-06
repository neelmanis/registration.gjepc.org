<?php session_start(); ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
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
	$query_cnt=$conn->query("SELECT * FROM `iijs_stand_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	$stand_cnt=$query_cnt->num_rows;
	if($stand_cnt==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Items in order');
		window.location.href='add_new_standfitting.php?Exhibitor_Code=$exhibitor_code&action=ADD';
		</script>"	;
		return;	
	}
	
	$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
	$Payment_Master_Amount=$_POST['Payment_Master_Amount'];	
	$Payment_Master_ServiceTax=$Payment_Master_Amount*18/100;
	$Payment_Master_EducationCess=$Payment_Master_ServiceTax*0/100;
	$she_cess_tax=$Payment_Master_ServiceTax*0/100;
	$Payment_Master_AmountPaid=round($Payment_Master_Amount+$Payment_Master_ServiceTax+$Payment_Master_EducationCess+$she_cess_tax);


	$Create_Date=date('Y-m-d h:i:s');
	/*..........................Payment Update..................................*/
	
	$qorder=$conn->query("select count(Payment_Master_ID) as count from  iijs_payment_master where Exhibitor_Code='$Exhibitor_Code'");
	$rorder=$qorder->num_rows;	
	$order_count=$rorder['count'];
	//$Payment_Master_OrderNo=$order_count+1;
	$strNo = rand(1,1000000);			
	$Payment_Master_OrderNo = 'STAND21'.$strNo;
			
	$conn->query("insert into iijs_payment_master set Form_ID='3',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Payment_Master_Approved='P',Create_Date='$Create_Date',Modify_Date='$Create_Date'");
	
	$Payment_Master_ID=$conn->insert_id;
	
	$conn->query("insert into iijs_stand set Info_Approved='Y',Application_Complete='Y',Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',orderId='$Payment_Master_OrderNo',Create_Date='$Create_Date'");
	
	//$conn->query("insert into iijs_stand set Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',Create_Date='$Create_Date'");
	$Stand_ID=$conn->insert_id;
	$query=$conn->query("SELECT * FROM `iijs_stand_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result=$query->fetch_assoc())
	{
	$id=$result['id'];
	$Item_Master_ID=$result['Item_Master_ID'];
	$Item_Rate=$result['Item_Rate'];
	$Item_Quantity=$result['Item_Quantity'];
	
	$conn->query("insert into iijs_stand_items set Stand_ID='$Stand_ID',Item_Master_ID='$Item_Master_ID',Item_Quantity='$Item_Quantity',Item_Rate='$Item_Rate',Create_Date='$Create_Date'");
	
	/*......................Get Stand Fitting Item Quantity...............................*/
	//echo "select Item_Quantity from iijs_vendor_item_master where Vendor_Iteam_Master_ID='$Item_Master_ID'";
	$qitem_quantity=$conn->query("select Item_Quantity from iijs_stand_items_master where Item_ID='$Item_Master_ID'");
	$ritem_quantity=$qitem_quantity->fetch_assoc();
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$Item_Quantity;
	$conn->query("update iijs_stand_items_master set Item_Quantity='$remain_quantity' where Item_ID='$Item_Master_ID'");
		
	$conn->query("delete from iijs_stand_items_tmp where id='$id'");
}

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
	<td align="left" height="60px"><img src="https://gjepc.org/assets/images/logo.png" border="0" width="230" /></td>
	<td align="right" height="60px"><img src="https://registration.gjepc.org/manual_signature/images/logo.png" width="120" border="0"/></td>
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
	<p>Thank  you for applying Online for <strong>Form No. 3. STANDFITTING SERVICES</strong>. Please note your  application is under approval process. </p>
	
	<p>A system generated notification will be sent to you on successful approval/Disapproval of your application</p>
	
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
		//$to ='neelmani@kwebmaker.com';
		$subject = "IIJS PREMIERE 2021 Exhibitor Manual - STANDFITTING SERVICES"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: IIJS PREMIERE 2021 <admin@gjepc.org>';
		@mail($to, $subject, $message, $headers);
		header('location:Form3.php?Exhibitor_Code='.$Exhibitor_Code);
}
?>
<?php 
$action=$_REQUEST['action'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=="ADD")
{
	//echo $query="delete from iijs_stand_items_tmp where EXHIBITOR_CODE='$exhibitor_code'";
	//$conn->query("delete from iijs_stand_items_tmp where EXHIBITOR_CODE='$exhibitor_code'");

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
<script type="text/javascript">
function validate()
{
	//alert(11);
	Payment_Mode_ID=$("input[type='radio'][name='Payment_Mode_ID']:checked").val();
	if(Payment_Mode_ID==undefined)
	{
		alert("Please select payment method");
		return false;
	}
	
	//alert("Kindly upload custom layout mentioning furniture placement in Form No. 2");
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
	<div class="breadcome"><a href="search_application.php">Home</a> > Standfitting Services</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Standfitting Services</div>
 
<div class="content_details22">
<div id="formWrapper">
<!--<a href="standfitting_services.php?action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />-->
<!--<h2 style="float:left">Application Summary</h2>

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
		<th valign="top" class="centerAlign">
        <div align="center">Delete Order</div></th>
        </tr>
    <?php
	$query=$conn->query("SELECT a.*,b.* FROM `iijs_stand` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='3' order by b.Payment_Master_ID asc");
	$order_num=$query->num_rows;
	$i=1;
	while($result=$query->fetch_assoc()){
	?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="Form3.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Stand_ID=<?php echo $result['Stand_ID'];?>&orderno=<?php echo $i;?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
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
		
		<td  class="centerAlign">
			<img src='../images/red_cross.png'  alt='' class="deleteOrder <?php echo $result['Payment_Master_ID']?> <?php echo $result['Stand_ID']?> <?php echo $result['Exhibitor_Code']?>" style="cursor:pointer;" />
        </td>
        </tr>
    <?php $i++;}?>     
    </tbody>
</table>-->

<p>The sections marked with an <span class="red">*</span> are compulsory.</p>

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
</table>


<div class="title">
<h4>Basic Furniture</h4>

</div>
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
      <select class="textField" id="Item_ID" name="Item_ID" >
      <option value="" selected="selected">--Select Item--</option>
      <?php 
	    if($Exhibitor_Section != 'machinery' && $Exhibitor_Section != 'allied'  )//if($Exhibitor_Section=='signature_club')
		{
	  	//$sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='SIGNATURE CLUB'";
      $sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='' ";
		}
		else
		{
		  //$sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type!='SIGNATURE CLUB'";
      $sql="SELECT * FROM iijs_stand_items_master where Item_Section_Type='machinery' ";
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
      <input type="text" name="Item_Quantity" id="Item_Quantity" class="textField"   />
      </td>
      <td><span class="bold">
        <input type="button" name="add_item_tmp" id="add_item_tmp" value="ADD" class="maroon_btn"  />
      </span>
	  </td>
	  <span id='progress' style="display:none"><img src="images/progress.gif"/></span>
      </tr>
  </table>  

<div class="title">
<h4>Applied Items (Order No: <?php echo $_REQUEST['orderno'];?>)</h4>
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
      <td><?php echo $tot;?></td>
      <td><?php echo $result['Item_Rate']?></td>
     <td><input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" value="<?php echo $result['Item_Quantity'];?>" disabled="disabled"/></td>
      <td>
	  <img src="images/delete.png" class="deleteItem <?php echo $result['Stand_Item_ID'];?> <?php echo $Stand_ID;?> <?php echo $_REQUEST['Payment_Master_ID'];?> <?php echo $result['Item_Master_ID'];?>" style="cursor:pointer;">
	  </td>
   </tr>
   
   <?php } ?>
  </tbody> 
  </table>

<div class="title"><h4> Payment </h4></div>

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

<div class="title"><h4>Payment Mode</h4></div>
<div class="clear"></div>
<?php 
$Payment_Master_ID=getPaymentModeId($_REQUEST['Payment_Master_ID'],$conn);
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <!--<td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1" <?php if($Payment_Master_ID==1){?> checked="checked"<?php }?> /></td>
    <td width="100">Credit Card</td>-->
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="2" <?php if($Payment_Master_ID==2){?> checked="checked"<?php }?> /></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Master_ID==4){?> checked="checked"<?php }?> /></td>
    <td>DD</td>
  </tr>
</table> 

<ol class="numeric">
<li>Payment must be made within three working days from placing the order, failing will result in cancellation of order. </li>
<li>Cheque should be in favour of ? <strong>"The Gem and Jewellery Export Promotion Council."</strong></li>
</ol>

    <div align="center">
     <?php 
	 $orderno=$_REQUEST['orderno'];
	 if($_REQUEST['orderno']!=""){?>
	 <a href="print_acknowledge/standfitting.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Stand_ID=<?php echo $_REQUEST['Stand_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>&Exhibitor_Code=<?php echo $exhibitor_code;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
	 <?php }?>
	 <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
	 <input type="hidden" name="Payment_Master_ID" id="Payment_Master_ID" value="<?php echo $_REQUEST['Payment_Master_ID'];?>"/>
	 <input type="hidden" name="Stand_ID" id="Stand_ID" value="<?php echo $Stand_ID;?>" />
	 <input type="hidden" name="save" id="save" value="Save"/>
     <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn"  />
    </div>
	
	</form>
	
		</div>
	</div>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
