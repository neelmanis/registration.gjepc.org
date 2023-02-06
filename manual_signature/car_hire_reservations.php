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
	$Car_Type_ID=$_POST['Car_Type_ID'];
	$Exhibitor_Code=$_SESSION['EXHIBITOR_CODE'];
	$Car_Hire_CompanyName=$_POST['CompanyName'];
	$Car_Hire_NameOfPassenger=$_POST['NameOfPassenger'];
	$Car_Hire_Address1=$_POST['Address1'];
	$Car_Hire_City=$_POST['City'];
	$Car_Hire_Pincode=$_POST['Pincode'];
	$Country_ID=$_POST['Country_ID'];
	$Car_Hire_Mobile=$_POST['Mobile'];
	$Car_Hire_Phone=$_POST['Phone'];
	$Car_Hire_Fax=$_POST['Fax'];
	$Car_Hire_Email=$_POST['Email'];
	$Car_Hire_Website=$_POST['Website'];
	$Car_Hire_Reporting_Time=$_POST['Reporting_Time'];
	$Car_Hire_Reporting_Address=$_POST['Reporting_Address'];
	$Car_Hire_No_Of_Passengers=$_POST['No_Of_Passengers'];
	$Car_Hire_Hours=$_POST['Hours'];
	$Car_Hire_Kilometers=$_POST['Kilometers'];
	$Car_Hire_PickUp_Type=$_POST['PickUp_Type'];
	$Car_Hire_Drop_Type=$_POST['Drop_Type'];
	$Car_Hire_Pickup_Date=$_POST['Pickup_Date'];
	$Car_Hire_Pickup_Flight_Time=$_POST['Pickup_Flight_Time'];
	$Car_Hire_Pickup_FlightNumber=$_POST['Pickup_FlightNumber'];
	$Car_Hire_Pickup_Location=$_POST['Pickup_Location'];
	$Car_Hire_Drop_Date=$_POST['Drop_Date'];
	$Car_Hire_Drop_Flight_Time=$_POST['Drop_Flight_Time'];
	$Car_Hire_Drop_FlightNumber=$_POST['Drop_FlightNumber'];
	$Car_Hire_Drop_Location=$_POST['Drop_Location'];
	$Car_Hire_FromDate=$_POST['FromDate'];
	$Car_Hire_Todate=$_POST['Todate'];
	$Car_Hire_Charges=$_POST['Charges'];
	
	
	$Payment_Mode_ID=$_POST['Payment_Mode_ID'];
	$Payment_Mode_ID=$Payment_Mode_ID[0];
	
	$Payment_Master_Amount=$_POST['total_amount'];
	$Payment_Master_ServiceTax=$_POST['service_tax'];
	$Payment_Master_AmountPaid=$_POST['total_payble'];
	$Create_Date=date('Y-m-d h:i:s');
	
	mysql_query("insert into iijs_payment_master set Form_ID='13',Exhibitor_Code='$Exhibitor_Code',Payment_Mode_ID='$Payment_Mode_ID',Payment_Master_Amount='$Payment_Master_Amount',Payment_Master_ServiceTax='$Payment_Master_ServiceTax',Payment_Master_AmountPaid='$Payment_Master_AmountPaid',Create_Date='$Create_Date'");
	
	$Car_Hire_Payment_ID=mysql_insert_id();
	
	
	$sql="insert into iijs_car_hire set Car_Type_ID='$Car_Type_ID',Car_Type_Preference='$Car_Type_Preference',Exhibitor_Code='$Exhibitor_Code',Car_Hire_CompanyName='$Car_Hire_CompanyName',Car_Hire_NameOfPassenger='$Car_Hire_NameOfPassenger',Car_Hire_Address1='$Car_Hire_Address1',Car_Hire_City='$Car_Hire_City',Car_Hire_Pincode='$Car_Hire_Pincode',Country_ID='$Country_ID',Car_Hire_Mobile='$Car_Hire_Mobile',Car_Hire_Phone='$Car_Hire_Phone',Car_Hire_Fax='$Car_Hire_Fax',Car_Hire_Email='$Car_Hire_Email',Car_Hire_Website='$Car_Hire_Website',Car_Hire_Reporting_Time='$Car_Hire_Reporting_Time',Car_Hire_Reporting_Address='$Car_Hire_Reporting_Address',Car_Hire_No_Of_Passengers='$Car_Hire_No_Of_Passengers',Car_Hire_Hours='$Car_Hire_Hours',Car_Hire_Kilometers='$Car_Hire_Kilometers',Car_Hire_PickUp_Type='$Car_Hire_PickUp_Type',Car_Hire_Drop_Type='$Car_Hire_Drop_Type',Car_Hire_Pickup_Date='$Car_Hire_Pickup_Date',Car_Hire_Pickup_Flight_Time='$Car_Hire_Pickup_Flight_Time',Car_Hire_Pickup_FlightNumber='$Car_Hire_Pickup_FlightNumber',Car_Hire_Pickup_Location='$Car_Hire_Pickup_Location',Car_Hire_Drop_Date='$Car_Hire_Drop_Date',Car_Hire_Drop_Flight_Time='$Car_Hire_Drop_Flight_Time',Car_Hire_Drop_FlightNumber='$Car_Hire_Drop_FlightNumber',Car_Hire_Drop_Location='$Car_Hire_Drop_Location',Car_Hire_FromDate='$Car_Hire_FromDate',Car_Hire_Todate='$Car_Hire_Todate',Car_Hire_Charges='$Car_Hire_Charges',Car_Hire_Payment_ID='$Car_Hire_Payment_ID',Create_Date='$Create_Date',Modify_Date='$Create_Date'";
mysql_query($sql);
header('location:car_hire_reservations.php');
exit;
}
?>
<?php 
$query=mysql_query("select * from iijs_car_hire where Exhibitor_Code='$exhibitor_code' order by Modify_Date desc limit 0,1");
$result=mysql_fetch_array($query);
$num=mysql_num_rows($query);
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

<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

<!-- calendar starts-->
<link rel="stylesheet" href="../calendar/css/jquery-ui.css" />
  <script src="../calendar/js/jquery-1.9.1.js"></script>
  <script src="../calendar/js/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
  <script>
  $(function() {
    $( "#FromDate" ).datepicker();
	$( "#Todate" ).datepicker();
	$( "#Pickup_Date" ).datepicker();
	$( "#Drop_Date" ).datepicker();
  });
  </script>

<!-- calendar ends-->

<script src="js/carhire.js"></script>
<link rel="stylesheet" type="text/css" href="../css/manual.css"/>

<script type="text/javascript">
function validate()
{
  if(document.forms['car_hire_reservation']['CompanyName'].value=="")
  {
	  alert("Please enter company name");
	  document.forms['car_hire_reservation']['CompanyName'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['NameOfPassenger'].value=="")
  {
	  alert("Please enter Name Of passenger");
	  document.forms['car_hire_reservation']['NameOfPassenger'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Address1'].value=="")
  {
	  alert("Please enter Address");
	  document.forms['car_hire_reservation']['Address1'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['City'].value=="")
  {
	  alert("Please enter City");
	  document.forms['car_hire_reservation']['City'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Pincode'].value=="")
  {
	  alert("Please enter Pincode");
	  document.forms['car_hire_reservation']['Pincode'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Mobile'].value=="")
  {
	  alert("Please enter mobile");
	  document.forms['car_hire_reservation']['Mobile'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Country_ID'].value=="")
  {
	  alert("Please select country");
	  document.forms['car_hire_reservation']['Country_ID'].focus();
	  return false;
  }
  
  if(document.forms['car_hire_reservation']['Email'].value=="")
  {
	  alert("Please enter Email Id");
	  document.forms['car_hire_reservation']['Email'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Fax'].value=="")
  {
	  alert("Please enter fax");
	  document.forms['car_hire_reservation']['Fax'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Website'].value=="")
  {
	  alert("Please enter website");
	  document.forms['car_hire_reservation']['Website'].focus();
	  return false;
  }
 
  Reporting_Address=document.forms['car_hire_reservation']['Reporting_Address'].value;
  Pickup_Date=document.forms['car_hire_reservation']['Pickup_Date'].value;
  Drop_Date=document.forms['car_hire_reservation']['Drop_Date'].value;
  if((Reporting_Address=="") && (Pickup_Date=="") && (Drop_Date==""))
  {
  	alert("Please fill one of the pickup type");
	document.forms['car_hire_reservation']['Reporting_Address'].focus();
	return false;
  }
 
if(Reporting_Address!="")
{
  if(document.forms['car_hire_reservation']['FromDate'].value=="")
  {
	  alert("Please enter From Date");
	  document.forms['car_hire_reservation']['FromDate'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Todate'].value=="")
  {
	  alert("Please enter To date");
	  document.forms['car_hire_reservation']['Todate'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['No_Of_Passengers'].value=="")
  {
	  alert("Please enter No Of Passengers");
	  document.forms['car_hire_reservation']['No_Of_Passengers'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Reporting_Time'].value=="")
  {
	  alert("Please enter Reporting Time");
	  document.forms['car_hire_reservation']['Reporting_Time'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Car_Type_ID'].value=="")
  {
	  alert("Please select car pickup type");
	  document.forms['car_hire_reservation']['Car_Type_ID'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Hours'].value=="")
  {
	  alert("Please enter hours");
	  document.forms['car_hire_reservation']['Hours'].focus();
	  return false;
  }
 } 
if(Pickup_Date!="")
{
  if(document.forms['car_hire_reservation']['Pickup_Date'].value=="")
  {
	  alert("Please enter Pickup Date");
	  document.forms['car_hire_reservation']['Pickup_Date'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Pickup_Flight_Time'].value=="")
  {
	  alert("Please enter Pickup Flight Time");
	  document.forms['car_hire_reservation']['Pickup_Flight_Time'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Pickup_FlightNumber'].value=="")
  {
	  alert("Please enter Pickup Flight Number");
	  document.forms['car_hire_reservation']['Pickup_FlightNumber'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Pickup_Location'].value=="")
  {
	  alert("Please enter Pickup_Location");
	  document.forms['car_hire_reservation']['Pickup_Location'].focus();
	  return false;
  }
}
if(Drop_Date!="")
{
  if(document.forms['car_hire_reservation']['Drop_Date'].value=="")
  {
	  alert("Please enter Drop Date");
	  document.forms['car_hire_reservation']['Drop_Date'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Drop_Flight_Time'].value=="")
  {
	  alert("Please enter Drop Flight Time");
	  document.forms['car_hire_reservation']['Drop_Flight_Time'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['DropFlightNumber'].value=="")
  {
	  alert("Please enter Drop Flight Number");
	  document.forms['car_hire_reservation']['Drop_FlightNumber'].focus();
	  return false;
  }
  if(document.forms['car_hire_reservation']['Drop_Location'].value=="")
  {
	  alert("Please enter Drop Date");
	  document.forms['car_hire_reservation']['Drop_Location'].focus();
	  return false;
  }
}
if ( ( item_selection.Payment_Mode_ID[0].checked == false ) && ( item_selection.Payment_Mode_ID[1].checked == false ) && ( item_selection.Payment_Mode_ID[2].checked == false ) )
{
  alert("Please select a payment mode");
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
    top: 350%;
    right: -50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: -38%;
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

.bigTextField { width: 100%; height: 110px; }
</style>
</head>

<body>
<!-- header starts -->

<div class="header_wrap">
	<?php include ('header.php'); ?>
</div>

<!-- header ends -->

<div class="clear"></div>

<!--banner starts-->
<div class="banner_inner_wrap">
	<div class="banner_inner">
    	<img src="../images/highlight_banner.jpg" />
    </div>
</div>
<!--banner ends-->
<div class="clear"></div>

<div class="container_wrap">
<div class="container" id="manualFormContainer">
<h1>Online Manual </h1>

<div id="formWrapper">
<h3>Car Hire Reservations Request Form</h3>

<span style="margin-left:40%;" class="spanbox">Deadline : <strong>21st Dec 2016</strong></span>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>After form submission, please print an acknowledgement and send a copy of it along with the cheque / draft to the following address,<br />
<strong><u>Return to:</u></strong><br />
<strong>Travel Corporation (India) Ltd.</strong><br />
Thomas Cook Building, 3rd floor,<br />
Dr. D.N. Road, Fort, Murnbai .400 001, India<br />
<strong>Tel:</strong>+91 22 6609 1546/47/48<br />
<strong>Fax:</strong> +91 22 66091595<br />
<strong>Email:</strong> <a href="mailto:rmane@tci.co.in">rmane@tci.co.in</a>, <a href="mailto:irnerchant@tci.co.in">irnerchant@tci.co.in</a> , <a href="mailto:aghodekar@tci.co.in">aghodekar@tci.co.in</a><br />
<strong>Contact Person:</strong> Mr. Raju Mane/ Mr. Irian Merchant<br />
</li>
<li>The Cheque / Draft is payable to <strong>Travel Corporation (India) Ltd. </strong>
</li>
</ol>
</span>
</div>

<div class="clear"></div>
<h2>Exhibitor Information</h2>
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

<form  id="car_hire_reservation" name="car_hire_reservation" method="post" onSubmit="return validate()"> 
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold"><sup>*</sup> Company Name</td>
    <td>:</td>
    <td>
      <input type="text" name="CompanyName" id="CompanyName" class="textField" value="<?php echo $result['Car_Hire_CompanyName'];?>" />   </td>
    <td>&nbsp;</td>
    <td class="bold"><sup>* </sup>Name of Passenger</td>
    <td>:</td>
    <td><input type="text" name="NameOfPassenger" id="NameOfPassenger" class="textField" value="<?php echo $result['Car_Hire_NameOfPassenger'];?>" /></td>
  </tr>
  
  <tr>
    <td class="bold"><sup>* </sup>Address</td>
    <td>:</td>
    <td>
      <textarea name="Address1" id="Address1" cols="45" rows="5" class="textArea"><?php echo $result['Car_Hire_Address1'];?></textarea>   </td>
    <td>&nbsp;</td>
    <td class="bold"><sup>*</sup> City</td>
    <td>:</td>
    <td><input type="text" name="City" id="City" class="textField" value="<?php echo $result['Car_Hire_City'];?>" /></td>
  </tr>
  
  <tr>
    <td class="bold"><sup>* </sup>Telephone</td>
    <td>:</td>
    <td><input type="text" name="Phone" id="Phone" class="textField" value="<?php echo $result['Car_Hire_Phone'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold"><sup> *</sup> Pincode</td>
    <td>:</td>
    <td><input type="text" name="Pincode" id="Pincode" class="textField" value="<?php echo $result['Car_Hire_Pincode'];?>" /></td>
  </tr>
  <tr>
    <td class="bold"><sup>*</sup> Mobile</td>
    <td>:</td>
    <td><input type="text" name="Mobile" id="Mobile" class="textField"value="<?php echo $result['Car_Hire_Mobile'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold"><sup>* </sup>Country</td>
    <td>:</td>
    <td>
	<?php $Country_ID=$result['Country_ID'];?>
    <select class="textField" name="Country_ID" id="Country_ID">
        <option value="">------ Select -------</option>
        <?php 
        $query1=mysql_query("SELECT * FROM iijs_country_master");
        while($result1=mysql_fetch_array($query1)){
        ?>
        <option value="<?php echo $result1['Country_ID'];?>" <?php if($result1['Country_ID']==$Country_ID){ ?> selected="selected"<?php }?> ><?php echo $result1['Country_Name'];?></option>
        <?php }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="bold"><sup>* </sup>E-Mail</td>
    <td>:</td>
    <td><input type="text" name="Email" id="Email" class="textField" value="<?php echo $result['Car_Hire_Email'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold"><sup>*</sup> Fax</td>
    <td>:</td>
    <td><input type="text" name="Fax" id="Fax" class="textField" value="<?php echo $result['Car_Hire_Fax'];?>"  /></td>
  </tr>
  <tr>
     <td class="bold"><sup>* </sup>Website</td>
     <td>:</td>
    <td><input type="text" name="Website" id="Website" class="textField" value="<?php echo $result['Car_Hire_Website'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<div class="title">
<h4>Provision to Car Hire</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  
   <tr>
    <td class="bold"><sup>* </sup>Reporting Address</td>
    <td>:</td>
    <td><input type="text" name="Reporting_Address" id="Reporting_Address" class="textField" value="<?php echo $result['Car_Hire_Reporting_Address'];?>" />

	</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
  
  <tr>
    <td class="bold"><sup>*</sup> From Date</td>
    <td>:</td>
    <td>
      <input name="FromDate" id="FromDate" type="text"  class="calendar datepicker" value="<?php echo $result['Car_Hire_FromDate'];?>" /> <!--<img src="../manual/images/calendar.png" />-->   </td>
    <td>&nbsp;</td>
    <td class="bold"><sup>* </sup>To Date</td>
    <td>:</td>
    <td><input name="Todate" id="Todate" type="text"  class="calendar datepicker" value="<?php echo $result['Car_Hire_Todate'];?>" /><!-- <img src="../manual/images/calendar.png" />-->  </tr>
  
  <tr>
    <td class="bold"><sup>* </sup>No. of Passenger</td>
    <td>:</td>
    <td><input type="text" name="No_Of_Passengers" id="No_Of_Passengers" class="qty" value="<?php echo $result['Car_Hire_No_Of_Passengers'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold"><sup>*</sup> Reporting Time</td>
    <td>:</td>
    <td><input type="text" name="Reporting_Time" id="Reporting_Time" class="amt" value="<?php echo $result['Car_Hire_Reporting_Time'];?>" /> (24 hr format)</td>
  </tr>
  
   <tr>
    <td class="bold"><sup>*</sup> Type of Car A/C</td>
    <td>:</td>
    <td>
     <select name="Car_Type_ID" id="Car_Type_ID">
   	 <option value="">------ Select -------</option>
       <?php 
		$query2=mysql_query("SELECT * FROM iijs_car_type_master");
		while($result2=mysql_fetch_array($query2)){
		?>
        <option value="<?php echo $result2['Car_Type_ID'];?>" <?php if($result2['Car_Type_ID']==$result['Car_Type_ID']){?> selected="selected"<?php }?>><?php echo $result2['Car_Type_Description'];?></option>
        <?php }?>
    </select>
	</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
   <tr>
    <td class="bold"><sup>*</sup> Hrs</td>
    <td>:</td>
    <td>
    	<select name="Hours" id="Hours">
          <option selected="selected">-- Select -- </option>
          <option value="8" <?php if($result['Car_Hire_Hours']=="8"){?> selected="selected"<?php }?>>8 Hrs </option>
          <option value="12" <?php if($result['Car_Hire_Hours']=="12"){?> selected="selected"<?php }?>>12 Hrs </option>          
        </select>
    </td>
    <td>&nbsp;</td>
    <td class="bold">Kelometers</td>
    <td>:</td>
    <td><input type="text" name="Kilometers" id="Kilometers" class="textField" value="<?php echo $result['Car_Hire_Kilometers'];?>" /></td>
  </tr>
  
   <tr>
    <td class="bold">Charges</td>
    <td>:</td>
    <td><input type="text" name="Charges" id="Charges" class="textField" value="<?php echo $result['Car_Hire_Charges'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>

</table>
<div class="title">
<h4>Pick - Up</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  
  <tr>
    <td colspan="2" class="bold"><sup>* </sup>Date</td>
    <td width="4%">:</td>
    <td width="61%">
      <input name="Pickup_Date" id="Pickup_Date" type="text"  class="calendar datepicker" value="<?php echo $result['Car_Hire_Pickup_Date'];?>" /> <!--<img src="../manual/images/calendar.png" />-->   </td>
    <td width="3%">&nbsp;</td>
    <td width="3%" class="bold">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="4%">  </tr>
  
  <tr>
    <td colspan="2" class="bold"><sup>*</sup> Flight Time</td>
    <td>:</td>
    <td><input type="text" name="Pickup_Flight_Time" id="Pickup_Flight_Time" class="amt" value="<?php echo $result['Car_Hire_Pickup_Flight_Time'];?>" /> 
    (24 hr format) e.g. 22:15</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
   <tr>
    <td colspan="2" class="bold"><sup>*</sup> Flight No.</td>
    <td>:</td>
    <td><input type="text" name="Pickup_FlightNumber" id="Pickup_FlightNumber" class="textField" value="<?php echo $result['Car_Hire_Pickup_FlightNumber'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   
   <tr>
    <td colspan="2" class="bold"><sup>*</sup> Location</td>
    <td>:</td>
    <td><input type="text" name="Pickup_Location" id="Pickup_Location" class="textField" value="<?php echo $result['Car_Hire_Pickup_Location'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   
    <tr><td colspan="8" class="bold">Facilities :</td></tr>
   
   <tr>
     <td width="6%" class="bold"><input type="radio" name="pickup_facility" class="pickup_facility" value="750" /></td>     
     <td colspan="7" >One way Airport Transfer by private air-conditioned insured medium sized car Rs. 750/- per car (Maximum two person)</td>
     </tr>
   <tr>
     <td width="6%" class="bold"><input type="radio" name="pickup_facility" class="pickup_facility" value="1250" /></td>     
     <td colspan="7" >One way Airport Transfer by private air-conditioned insured medium large car Rs. 1250/-per car (Maximum four person)</td>	
   </tr>
</table>

<div class="title">
<h4>Drop</h4>
</div>

<div class="clear"></div>

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td colspan="2" class="bold"><sup>* </sup>Date</td>
    <td width="4%">:</td>
    <td width="61%"><input name="Drop_Date" id="Drop_Date" type="text"  class="calendar datepicker" value="<?php echo $result['Car_Hire_Drop_Date'];?>" />
      <!--<img src="../manual/images/calendar.png" />-->   </td>
    <td width="3%">&nbsp;</td>
    <td width="3%" class="bold">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="4%">  </tr>
  
  <tr>
    <td colspan="2" class="bold"><sup>*</sup> Flight Time</td>
    <td>:</td>
    <td><input type="text" name="Drop_Flight_Time" id="Drop_Flight_Time" class="amt" value="<?php echo $result['Car_Hire_Drop_Flight_Time'];?>" /> 
    (24 hr format) e.g. 22:15</td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  
   <tr>
    <td colspan="2" class="bold"><sup>*</sup> Flight No.</td>
    <td>:</td>
    <td><input type="text" name="Drop_FlightNumber" id="Drop_FlightNumber" class="textField" value="<?php echo $result['Car_Hire_Drop_FlightNumber'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   
   <tr>
    <td colspan="2" class="bold"><sup>*</sup> Location</td>
    <td>:</td>
    <td><input type="text" name="Drop_Location" id="Drop_Location" class="textField" value="<?php echo $result['Car_Hire_Drop_Location'];?>" /></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   
   <tr>
     <td colspan="8" class="bold">Facilities :</td>
   </tr>
   
   <tr>
     <td width="6%" class="bold"><input type="radio" name="drop_facility" class="drop_facility" value="750" /></td>     
     <td colspan="7">One way Airport Transfer by private air-conditioned insured medium sized car Rs. 750/- per car (Maximum two person)</td>
   </tr>
   <tr>
     <td width="6%" class="bold"><input type="radio" name="drop_facility" class="drop_facility" value="1250" /></td>     
     <td colspan="7">One way Airport Transfer by private air-conditioned insured medium large car Rs. 1250/-per car (Maximum four person)</td>	
   </tr>
</table>

<div class="title"><h4>Payment Details </h4></div>
<?php 
$Car_Hire_Payment_ID=$result['Car_Hire_Payment_ID'];
$query=mysql_query("select * from  iijs_payment_master where Payment_Master_ID='$Car_Hire_Payment_ID'");
$result=mysql_fetch_array($query);
$total_amount=$result['Payment_Master_Amount'];
?>
<div class="clear"></div>
<div id="paymentDiv">
<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:550px;">
  <tr>
    <td width="38%" class="bold">Total Amount</td>
    <td width="4%">:</td>
    <td width="34%"><?php echo $total_amount;?><input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_amount;?>"/></td>
    <td width="3%">&nbsp;</td>
    <td width="5%" class="bold">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Service Tax (4.944%)</td>
    <td>:</td>
    <td><?php echo $service_tax=$total_amount*4.944/100;?></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bold">Total Payable</td>
    <td>:</td>
    <td><?php echo $total_payble=round($total_amount+$service_tax);?></td>
    <td>&nbsp;</td>
    <td class="bold">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<div class="title"><h4>Payment Mode</h4></div>

<div class="clear"></div>
<?php 
$Payment_Mode_ID=getPaymentModeId($Car_Hire_Payment_ID);
?>

<table border="0" cellspacing="0" cellpadding="0" class="formManual" style="width:450px;"> 
  <tr>
    <!--<td width="20"><input type="radio" name="Payment_Mode_ID[]" id="Payment_Mode_ID" value="1" <?php if($Payment_Mode_ID=="1"){?> checked="checked"<?php }?> /></td>
    <td width="100">Credit Card</td>-->
    <td width="20"><input type="radio" name="Payment_Mode_ID[]" id="Payment_Mode_ID" value="2" <?php if($Payment_Mode_ID=="2"){?> checked="checked"<?php }?> /></td>
    <td width="100">Cheque</td>
    <td width="20"><input type="radio" name="Payment_Mode_ID[]" id="Payment_Mode_ID" value="4" <?php if($Payment_Mode_ID=="4"){?> checked="checked"<?php }?> /></td>
    <td>DD</td>
    <input type="hidden" name="Exhibitor_Code" id="Exhibitor_Code" value="<?php echo $exhibitor_code;?>" />
  </tr>
</table>

<ol class="numeric">
<li>Payment must be made within three working days from placing the order, failing will result in cancellation of order. </li>
<li>Cheque should be in favour of - <strong>"Travel Corporation (India) Ltd."</strong></li>
</ol>

<div class="title">
<h4>Transport Area of Usage</h4>

</div>
<div class="clear"></div>

<ol class="numeric">
	<li>Parking, Toll taxes will be charged on actuals.</li>
    <li>Local - Within City Limits - Upto Dahisar / Mulund / Vashi Check Naka.</li>
    <li>Outstation: For a 12 Hour duty, standard rates applicable upto 100 Kms. Chauffer Charges will be Rs. 250 For Day Trip and Rs. 450 For Over Night Trip.</li>
    <li>Nature of Duty - In case of any duty being performed beyond 2400 HRS, the drivers allowance shall be applicable @ Rs. 250.</li>
    <li>The Kilometers and Hours shall be calculated from Garage to Garage.</li>

</ol>
  
<div class="title">
<h4>Government Service Tax Structure</h4>

</div>
<div class="clear"></div>

<ol class="numeric">
	<li>Transport - 4.9 %</li>
    <li>Hotels- 49%</li>
    <li>Package - 49 %</li>

</ol>

<p>Service Tax shall be applicable as per Govemment regulations</p>

    <div align="center"> 
        <!--<input type="hidden" name="save" id="save" value="Save"/>
        <?php if($num==0){?><input name="submit" id="submit" type="submit" value="Submit" class="maroon_btn" /><?php }?>
<!-- <input name="input" type="button" value="Reset" class="maroon_btn" />
      <input name="input3" type="button" value="Cancel" class="maroon_btn" />-->
      </div>
      </form>
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
