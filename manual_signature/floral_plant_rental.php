<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE']))
{
	header("location:index.php");
	exit;
}
?>

<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];
$exhibitor_data="select * from iijs_exhibitor where Exhibitor_Code='$exhibitor_code'";
$result=mysql_query($exhibitor_data);
$fetch_data=mysql_fetch_array($result);

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
$Exhibitor_Email1=$fetch_data['Exhibitor_Email1'];
$Exhibitor_Pincode=$fetch_data['Exhibitor_Pincode'];
$Exhibitor_State=$fetch_data['Exhibitor_State'];
$Exhibitor_Country_ID=$fetch_data['Exhibitor_Country_ID'];
$Exhibitor_City=$fetch_data['Exhibitor_City'];
$Exhibitor_Website=$fetch_data['Exhibitor_Website'];
?>


<?php 
$save=$_REQUEST['save'];
if($save=="Save")
{
	$Exhibitor_Code=$_POST['Exhibitor_Code'];
	
	$query_cnt=mysql_query("SELECT * FROM `iijs_floral_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	$stand_cnt=mysql_num_rows($query_cnt);
	if($stand_cnt==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Items in order');
		window.location.href='floral_plant_rental.php?action=ADD';
		</script>"	;
		return;	
	}
	
	$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
	$Payment_Master_Amount=$_POST['Payment_Master_Amount'];
	$Payment_Master_ServiceTax=$_POST['Payment_Master_ServiceTax'];
	$Payment_Master_EducationCess=$_POST['Payment_Master_EducationCess'];
	$Payment_Master_AmountPaid=$_POST['Payment_Master_AmountPaid'];
	$Create_Date=date('Y-m-d h:i:s');
	/*..........................Payment Update..................................*/
$qorder=mysql_query("select count(Payment_Master_ID) as count from  iijs_payment_master where Exhibitor_Code='$Exhibitor_Code'");
$rorder=mysql_fetch_array($qorder);	
$order_count=$rorder['count'];
$Payment_Master_OrderNo=$order_count+1;
	
	mysql_query("insert into iijs_payment_master set Form_ID='10',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Create_Date='$Create_Date'");
	
	$Payment_Master_ID=mysql_insert_id();
	
	mysql_query("insert into iijs_floral set Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',Create_Date='$Create_Date'");
	
	$Floral_ID=mysql_insert_id();
	
	$query=mysql_query("SELECT * FROM `iijs_floral_items_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result=mysql_fetch_array($query))
	{
	$id=$result['id'];
	$Floral_Items_MasterID=$result['Floral_Items_MasterID'];
	$Floral_Items_Rate=$result['Floral_Items_Rate'];
	$Floral_Items_Quantity=$result['Floral_Items_Quantity'];
	
	
	mysql_query("insert into iijs_floral_items set Floral_ID='$Floral_ID',Floral_Items_MasterID='$Floral_Items_MasterID',Floral_Items_Quantity='$Floral_Items_Quantity', 	Floral_Items_Rate='$Floral_Items_Rate',Create_Date='$Create_Date'");
	
	/*......................Get Floral Item Quantity...............................*/
	$qitem_quantity=mysql_query("select Item_Quantity from iijs_floral_items_master where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	$ritem_quantity=mysql_fetch_array($qitem_quantity);
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$Floral_Items_Quantity;
	mysql_query("update iijs_floral_items_master set Item_Quantity='$remain_quantity' where Floral_Items_Master_ID='$Floral_Items_MasterID'");
	
	mysql_query("delete from iijs_floral_items_tmp where id='$id'");
	}	
	
	$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	<tr>
	<td style="padding:30px;">
	<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
	<tr>
	<td align="left" height="60px"><img src="http://iijs-signature.org/images/logo.png" border="0" width="230" /></td>
	<td align="right" height="60px"><img src="http://iijs-signature.org/images/gjepc_logo.png" width="120" border="0"/></td>
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
	<p>Thank  you for applying Online for <strong>Form No. 10. FLORAL / PLANT RENTAL FORM </strong>. Please note your  application is under approval process. </p>
	
	<p>All the applicant members will have to send the  requisite payment along with the print acknowledgement receipt which will be  available after successful submission of online application with company seal  in 4 working days from date of online submission.</p>
	
	<p>A  system generated notification will be sent to you on successful  approval/Disapproval of your application</p>
	
	<p>Kind regards, <br />
	
	<strong>Signature Web Team,</strong>
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
	
	$subject = "Signature 2015 Exhibitor Manual - Form No. 10. FLORAL / PLANT RENTAL FORM";
	
	$headers  = 'MIME-Version: 1.0' . "\n";
	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
	$headers .= 'From:admin@gjepc.org';                                   
	
	@mail($to, $subject, $message, $headers);		
	header('location:floral_plant_rental.php');
}
?>
<?php 
$action=$_REQUEST['action'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="ADD")
{
	mysql_query("delete from iijs_floral_items_tmp where EXHIBITOR_CODE='$exhibitor_code'");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>

<link rel="stylesheet" type="text/css" href="../css/mystyle.css" />

<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    -->  

<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

<script type="text/javascript" src="../js/ddsmoothmenu.js">
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

<!-- small slider -->
	<script type="text/javascript" src="../js/jquery.cycle.all.js"></script>
<!-- SLIDER -->
	<script type="text/javascript">
	$(document).ready(function(){ 
	$('#imgSlider').cycle({ 
			fx:    'scrollHorz', 
			timeout: 6000, 
			delay: -1000,
			prev:'.prev1',
			next:'.next1', 
		});
	});
	</script>

<!--  SLIDER ends  -->

<link href="../css/slider.css" rel="stylesheet" type="text/css" />
<script src="js/floral_plant.js"></script>
<!--manual form css-->

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>
<script type="text/javascript">
function validate()
{
	Payment_Mode_ID=$("input[type='radio'][name='Payment_Mode_ID']:checked").val();
	if(Payment_Mode_ID==undefined)
	{
		alert("Please select payment method");
		return false;
	}
}
</script>

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
    padding: 5px 30px;
    background-color: #d661aa;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 600px;
    background-color: #d661aa;
    color: #fff;
    text-align: left;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    top: 280%;
    right: -50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -18%;
    left: 93%;
    margin-left: -60px;
    border-width: 50px;
    border-style: solid;
    border-color: #d661aa transparent transparent transparent;
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
    background-color: #d661aa;	
}

.tooltip{float:right;}
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
<h3>FLORAL / PLANT RENTAL</h3>

<span style="margin-left:5%;" class="spanbox"><a href="floral_items.php" target="_blank" style="color:#2a2a2a;"><strong>Click here to view rate list and images</strong></a></span>
<span style="margin-left:12%;" class="spanbox">Deadline : <strong>21st Dec 2016</strong></span>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">

<?php if($order_num==0 || $_REQUEST['action']=='ADD' || $_REQUEST['action']=='summary') {?>
<ol class="numeric">
<li>
Demand Draft / Cheque payable to <b>"Shivco Arts"</b></li>
<li>After the form submission please print an acknowledgement and send a copy of it along with the Cheque / Draft to the following address 
<strong>Return To</strong><br/>
<b>M/s Shivco Arts</b><br/>
H/O: B-298,Avantika,Sec-1.Rohini New Delhi -110085<br/>
B/O: B-1707,S.R.A Tower, Santaram Talaw, Malad East mumbai 97
Email: <a href="mailto:sonika@myShivco Artsonline.com">sonika@myShivco Artsonline.com </a><br />
<strong>Contact Person: </strong>
<p>Mr. Pradeep Ananad :9821180300,8452088964 </p>
<p>Mr. Urmila Ananad : 9891144332</p>
<p>Mr. Deepen Ananad : 8587861492,84520889667</p>
<strong>Bank Detail: </strong>
Account Holder: Shivco Arts<br/>
Account Number: 619102000000824<br/>
Bank Name: IDBI Bank<br/>
Branch: Amboli Andhri West<br/>
IFSC Code: IBKL0000619 
</li>
<li>
Shivco Arts will not be responsible for any breakage or missing plants during the exhibition and extra charges will be applicable for damages.</li>
</ol>
<?php } ?>
</span>
</div>

<div class="clear"></div>
<h2>Application Summary</h2>

<table cellspacing="0" cellpadding="0" class="common">
<tbody>
    <tr>
        <th valign="top"><span class="table_head" style="width: 58px; height: 13px">Sr. No</span></th>
        <th valign="top"><span class="table_head" style="width: 78px; height: 13px">Date</span></th>
        <th valign="top" >
        <div align="center"><span class="table_head" style="width: 120px; height: 13px;"> Information Status</span></div></th>
        <th valign="top" class="centerAlign">
        <div align="center"><span class="table_head" style="width: 120px; height: 13px"> Payment Status</span></div></th>
        <th valign="top" class="centerAlign">
        <div align="center"><span class="table_head" style="height: 13px"> Application Status</span></div></th>
    </tr>

   <?php
    $i=1;
	$query=mysql_query("SELECT a.*,b.* FROM `iijs_floral` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='10' order by b.Payment_Master_ID asc");
	$order_num=mysql_num_rows($query);
	while($result=mysql_fetch_array($query)){
	?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="floral_plant_rental.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&Floral_ID=<?php echo $result['Floral_ID'];?>&orderno=<?php echo $i;?>&action=summary" style="color:#FF0000;"><?php echo date("j M Y", strtotime($result['Create_Date']));?>(Click Here)</a></td>
        <td  class="centerAlign">
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
<?php if($order_num==0 || $_REQUEST['action']=='ADD' || $_REQUEST['action']=='summary') {?>
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
        <h4>Items</h4>
      </div>

<div class="clear"></div>

<form  id="item_selection" name="item_selection" method="post" onSubmit="return validate()">

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
      <select class="textField" id="Floral_Items_Master_ID" name="Floral_Items_Master_ID" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
        $query=mysql_query("SELECT * from iijs_floral_items_master");
        while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['Floral_Items_Master_ID'];?>"><?php echo $result['Floral_Items_Master_Description'];?></option>
        <?php }?>
       </select>  
       </td>
      <td id="avail_qty">0</td>
      <td id="rate">0</td>
      <td>
      <input type="hidden" name="exhibitor_code" id="exhibitor_code"  value="<?php echo $exhibitor_code;?>" />
      <input type="text" name="Item_Quantity" id="Item_Quantity" class="textField" />
      </td>
      <td><span class="bold">
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php }?> disabled="disabled" style="background:#dddddd;"/>
      </span></td>
      </tr>
  </table>
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
	if(isset($_REQUEST['Floral_ID']) && $_REQUEST['Floral_ID']!="")
	{
		$Floral_ID=$_REQUEST['Floral_ID'];
		$query=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
	}
	while($result=mysql_fetch_array($query)){  
	$tot=$result['Floral_Items_Rate']*$result['Floral_Items_Quantity'];
	?>
    <tr>
      <td><?php echo getFloralItemName($result['Floral_Items_MasterID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result['Floral_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result['Floral_Items_Quantity'];?>" disabled="disabled" /></td>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
   </tr>
   
   <?php }?>
  </tbody>
</table>
<?php 
$Floral_ID=mysql_real_escape_string($_REQUEST['Floral_ID']);
$query=mysql_query("select Info_Approved,Info_Reason from  iijs_floral where  Floral_ID='$Floral_ID'");
$result=mysql_fetch_array($query);
$Info_Approved=$result['Info_Approved'];
$Info_Reason=$result['Info_Reason'];
?>

<?php if(isset($_REQUEST['orderno'])){?>
<div class="title">
<h4>Item Approval :</h4>
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
<?php }?>

<div class="title">
        <h4>Payment</h4>
      </div>
<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php  
if(isset($_REQUEST['Floral_ID']) && $_REQUEST['Floral_ID']!="")
	{
		$Floral_ID=$_REQUEST['Floral_ID'];
		$query=mysql_query("select * from iijs_floral_items where Floral_ID='$Floral_ID'");
	}
else
{
	$query=mysql_query("select * from  iijs_floral_items_tmp where Exhibitor_Code='$exhibitor_code'");
}
$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['Floral_Items_Rate']*$result['Floral_Items_Quantity'];
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
    <td class="bold">Service Tax (14%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*14/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Swachh Bharat Cess (0.5%) </td>
    <td>:</td>
    <td><?php echo $e_cess_tax=$tot*.5/100;?><input type="hidden" name="Payment_Master_EducationCess" id="Payment_Master_EducationCess" value="<?php echo $e_cess_tax;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 	<?php $she_cess_tax=$service_tax*0/100;?><input type="hidden" name="" id="" value="<?php echo $she_cess_tax;?>" />
  <tr>
    <td class="bold">Total Payable INR</td>
    <td>:</td>
    <td><?php echo $grand_tot=round($tot+$service_tax+$e_cess_tax+$she_cess_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div class="clear"> 
<div class="title">
        <h4>Payment Mode</h4>
      </div>

<div class="clear"></div>
<?php 
   $Payment_Master_ID=mysql_real_escape_string($_REQUEST['Payment_Master_ID']);
   $Payment_Mode_ID=getPaymentModeId($_REQUEST['Payment_Master_ID']);
   $query=mysql_query("select * from iijs_payment_master where Payment_Master_ID='$Payment_Master_ID'");
   $result=mysql_fetch_array($query);
   $Payment_Master_Approved=$result['Payment_Master_Approved'];
   $Payment_Master_Reason=$result['Payment_Master_Reason'];
?>
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <!--<td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="1" <?php if($Payment_Mode_ID==1){?> checked="checked"<?php }?> /></td>
    <td width="100">Credit Card</td>-->
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="2" <?php if($Payment_Mode_ID==2){?> checked="checked"<?php }?> /></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?> /></td>
    <td>DD</td>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  </tr>
</table> 
</div>

<?php if(isset($_REQUEST['orderno'])){?>
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

<div class="clear"></div>
<div align="center">
<?php if($_REQUEST['orderno']!=""){?>
  <a href="print_acknowledge/floral_plant_rental.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&Floral_ID=<?php echo $_REQUEST['Floral_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>" target="_blank" class="button5">Print AcknoledgeMent</a>
  <?php }?>
  <input type="hidden" name="save" id="save" value="Save"/>
  <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php }?> disabled="disabled" style="background:#dddddd;" />
  <a href="manual_list.php" class="button5">Cancel</a>
 <!-- <input name="input" type="button" value="Reset" class="maroon_btn" />
  <input name="input3" type="button" value="Cancel" class="maroon_btn" />-->
  
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
