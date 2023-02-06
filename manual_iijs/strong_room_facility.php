<?php 
include('header_include.php');
if(!isset($_SESSION['EXHIBITOR_CODE'])){	header("location:index.php");	exit; }
?>
<?php
$exhibitor_code=$_SESSION['EXHIBITOR_CODE'];

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
$sql = "select * from iijs_strongroom where Exhibitor_Code='$exhibitor_code'";
$result = $conn ->query($sql);
$rows = $result->fetch_assoc();
$num_rows = $result->num_rows;

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
$action=$_REQUEST['action'];
if($action=='ADD')
{	
	if($num_rows==0)
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$StrongRoom_Taken=$_REQUEST['StrongRoom_Taken'][0];
		$keyperson1=$_REQUEST['keyperson1'];
		$keyperson2=$_REQUEST['keyperson2'];
		
		if($StrongRoom_Taken=='N')
		{
			$keyperson1="";
			$keyperson2="";
		}
		$sql_insert="insert into iijs_strongroom set Exhibitor_Code='$exhibitor_code',StrongRoom_Taken='$StrongRoom_Taken',Badge_ID='$Badge_ID',keyperson1='$keyperson1',keyperson2='$keyperson2',Items_Recieved='1',Items_Approved='P',Items_Reason='',Create_Date=NOW(),Modify_Date=NOW(),Application_Complete='P'";
		$execute=$conn ->query($sql_insert);
		
		$sql3="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson1'";
		$result3=$conn ->query($sql3);
		
		$sql4="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson2'";
		$result4=$conn ->query($sql4);
		if(!$execute) die ($conn->error);
		
		/*.......................................Send mail to users mail id...............................................*/
		$message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
		
		<tr>
		<td align="left" height="60px"><img src="http://iijs-signature.org/images/logo.png" border="0" width="220" /></td>
		<td align="right" height="60px"><img src="http://iijs-signature.org/images/gjepc_logo.png" border="0"/></td>
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
		<p>Thank you for applying Online for <strong>Form No. 5. STRONG ROOM FACILITY</strong>. Please note your application is under approval process. </p>
		<p>A  system generated notification will be sent to you on successful Approval/Disapproval of your application</p>
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
		$to ='neelmani@kwebmaker.com';
		$subject = "IIJS Signature 2021 Exhibitor Manual - Form No. 5. STORNG ROOM FACILITY"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From:admin@gjepc.org';			
		mail($to, $subject, $message, $headers);
		
	} else
	{
		$EXHIBITOR_CODE=$_REQUEST['EXHIBITOR_CODE'];
		$StrongRoom_Taken=$_REQUEST['StrongRoom_Taken'][0];
		$keyperson1=$_REQUEST['keyperson1'];
		$keyperson2=$_REQUEST['keyperson2'];
		
		if($StrongRoom_Taken=='N')
		{
			$keyperson1="";
			$keyperson2="";
		}
		
		$sql_insert="update iijs_strongroom set StrongRoom_Taken='$StrongRoom_Taken',keyperson1='$keyperson1',keyperson2='$keyperson2',Items_Approved='P',Items_Reason='',Application_Complete='P',Modify_Date=NOW() where Exhibitor_Code='$exhibitor_code'";
		$execute=$conn ->query($sql_insert);
		
		$sql3="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson1'";
		$result3=$conn ->query($sql3);
		
		$sql4="update iijs_badge_items set Badge_IsKeyPerson='1' where Badge_Item_ID='$keyperson2'";
		$result4=$conn ->query($sql4);
		if(!$execute) die ($conn->error);		
	}
	
	echo '<script type="text/javascript">'; 
	echo 'alert("You have successfully submitted your application..");'; 
	echo 'window.location.href = "manual_list.php";';
	echo '</script>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to SIGNATURE</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<!--navigation script-->
<script type="text/javascript" src="../js/jquery_002.js"></script>
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
    top: -30%;
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
function check_disable(){
	if ($('input[name=\'StrongRoom_Taken[]\']:checked').val() == "Y"){
        $("#keyperson").show();
    }
    else{
        $("#keyperson").hide();
    }	
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
$(document).ready(function(){
	
	$("#keyperson1").change(function(){
    Badge_Item_ID=$("#keyperson1").val();
	$.ajax({ type: 'POST',
	url: 'ajax_strong_room.php',
	data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#keydesc1").html(data);  
						//alert(data);
	}
	});
  });
						    		
	$("#keyperson2").change(function(){
    Badge_Item_ID=$("#keyperson2").val();
	$.ajax({ type: 'POST',
	url: 'ajax_strong_room.php',
	data: "actiontype=getBadgeDetails&Badge_Item_ID="+Badge_Item_ID,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){
						$("#keydesc2").html(data);  
						//alert(data);
	}
	});
  });
	
});
</script>
<script type="text/javascript">
function validation()
{

	if($('input[name="StrongRoom_Taken[]"]:checked').length == 0)
		{
			alert("Please Select One Option.");
			document.getElementById('StrongRoom_Taken').focus();
			return false;
		}
		
	
	if($('input[name=\'StrongRoom_Taken[]\']:checked').val() == "Y")
	{
		if(document.getElementById('keyperson1').value=="")
		{
			alert("Please Select One Key Person1");
			document.getElementById('keyperson1').focus();
			return false;
		}
		
		if(document.getElementById('keyperson2').value=="")
		{
			alert("Please Select One Key Person2");
			document.getElementById('keyperson2').focus();
			return false;
		}
		
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
<h3>Strong Room Facility</h3>

<div class="tooltip"><strong>Note</strong>
<span class="tooltiptext">
<ol class="numeric">
<li>This is to provide information about the strong room facility.</li>
<li>After submission of the form, please print an acknowledgment and forward the signed hard copy along with the signatures on <a href="images/pdf/Disclaimer_cum_handling_instructions_for_strong_room_Signature_2020.pdf" target="_blank" ><strong>Strong Room Disclaimer</strong></a>, to the GJEPC OFFICE at the given below address :<br />

<strong>Return To :</strong>
<br />
The Executive Director,<br />
The Gem &amp; Jewellery Export Promotion Council<br />
G2-A, Trade Centre, Opp. MTNL Building<br />
Bandra Kurla Complex,<br />
Bandra (E) Mumbai 400 051 - India<br />
<strong>Call Centre No. : 1800-103-4353 Missed Call No: +91 7208048100<br />
<strong>Email:</strong> <a href="mailto:signature@gjepcindia.com">signature@gjepcindia.com</a></li>
<li>For payment approval all cheques/drafts/ Wire Transfer should reach the council within <strong>4 working days after order date</strong> failing will result in cancellation of order</li>
</ol>
</span>
</div>

<span  class="spanbox">Deadline : <strong>11th January 2020</strong></span>

<span  class="spanbox"><a href="images/pdf/Disclaimer_cum_handling_instructions_for_strong_room_Signature_2020.pdf" target="_blank" ><strong>Strong Room Disclaimer</strong></a></span>

<div class="clear"></div>

<h2>Application Summary</h2>
<table  cellspacing="0" cellpadding="0" class="common">
<tbody>
<tr>
	<th valign="top">Date</th>
    <th valign="top">Information Status</th>
    <th valign="top">Application Status</th>
</tr>

<tr>
	<td valign="middle"><?php if($Create_Date==""){ echo "NA"; }else{echo date("d-m-Y",strtotime($Create_Date));} ?></td>
    <td valign="middle">
	<?php  
        if($Items_Approved=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Items_Approved=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";        
    ?>
   </td>
   
  <td valign="middle"  class="centerAlign">
	  <?php  
        if($Application_Complete=='Y')
            echo "<img src='images/correct.png'  alt='' />";
        else if($Application_Complete=='N')
            echo "<img src='images/red_cross.png'  alt='' />";
        else
            echo "<img src='images/pending.png'  alt='' />";
    ?>
    </td>
</tr>
</tbody>
</table>

<p>The sections marked with a <span class="red">*</span> are compulsory.</p>

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
    <td><?php echo $Exhibitor_Section; ?></td>
    <td>&nbsp;</td>
    <td class="bold">Area</td>
    <td>:</td>
    <td><?php echo $Exhibitor_Area; ?></td>
  </tr>
</table>

<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()">
<input type="hidden" name="action" value="ADD"/>
<input type="hidden" name="EXHIBITOR_CODE" id="EXHIBITOR_CODE" value="<?php echo $_SESSION['EXHIBITOR_CODE'];?>" />

<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td class="bold" width="350px">Would you like to avail of strong room facilities at the show? <sup>*</sup></td>
    <td><input type="radio" name="StrongRoom_Taken[]" id="StrongRoom_Taken" value="Y" onchange="check_disable()" <?php if($Items_Approved=='Y' || $Items_Approved=='P') {} ?> <?php if($StrongRoom_Taken=="Y"){echo "checked='checked'";}?> /> Yes</td>
    <td><input type="radio" name="StrongRoom_Taken[]" id="StrongRoom_Taken" value="N" onchange="check_disable()" <?php if($Items_Approved=='Y' || $Items_Approved=='P') {} ?> <?php if($StrongRoom_Taken=="N"){echo "checked='checked'";}?> /> No</td>
  </tr>
</table>

<?php
if($StrongRoom_Taken=="Y" && ($Items_Approved=='Y' || $Items_Approved=='P'))
{
?>
<div class="title"><h4>Key Person</h4></div>
<div class="clear"></div>
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
      <td class="bold">Key Person 1</td>
      <td>:</td>
      <td><?php echo getKeyName($keyperson1,$conn);?></td>
      <td>&nbsp;</td>
      <td class="bold">Key Person 2</td>
      <td>:</td>
      <td><?php echo getKeyName($keyperson2,$conn);?></td>
    </tr>
    <tr>
      <td width="14%" class="bold">Designation</td>
      <td width="3%">:</td>
      <td width="29%"><?php echo getKeyDesignation($keyperson1,$conn);?></td>
      <td width="3%">&nbsp;</td>
      <td width="14%" class="bold">Designation</td>
      <td width="5%">:</td>
      <td width="32%"><?php echo getKeyDesignation($keyperson2,$conn);?></td>
    </tr>
    <tr>
      <td class="bold">Photo</td>
      <td>:</td>
      <td><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo getKeyPhoto($keyperson1,$conn);?>" width='150px' height='120' /></td>
      <td>&nbsp;</td>
      <td class="bold">Photo</td>
      <td>:</td>
      <td><img src="images/badges/<?php echo $_SESSION['EXHIBITOR_CODE'];?>/<?php echo getKeyPhoto($keyperson2,$conn);?>" width='150px' height='120' /></td>
    </tr>
   
    
    </table>
<?php	
}
?>
<div class="clear"></div>
<div id="keyperson" <?php //if($Items_Approved!='N'){ echo "style='display:none;'";}?>>
<div class="title"><h4>Key Person</h4></div>
<div class="clear">
  <table border="0" cellspacing="0" cellpadding="0" class="formManual">
    <tr>
    <td colspan="8" class="bold">Select safe key holder ( Recommended : Exhibitors ) <sup>*</sup></td>
    </tr>
    <tr>
      <td width="14%" class="bold">Key Person 1<sup>*</sup></td>
      <td width="3%">:</td>
      <td width="29%">
      <select name="keyperson1" id="keyperson1" class="textField">
        <option selected="selected" value="">--Select--</option>
        <?php 
		$sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M')";
		$result=$conn ->query($sql);
		while($rows=$result->fetch_assoc())
		{
			if($rows['Badge_Item_ID']==$keyperson1)
			{
			echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";	
			}else
			{
			echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}
		}
		?>
      </select></td>
      <td width="3%">&nbsp;</td>
      <td width="14%" class="bold">Key Person 2 <sup>*</sup></td>
      <td width="5%">:</td>
      <td width="32%">
      <select name="keyperson2" id="keyperson2" class="textField">
        <option selected="selected" value="">--Select--</option>
        <?php 
		$sql="SELECT * FROM `iijs_badge_items` WHERE `Exhibitor_Code`='$exhibitor_code' AND (`Badge_Type`='E' || `Badge_Type`='M')";
		$result=$conn ->query($sql);
		while($rows=$result->fetch_assoc())
		{
			if($rows['Badge_Item_ID']==$keyperson2)
			{
			echo "<option value='$rows[Badge_Item_ID]' selected='selected'>$rows[Badge_Name]</option>";	
			}else
			{
			echo "<option value='$rows[Badge_Item_ID]'>$rows[Badge_Name]</option>";	
			}	
		}
		?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td colspan="3" class="bold"><div id="keydesc1"></div></td>
      <td>&nbsp;</td>
      <td colspan="3" class="bold"><div id="keydesc2"></div></td>
      </tr>
    
    </table>
</div>
</div>
<div class="title"><h4>Information Approval</h4></div>
<div class="clear"></div>
<table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="150"><strong>Status</strong></td>
    <td>:</td>
    <td>
    <?php 
		if($Items_Approved=='Y')
			echo "<img src='images/correct.png'  alt='' /> &nbsp;&nbsp;Approved";
		else if($Items_Approved=='N')
			echo "<img src='images/red_cross.png'  alt='' /> &nbsp;&nbsp;Disapproved";
		else
			echo "<img src='images/pending.png'  alt='' /> &nbsp;&nbsp;Pending";                                        	
    ?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
	if($Items_Approved=='N'){?>
  <tr>
    <td><strong>Reason</strong></td>
    <td>:</td>
    <td><?php echo "$Items_Reason"; ?></td>
  </tr>
  <?php }?>
</table>
<p>&nbsp;</p>
<div class="clear"></div>

<div align="center">
<?php if($Items_Approved=='N' || $Items_Approved=='P'){ ?>
<a href="print_acknowledge/strong_room_print.php?StrongRoom_ID=<?php echo $StrongRoom_ID;?>" target="_blank" class="button5">Print AcknowledgeMent</a>
<?php } else { ?>
  <?php //if($_REQUEST['auth']=="admin"){?> 
  <input name="input2" type="submit" value="Submit" class="maroon_btn"/>
  <?php //} ?>
<?php } ?>
<a href="manual_list.php"><input name="input22" type="button" value="Cancel" class="maroon_btn" /></a>
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
