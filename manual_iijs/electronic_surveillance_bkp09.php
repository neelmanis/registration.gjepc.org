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
	$query_cnt=mysql_query("SELECT * FROM `iijs_cctv_items_master_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	$cctv_cnt=mysql_num_rows($query_cnt);
	if($cctv_cnt==0)
	{
		echo "<script type='text/javascript'> alert('Please Add Items in order');
		window.location.href='electronic_surveillance.php?action=ADD';
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
$qorder=mysql_query("select count(Payment_Master_ID) as count from  iijs_payment_master where Exhibitor_Code='$Exhibitor_Code' and Form_ID='8'");
$rorder=mysql_fetch_array($qorder);	
$order_count=$rorder['count'];
$Payment_Master_OrderNo=$order_count+1;

	
	mysql_query("insert into iijs_payment_master set Form_ID='8',Exhibitor_Code='$Exhibitor_Code',Payment_Master_OrderNo='$Payment_Master_OrderNo',Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_EducationCess='$Payment_Master_EducationCess',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Create_Date='$Create_Date'");
	
	$Payment_Master_ID=mysql_insert_id();
	
	mysql_query("insert into iijs_cctv set Exhibitor_Code='$Exhibitor_Code',Payment_Master_ID='$Payment_Master_ID',Create_Date='$Create_Date'");
	
	$CCTV_ID=mysql_insert_id();
	//echo "SELECT * FROM `iijs_cctv_items_master_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'";exit;
	$query=mysql_query("SELECT * FROM `iijs_cctv_items_master_tmp` WHERE `Exhibitor_Code`='$Exhibitor_Code'");
	while($result=mysql_fetch_array($query))
	{
	$id=$result['id'];
	$CCTV_Items_Master_ID=$result['CCTV_Items_Master_ID'];
	$CCTV_Items_Rate=$result['CCTV_Items_Rate'];
	$CCTV_Items_Quantity=$result['CCTV_Items_Quantity'];

	mysql_query("insert into  iijs_cctv_items set CCTV_ID='$CCTV_ID',CCTV_Items_Master_ID='$CCTV_Items_Master_ID',CCTV_Items_Quantity='$CCTV_Items_Quantity', 	CCTV_Items_Rate='$CCTV_Items_Rate',Create_Date='$Create_Date'");
	
	/*......................Get Floral Item Quantity...............................*/
	$qitem_quantity=mysql_query("select Item_Quantity from iijs_cctv_items_master where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	$ritem_quantity=mysql_fetch_array($qitem_quantity);
	$tot_quantity=$ritem_quantity['Item_Quantity'];
	$remain_quantity=$tot_quantity-$CCTV_Items_Quantity;
	mysql_query("update iijs_cctv_items_master set Item_Quantity='$remain_quantity' where CCTV_Items_Master_ID='$CCTV_Items_Master_ID'");
	
	mysql_query("delete from iijs_cctv_items_master_tmp where id='$id'");
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
	<p>Company Name: <strong>'.$Exibitor_Name.'</strong> </p>
	<p>Thank  you for applying Online for <strong>Form No. 8. ELECTRONIC SURVEILLANCE</strong>. Please note your  application is under approval process. </p>
	
	<p>All the applicant members will have to send the  requisite payment along with the print acknowledgement receipt which will be  available after successful submission of online application with company seal  in 4 working days from date of online submission.</p>
	
	<p>A system generated notification will be sent to you on successful  approval/Disapproval of your application</p>
	
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
	
	//$to =$Exhibitor_Email.',notification@gjepcindia.com';
//	$to ='bhavin@gjepcindia.com';	
	$subject = "Signature 2017 Exhibitor Manual - Form No. 8. ELECTRONIC SURVEILLANCE";	
	$headers  = 'MIME-Version: 1.0' . "\r\n";	
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";				
	header('location:electronic_surveillance.php');
}
?>
<?php 
$action=$_REQUEST['action'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=="ADD")
{
	mysql_query("delete from iijs_cctv_items_master_tmp where EXHIBITOR_CODE='$exhibitor_code'");
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

<!--navigation script end-->


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

<!--manual form css-->
<script src="js/electronic_surveillance.js"></script>
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
<script type="text/javascript">
function validate()
{
	
//return false;
	Payment_Mode_ID=$("input[type='radio'][name='Payment_Mode_ID']:checked").val();
	if(Payment_Mode_ID==undefined)
	{
		alert("Please select payment method");
		return false;
	}
}
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
<h3>Electronic Surveillance</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
   <li>After form submission, please print an acknowledgement and send a copy of it along with the cheque/draft lathe following address</li>
<li><p><strong>M/s.  Intelligent Integration N Automation,</strong><br />
  104, 1st floor, Quantum Tower,<br />
  Off. S V Road,  B/H SBI Bank , Ram Baug Lane,<br />
  Malad (West), Mumbai – 400064<br />
  Tel. 022-288-99-000&nbsp;<br />
  <strong>Contact:</strong><br />
  <strong> Ms. Amruta / Ms. Heta</strong><br />
  <strong> Contact  No</strong>: +91-22-2 88 99 000 Ext : 505<br />
  <strong> Mobile No:</strong> +91-8879099901&nbsp;<br />
  <strong>Email:</strong><a href="mailto:exhibition@iinaindia.com" target="_blank" style="color:#2a2a2a;">exhibition@iinaindia.com</a>&nbsp; <br />
  <strong>RTGS Details</strong><br />
  <strong>Account Name:&nbsp;</strong>Intelligent Integration N Automation&nbsp;&nbsp;<br />
  <strong>Bank Name:</strong>&nbsp;ICICI BANK LTD&nbsp;<br />
  <strong>Branch:</strong> MINDSPACE MALAD<br />
  <strong>Account Type:</strong>&nbsp;CURRENT<br />
  <strong>Account No:</strong> 038805001411<br />
  <strong>IFSC code:</strong> ICIC0000388<br />
  <strong>PAN No:</strong>&nbsp;AADFI2896K<br />
  <strong>Service Tax No:</strong>&nbsp;AADFI2896KSD001<br />
  * <strong>Kindly email the UTR number after  transaction made online on email id </strong><a href="mailto:accounts@iinaindia.com" target="_blank" style="color:#2a2a2a;">accounts@iinaindia.com</a>;<a href="mailto:exhibition@iinaindia.com" target="_blank" style="color:#2a2a2a;">exhibition@iinaindia.com</a>&nbsp; </p></li>

  <li>The cheque/ draft is payable to <strong>Intelligent Integration N Automation&nbsp;</strong></li>
  <li>The system shall continuously record the events of the date along with the time. This recording is done on the harddisk of the DVR and shall enable Exhibitors to keep a record of the visitors at the stall_ along with the person's attending to the particular visitor/s. The recording will be very helpful for further follow-ups with potential clients who were attended to by the Exhibitors' representative</li>
  <li>For SAFE being placed in the stall - a strict vigil will be maintained on the operation of the safe and will record the images of the person/s opening the safe, in the Exhibitor's presence or absence if camera is installed to cover SAFE Visual.</li>
  <li>Since continuous recording of the counter and visitors will be done during exhibition hours only, any kind of mischief or theft will be detected along with the evidence.</li>
  <li>The entire recording of the exhibitors booth can be transferred to HARD DISK and stored permanently for future records</li>
  <li>Power Points tobe made available by the customer.</li>
  <li>Back up Procedure to handover data to Exhibitor &nbsp;: Rs 4900 + 5%VAT&nbsp;</li>
  <li>Loss / Theft / Damage to any equipment to be reimbursed in full as per MRP</li>
  <li>Service tax @15%</li>
  <li>Please mail the booth layout with camara positions and DVR-Monitor Position along with the payment details.</li>
  <li>The power supply at the booth will be from 8AM to 8PM only during exhibition period.</li>
  <li>
    <p><strong>Cost for&nbsp;exhibitor considering HD Analog  Camera&nbsp;&nbsp;Including&nbsp;</strong><br />
      1) 1.3 MP  Camera, 2) HD Recorder, 3) 1 TB HDD, 4) Cable with Connector, 5) Power Supply  Unit, 6) Installation, 7) 14 to 17&quot; Display&nbsp;</p>
  </li>
<li><strong>Please fill in Form No. 8 and send a copy of it to  Intelligent Integration N Automation&nbsp;alongwith an enclosed Cheque/ Demand  Draft before 14th January 2017</strong></li>
</ol>
</span>
</div>
<span  class="spanbox">Deadline : <strong>14th January 2017</strong></span>
<div class="clear"></div>

<a href="electronic_surveillance.php?action=ADD" class="maroon_btn" style="float:right;">ADD NEW ORDER</a><br />
<h2>Application Summary</h2>

<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
    <tr>
        <th valign="top"><span class="table_head" style="width: 58px; height: 13px">Sr. No</span></th>
        <th valign="top"><span class="table_head" style="width: 78px; height: 13px">Date</span></th>
        <th valign="top" class="centerAlign">
        <div align="center"><span class="table_head" style="width: 128px; height: 13px;"> Items Approved</span></div></th>
        <th valign="top" class="centerAlign">
        <div align="center"><span class="table_head" style="width: 120px; height: 13px"> Payment Status</span></div></th>
        <th valign="top" class="centerAlign">
        <div align="center"><span class="table_head" style="height: 13px"> Application Status</span></div></th>
    </tr>

   <?php
    $i=1;
	$query=mysql_query("SELECT a.*,b.* FROM `iijs_cctv` a,iijs_payment_master b WHERE 1 and a.`Payment_Master_ID`=b.`Payment_Master_ID` and a.Exhibitor_Code='$exhibitor_code' and b.Form_ID='8' order by b.Payment_Master_ID desc");
	$order_num=mysql_num_rows($query);
	while($result=mysql_fetch_array($query)){
	?>
        <tr>
        <td ><?php echo $i;?></td>
        <td><a href="electronic_surveillance.php?Payment_Master_ID=<?php echo $result['Payment_Master_ID'];?>&CCTV_ID=<?php echo $result['CCTV_ID'];?>&orderno=<?php echo $i;?>&action=summary"><?php echo date("j M Y", strtotime($result['Create_Date']));?></a></td>
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
			//if($result['Payment_Master_Amount_Received']=='Y')
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
<p>Stall owners can avail of electronic surveillance services by installing CCTV system in their stalls on rental basis. </p>

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
<p><strong>Item List :</strong></p>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <th width="45">Sr No</td>
    
    <th width="500">Item</th>
    <th width="140">Rent 
      [Exclusive of all taxes]</th>
    </tr>
  <tr>
    <td>1</td>
    <td>Rent  Charges for 2 Nos Camera Setup.</td>
    <td>10000.00</td>
    </tr>
  <tr>
    <td>2</td>
    <td>Rent  Charges for 4 Nos Camera Setup.</td>
    <td>14000.00</td>
    </tr>
  <tr>
    <td>3</td>
    <td>Rent  Charges for 6 Nos Camera Setup.</td>
    <td>18000.00</td>
    </tr>
  <tr>
    <td>4</td>
    <td>Rent  Charges for 8 Nos Camera Setup.</td>
    <td>20000.00</td>
  </tr>
 
</table>
<p>* The above price are exclusive of service taxes,charged extra @15% on the above amount.</p>
<div class="title"><h4>Items</h4></div>

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
      <select class="textField" id="CCTV_Items_Master_ID" name="CCTV_Items_Master_ID" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php }?>>
      <option value="" selected="selected">--Select Item--</option>
      <?php 
        $query=mysql_query("SELECT * from iijs_cctv_items_master");
        while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['CCTV_Items_Master_ID'];?>"><?php echo $result['CCTV_Items_Master_Description'];?></option>
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
        <input type="button" name="add_item" id="add_item" value="ADD" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> disabled="disabled" style="background:#dddddd;" <?php }?> />
      </span></td>
      </tr>
  </table>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">

  <tr>
    <th>Items Applied</th>
    <th>Amount</th>
    <th>Rate</th>
    <th>Quantity</th>
    <?php if(!isset($_REQUEST['CCTV_ID'])){?>
    <th>Action</th>
    <?php } ?>
  </tr>
  <tbody id="Applied_Items">
    <?php 
	if(isset($_REQUEST['CCTV_ID']) && $_REQUEST['CCTV_ID']!="")
	{
		$CCTV_ID=$_REQUEST['CCTV_ID'];
		$query=mysql_query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	}
	else
	{
    	$query=mysql_query("select * from iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
	}
	$cctv_cnt=mysql_num_rows($query);
	while($result=mysql_fetch_array($query)){  
	$tot=$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
	?>
    <tr>
      <td><?php echo getElectronicItemName($result['CCTV_Items_Master_ID']);?></td>
      <td><?php echo $tot;?></td>
      <td><?php echo $result['CCTV_Items_Rate']?></td>
      <td><input type="text" name="textfield" id="textfield" class="textField" value="<?php echo $result['CCTV_Items_Quantity'];?>" disabled="disabled" /></td>
       <?php if(!isset($_REQUEST['CCTV_ID'])){?>
      <td><img src="images/red_cross.png" class="deleteItem <?php echo $result['id'];?> <?php echo $exhibitor_code;?>" style="cursor:pointer;"></td>
      <?php } ?>
   </tr>

   <?php }?>
      <input type="hidden" name="cctv_cnt" id="cctv_cnt" value="<?php echo $cctv_cnt;?>">

  </tbody>
</table>


<!--<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150">Status</td>
    <td>:</td>
    <td><div class="leftDiv">Approved</div> 
      <div class="leftDiv rightSpace"><input type="radio" name="radio" id="radio" value="radio" /> </div>
      <div class="leftDiv">Disapproved</div> 
      
      <div class="leftDiv">
      <input type="radio" name="radio" id="radio2" value="radio" />
      </div>      </td>
    </tr>
  <tr>
    <td>Reason (if disapproved)</td>
    <td>:</td>
    <td><textarea name="textarea2" id="textarea2" cols="45" rows="5" class="textArea"></textarea></td>
    </tr>
</table>-->

<table>
<div class="title"><h4>Payment </h4></div>
</table>
<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
<?php  
if(isset($_REQUEST['CCTV_ID']) && $_REQUEST['CCTV_ID']!="")
	{
		$CCTV_ID=$_REQUEST['CCTV_ID'];
		$query=mysql_query("select * from iijs_cctv_items where CCTV_ID='$CCTV_ID'");
	}
else
{
	$query=mysql_query("select * from  iijs_cctv_items_master_tmp where Exhibitor_Code='$exhibitor_code'");
}

$tot=0;
while($result=mysql_fetch_array($query))
{
	$tot=$tot+$result['CCTV_Items_Rate']*$result['CCTV_Items_Quantity'];
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
    <td class="bold">Service Tax (15%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$tot*15/100;?><input type="hidden" name="Payment_Master_ServiceTax" id="Payment_Master_ServiceTax" value="<?php echo $service_tax;?>" /></td>
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
    <td><?php echo $grand_tot=round($tot+$service_tax+$she_cess_tax);?><input type="hidden" name="Payment_Master_AmountPaid" id="Payment_Master_AmountPaid" value="<?php echo $grand_tot;?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
</table>

<div class="clear">
 
<div class="title"><h4>Payment Mode</h4></div>

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
    <td width="100">RTGS</td>-->
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="2" <?php if($Payment_Mode_ID==2){?> checked="checked"<?php }?> /></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID" id="Payment_Mode_ID" value="4" <?php if($Payment_Mode_ID==4){?> checked="checked"<?php }?> /></td>
    <td>DD</td>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  </tr>
</table> 
</div>

<?php if(isset($_REQUEST['orderno'])){?>
<?php 
$CCTV_ID=$_REQUEST['CCTV_ID'];
$query=mysql_query("select * from iijs_cctv where CCTV_ID='$CCTV_ID'");
$result_i=mysql_fetch_array($query);
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


<div class="clear"></div>
<div align="center">
  <?php if($_REQUEST['orderno']!=""){?>
      <a href="print_acknowledge/electronic_servillance.php?Payment_Master_ID=<?php echo $_REQUEST['Payment_Master_ID']?>&CCTV_ID=<?php echo $_REQUEST['CCTV_ID'];?>&orderno=<?php echo $_REQUEST['orderno'];?>" target="_blank" class="button5">Print AcknowledgeMent</a>
<?php }?> 
  <input type="hidden" name="save" id="save" value="Save"/>
       <?php if($_REQUEST['auth']=="admin"){?>
  <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> /><?php } } else { if($_REQUEST['orderno']==""){?>
	 <input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" <?php if($order_num>0 && $action!="ADD"){?> />
	 <?php } } } ?>
 <a href="list.php"><input name="input2" type="button" value="Cancel" class="maroon_btn" /></a>
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
